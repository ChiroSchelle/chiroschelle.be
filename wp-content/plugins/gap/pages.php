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

add_action('admin_menu', 'gap_menu');

function gap_menu()
{
    add_options_page('GAP', 'GAP Ledenbeheer', 'edit_ledenbeheer', 'gap_options_page', 'gap_display_options_page');
    $icon_url = plugins_url('images/plugin-menu-icon16.png', __FILE__);
    add_menu_page('', 'GAP Ledenbeheer', 'view_ledenbeheer', GAP_NAME, 'gap_display_page', $icon_url) ;
    //add_submenu_page( GAP_NAME, 'GAP Ledenbeheer', 'GAP Ledenbeheer', 'rank_leiding', 'gap_page', 'gap_display_page');
}

function gap_display_options_page()
{
?>
    <div class="wrap">
        <h2>GAP Ledenbeheer opties</h2>
        <form action="options.php" method="post">
            <?php settings_fields('gap_options'); ?>
            <?php do_settings_sections('gap'); ?>
            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php 
//    gap_display_page();
}

function gap_display_page() {
    global $current_user, $protocol, $server, $directory ;
    $afdeling = false;
    $werkjaar = false;

		if (isset($_POST['afdeling'])) {
        $afdeling = $_POST['afdeling'];
    }
    else {
        $afdeling =$current_user->afdeling;
    }
    if (isset($_POST['werkjaar'])) {
        $werkjaar = $_POST['werkjaar'];
    }
    
?>
<div class="wrap">
<h2>GAP Ledenlijst</h2>
<form id="kies_afdeling" method="post">
  <p><label for="afdeling">Afdeling:</label><select name="afdeling">
  	<?php
  	for ($i=1;$i<=12;$i++){
  		echo '<option value="' . $i .'" ';
  		if ($i == $afdeling) {echo 'selected="selected" ';}
  		echo '>' . maaknummerafdeling($i) . '</option>';
  	}
  	echo '<option value="O"' ;
	if (0 == $afdeling) {echo 'selected="selected" ';}
	echo '>Iedereen</option>';
  	?>
  	</select>
  	</p>
  	<p><input name="xlsx" type="checkbox"> Maak xlsx-download</input>
  	</p> Opgelet:
      	<lu>
      	    <li>Het maken van de xlsx-download kan even duren</li>
      	    <li>Deze pagina werkt enkel als <?php echo "$protocol://$server/$directory"; ?> online is </li>
            <li>Als een lid meerder gegevens bij dezelfde communicatievorm heeft (adres, telefoon, e-mail), komt hier maar 1 van in de lijst</li>
            <li>De meeste telefoonnummers en e-mailadressen zijn van ouders.</li>
      	 </lu>
  <p class="submit">
	<input type="submit" name="submit" value="toon lijst" class="button-primary">
	</p>
  </form>
<?php
    //don't do anything else if the gap-server is offline
    $offline_status = gap_server_offline();
    if ( $offline_status) {
        echo "<h3>We kunnen de server niet bereiken, probeer later nog eens (code $offline_status)</h3>";
    }
    else{
        if(isset($_POST['xlsx']) && $_POST['xlsx']) {
            $link = gap_get_download_link($afdeling);
?>
            <form>
                <p><a href="<?php echo $link; ?>"><input type="button" value="Download lijst" /></a></p>
<?php
        }
        elseif (isset($_POST['gap_ids'])) {
        	gap_edit_leden();
    	}
        else { //geen xlsx en geen edit_leden
            gap_echo_table($afdeling);
        }
    } // else offline_status
    echo '</div>';
}

// hang de functie gap_admin_init aan de actie admin_init
add_action('admin_init','gap_admin_init');

