<?php
global $current_user;
      get_currentuserinfo();
      $afdeling =$current_user->afdeling;
      $uid = $current_user->ID;

$maand = date('n', time());
$jaar = date('Y', time());
if ($maand>=9 && $maand <=12){//september-december
	$folder = $jaar . '-' . $jaar + 1;
	$start = $jaar;
}else{ // januari-augustus
	$folder = $jaar - 1 . '-' . $jaar;
	$start = $jaar - 1;
}
if (isset($_GET['folder'])){
	$folder = $_GET['folder'];
}



$dir = WP_CONTENT_DIR . '/uploads/verslagen/' . $folder . '/';

$url = get_bloginfo('url') . '/wp-content/uploads/verslagen/' . $folder . '/';



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



	$bestandsnaam = $nr . '_LK_' . $_POST['jaar'] . '-' . maaktweecijfer($_POST['maand']) . '-' . maaktweecijfer($_POST['dag']) . '_' . $_POST['initiaal'] . '.' . $ext;
	$target_path = $dir . $bestandsnaam;

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
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
		if (file_exists(WP_CONTENT_DIR . '/uploads/verslagen/' . $print . '/')){
			echo '<option value="' . $print . '" ';
			if ($folder == $print){ echo 'selected="selected" ';}
			echo '>' . $print . '</option>';
		}
	}
	?>
</select> <input type="submit" name="kies_jaar" value="Kies jaar" class="button-primary" /><input type="hidden" name="page" value="chiroleden-submenu-verslagen" />
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
			echo "<li><a href='$fileurl'>$f</a> ($kB kB)</li>";
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
  <h1>BOE!</h1>
  <form method="post" enctype="multipart/form-data">
  <table>
  <tr><td>Bestand</td><td><input type="file" name="uploadedfile" /></td></tr>
  <tr><td>Geschreven door:</td><td><input type="text" name="naam" value="<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>" /></td></tr>
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
  <tr><td>nr LK</td><td><input type="text" size="2" name="nr" value="<?php echo maaktweecijfer($aantal); ?>" /></td></tr>
  <tr><td>&nbsp;</td><td><input type="submit" name="upload" value="Verzend" class="button-primary" /></tr>

  </table>

  </form>

  </div>

  </div>