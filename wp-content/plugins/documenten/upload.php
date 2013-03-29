<?php
global $current_user;
      get_currentuserinfo();
      $afdeling =$current_user->afdeling;
      $uid = $current_user->ID;

// Where the file is going to be placed
$target_path = WP_CONTENT_DIR . '/uploads/documenten/';
$documenten_options = get_option('documenten_options');



if (isset($_POST['submit'])){
	/* Add the original filename to our target path.
	Result is "uploads/filename.extension" */




	$bestandsnaam = basename( $_FILES['uploadedfile']['name']);
	$target_path = $target_path . $bestandsnaam;

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	    //echo '<div id="message" class="updated fade" The file '.  basename( $_FILES['uploadedfile']['name'])." has been uploaded</div>";
	   $to = '';
		 $naar = documenten_splits($documenten_options['email_schijf']);
		 foreach ($naar as $e){
		 	$to .= "<$e>,";
		 }
	$subject = "[ChiroSchelle.be] Upload van " . $current_user->first_name . " ". $current_user->last_name;
	$opmerkingen = $_POST['opm'];
	$bericht =
"Geüpload door: ".$current_user->first_name . " ". $current_user->last_name . "
Afdeling: " . maaknummerafdeling($afdeling) . "
Verzonden op: " . date("d-m-Y H:i:s",time()) . "
Bestandsnaam : $bestandsnaam
------------Opmerkingen------------
$opmerkingen
------------Opmerkingen------------




--
verzonden via chiroschelle.be";
	$from = $current_user->user_email;
	$fromname = $current_user->first_name . ' ' . $current_user->last_name;
	$headers = "From: $fromname <$from> \r\n";
	$headers .= "Reply-To: $from \r\n";
	if ($_POST['medeleiding']== 1){
		$afdelingemail = strtolower(str_replace(" ", "", maaknummerafdeling($afdeling)) . '@chiroschelle.be');
		$headers .= "CC: $afdelingemail";
	}
	elseif ($_POST['cc'] == 1){
		$headers .= "CC: $from \r\n";
	}

	$attachments = array($target_path);

	wp_mail($to, $subject, $bericht, $headers, $attachments);
	unlink($target_path);

	    ?><div id="message" class="updated fade">Gelukt!</h1></div><?php

	} else{
	    echo '<div class="error" >There was an error uploading the file, please try again!</div>';
	}
}

//mail de file


?>
<div class="wrap">
<h2>Document Uploaden</h2>
<p>Gebruik dit formulier om al je documenten die in het chiroarchief zouden moeten te verzenden (LK-verslagen doe je via &quot;verslagen LK&quot;à</p>
<form enctype="multipart/form-data"  method="POST">

<table>
	<tr><td>Kies document</td><td><input name="uploadedfile" type="file" /></td></tr>
	<tr><td>Stuur mezelf een kopie: </td><td><input type="checkbox" name="cc" value="1" /></td></tr>
	<tr><td>Opmerkingen: </td><td><textarea name="opm" cols="50" rows="8"></textarea></td></tr>
</table>
<p class="submit">
<input class="button-primary" type="submit" value="Upload File" name="submit" />
</p>
</form>
</div>