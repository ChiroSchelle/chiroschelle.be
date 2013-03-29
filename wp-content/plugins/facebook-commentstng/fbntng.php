<?php
/* Plugin Name: Facebook Comments TNG
   Plugin URI: http://www.philtopia.com/?page_id=292
   Description: A new and re written Facebook notes comments grabber.
   Version: 0.20
   Author: Phil Spencer 
   Author URI: http://www.philtopia.com 	
*/

$tng_debug = 0; //will show other note titles in test when set to 1, I use it for finding why proper notes are not matching.

// this function checks for admin pages
if (!function_exists('is_admin_page')) {
  function is_admin_page() {
    if (function_exists('is_admin')) {
      return is_admin();
    }
    if (function_exists('check_admin_referer')) {
       return true;
    } else {
       return false;
    }
  }
}

function tng_is_authorized() {
  global $user_level;
  if (function_exists("current_user_can")) {
     return current_user_can('activate_plugins');
  } else {
     return $user_level > 5;
  }
}

function tng_connect_notes_timer() {
   global $tng_debug;
   if ($tng_debug == 1) {
      //Debug messages break the hourly/daily so switch them off/on when being run from schedule
      $tng_debug = 0;
      tng_connect_notes(); 
      $tng_debug = 1;
   } else {
      tng_connect_notes();
   }
}

function tng_connect_notes() {
   
   //Connect to data source and log in
   $email = get_option("facebook_email");
   $pass = get_option("facebook_password");
   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL, "http://m.facebook.com/login.php?next=http%3A%2F%2Fm.facebook.com%2Fhome.php%3Fledac5e3a");
   @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE); 
   curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookiefile.txt'); 
   curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiefile.txt'); 
   curl_setopt($ch, CURLOPT_HEADER, 0); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POST,true);
   curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla 4.0 (PHP ; Facebook Login Script 0.1 ; PHILTOPIA EDITION");
   curl_setopt($ch, CURLOPT_REFERER,"http://m.facebook.com/");
   $post = array("email" => $email, "pass" => $pass);
   curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
   curl_exec($ch);

   tng_spider_notes($ch);
   
   curl_close($ch);
 }

function tng_spider_notes($ch) {
    global $tng_debug;

    //This finds the note links and feeds them to the parser
    $page_id = get_option("facebook_page");
    curl_setopt($ch, CURLOPT_URL,sprintf("http://m.facebook.com/notes.php?locale=en_US&id=%s",$page_id));
    if ($tng_debug == 1)
       echo sprintf("http://m.facebook.com/notes.php?locale=en_US&id=%s",$page_id) . "\n<br/>\n";

    $data = curl_exec($ch);
    $data = tng_charset_decode_utf_8($data);
    $data = tng_fix_fb_chars($data);
    $html = str_get_html($data);
    
    //count posts so we can travese all pages
    foreach($html->find('small') as $element) {
       if ($buffer = strstr($element->innertext,"Notes 1 - 5 of ")) {
           $posts = substr($buffer,15);
       } 
       if ($buffer = strstr($element->innertext," notes.")) {
           $posts = str_replace(" notes.","",$element->innertext);
       }
    }
    if ($tng_debug == 1)
       echo $posts . "\n<br/>\n";
    //Set up starting note
    $count = get_option('facebook_start') - 1; //0 is actually 1 but for the users sake I'm not going to explain this and just subtract 1 from the value when using it
    if ($count < 0) $count = 0;
    if ($count > $posts) $count = $posts;
    if ($count != 0) {
       curl_setopt($ch, CURLOPT_URL,sprintf("http://m.facebook.com/notes.php?p=%s&locale=en_US&id=%s",$count,$page_id));
       $data = curl_exec($ch);
       $data = tng_charset_decode_utf_8($data);
       $data = tng_fix_fb_chars($data);
       $html = str_get_html($data);
    }
 
    
    $limit = get_option("facebook_limit");
    if ($limit > $posts || $limit == 0) $limit = $posts;
    $limit = $limit + $count; //Need to add count incase starting note is changed    

    //the while loop CURL's through the multiple pages of your notes section
    while ($count < $limit) {
          foreach($html->find('a') as $element) { 
          if (strstr($element->href,"/note.php")) {
             if (strstr($element->href,"#anchor_fbid_")) {
                if ($element->innertext != "Read More") 
                   if ($post_id = tng_isBlog($element->innertext)) {   
                      tng_find_comments($ch,html_entity_decode($element->href),$post_id); //go to and parse the note   
                      if(get_option("facebook_test") == 1)
                         echo "<hr/>"; 
                   } elseif($tng_debug == 1)
                      echo "Not note: " . $element->innertext . "<br/>\n";
                }
          }
       } 
       $count = $count + 5;       
       curl_setopt($ch, CURLOPT_URL,sprintf("http://m.facebook.com/notes.php?p=%s&locale=en_US&id=%s",$count,$page_id));
       $data = curl_exec($ch);
       $data = tng_charset_decode_utf_8($data);
       $data = tng_fix_fb_chars($data);
       $html = str_get_html($data);
    }
    $html->clear(); //Memory cleanup
}

