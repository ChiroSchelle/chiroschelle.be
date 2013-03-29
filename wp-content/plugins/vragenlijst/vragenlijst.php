<?php
/*
Plugin Name: Vragenlijst
Plugin URI:
Description: Extra Chiro-vragenlijst en info
Author: Peter Westwood, Daniel Quinn, aanpassingen door Mante, Jo & Ben Bridts
Version: 0.02
Author URI: http://www.dquinn.net

Add new custom user meta fields to the user's Profile in the WordPress Dashboard.

*/

class custom_user_meta {

function custom_user_meta() {
    if ( is_admin() ) {
        add_action('show_user_profile', array(&$this,'action_show_user_profile'));
        add_action('edit_user_profile', array(&$this,'action_show_user_profile'));
        add_action('personal_options_update', array(&$this,'action_process_option_update'));
        add_action('edit_user_profile_update', array(&$this,'action_process_option_update'));

    }
    // This function shows the form fiend on registration page
		add_action('register_form','show_first_name_field');

		// This is a check to see if you want to make a field required
		add_action('register_post','check_fields',10,3);

		// This inserts the data
		add_action('user_register', 'register_extra_fields');
}

function action_show_user_profile($user) {
    echo get_the_author_meta( 'error', $user->ID);
	?>
	<script type="text/javascript">/* <![CDATA[ */
	var hideFields = [ "aim", "yim", "jabber" ];
	jQuery.each( jQuery( "form#your-profile tr" ), function() {
		var field = jQuery( this ).find( "input,textarea,select" ).attr( "id" );
		if ( hideFields.indexOf( field ) != -1 ) {
			jQuery( this ).remove();
		}
	});
	/* ]]> */</script>
	<p class="submit">

	<input type="submit" name="submit" value="Profiel bijwerken" class="button-primary">
</p>
    <h3>Chiro - Info</h3>
    <table class="form-table">
    <tr>
    	<th><label for="afdeling">Afdeling/chirofunctie</th>
	    <td>
		    <select name="afdeling">
				 <option value="18" <?php if (get_the_author_meta( 'afdeling', $user->ID )==18) {echo 'selected="selected"';} ?>>Oudleiding</option>
		    	 <option value="20" <?php if (get_the_author_meta( 'afdeling', $user->ID )==20) {echo 'selected="selected"';} ?>>Sympathisant</option>

		    	 <?php
		    	 for ($i=1;$i<=12;$i++){
		    	 	echo '<option value="' . $i .'"';
		    	 	if (get_the_author_meta( 'afdeling', $user->ID)==$i){ echo 'selected="selected"';}
		    	 	echo '>' . maaknummerafdeling($i) . '</option>';
		    	 }
		    	 ?>
		    	<option value="19" <?php if (get_the_author_meta( 'afdeling', $user->ID )==19) {echo 'selected="selected"';} ?>>VB</option>
			</select><br />
			<span class="description">Kies je afdeling/chirofunctie</span>
		 </td>
	</tr>
	<tr>
		<th><label for="muziekkapel"><?php _e("Muziekkapellid?"); ?></label></th>
		<td>
			<input id="muziekkapel" class="input"  type="checkbox"  value="1" <?php if (get_the_author_meta( 'muziekkapel', $user->ID) == 1) {echo 'checked="checked"';} ?> name="muziekkapel"/><br />
			<span class="description"><?php _e("Duid aan als je lid bent van de muziekkapel"); ?></span>
		</td>
	</tr>
	<?php global $current_user;
	get_currentuserinfo();
	if (current_user_can('edit_users')){  //toon enkel aan admin's?>
	<tr><th><label for="rank">Rank</th>
    	<td><select name="rank" id="rank">
	     <option value="chirovolk">Chirovolk</option>
	      <option value="leiding" <?php if (get_the_author_meta( 'rank', $user->ID )=='leiding') {echo 'selected="selected"';} ?>>Leiding</option>
	      <option value="vb" <?php if (get_the_author_meta( 'rank', $user->ID )=='vb') {echo 'selected="selected"';} ?>>VB</option>
	      <option value="admin" <?php if (get_the_author_meta( 'rank', $user->ID )=='admin') {echo 'selected="selected"';} ?>>Admin</option>
	      <option value="stuurgroep mk" <?php if (get_the_author_meta( 'rank', $user->ID )=='stuurgroep mk') {echo 'selected="selected"';} ?>>Stuurgroep MK</option>
	      <option value="gast" <?php if (get_the_author_meta( 'rank', $user->ID )=='gast') {echo 'selected="selected"';} ?>>Gast</option>
		</select><br />
	<span class="description">Geef een rank.</span></td></tr>
	    <tr><th><label for="groeps">Groeps?</th><td><input type="checkbox" value="1" <?php if (get_the_author_meta( 'groeps', $user->ID )==1) {echo 'checked="checked"';} ?> name="groeps" id="groeps" /><br />
	<span class="description">Duid aan als groepsleiding</span></td></tr>
	<?php } ?>
	</table>
<p class="submit">

	<input type="submit" name="submit" value="Profiel bijwerken" class="button-primary">
</p>
	<h3>Persoonlijke Info</h3>
	<table class="form-table">
		<tr>
			<th><label for="straat"><?php _e("Straat"); ?></label></th>
			<td>
				<input type="text" name="straat" id="straat" value="<?php echo esc_attr( get_the_author_meta( 'straat', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e("Vul je straat in."); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="nr"><?php _e("Nummer:"); ?></label></th>
			<td>
				<input type="text" name="nr" id="nr" value="<?php echo esc_attr( get_the_author_meta( 'nr', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e("Vul je huisnummer in."); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="postcode"><?php _e("Postcode:"); ?></label></th>
			<td>
				<input type="text" name="postcode" id="postcode" value="<?php echo esc_attr( get_the_author_meta( 'postcode', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e("Vul je postcode in."); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="gemeente"><?php _e("Gemeente"); ?></label></th>
			<td>
				<input type="text" name="gemeente" id="gemeente" value="<?php echo esc_attr( get_the_author_meta( 'gemeente', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e("Vul je Gemeente is."); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="telefoon"><?php _e("Telefoonnummer"); ?></label></th>
			<td>
				<input type="text" name="telefoon" id="telefoon" value="<?php echo esc_attr( get_the_author_meta( 'telefoon', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e("Vul je telefoon in (0000 00 00 00 of 00 000 00 00."); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="geboorte"><?php _e("Geboortedatum"); ?></label></th>
			<td>
			<?php
				$huidigjaar = date('Y', time());
				$laagstejaar = $huidigjaar - 100;

				$geboortedatum = get_the_author_meta( 'geboorte' , $user->ID);

				$splits = explode("-",$geboortedatum);
				$geboortejaar = $splits[0];
				$geboortemaand = $splits[1];
				$geboortedag = $splits[2];

				?>
				<select name="geb_dag">
					<?php
					for ($i=1; $i<=31; $i++){
						echo '<option value="' . maaktweecijfer($i) .'" ';
						if ($i == $geboortedag){echo 'selected="selected"';}
						echo ' >' . $i . '</option>';
					}
					?>
				</select>
				<select name="geb_maand">
					<option value="01" <?php if ($geboortemaand == 1){echo 'selected="selected"';} ?> >Januari</option>
					<option value="02" <?php if ($geboortemaand == 2){echo 'selected="selected"';} ?> >Februari</option>
					<option value="03" <?php if ($geboortemaand == 3){echo 'selected="selected"';} ?> >Maart</option>
					<option value="04" <?php if ($geboortemaand == 4){echo 'selected="selected"';} ?> >April</option>
					<option value="05" <?php if ($geboortemaand == 5){echo 'selected="selected"';} ?> >Mei</option>
					<option value="06" <?php if ($geboortemaand == 6){echo 'selected="selected"';} ?> >Juni</option>
					<option value="07" <?php if ($geboortemaand == 7){echo 'selected="selected"';} ?> >Juli</option>
					<option value="08" <?php if ($geboortemaand == 8){echo 'selected="selected"';} ?> >Augustus</option>
					<option value="09" <?php if ($geboortemaand == 9){echo 'selected="selected"';} ?> >September</option>
					<option value="10" <?php if ($geboortemaand == 10){echo 'selected="selected"';} ?> >Oktober</option>
					<option value="11" <?php if ($geboortemaand == 11){echo 'selected="selected"';} ?> >November</option>
					<option value="12" <?php if ($geboortemaand == 12){echo 'selected="selected"';} ?> >December</option>
				</select>
				<select name="geb_jaar">
				<?php
				for ($i=$huidigjaar;$i>$laagstejaar; $i--){
					echo '<option value="' . $i . '"';
					if ($geboortejaar == $i) { echo 'selected="selected"'; }
					echo ' >' . $i . '</option>';

				}
				?>
				</select>

				<span class="description"><?php _e("Vul je geboortedatum in."); ?></span>
			</td>
		</tr>
	</table>
<?php


// Checken of gebruiker leiding of VB is. Zoniet heeft hij geen aparte profielpagina, en wordt de vragenlijst niet getoond

$user_id =  get_the_author_meta('ID',$user->ID);
if (get_rank($user_id) == 'Leiding' || get_rank($user_id) == 'VB'){?>
<p class="submit">

	<input type="submit" name="submit" value="Profiel bijwerken" class="button-primary">
</p>

    <h3><?php _e('Vragenlijst') ?></h3>

    <table class="form-table" style="width:600px;">
    <tr>
         <th><label for="jaar"><?php _e('In Chiro Schelle sinds:'); ?></label></th>
         <td>
              <select name="jaar" id="jaar">
                   <option value="" <?php if (esc_attr(get_the_author_meta('jaar',$user->ID)) == "") { ?>selected<?php } ?>>-Kies je startjaar-</option>
					<?php
                        for($jaar= date("Y") - 5; $jaar > 1990; $jaar--){
                            echo("<option value=\"$jaar\"");
                            if (esc_attr(get_the_author_meta('jaar',$user->ID)) == "$jaar") {
                                echo("selected");
                            }
                            echo(">$jaar</option>");
                        }
                    ?>
              </select>
         </td>
        </tr>
    <tr>
    <tr>
        <th><label for="extra2"><?php _e('School/werk'); ?></label></th>
        <td colspan="2"><textarea style="width:400px; height:45px" type="text" name="schoolwerk" id="schoolwerk"><?php echo  esc_attr(get_the_author_meta('schoolwerk', $user_id) ); ?></textarea></td>
    </tr>
    <tr>
        <th><label for="extra3"><?php _e('Het lekkerste 4-uur dat we krijgen op kamp, is:'); ?></label></th>
        <td><input style="width:300px;" type="text" name="vieruur" id="vieruur" value="<?php echo esc_attr(get_the_author_meta('vieruur', $user->ID) ); ?>" /></td>
    </tr>
    <tr>
        <th><label for="extra4"><?php _e('In het weekend: mijn Chiro-uniform; maar in de week draag ik het liefst:'); ?></label></th>
        <td colspan="2"><textarea style="width:400px; height:90px" type="text" name="kledij" id="kledij"><?php echo  esc_attr(get_the_author_meta('kledij', $user_id) ); ?></textarea></td>
    </tr>
    <tr>
        <th><label for="extra5"><?php _e('In mijn vrije tijd hou ik mij nog bezig met (buiten de Chiro-activiteiten):'); ?></label></th>
        <td colspan="2"><textarea style="width:400px; height:90px" type="text" name="vrijetijd" id="vrijetijd"><?php echo  esc_attr(get_the_author_meta('vrijetijd', $user_id) ); ?></textarea></td>
    </tr>
    <tr>
        <th><label for="extra9"><?php _e('De eerste cd die ik had, was:'); ?></label></th>
        <td><input style="width:300px;" type="text" name="eerstecd" id="eerstecd" value="<?php echo esc_attr(get_the_author_meta('eerstecd', $user->ID) ); ?>" /></td>
    </tr>
    <tr>
        <th><label for="extra10"><?php _e('De laatste cd die ik gekocht heb:'); ?></label></th>
        <td><input style="width:300px;" type="text" name="laatstecd" id="laatstecd" value="<?php echo esc_attr(get_the_author_meta('laatstecd', $user->ID) ); ?>" /></td>
    </tr>
    <tr>
    	<th><label for="extra6"><?php _e('Ben jij een vouwer of een propper?'); ?></label></th>
    	<td colspan="2">
        		<?php
               		$propvouw = get_the_author_meta('propvouw',$user->ID);
             	?>
        	<ul>
                <li><input value="vouwer" id="vouwer" name="propvouw" <?php if ($propvouw == "vouwer") { ?>checked="checked"<?php } ?> type="radio" />Vouwer</li>
                <li><input value="propper" id="propper" name="propvouw" <?php if ($propvouw == "propper") { ?>checked="checked"<?php } ?> type="radio" />Propper</li>
            </ul>
    	</td>
    </tr>
    <tr>
        <th><label for="extra7"><?php _e('Wat is jouw leukste Chiroherinnering?'); ?></label></th>
        <td colspan="2"><textarea style="width:400px; height:90px" type="text" name="herinnering" id="herinnering"><?php echo  esc_attr(get_the_author_meta('herinnering', $user_id) ); ?></textarea></td>
    </tr>
    <tr>
        <th><?php _e('Afdelingen waar ik in leiding heb gestaan'); ?></th>
        <td>
        <div class="alignleft"
            <?php
              $afdelingen_array = get_the_author_meta('afdelingen',$user->ID);
            ?>
            <ul>
              <li><input value="ribbelm" id="ribbelm" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("ribbelm",$afdelingen_array)) { ?>checked="checked"<?php } }?> type="checkbox" />Ribbel Meisjes</li>
              <li><input value="speelclubm" id="speelclubm" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("speelclubm",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Speelclub Meisjes</li>
              <li><input value="kwiks" id="kwiks" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("kwiks",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Kwiks</li>
              <li><input value="tippers" id="tippers" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("tippers",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Tippers</li>
              	<li><input value="tiptiens" id="tiptiens" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("tiptiens",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Tiptiens</li>
              	<li><input value="aspimeisjes" id="aspis" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("aspimeisjes",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Aspiranten Meisjes</li>
            </ul>
      </div>
        <div class="alignright">
        	<ul>
           		<li><input value="ribbelj" id="ribbelj" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("ribbelj",$afdelingen_array)) { ?>checked="checked"<?php } }?> type="checkbox" />Ribbel Jongens</li>
              	<li><input value="speelclubj" id="speelclubj" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("speelclubj",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Speelclub Jongens</li>
              	<li><input value="rakkers" id="rakkers" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("rakkers",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Rakkers</li>
        		<li><input value="toppers" id="toppers" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("toppers",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Toppers</li>
              	<li><input value="kerels" id="kerels" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("kerels",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Kerels</li>
              	<li><input value="aspijongens" id="aspijongens" name="afdelingen[]"<?php if (is_array($afdelingen_array)) { if (in_array("aspijongens",$afdelingen_array)) { ?>checked="checked"<?php } } ?> type="checkbox" />Aspiranten Jongens</li>
             </ul>
             </div>
             <div class="cleaner"></div>
        </td>
    </tr>

    <tr>
        <th><label for="extra8"><?php _e('Welk Chiro-spel vind jij het leukst?'); ?></label></th>
        <td colspan="2"><textarea style="width:400px; height:90px" type="text" name="leukstespel" id="leukstespel"><?php echo  esc_attr(get_the_author_meta('leukstespel', $user_id) ); ?></textarea></td>
    </tr>
    </table>
    <?php
}
}

function action_process_option_update($user_id) {
	//foutcontrole
	$ja = trim($_POST['geb_jaar']);
	$m = $_POST['geb_maand'];
	$d = $_POST['geb_dag'];
	$geb_datum = $ja . '-' .$m . '-' . $d;
	//kijk of de sommige maanden meer dan 30 dagen hebben
	$errortekst = '<div class="error fade" >';
	if (($m==4 || $m==6 || $m==9 || $m==11) && $d>30){
		$errortekst .= "<p>Je hebt geen juiste geboortedatum ingevuld.</p>";
		$error = true;
	}
	// 28 of 29 dagen in februari
	if ($m == 2 && $d >schrikkeljaar($ja)){
		$errortekst .= "<p>Je hebt geen juiste datum ingevuld.</p>";
		$error = true;
	}
	$errortekst .= '</div>';
	if ($error != true){
		update_usermeta($user_id, 'afdelingen', ( isset($_POST['afdelingen']) ? $_POST['afdelingen'] : '' ) );
		update_usermeta($user_id, 'leukstespel', ( isset($_POST['leukstespel']) ? $_POST['leukstespel'] : '' ) );
		update_usermeta($user_id, 'schoolwerk', ( isset($_POST['schoolwerk']) ? $_POST['schoolwerk'] : '' ) );
		update_usermeta($user_id, 'kledij', ( isset($_POST['kledij']) ? $_POST['kledij'] : '' ) );
		update_usermeta($user_id, 'vrijetijd', ( isset($_POST['vrijetijd']) ? $_POST['vrijetijd'] : '' ) );
		update_usermeta($user_id, 'vieruur', ( isset($_POST['vieruur']) ? $_POST['vieruur'] : '' ) );
		update_usermeta($user_id, 'herinnering', ( isset($_POST['herinnering']) ? $_POST['herinnering'] : '' ) );
		update_usermeta($user_id, 'propvouw', ( isset($_POST['propvouw']) ? $_POST['propvouw'] : '' ) );
		update_usermeta($user_id, 'eerstecd', ( isset($_POST['eerstecd']) ? $_POST['eerstecd'] : '' ) );
		update_usermeta($user_id, 'laatstecd', ( isset($_POST['laatstecd']) ? $_POST['laatstecd'] : '' ) );
		update_usermeta($user_id, 'jaar', ( isset($_POST['jaar']) ? $_POST['jaar'] : '' ) );


	    update_usermeta( $user_id, 'straat', $_POST['straat'] );
		update_usermeta( $user_id, 'nr', $_POST['nr'] );
		update_usermeta( $user_id, 'postcode', $_POST['postcode'] );
		update_usermeta( $user_id, 'gemeente', $_POST['gemeente'] );
		update_usermeta( $user_id, 'telefoon', $_POST['telefoon'] );

		update_usermeta( $user_id, 'geboorte', $geb_datum );
		update_usermeta( $user_id, 'afdeling', $_POST['afdeling'] );

		global $current_user;
		get_currentuserinfo();
		if (current_user_can('edit_users')){
			update_usermeta( $user_id, 'rank', $_POST['rank']);
			update_usermeta( $user_id, 'groeps', $_POST['groeps']);
		}

		update_usermeta( $user_id, 'muziekkapel', ( isset($_POST['muziekkapel']) ? $_POST['muziekkapel'] : '' ) );
		update_usermeta ($user_id, 'error', '');

	}else{
		update_usermeta ($user_id, 'error', $errortekst);
	}
}
}

// verwijder het bio stuk

	function remove_plain_bio($buffer) {
		$titles = array('#<h3>Over jezelf</h3>#','#<h3>About the user</h3>#');
		$buffer=preg_replace($titles,'<h3>Wachtwoord</h3>',$buffer,1);
		$biotable='#<h3>Wachtwoord</h3>.+?<table.+?/tr>#s';
		$buffer=preg_replace($biotable,'<h3>Wachtwoord</h3> <table class="form-table">',$buffer,1);
		return $buffer;
	}

	function profile_admin_buffer_start() { ob_start("remove_plain_bio"); }
	function profile_admin_buffer_end() { ob_end_flush(); }

	add_action('admin_head', 'profile_admin_buffer_start');
	add_action('admin_footer', 'profile_admin_buffer_end');


/* Initialise outselves */
add_action('plugins_loaded', create_function('','global $custom_user_meta_instance; $custom_user_meta_instance = new custom_user_meta();'));



// Vragenlijst opbouwen

function get_vragenlijst($thisauthor) {
// slechte check die enkel de titel verbergt indien geen vragen ingevuld
if($thisauthor->jaar || $thisauthor->afdelingen || $thisauthor->schoolwerk || $thisauthor->vrijetijd 
    || $thisauthor->leukstespel || $thisauthor->vieruur || $thisauthor->kledij || $thisauthor->propvouw || $thisauthor->eerstecd || $thisauthor->laatstecd || $thisauthor->herinnering)
{
	echo "<h2>Meer over $thisauthor->first_name</h2>";
}
?>
<table class="vragenlijst">
    <?php
	if ($thisauthor->jaar !== ""){
		if( date("n") < 9){
			$jaren =  date("Y") - $thisauthor->jaar - 1;
        }
		else{
			$jaren = date("Y") - $thisauthor->jaar;
      	}
	}
	if (empty($thisauthor->jaar) == false){
	?>
    	<tr>
		<td class="vraag">Aantal jaren lid van Chiro Schelle?</td>
		<td class="antwoord"><?php echo $jaren." jaar";?></td>
		</tr>
	<?php
	}
	if (empty($thisauthor->afdelingen) == false){
	?>
    <tr>
    	<td class="vraag">Bij welke afdelingen heb jij al in leiding gestaan?</td>
        <td class="antwoord"><?php $afdelingen = $thisauthor->afdelingen;
					if (!empty($afdelingen)){
						foreach ($afdelingen as $afdeling) {
		   				switch ($afdeling){
							case 'ribbelm':
								$afdeling = 'ribbel meisjes';
								break;
							case 'ribbelj':
								$afdeling = 'ribbel jongens';
								break;
							case 'speelclubm':
								$afdeling = 'speelclub meisjes';
								break;
							case 'speelclubj':
								$afdeling = 'speelclub jongens';
								break;
							case 'aspimeisjes':
								$afdeling = 'aspiranten meisjes';
								break;
							case 'aspijongens':
								$afdeling = 'aspiranten jongens';
								break;
							}
						echo ucwords($afdeling) . "<br/>";
						}
					}?></td>
    </tr>
    <?php }
    if (empty($thisauthor->schoolwerk)==false){
	?>
    <tr>
        <td class="vraag">School? Werk?</td>
        <td class="antwoord"><?php echo nl2br($thisauthor->schoolwerk); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->vrijetijd)==false){
	?>
    <tr>
    	<td class="vraag">In de vrije tijd?</td>
        <td class="antwoord"><?php echo nl2br(strip_tags($thisauthor->vrijetijd)); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->leukstespel)==false){
	?>
    <tr>
        <td class="vraag">Het leukste Chirospel?</td>
        <td class="antwoord"><?php echo nl2br($thisauthor->leukstespel); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->vieruur)==false){
	?>
    <tr>
        <td class="vraag">Het lekkerste vieruur op bivak?</td>
        <td class="antwoord"><?php echo nl2br($thisauthor->vieruur); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->kledij)==false){
	?>
    <tr>
        <td class="vraag">In de week draag ik...</td>
        <td class="antwoord"><?php echo nl2br(strip_tags($thisauthor->kledij)); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->propvouw)==false){
	?>
    <tr>
    	<td class="vraag">Propper of een vouwer?</td>
        <td class="antwoord"><?php echo ucwords(nl2br(strip_tags($thisauthor->propvouw))); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->eerstecd)==false){
	?>
    <tr>
    	<td class="vraag">Welke cd had je het eerst in bezit?</td>
        <td class="antwoord"><?php echo nl2br(strip_tags($thisauthor->eerstecd)); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->laatstecd)==false){
	?>
    <tr>
    	<td class="vraag">Welke cd heb je het laatst gekocht?</td>
        <td class="antwoord"><?php echo nl2br(strip_tags($thisauthor->laatstecd)); ?></td>
    </tr>
    <?php }
	if (empty($thisauthor->herinnering)==false){
	?>
    <tr>
    	<td class="vraag">Leukste Chiroherinnering:</td>
        <td class="antwoord"><?php echo $thisauthor->herinnering; ?></td>
    </tr>
    <?php
    }
	?>
</table>
<?php
}
?>