function gap_admin_init()
/**
* Maak een settingspagina + plaats in de db voor GAP
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
    // we gaan een optie gap_options (param2) toevoegen aan de groep gap_options (param 1).
    // Als we deze optie aanpassen, gaan we die eerst valideren met gap_options_sanitize 
    register_setting('gap_options','gap_options', 'gap_options_sanitize');
    
    // voeg een sectie toe aan de pagina gap, met als titel Server Settings, als id gap_server_section en
    // als uit te voeren functie gap_server_section_text
    add_settings_section('gap_server_section', 'Server Settings', 'gap_server_section_text', 'gap');
    
    // We voegen een veld toe aan de sectie gap_server_section, met als naam Protocol, als id gap_protocol, op de pagina gap en als functie gap_settings_protocol
    add_settings_field('gap_protocol', 'Protocol', 'gap_settings_protocol', 'gap', 'gap_server_section');
    // de rest is hier gelijkaardig
    add_settings_field('gap_username', 'Gebruiksnaam', 'gap_settings_username', 'gap', 'gap_server_section');
    add_settings_field('gap_password', 'Wachtwoord', 'gap_settings_password', 'gap', 'gap_server_section');
    add_settings_field('gap_server', 'Server', 'gap_settings_server', 'gap', 'gap_server_section');
    add_settings_field('gap_directory', 'Omgeving', 'gap_settings_directory', 'gap', 'gap_server_section');
    add_settings_field('gap_groupID', 'Groep ID', 'gap_settings_groupID', 'gap', 'gap_server_section');

//    add_settings_field('gap_afdelingIDs', 'afdeling IDs', 'gap_afdelingIDs', 'gap', 'gap_server_section');
//    add_settings_field('gap_werkjaarIDS', 'werkjaar IDs', 'gap_werkjaarIDs', 'gap', 'gap_server_section');

    add_settings_section('gap_clean_section', 'Kuis op', 'gap_clean_section_text', 'gap');
		add_settings_field('gap_clean_tmp', 'tmp', 'gap_clean_tmp', 'gap', 'gap_clean_section');

}
function gap_server_section_text()
{
echo '
<p>Vul hier de server settings in. Je kan deze uit de url halen als je naar het Groepsadminstratieprogramma surft.</p>
<p>voorbeeld: url = https://gap.chiro.be/live/493</p>
    <ul>
        <li>protocol = https</li>
        <li>server = gap.chiro.be</li>
        <li>omgeving = live</li>
        <li>groep ID = 493</li>
    </ul>
';
}


function gap_settings_protocol()
// hier maken we gebruik van de global, ipv get_option en dan iets uit de array te halen.
{
    global $protocol;
    
    echo'<input id="gap_protocol_https" name="gap_options[protocol]" value="https" type="radio" ';
    if ($protocol == 'https') {
        echo 'checked ';
    }
    echo '/><label for="gap_protocol_https">https</label></br>';
    echo '<input id="gap_protocol_http" name="gap_options[protocol]" value="http" type="radio" ';
    if ($protocol == 'http') {
        echo 'checked ';
    }
    echo '/><label for="gap_protocol_http">http (server moet dit ondersteunen)</label>';
}

function gap_settings_username()
{
    $options = get_option('gap_options');
    echo "<input id='gap_username' name='gap_options[username]' size='20' type='text' value='{$options['username']}' />";
}
function gap_settings_password()
{
    //$options = get_option('gap_options');
    echo "<input id='gap_password' name='gap_options[password]' size='20' type='password' value='' /><label for='gap_password'>Laat leeg om het huidige wachtwoord te blijven gebruiken</label>";
}
function gap_settings_server()
{
    $options = get_option('gap_options');
    echo "<input id='gap_server' name='gap_options[server]' size='20' type='text' value='{$options['server']}' />";
}
function gap_settings_directory()
{
    global $directory;
    echo '<input id="gap_directory_live" name="gap_options[directory]" type="radio" value="live" ';
    if ($directory == 'live') {
        echo 'checked ';
    }
    echo '/><label for="gap_directory_live">live</label></br>';
    echo '<input id="gap_directory_gap" name="gap_options[directory]" type="radio" value="gap" ';
    if ($directory == 'gap') {
        echo 'checked ';
    }
    echo '/><label for="gap_directory_gap">gap (test-omgeving: account moet hier rechten voor hebben)</label>';
}

function gap_settings_groupID()
{
    $options = get_option('gap_options');
    echo "<input id='gap_groupID' name='gap_options[groupID]' size='20' type='text' value='{$options['groupID']}' />";
}
function gap_clean_section_text()
{
		echo "<p>Hier iets aanduiden zorgt er voor dat de andere instellingen niet veranderen</p>";
}
function gap_clean_tmp()
{
	echo "<input id='gap_clean_tmp' name='gap_options[clean_tmp]' type='checkbox' /><label for='gap_clean_tmp'>verwijder wp_content/uploads/tmp (waar de .xlsx-bestanden worden opgeslagen)</label>";
}
function gap_options_sanitize($input)
/**
* sanitize the settings input
*
* sanitize the settings input
*
* @package GAP
* @since 0.2
*
* @param array input input
* @return array output
**/
{    

    $options = get_option('gap_options');
    if (isset($input['clean_tmp'])) {
			if (file_exists(WP_CONTENT_DIR . '/uploads/tmp/')){
				gap_delete_directory(WP_CONTENT_DIR . '/uploads/tmp/');
			}
			mkdir(WP_CONTENT_DIR . '/uploads/tmp/');
			$output = $options;
		}
		else{
			$output = $input; // trust everything by default
		  // opm. Ben: dit is niet ideaal, maar (voorlopig) kunnen verkeerde instellingen
		  // niet meer doen dan het ophalen van de ledenlijst tegenwerken.
		  //if the password is empty, get the current password and use that.
		  $output['password'] = ($input['password'] == '') ? $options['password'] : $input['password'];
	//    echo "input : {$input['password']} options: {$options['password']} output: {$output['password']}" ;
		  //protocol should be http or http
		  $output['protocol'] = (!$input['protocol'] == 'http') ? 'https' : $input['protocol'];
		  $output['groupID'] = (!intval($input['groupID'])) ? '493' : $input['groupID'] ;
		}
		return $output;
}
?>