function tng_find_comments($ch,$url,$post_id) {
    //This function dwnloads the HTML and searches for specific tags that surround the data I want
    $url_parts = parse_url($url);
    curl_setopt($ch, CURLOPT_URL, sprintf("http://m.facebook.com%s?locale=en_US&%s#%s",$url_parts[path],$url_parts[query],$url_parts[fragment]));
    $data = curl_exec($ch);
    //$data = tng_charset_decode_utf_8($data);
    //$data = tng_fix_fb_chars($data);
    $html = str_get_html($data);
    
    if(get_option("facebook_test") == 1)
      echo "Note ID: " . tng_getTitle($post_id) . "<br/>";   

    foreach ($html->find("div[id*=comments_]") as $element) {
       foreach ($element->find("div") as $scrape) {
          if($scrape->class == "note") {
             if(tng_getTitle($post_id) != $scrape->find("a",0)->plaintext) {
                $author = $scrape->find("a",0)->plaintext;
                //If the user changes this before running a test right after upgrading to .20 this may break and cause doubles.
                //A test would prevent this as the comment exists function will upgrade old comments with the FB ID preventing name duplicates
                if (get_option("facebook_author_firstonly") == 1) {                   
                   $token = strtok($author," ");
                   //Check if the token was populated before changing the variable
                   if ($token)
                      $author = $token;
                }
                $profile_id= $scrape->find("a",0)->outertext;
		$profile_id=preg_match('/id=([^&"]+)/', $profile_id, $match);
	        $profile_id = $match[1];
	       
        	//There is no time like the present!
                                
                $time = $scrape->find("small",0)->plaintext;
                $time = str_replace("at","",$time);
                $time = str_replace("on","",$time);
                $time = str_replace("yesterday",date("M d, Y",strtotime("-1 day")),$time); //trying to fix yesterday
             }
          }
          if(!$scrape->class) {
             $comment = substr($scrape->plaintext,0,-6);
             if (!tng_comment_exist($post_id,$profile_id,$author,$comment)) {
                if(get_option("facebook_test") == 1) 
                   echo "Author: " . $author . "<br/> Profile Id: " . $profile_id . "<br/> Comment: " . $comment . "<br/> Time: " . date("Y-m-d H:i:s",strtotime($time)) . "\n<br/>";  
                else 
                   tng_add_comment($post_id,$author,$comment,date("Y-m-d H:i:s",strtotime($time)),$profile_id);
             }
          }
       }
    }
    foreach ($html->find("a") as $element) {
        //If someone has lots of comments they are broken up into 15 comment chunks per page, this scans for "Next" which only exists if there are further comments, last page of comments never has a Next
        if($element->plaintext == "Next") { //There are other pages with comments if this is true
           $next_url = $element->href;
           $html->clear(); //This is to prevent if someone has multiple comment pages to blow out there memory during the recursion, at this point the html data for the current comment page is no longer needed
           tng_find_comments($ch,html_entity_decode($next_url),$post_id);
           return;
        } 
    }
    $html->clear(); //Final comment memory cleanup
}

function tng_fix_fb_chars($string) {
   //Sometimes you end up with the single ... character or the weird ' this just puts them back cause wordpress doesnt use those in the database
   $string = preg_replace("/&#8217;/","'",$string);
   $string = preg_replace("/&#8230;/","...",$string);
   $string = preg_replace("/&#8211;/","-",$string);
   $string = preg_replace("/&#65533;/",utf8_encode("&#65533;"),$string);
   return $string;
}

