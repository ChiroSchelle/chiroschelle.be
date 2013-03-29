<?php

/**
 *
 * @package WordPress
 * @subpackage stubru
 * Template Name: Wedstrijdpagina2
 */
 
 /**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
 //Facebook-code includen
	get_template_part('base_facebook'); 
	get_template_part('facebook'); 
	include_once('facebook-db.php');

// Create our Application instance (replace this with your appId and secret).

$facebook = new Facebook(array(
  'appId'  => '159977697400872',
  'secret' => 'c04e5124563cb4b65602444aa7964847',
));
$eventid = '221233804574737';

$app_id = "159977697400872";
$app_secret = "c04e5124563cb4b65602444aa7964847";
$my_url = "http://www.stubru.chiroschelle.be/wall";
$event_id = "221233804574737";


// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	
	//print_r($user_profile);
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}



get_header();
get_sidebar();
?>

<div id="content" class="">
  <h1>Doe mee aan onze wedstrijden</h1>
  <a href="https://www.facebook.com/dialog/oauth?client_id=<?php echo $app_id;?>&redirect_uri=http://stubru.chiroschelle.be/wall&scope=publish_stream,email">LOG IN</a> 
  <?php
  if (isset($_REQUEST['code'])){
   $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=http://stubru.chiroschelle.be/wall&client_secret=" . $app_secret . "&code=" . $_REQUEST['code'];
	
	 $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);
	 $token = $params['access_token'];
	 
	 $jsonstr = "https://graph.facebook.com/me/permissions?access_token=" . $token;
	 $json = file_get_contents($jsonstr);
	$permissions = json_decode($json,true);
	foreach ($permissions as $p){
		foreach ($p as $pe){
			$permission = $pe;
		}
	}
	$jsonstr = "https://graph.facebook.com/me?access_token=" . $token;
	 $json = file_get_contents($jsonstr);
	$user = json_decode($json,true);
	
	if ($user){
	if (inDb($user, 'wall')==true){
		echo "je deed al mee";
	}elseif ($permission['publish_stream'] == 1){
		steekUserInDb($user, "wall");
		$message = 
		"Ik deed mee (en verdubbelde mijn kansen!) ";
		$result = $facebook->api(
  	  '/me/feed/',
    	'post',
   	 array(
	 	'access_token' => $token,
		 'message' => $message,
		 'picture' => "http://stubru.chiroschelle.be/wp-content/themes/stubru/img/head_stubru.png",
		 'link' => "http://stubru.chiroschelle.be/wedstrijd/",
		 'name' => "Doe mee en win!",
		 'caption' => 'Was het nu 80, 90 of 2000? - 10/09/2011',
		 'description' => "Doe mee en maak kans op een laptop ter waarde van €500, een weekendje rijden in een fiat 500, gratis tickets en meer! ",
		 
		 
		 
		 )
	);
		if ($result){
			echo "gelukt!";
		}else{
			echo "mislukt!";
		}
		
	}else{
		echo "geef eerst toestemming";
	}
  }
  }

?>
  
  
  
  </div>
  
<!-- Close #content -->
<div class="clearfix"></div>
</div>
<!-- Close #content_wrapper -->
<?php get_footer(); ?>
