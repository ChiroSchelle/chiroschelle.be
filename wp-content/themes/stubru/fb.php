<?php

/**
 *
 * @package WordPress
 * @subpackage stubru
 * Template Name: Wedstrijdpagina
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
	steekUserInDb($user_profile);
	//print_r($user_profile);
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

//Haal de info op over ons event.
$jsonstring = "https://graph.facebook.com/$eventid/attending?access_token=$_SESSION[fb_159977697400872_access_token]";
$json = file_get_contents($jsonstring);
$aanwezigen = json_decode($json);


$app_id = "159977697400872";
$app_secret = "c04e5124563cb4b65602444aa7964847";
$my_url = "http://www.stubru.chiroschelle.be/wedstrijd";
$event_id = "221233804574737";
$rsvp_status = "";
 
$code = $_REQUEST["code"];
 
//if(empty($code)) {
    //$auth_url = "http://www.facebook.com/dialog/oauth?client_id=". $app_id . "&redirect_uri=" . urlencode($my_url). "&scope=rsvp_event,email";
//}else{
	$auth_url = $facebook->getLoginUrl();
	$auth_url .= '&scope=email,rsvp_event';
//}
//check hoeveel keer pagina werd bezocht:
if ($_SESSION['count'] == ""){
	$_SESSION['count'] = 1;
}elseif ($_REQUEST['state'] != ""){
	$_SESSION['count'] = 2;
}elseif ($_REQUEST['state'] == ''){
	$_SESSION['count'] = 1;
}

 
$token_url = "https://graph.facebook.com/oauth/access_token?client_id=". $app_id . "&redirect_uri=" . urlencode($my_url). "&client_secret=" . $app_secret. "&code=" . $code;
$access_token = file_get_contents($token_url);

//post
if( isset($_POST['rsvp']) ) {
    // Form submitted, call the Graph API to RSVP to the event
    echo $event_rsvp = "https://graph.facebook.com/$eventid/{$_POST['rsvp']}?method=post&" . $access_token;
    $rsvped = json_decode(file_get_contents($event_rsvp));
    if($rsvped) {
       echo $msg = "Your RSVP status is now <strong>{$_POST['rsvp']}</strong>";
        $rsvp_status = $_POST['rsvp'];
    }
}



//hoofding en sidebar ophalen, dan de rest... 
get_header();
get_sidebar();
?>

<div id="content" class="">
  <h1>Doe mee aan onze wedstrijden</h1>
  <?php if ($user): 
  //failsafe
  steekUserInDb($user_profile);
  ?>
  <h2>Bedankt voor de deelname <?php echo $user_profile[first_name] ?>!</h2>
  <?php //print_r($user_profile); 
    ##START VERDUBBEL JE KANSEN##
  if (isset($_REQUEST['code'])){
   $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=http://stubru.chiroschelle.be/wedstrijd&client_secret=" . $app_secret . "&code=" . $_REQUEST['code'];
	
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
		echo "<p>Je kansen zijn verdubbeld</p>";
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
			echo "<p>Er is een bericht op je wall gepost!</p>";
		}else{
			echo "<p>Er ging iets mis, probeer later nog eens.</p>";
		}
		
	}else{
		?>
  <p> Post op je wall dat je deelnam aan onze wedstrijd, en verdubbel je kansen! Het enige wat je hoeft te doen is op de knop klikken:</p>
  <?php echo "<a href='https://www.facebook.com/dialog/oauth?client_id=$app_id&redirect_uri=http://stubru.chiroschelle.be/wedstrijd&scope=publish_stream,email'><img src='http://stubru.chiroschelle.be/wp-content/themes/stubru/img/btn_verdubbel.png' alt='VERDUBBEL JE KANSEN' /></a>"; ?>
  <p>volgend bericht zal op je wall worden gepost: <br />
    <br />
    <img src="http://stubru.chiroschelle.be/wp-content/themes/stubru/img/fb_post.jpg" alt="voorbeeld facebookpost" />
    <?php 
	}
  }
  }else{
	  ?>
  <p> Post op je wall dat je deelnam aan onze wedstrijd, en verdubbel je kansen!. Het enige wat je hoeft te doen is op de knop klikken:</p>
  <?php echo "<a href='https://www.facebook.com/dialog/oauth?client_id=$app_id&redirect_uri=http://stubru.chiroschelle.be/wedstrijd&scope=publish_stream,email'><img src='http://stubru.chiroschelle.be/wp-content/themes/stubru/img/btn_verdubbel.png' alt='VERDUBBEL JE KANSEN' /></a>"; ?>
  <p>volgend bericht zal op je wall worden gepost: <br />
    <br />
    <img src="http://stubru.chiroschelle.be/wp-content/themes/stubru/img/fb_post.jpg" alt="voorbeeld facebookpost" />
    <?php 
  }
		
##STOP VERDUBBEL JE KANSEN##
?>
  <p>De winnaars zullen via e-mail op de hoogte worden gebracht.</p>
  <h3>Deze personen komen al zeker naar de fuif</h3>
  <?php  	
	$i=0;
	foreach ($aanwezigen->data as $attending) {
		$id1[$i]['id'] = $attending->id;
		$id1[$i]['naam'] = $attending->name;
		
		$i++;
	}
	$rand_keys = array_rand($id1, 21);
	$ids = array ( $id1[$rand_keys[0]] );
	for ($i=1; $i<21; $i++){
		array_push($ids,$id1[$rand_keys[$i]]);
	}
				  
	
	echo "<ul class=\"participants\">";
	$i=0;
	foreach ($ids as $id) {
		$i++;
	 /*switch ($i){
		  case 1:
		   echo '<tr>';
		   break;
		case 4:
			echo '</tr><tr>';
			break;
		case 7:
			echo '</tr><tr>';
			break;
	  }*/
	  echo "<li><img src=\"https://graph.facebook.com/{$id['id']}/picture\"/><br/>{$id['naam']}</li>";
	  
	 /* if ($i == 9){echo '</tr>'; }*/
	  	}?>
  </ul>
  <div class="clearfix"></div>
  <!--<form action="" method="post">
    <input type="hidden" name="rsvp" value="attending" <?php if($rsvp_status==="attending") echo "checked='checked'"; ?>/>
    <p>
      <input type="submit" value="Ik kom ook!" />
    </p>
  </form>-->
  <p>Laat <a href="http://www.facebook.com/event.php?eid=221233804574737">hier</a> weten of je er ook zal zijn.</p>
  <?php else: ?>
  <p>En maak kans op:</p>
  <ul>
    <li>Een laptop, ter waarde van €500, geschonken door <a href="http://www.alternate.be">Alternate</a></li>
    <li>Een weekendje cruisen in een Fiat 500 (dankzij garage de Linde)</li>
    <li>Inkomtickets voor onze fuif (dankzij André de Clercq - <a href="http://www.melis-debo.be">Verzekeringskantoor Melis-Debo-Hermans</a>)</li>
    <li>Kortingsbons voor Bobbejaandland</li>
    <li>Kortingsbons voor Pizzahut</li>
  </ul>
  <h2>Doe mee... Log in via Facebook</h2>
  <p>Het enige wat je hoeft te doen is via je facebook-account toestemming geven aan onze "Was het nu 80, 90 of 2000?"-wedstrijd applicatie.</p>
  <a href="<?php echo $auth_url;//'&scope=email,rsvp_event'; ?>">
  <?php if ($_SESSION['count'] == 2){
			//echo "DOE MEE!"; ?>
  <img src="http://stubru.chiroschelle.be/wp-content/themes/stubru/img/btn_doemee.png" alt="doe mee" width="170" height="50">
  <?php
		}else{
			//echo "GEEF ONZE APP TOESTEMMING";?>
  <img src="http://cache.boston.com/universal/regi/images/fb-login-button.png" alt="pol" width="154" height="22">
  <?php
		}
	
   ?>
  </a>
  <?php endif ?>
  <h2>Geen facebook?</h2>
  <h3>Geen probleem!</h3>
  <p>We doen niet enkel wedstrijden via facebook. Ook via <a href="http://twitter.com/chiroschelle">Twitter</a> vallen er prijzen te winnen. Volg ons en retweet onze wedstrijd-tweet</p>
  <h2>Ook geen twitter?</h2>
  <p>Geen paniek! Ook alle eigenaars van een echte voorverkoopkaart maken kans op een van deze prijzen! Snel dus naar een van de <a href="http://stubru.chiroschelle.be/programma/studio-brussel-fuif/">voorverkooppunten</a>!</p>
  <h2>Hang de STF-affiche voor het raam en win!</h2>
  <p>Er zijn tickets voor het STF en de Stubru-fuif te winnen. Wij geven weg:</p>
  <ul>
    <li>20 x 2 tickets voor het STF</li>
    <li>10 x 2 tickets voor de Stubru-fuif</li>
  </ul>
  <p>Om te winnen, hang je de STF-affiche goed zichtbaar voor je raam.
    We noteren in de maand augustus de adressen waar de affiche hangt en trekken er de winnaars uit.
    De winnaarslijst wordt op 10 september aan de ingangen van het STF-feestterrein en de tent van de Stubrufuif uitgehangen.<br />
    De winnaars kunnen daar meteen hun tickets afhalen.</p>
</div>
<!-- Close #content -->
<div class="clearfix"></div>
</div>
<!-- Close #content_wrapper -->
<?php get_footer(); ?>