//This next function I got of the PHP manual comments apparantly this is from Squirrel Mail, Love that project!
function tng_charset_decode_utf_8 ($string) { 
    /* Only do the slow convert if there are 8-bit characters */ 
    /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */ 
    if (! ereg("[\200-\237]", $string) and ! ereg("[\241-\377]", $string)) 
        return $string; 

    // decode three byte unicode characters 
    $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/e",        
    "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",    
    $string); 

    // decode two byte unicode characters 
    $string = preg_replace("/([\300-\337])([\200-\277])/e", 
    "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'", 
    $string); 

    
    return $string; 
} 

function tng_add_comment($post_id,$author,$comment,$time,$profile_id) {
   if (get_option("facebook_auto") == 1)
      $auto = 1;
   if (get_option("facebook_author_profile_url") == 1)
      $author_url = 1;
   
   $comment_data = array(); 
   //$time = current_time("mysql");
   //Scraped data
   $comment_data["comment_post_ID"] = $post_id;
   $comment_data["comment_author"] = $author;
   $comment_data["comment_content"] = $comment;
   
   //Generated data
   $comment_data["comment_author_email"] = get_option("facebook_author_email");
   $comment_data["comment_author_IP"] = $profile_id;
   if ($author_url)
	   $comment_data["comment_author_url"] = "http://facebook.com/profile.php?id=$profile_id";  
   else
   	   $comment_data["comment_author_url"] = "";
   $comment_data["comment_date"] = $time;
   $comment_data["comment_date_gmt"] = $time;
   if ($auto)
      $comment_data["comment_approved"] = 1;  
   else
      $comment_data["comment_approved"] = 0;  
   $comment_data["comment_agent"] = "Mozilla 4.0 (PHP ; Facebook Login Script 0.1 ; PHILTOPIA EDITION"; //This unique agent will change each version and be used to find and remove/upgrade old comments in the future

   wp_insert_comment($comment_data);
}

function tng_isBlog($title) {
   //If this returns a value the post from facebook also exists here
   global $wpdb;

   return $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_status = 'publish'",tng_fix_fb_chars($title)));
}

function tng_getTitle($id) {
   global $wpdb;

   return $wpdb->get_var($wpdb->prepare("SELECT post_title FROM $wpdb->posts WHERE ID = %s",$id));
}

