<?php
global $current_user;
      get_currentuserinfo();
      $afdeling =$current_user->afdeling;
      $uid = $current_user->ID;

$maand = date('n', time());
$jaar = date('Y', time());
if ($maand>=9 && $maand <=12){//september-december
	// JOB Geen idee waarom dit niet in één keer kan, maar anders krijg ik als folder enkel '2011' (in sept 2010)
	$jaarplus1 = $jaar + 1;
	$folder = $jaar . '-' . $jaarplus1;
	$start = $jaar;
	
}else{ // januari-augustus
	$folder = $jaar - 1 . '-' . $jaar;
	$start = $jaar - 1;
}
if (isset($_GET['folder'])){
	$folder = $_GET['folder'];
}


$documenten_options = get_option('documenten_options');

$dir = WP_CONTENT_DIR . '/uploads/documenten/Verslagen/' . $folder . '/';

$url = get_bloginfo('url') . '/wp-content/uploads/documenten/Verslagen/' . $folder . '/';



if (file_exists($dir)){
	if ($handle = opendir($dir)) {

	    /* This is the correct way to loop over the directory. */
	    $i = 0;
	    while (false !== ($file = readdir($handle))) {
	    	if ($file != "." && $file != "..") {
		        $files[$i] = $file;
		        $i ++;
	    	}
	    }
	}
	sort($files);
	$aantal = count($files) + 1;
}



if (isset($_POST['upload'])){
	/* Add the original filename to our target path.
	Result is "uploads/filename.extension" */

	$pathinfo = pathinfo($_FILES['uploadedfile']['name']);
	$ext = $pathinfo['extension'];
	$nr = $_POST['nr']; // nog automatisch te berekenen



	$bestandsnaam = 'LK_' . $_POST['jaar'] . '-' . maaktweecijfer($_POST['maand']) . '-' . maaktweecijfer($_POST['dag']) . '_' . $_POST['initiaal'] . '.' . $ext;
	$target_path = $dir . $bestandsnaam;

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

		//STUUR HET VERSLAG VIA MAIL: //
		 $to = '';
		 $naar =  explode(" ", $documenten_options['email_updates']);//documenten_splits($documenten_options['email_updates']);
		 for ($a=0; $a<count($naar);$a++){
		 //foreach ($naar as $e){
		 	$to .= '<'. $naar[$a] . '>, ';

		 }

		$subject = "Verslag LK " . maaktweecijfer($_POST['dag']) . '-' . maaktweecijfer($_POST['maand']) . '-' . $_POST['jaar'];
		$opmerkingen = $_POST['opm'];
		$bericht =
"Geüpload door: ".$current_user->first_name . " ". $current_user->last_name . "
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

	wp_mail($to, $subject, $bericht, $headers, $attachments) or die('error!');




//mail de file


		?>

		<div id="message" class="updated fade">Succesvol toegevoegd (<?php echo $bestandsnaam; ?>) <form method="post"><input type="submit" name="refresh" value="Herlaad pagina" /></form></div><?php
	}else {
		?>
		<div class="error">Er ging iets goed fout ;-)</div>
		<?php
	}
}
?>
<div id="wrap">
<h2>Verslagen LK <?php echo $folder; ?></h3>
<form method="get">
<p><label for="folder">Kies Jaar</label>
<select name="folder">
	<?php
	for ($j=$start; $j>=2001;$j--){
		$j2 = $j+1;
		$print = $j . '-' . $j2;
		if (file_exists(WP_CONTENT_DIR . '/uploads/documenten/Verslagen/' . $print . '/')){
			echo '<option value="' . $print . '" ';
			if ($folder == $print){ echo 'selected="selected" ';}
			echo '>' . $print . '</option>';
		}
	}
	?>
</select> <input type="submit" name="kies_jaar" value="Kies jaar" class="button-primary" /><input type="hidden" name="page" value="documenten-submenu-verslagen" />
</p>


</form>



