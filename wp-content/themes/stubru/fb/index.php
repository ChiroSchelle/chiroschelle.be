<?php
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

require 'src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '159977697400872',
  'secret' => 'c04e5124563cb4b65602444aa7964847',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
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
$jsonstring = "https://graph.facebook.com/221233804574737/attending?access_token=$_SESSION[fb_159977697400872_access_token]";
$json = file_get_contents($jsonstring);
$fuif = json_decode($json);

print_r($fuif);

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>FB-app</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
  <h1>Test voor ChiroSchelle - fuif?</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        <a href="<?php echo $loginUrl.'&scope=email,rsvp_event'; ?>"><img src="http://cache.boston.com/universal/regi/images/fb-login-button.png" alt="pol" width="154" height="22"></a>

    <?php endif ?>

   <!-- <h3>PHP Session</h3>
    <pre><?php //print_r($_SESSION); ?></pre>
	<pre><?php //print_r($_SESSION[fb_159977697400872_access_token]); ?></pre>-->

    <?php if ($user): ?>
  	  <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture"><br/>
      <?php echo $user; ?>
      
      
     <?php if( isset($_POST['rsvp']) ) {
    	// Form submitted, call the Graph API to RSVP to the event
		echo 'test';
    	$event_rsvp = "https://graph.facebook.com/221233804574737/{$_POST['rsvp']}?method=post&" . $access_token;
    	$rsvped = json_decode(file_get_contents($event_rsvp));
    	if($rsvped) {
        	$msg = "Your RSVP status is now <strong>{$_POST['rsvp']}</strong>";
        	$rsvp_status = $_POST['rsvp'];
    		}
		}?>
        <?php if( isset($msg) ) { ?>
		<p id="msg"><?php echo $msg; ?></p>
		<?php } ?>
        <form action="" method="post">
    	<p>
            <label for="privacy_type">RSVP:</label>
            <input type="radio" name="rsvp" value="attending" <?php if($rsvp_status==="attending") echo "checked='checked'"; ?>/>Attending&nbsp;&nbsp;&nbsp;
            <input type="radio" name="rsvp" value="maybe" <?php if($rsvp_status==="maybe" || $rsvp_status==="unsure") echo "checked='checked'"; ?>/>Maybe&nbsp;&nbsp;&nbsp;
            <input type="radio" name="rsvp" value="declined" <?php if($rsvp_status==="declined") echo "checked='checked'"; ?>/>Not Attending&nbsp;&nbsp;&nbsp;
    	</p>
    	<p><input type="submit" value="RSVP to this event" /></p>
		</form>

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

<h4>komen al:</h4>
<?php
foreach ($fuif->data as $attending) {
  //print_r($attending);
  echo "{$attending->name} <img src=\"https://graph.facebook.com/{$attending->id}/picture\"/><br/>";
}?>
  </body>
</html>
