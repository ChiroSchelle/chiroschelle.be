<?php
/*  Copyright 2010  Ben Bridts  (email : ben.bridts@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('admin_menu', 'docs3_menu');

function docs3_menu()
{
    add_options_page('docs3', 'Documenten S3', 'manage_options', 'docs3_options_page', 'docs3_display_options_page');
    $icon_url = plugins_url('images/plugin-menu-icon16.png', __FILE__);
    add_menu_page('', 'Documenten S3', 'add_documenten', DOCS3_NAME, 'docs3_display_page', $icon_url) ;
    add_submenu_page( DOCS3_NAME, 'Verslagen LK', 'Verslagen LK', 'add_documenten', 'docs3_page', 'docs3_display_verslag_page');
}

function docs3_display_options_page()
{
?>
    <div class="wrap">
        <h2>DocS3 opties</h2>
        <form action="options.php" method="post">
            <?php settings_fields('docs3_options'); ?>
            <?php do_settings_sections('docs3'); ?>
            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php 

}

function docs3_display_page()
{
    
?>
<div class="wrap">
<h2>Documenten S3</h2>
<?php 
	$options = get_option('docs3_options');
	$bucket = $options['bucket'];
	$prefix = $options['prefix'];
	
	
	$s3 = new AmazonS3($options['accesskey'],$options['secretkey']);
	if ($options['nicename']) {
		$s3->set_vhost ( $bucket );
	}
	
	// remember succes and error messages
	$message = '';
	
	//check for upload errors
	if( !isset($_POST['Submit']) || !isset($_POST['dir']) ) { //not uploading file
		$message = false; 
	}
	elseif( $_FILES['theFile']['error'] != UPLOAD_ERR_OK ) {
		$message = 'upload error: ' . $_FILES['theFile']['error'];
	}
	elseif ( isset($_POST['updir']) ) {
		$message = 
		  ( 
			docs3_post_upload (
				$s3,
				$bucket,
			 	$_FILES['theFile'],$_POST['updir'].$_FILES['theFile']['name']
			  )
		    ? 'upload ok'
		    : "upload error: couldn't post to S3 :-("
		  ) ;
	}
	else{
		$message = 
		  ( docs3_post_upload($s3, $bucket, $_FILES['theFile']) 
		    ? 'upload ok' 
		    : "upload error: couldn't post to S3" 
		  );
	}
	
	// display messgae
	if ($message) {
		echo '<p>'.$message.'</p>';
	}
	
	//calculate display settings
	if(isset($_POST['dir'])) {
		$updir = $_POST['dir']; //used in form.
	}		
	elseif (isset($_POST['updir'])) {
		$updir = $_POST['updir']; //used in form
	}
	else {
		$updir = $prefix;
	}	
	
	//display list + chooser
	docs3_dir_chooser($s3,$bucket,$prefix,$updir);
	docs3_list_files($s3,$bucket,$updir,$options['validtime']);

	// display form
?>
<form action="" method="post" enctype="multipart/form-data">  
  <input name="theFile" type="file" />
  <input name="updir" type="hidden" value="<?php echo($updir);?>"/>  
  <input name="Submit" type="submit" value="Upload">  
</form>
</div>
<?php
}

function docs3_display_verslag_page()
{
	$options = get_option('docs3_options');
	$bucket = $options['bucket'];
	$prefix = $options['prefix'] . 'verslagLK';
	
	
	$s3 = new AmazonS3($options['accesskey'],$options['secretkey']);
	if ($options['nicename']) {
		$s3->set_vhost ( $bucket );
	}
		
	if (isset($Files['theFile'])) {
		//uploading verslag
		$pathinfo = pathinfo($_FILES['theFile']['name']);
		$ext = $pathinfo['extension'];
		$newname = 'LK_' . $_POST['jaar'] . '-' . docs3_maaktweecijfer($_POST['maand']) . '-' . docs3_maaktweecijfer($_POST['dag']) . '_' . $_POST['initiaal'] . '.' . $ext ;
	}		
	else{
		$skip=true;
	}
	//check for upload errors
	if( $skip ) { //not uploading file
		$message = false; 
	}
	elseif( $_FILES['theFile']['error'] != UPLOAD_ERR_OK ) {
		$message = 'upload error: ' . $_FILES['theFile']['error'];
	}
	elseif ( isset($_POST['updir']) ) {
		$message = 
		  ( 
			docs3_post_upload (
				$s3,
				$bucket,
			 	$_FILES['theFile'],$_POST['updir'].$newname
			  )
		    ? 'upload ok'
		    : "upload error: couldn't post to S3 :-("
		  ) ;
	}
	else{
		$message = 
		  ( docs3_post_upload($s3, $bucket, $_FILES['theFile'], $prefix.$newname) 
		    ? 'upload ok' 
		    : "upload error: couldn't post to S3" 
		  );
	}
	
	// display messgae
	if ($message) {
		echo '<p>'.$message.'</p>';
	}
	
	//calculate display settings
	if(isset($_POST['dir'])) {
		$updir = $_POST['dir']; //used in form.
	}		
	elseif (isset($_POST['updir'])) {
		$updir = $_POST['updir']; //used in form
	}
	else {
		$updir = $prefix;
	}	
	
	//display list + chooser
	docs3_dir_chooser($s3,$bucket,$prefix,$updir);
	docs3_list_files($s3,$bucket,$updir,$options['validtime']);

	// display form
?>
<form action="" method="post" enctype="multipart/form-data">  
  <input name="theFile" type="file" /><label for="theFile">Bestand</label>
  <input name="initiaal" type="text" size="4" maxlength="4" value="<?php ?>" /><label for="initiaal">Initialen</label>
  <select name ="dag">
  <?php
  	for ($i = 1; $i< 32; $i++) {
  		echo "<option value='$i'>$i</option>";
  	}
  ?>
  </select>
  <select name ="maand">
  <?php
  	for ($i = 1; $i< 12; $i++) {
  		echo "<option value='$i'>$i</option>";
  	}
  ?>
  </select>
  <select name ="jaar">
  <?php
  	for ($i = date('Y')-5; $i<= date('Y'); $i++) {
  		echo "<option value='$i'>$i</option>";
  	}
  ?>
  </select>
  <input name="updir" type="hidden" value="<?php echo($updir);?>"/>  
  <input name="Submit" type="submit" value="Upload">  
</form>
</div>
<?php
}

// hang de functie docs3_admin_init aan de actie admin_init
add_action('admin_init','docs3_admin_init');

function docs3_admin_init()
/**
* Maak een settingspagina + plaats in de db voor docs3
*
* We maken een settingspagina en gebruiken een array om alle opties in de db op te slaan.
*
* @package
* @since 0.1
*
* @ToDo validatie schrijven
*
**/
{
    // we gaan een optie docs3_options (param2) toevoegen aan de groep docs3_options (param 1).
    // Als we deze optie aanpassen, gaan we die eerst valideren met docs3_options_sanitize 
    register_setting('docs3_options','docs3_options', 'docs3_options_sanitize');
    
    // voeg een sectie toe aan de pagina docs3, met als titel Server Settings, als id docs3_settings_section en
    // als uit te voeren functie docs3_settings_section_text
    add_settings_section('docs3_settings_section', 'Instellingen', 'docs3_settings_section_text', 'docs3');
    
    // We voegen een veld toe aan de sectie docs3_settings_section, met als naam Protocol, als id docs3_protocol, op de pagina docs3 en als functie docs3_settings_protocol
    add_settings_field('docs3_accesskey', 'access key', 'docs3_settings_accesskey', 'docs3', 'docs3_settings_section');
    // de rest is hier gelijkaardig
    add_settings_field('docs3_secretkey', 'Secret Key', 'docs3_settings_secretkey', 'docs3', 'docs3_settings_section');
    add_settings_field('docs3_bucket', 'Bucket', 'docs3_settings_bucket', 'docs3', 'docs3_settings_section');
    add_settings_field('docs3_prefix', 'Prefix', 'docs3_settings_prefix', 'docs3', 'docs3_settings_section');
    add_settings_field('docs3_nicename', 'Mooie URL', 'docs3_settings_nicename', 'docs3', 'docs3_settings_section');
    add_settings_field('docs3_validtime', 'Geldigheid', 'docs3_settings_validtime', 'docs3', 'docs3_settings_section');
}
function docs3_settings_section_text()
{
echo '
<p>Vul hier de instellingen in. </p>
';
}