function tng_comment_exist($post_id,$profile_id,$author,$comment) {
  //If this returns anything the comment exists
  global $wpdb;
  global $tng_debug;

  if (!$wpdb->get_var($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID= %s AND comment_author_IP = %s AND comment_content = %s ",$post_id,$profile_id,$comment))) {
     if ($tng_debug == 1)
        echo "Profile ID check did not match trying basic\n<br/>\n";
     if ($wpdb->get_var($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID= %s AND comment_author = %s AND comment_content = %s ",$post_id,$author,$comment))) {
        if($tng_debug == 1)
           echo "Basic check matches, comment needs update\n<br/>\n";
        $wpdb->query($wpdb->prepare("UPDATE $wpdb->comments SET comment_author_IP=%s WHERE comment_post_ID=%s AND comment_author=%s AND comment_content=%s",$profile_id,$post_id,$author,$comment));
        echo "Updated\n<br/>\n";
        return 1;
      }
      if ($tng_debug == 1)
         echo "New comment\n<br/>\n";
  } else {
     return 1;
  }
  return 0;
}

function tng_activate() {
   add_option("facebook_author_email","facebook@philtopia.com",'',"yes");
   add_option("facebook_start","1",'',"yes");
   add_option("facebook_auto","0",'',"yes");
   add_option("facebook_author_profile_url","0",'',"yes");
   add_option("facebook_author_firstonly","0",'',"yes");
}

function tng_activate_menu() {
   add_options_page('Facebook CommentsTNG Options', 'Facebook CommentsTNG', 8, 'fbntng.php', 'tng_options_menu');
}

//add saving the settings into a function:
function tng_save_options() {
   global $error_flag;
   global $tng_debug;
	
   if(tng_is_authorized()) {
      if((!empty($_POST['email'])) && (!empty($_POST['pass']))){ //make sure the user enters an e-mail and password.
      update_option('facebook_email', $_POST['email']);
      update_option('facebook_password', $_POST['pass']);
      update_option('facebook_author_email',$_POST["fbemail"]);
      update_option('facebook_auto',$_POST["auto"]);
      update_option('facebook_author_profile_url',$_POST["author_profile_url"]);
      update_option('facebook_author_firstonly',$_POST["author_firstonly"]);
      if (is_numeric($_POST["page"]))
         update_option('facebook_page',$_POST["page"]);
      else
         update_option('facebook_page',"");  
      if(is_numeric($_POST['limit']))
         update_option('facebook_limit',$_POST['limit']);
      else
         update_option('facebook_limit',0);
      if(is_numeric($_POST['start']))
         update_option('facebook_start',$_POST['start']);
      else
         update_option('facebook_start','1');
      $timer = $_POST['timer'];
      if ($timer != get_option('facebook_timer')) {
         update_option('facebook_timer',$_POST['timer']);
         //I had noticed that it was doing the hourly more frequent then an hour and it was because it kept adding new hourly...oops! 
         //wp_unschedule_event(wp_next_scheduled('import_facebook_comments_hook',""),'import_facebook_comments_hook',""); 
         wp_clear_scheduled_hook('import_facebook_comments_hook'); //0.18 this seems to work and the line above does not
         if ($timer == 86400) { //Borrowed from original FBC, thanks guys!
	     // Daily
	     wp_schedule_event( time(), 'daily', 'import_facebook_comments_hook' );
	  } elseif ($timer == 3600) {
	     // Hourly
	     wp_schedule_event( time(), 'hourly', 'import_facebook_comments_hook' );
	  } else {
            // Do nothing!           
	  }
      } 
      if ($tng_debug == 1)     
         echo "Next timer: " . date("M d Y H:i:s",wp_next_scheduled('import_facebook_comments_hook'));
         
      } else {  //Field check failed display explanation
         if((empty($_POST['email'])) && (!empty($_POST['pass']))){
            echo "<div id='message' class='error fade'><p>Options not saved, you must enter an e-mail address.</div>\n";
      	    $error_flag=TRUE;
         } elseif((!empty($_POST['email'])) && (empty($_POST['pass']))){
            echo "<div id='message' class='error fade'><p>Options not saved, you must enter a password.</div>\n";
      	    $error_flag=TRUE;
         } elseif((empty($_POST['email'])) && (empty($_POST['pass']))){
            echo "<div id='message' class='error fade'><p>Options not saved, you must enter both an e-mail adress and password</div>\n";
      	    $error_flag=TRUE;
         }
      }
   } else { 
      echo "<div id='message' class='error fade'><p>Sorry, you don't have permission to view this page.</div>\n";
   }
}

function tng_options_menu() {
   //see if the user can see this page.
   if(tng_is_authorized()){
      global $wpdb,$error_flag;
      
      if (isset($_POST['update'])) {
         tng_save_options();
         echo "<div id='message' class='updated fade'><p>Updating Comment e-mail addresses</p><div>\n";
         $wpdb->query($wpdb->prepare("UPDATE $wpdb->comments SET comment_Author_email=%s WHERE comment_agent=%s",get_option("facebook_author_email"), "Mozilla 4.0 (PHP ; Facebook Login Script 0.1 ; PHILTOPIA EDITION"));
      }

      if (isset($_POST['test'])) {
         tng_save_options();
         echo "<div id='message' class='updated fade'>Test run, All WP blog titles detected in Facebook will be shown along with comments not currently in Database<br/></div>\n";
         update_option('facebook_test',"1");
         echo "<div id='tng_output' style='width:800px;height:300px;overflow:scroll;'>";
         tng_connect_notes();  
         echo "</div>";
         update_option('facebook_test',"0");
      }
 
      if (isset($_POST['manual'])) {
         tng_save_options();
         update_option('facebook_test',"0"); //just incase test crashes and doesnt unset itself
         echo "<div id='message' class='updated fade'><p>Starting manual pull please be patient this may take time...</p></div>\n";
         tng_connect_notes();  
         echo "<div id='message' class='updated fade'><p>Completed, check the comments section of Wordpress for any pending comments</p></div>\n";
      }

      if (isset($_POST['save'])) {
         tng_save_options();
         if(!$error_flag){
            echo "<div id='message' class='updated fade'><p>Options updated</p></div>\n";
         }
      }
?>
<div class="wrap">
<h2> Facebook CommentsTNG</h2>
<form method="POST">
   <h3>Facebook Login</h3>
       Before this plugin can start working, you have to authorize it to access your Facebook account: 
       <br/>
	<fieldset name="email">
	<legend>  <?php _e('Email', 'Localization name') ?>: </legend>
	<input type="text" name="email" id="email" size="20" value="<?php echo get_option('facebook_email') ?>" /> &nbsp;&nbsp;&nbsp; 
	</fieldset>
	<fieldset name="password">
	<legend>  <?php _e('Password', 'Localization name') ?>: </legend>
	<input type="password" name="pass" id="pass" size="20" value="<?php echo get_option('facebook_password') ?>" />
	</fieldset>
       <fieldset name="page">
       <legend> <?php _e('Page ID', 'Localization name') ?>: </legend>
       Fill in this option if your blog is imported to a Facebook page instead of a user profile. Leave the field blank for user profile crawls.
       <br/>
       <input type="text" name="page" id="page" size="20" title="log into Facebook, click ads and pages, take the id value from your URL eg http://www.facebook.com/?ref=home#!/pages/edit/?id=123456 <- 123456 is the id for your page" value="<?php echo get_option('facebook_page') ?>" /> 
       </fieldset>
   <h3>Crawl Settings</h3>
   Automatic crawl: <select name="timer">
   <option value="86400"<?php if (get_option('facebook_timer') == 86400) { print " selected"; } ?>>Daily
   <option value="3600"<?php if (get_option('facebook_timer') == 3600) { print " selected"; } ?>>Hourly
   <option value="0"<?php if (get_option('facebook_timer') == 0) { print " selected"; } ?>>Never
   </select>
   <br/>
   Auto approve comments: <select name="auto">
   <option value="0" <?php if (get_option('facebook_auto') == 0) { print " selected"; } ?>> No
   <option value="1" <?php if (get_option('facebook_auto') == 1) { print " selected"; } ?>> Yes
   </select>
   <br>
   Limit how many posts the plugin will parse. Set to 0 for unlimited: <input type="text" name="limit" id="limit" value="<?php echo get_option('facebook_limit') ?>" />
   <br/>
   Start crawl at Note: <input type="text" name="start" id="start" value="<?php echo get_option('facebook_start') ?>" />
   <br/>
   <h3>Comment Settings</h3>
   Comment e-mail address (for assigning a gravatar): <input type="text" name="fbemail" id="fbemail" value="<?php echo get_option('facebook_author_email') ?>" />
   <br>
   Link to authors profile: <select name="author_profile_url">
   <option value="0" <?php if (get_option('facebook_author_profile_url') == 0) { print " selected"; } ?>> No
   <option value="1" <?php if (get_option('facebook_author_profile_url') == 1) { print " selected"; } ?>> Yes
   </select>
   <br/>
   Attempt to only show first name: <select name="author_firstonly">
   <option value="0" <?php if (get_option('facebook_author_firstonly') == 0) { print " selected"; } ?>> No
   <option value="1" <?php if (get_option('facebook_author_firstonly') == 1) { print " selected"; } ?>> Yes
   </select>
   <br/>
   <br>
   <input type="submit" name="save" value="<?php _e('Save options','Localization name') ?>" class="button-primary"/>
   <input type="submit" name="test" value="<?php _e('Test', 'Localization name') ?> " class="button" />
   <input type="submit" name="manual" value="<?php _e('Manual update','Localization name') ?>" class="button"/>
   <input type="submit" name="update" value="<?php _e('Update e-mail addresses', 'Localization name') ?>" class="button"/>
</form>
</div>
<?php
   } else { 
      echo "<div id='message' class='error fade'><p>Sorry, you don't have permission to view this page.</div>\n";
   }
}

//Set things up!
register_activation_hook( __FILE__, 'tng_activate');
add_action('admin_menu','tng_activate_menu');
add_action('import_facebook_comments_hook','tng_connect_notes_timer');
include_once("simple_html_dom.php");
?>
