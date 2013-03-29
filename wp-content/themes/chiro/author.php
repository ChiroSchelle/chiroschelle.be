<?php
/**
 * @package WordPress
 * @subpackage Chiro_Schelle
 */

  //bepaal of we ook 'persoonlijke' informatie moeten laten zien.
  //if persoon die kijkt is leiding.
  if (get_rank($user_ID)) { //heeft de huidige gebruiker een rank?
	  $show_personal = true; //laat dan alles zien
  }
  elseif (get_rank(intval($author))){ //persoon waarover pagina gaat heeft rank
	  $show_personal = true; //laat dan alles zien
  }
  else {
	  $show_personal = false;
  }
?>
<?php 
  get_header(); 
?>

<div id="kijkerbackground">
  <div id="kijker_single">   
    <div id="pijlgezicht_single"></div>
    <div id="kijkerfiguur">

<?php
  /* Userinfo ophalen */
  $thisauthor = get_userdata(intval($author));
  /*Avatar weergeven*/
  echo get_avatar($thisauthor->ID, 150, "" );
?>

    </div> <!--Sluiten van 'kijkerfiguur'-->
    <div id="kijkertekst">
      
<?php
  /*naam en achternaam*/
?>
      <h1><?php echo $thisauthor->first_name . " " . $thisauthor->last_name;?></h1>
      <p>
        <?php
          if (!VERBERG_AFDELING){
            get_user_rankafdeling($thisauthor->ID, 0, 1, 0);
          } 
        ?>
        <br/>
        <br/>

<?php 
  if($show_personal) : 
?>
				<?php echo $thisauthor->straat . " ". $thisauthor->nr; ?><br/>
        <?php echo $thisauthor->postcode . " ". $thisauthor->gemeente; ?><br /><br />
        <?php echo $thisauthor->telefoon; ?><br />                   
        <a href="<?php echo get_bloginfo('url') . '/contact/?uid=' . $thisauthor->ID; ?>">
          Contacteer <?php echo $thisauthor->first_name; ?>
        </a>
		  </p>
<?php
  endif;
?>
			<p>
			  <?php echo $thisauthor->description; ?>
		  </p> 
<?php 
  if ($thisauthor->user_url != ''){
			echo "<p><a href=\"".$thisauthor->user_url. "\">".$thisauthor->user_url."</a></p>";					
	}
?>
 
    </div> <!--Sluiten van 'kijkertekst'-->
    <div class="cleaner"></div>    
  </div><!--Sluiten van 'kijker'-->
</div><!--Sluiten van 'kijkerbackground'-->
<div id="main1">
  <div id="main2">    
    <div id="right"></div>
    <div id="left"></div>
    <div id="middle">   
    	<div id="pijl"></div>

<?php 
  if (have_posts()) : 
?>
  		<div class="post">
        <div class="inhoudfiguur">&nbsp;</div><!--Sluiten van 'inhoudfiguur'--> 
        <div class="inhoudzonderimg">

<?php 
    get_vragenlijst($thisauthor);
?>

          <h2>Berichten van <?php echo $thisauthor->display_name; ?></h2>
  		 	  <ul>

<?php 
    while (have_posts()) :  the_post(); 
?>
            <li>
              <a class="postsvan" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
            </li>
<?php 
    endwhile;
?>
          </ul>
   			  <br/>
			
<?php  
  else: 
?>
  		<div class="post">
  		  <div class="inhoudfiguur">&nbsp;</div><!--Sluiten van 'inhoudfiguur'--> 
        <div class="inhoudzonderimg">
<?php 
    get_vragenlijst($thisauthor); 
?>
          <!--h2><?php echo $thisauthor->first_name; ?> heeft nog geen berichten geschreven.</h2-->
<?php 
  endif;  
?>
                  
<?php
// Probleem: reacties op private posts worden hier ook weergegeven
// Oplossing: zie verder --Ben
  $querystr = "
          SELECT comment_ID, comment_post_ID, post_title
					FROM $wpdb->comments, $wpdb->posts
					WHERE user_id = $thisauthor->ID
					AND comment_post_id = ID
					AND comment_approved = 1
					ORDER BY comment_ID DESC
					LIMIT 10";
  $comments_array = $wpdb->get_results($querystr, OBJECT);

  if ($comments_array): 
?>
          <h2>Recente reacties</h2>
          <ul>
					
<? 
    foreach ($comments_array as $comment):
      // Oplossing (zie hoger): kijk of het een comment op een private post is --Ben
      $args = array(
        'include' => $comment->comment_post_ID,
        'post_status' => 'private'
      );
      $privates = get_posts($args);
      $private = $privates[0];
      if(!$private || current_user_can('read_private_posts') ) 
      // niet private, of de gebruiker mag private posts zien
      {
        setup_postdata($comment);
	                	echo "<li><a class=\"reactiesvan\" href='". get_bloginfo('url') ."/?p=".$comment->comment_post_ID."/#comment-". $comment->comment_ID ."'>Reactie op \"". $comment->post_title ."\"</a></li>";
	   }
    endforeach; 
?>

          </ul>    
<? 
  endif; //comments_array
?>        
        </div> <!--Sluiten van 'inhoudzonderimg'-->  
        <div class="cleaner"></div> 
      </div> <!--Sluiten van 'post'-->    
			<div class="cleaner"></div>       
    </div><!--Sluiten van 'middle'-->
	</div><!--Sluiten van 'main2'-->
</div><!--Sluiten van 'main1'-->
<?php get_footer(); ?>