function docs3_settings_accesskey()
{
    $options = get_option('docs3_options');
    echo "<input id='docs3_accesskey' name='docs3_options[accesskey]' size='20' type='text' value='{$options['accesskey']}' />";
}
function docs3_settings_secretkey()
{
    //$options = get_option('docs3_options');
    echo "<input id='docs3_secretkey' name='docs3_options[secretkey]' size='20' type='secretkey' value='' /><label for='docs3_secretkey'>Laat leeg om de huidige sleutel te blijven gebruiken</label>";
}
function docs3_settings_bucket()
{
    $options = get_option('docs3_options');
    echo "<input id='docs3_bucket' name='docs3_options[bucket]' size='20' type='text' value='{$options['bucket']}' />";
}
function docs3_settings_prefix()
{
    $options = get_option('docs3_options');
    echo "<input id='docs3_prefix' name='docs3_options[prefix]' size='20' type='text' value='{$options['prefix']}' /><label for='docs3_prefix'>gebruik / voor mappen</label>";
}

function docs3_settings_nicename()
{
    $options = get_option('docs3_options');
    echo "<input id='docs3_nicename' name='docs3_options[nicename]' type='checkbox' value='true' ";
    if ( $options['nicename'] ) {
        echo 'checked';
    }
    echo "/><label for='docs3_nicename'>gebruiken {$docs3_options['nicename']}</label>";
}

function docs3_settings_validtime()
{
    $options = get_option('docs3_options');
    echo "<input id='docs3_validtime' name='docs3_options[validtime]' size='5' type='text' value='{$options['validtime']}' /><label for='docs3_validtime'>minuten</label>";
}
function docs3_clean_section_text()
{
		echo "<p>Hier iets aanduiden zorgt er voor dat de andere instellingen niet veranderen</p>";
}
function docs3_clean_tmp()
{
	echo "<input id='docs3_clean_tmp' name='docs3_options[clean_tmp]' type='checkbox' /><label for='docs3_clean_tmp'>verwijder wp_content/uploads/tmp (waar de .xlsx-bestanden worden opgeslagen)</label>";
}
function docs3_options_sanitize($input)
/**
* sanitize the settings input
*
* sanitize the settings input
*
* @package docs3
* @since 0.2
*
* @param array input input
* @return array output
**/
{    

    $options = get_option('docs3_options');
	$output = $input; // trust everything by default
	// opm. Ben: dit is niet ideaal
	
	//if the secretkey is empty, get the current secretkey and use that.
	$output['secretkey'] = ($input['secretkey'] == '') ? $options['secretkey'] : $input['secretkey'];
	$output['bucket'] = trim($input['bucket']);
	// if validtime != an int, don't change it.
	$output['validtime'] = (!intval($input['validtime'])) ? 30 : $input['validtime'] ;
	$output['nicename'] = ($input['nicename']) ? true : false;
	return $output;
}
?>