<?php
if (isset($files)){
	echo '<p><ul>';

	foreach ($files as $f){
		$fileurl = $url . $f;
		$filename = $dir . $f;
		$kB = round(filesize($filename) / 1024, 1);

		if (!is_dir($filename)){
			$pathinfo = pathinfo($f);
			$ext = $pathinfo['extension'];
			$img = documenten_get_image($ext);

			echo "<li><img src='$img' width='16px' height='16px' /> <a href='$fileurl'>$f</a> ($kB kB)</li>";
		}else {
			$aantal--;
		}
	}
	echo '</ul></p>';
}else{
	?>
	<div class="error">Er staan voor dit jaar (nog) geen verslagen op de site</div>
	<?php
}

  ?>
  <p><a  href="#" class="show_toevoegen"><input type="button" value="Voeg een verslag toe" /></a></p>
  <div id="toevoegen">
  <form method="post" enctype="multipart/form-data">
  <table>
  <tr><td>Bestand</td><td><input type="file" name="uploadedfile" /></td></tr>
  <!--<tr><td>Geschreven door:</td><td><input type="text" name="naam" value="<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>" /></td></tr>-->
  <tr><td>Initialen: </td><td><input type="text" size="4"  name="initiaal" value="<?php echo strtoupper(substr($current_user->first_name,0,2) . substr($current_user->last_name,0,1) . substr($current_user->geboorte,2,2)); ?>" /></td></tr>
  <tr><td>Datum LK</td><td>
  <select name="dag">
			<option value="0"> -- </option>
			<?php
			for ($i=1;$i<=31;$i++){
				if ($i == $_POST['dag']){
					$selected = 'selected=selected"';
				}else{
					$selected = '';
				}
				echo "<option value='". maaktweecijfer($i) . "' $selected>$i</option>";
			}
			?>
		</select>
		<select name="maand">
			<option value="0"> -- </option>
			<option value="1" <?php if ($_POST['maand'] ==01) { echo 'selected ="selected"'; } ?>>januari</option>
			<option value="2" <?php if ($_POST['maand'] ==02) { echo 'selected ="selected"'; } ?>>februari</option>
			<option value="3" <?php if ($_POST['maand'] ==03) { echo 'selected ="selected"'; } ?>>maart</option>
			<option value="4" <?php if ($_POST['maand'] ==04) { echo 'selected ="selected"'; } ?>>april</option>
			<option value="5" <?php if ($_POST['maand'] ==05) { echo 'selected ="selected"'; } ?>>mei</option>
			<option value="6" <?php if ($_POST['maand'] ==06) { echo 'selected ="selected"'; } ?>>juni</option>
			<option value="7" <?php if ($_POST['maand'] ==07) { echo 'selected ="selected"'; } ?>>juli</option>
			<option value="8" <?php if ($_POST['maand'] ==08) { echo 'selected ="selected"'; } ?>>augustus</option>
			<option value="9" <?php if ($_POST['maand'] ==09) { echo 'selected ="selected"'; } ?>>september</option>
			<option value="10" <?php if ($_POST['maand'] ==10) { echo 'selected ="selected"'; } ?>>oktober</option>
			<option value="11" <?php if ($_POST['maand'] ==11) { echo 'selected ="selected"'; } ?>>november</option>
			<option value="12" <?php if ($_POST['maand'] ==12) { echo 'selected ="selected"'; } ?>>december</option>
		</select>
		<select name="jaar">
			<option value="0"> -- </option>
			<?php
			for ($i=date('Y',time()); $i>=2000; $i--){
				if ($i == $_POST['jaar']){
					$selected = 'selected=selected"';
				}else {
					$selected = '';
				}
				echo "<option value='$i' $selected>$i</option>";
			}
			?>
		</select>
  </td></tr>
  <!--<tr><td>nr LK</td><td><input type="text" size="2" name="nr" value="<?php echo maaktweecijfer($aantal); ?>" /></td></tr>-->
  <tr><td>Opmerkingen:<br />(enkel in mail)</td><td><textarea name="opm" cols="50" rows="7"></textarea></td></tr>
  <tr><td>&nbsp;</td><td><input type="submit" name="upload" value="Verzend" class="button-primary" /></tr>

  </table>

  </form>

  </div>

  </div>