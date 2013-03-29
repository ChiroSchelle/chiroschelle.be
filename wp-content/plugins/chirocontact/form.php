<?php
function chirocontact_toon_form_html(){
	chirocontact_verwerk_form();
	global $current_user;
	get_currentuserinfo();
	if (!$_GET['contact']){
		$contact = $_POST['contact'];
	}else{
		$contact = $_GET['contact'];
	}
	if (!$_GET['afdeling']){
		$afd = $current_user->afdeling;
    }else {
		$afd = $_GET['afdeling'];
	}
	if (!$_GET['verhuur']){
		$verhuur = $_POST['verhuur'];
	}else {
		$verhuur = $_GET['verhuur'];
	}
	if (!$_GET['uid']){
		$user = false;
	}else{
		$uid = $_GET['uid'];
		$user = get_userdata($uid);
		if (!$user->first_name){
			$user = false;
		}else{
			$leidingnaam = $user->first_name . " " . $user->last_name;
			$leidingmail = $user->user_email;
		}
	}


	?>
	 <form class="niceform" method="post" >
        <table>
        	<tr><th colspan="3"><h2>Jouw Gegevens:</h2></th></tr>
        	<tr>
            	<td class="contactinfo"><label for="voornaam">Voornaam:</label></td>
            	<td colspan="2"><input class="textveld" name="voornaam" type="text" value="<?php if ($current_user->user_firstname){echo $current_user->user_firstname;} else {echo $data['voornaam'];} ?>" /></td>
            </tr>
            <tr>
            	<td><label for="naam">Naam:</label></td>
            	<td colspan="2"><input class="textveld" name="naam" type="text" value="<?php if ($current_user->user_lastname){echo $current_user->user_lastname;} else {echo $data['naam'];} ?>" /></td>
            </tr>
            <tr>
            	<td><label for="email">E-mailadres:</label></td>
                <td colspan="2"><input class="textveld" name="email" type="text" value="<?php if ($current_user->user_email){echo $current_user->user_email;} else {echo $data['email'];} ?>" /></td>
            </tr>
            <tr>
            	<td><label for="telefoon">Telefoonnummer:</label></td>
                <td colspan="2"><input class="textveld" name="telefoon" type="text" value="<?php if ($current_user->telefoon){echo $current_user->telefoon;} else {echo $data['telefoon'];} ?>" /></td>
            </tr>
            <tr><th class="radiobuttons" colspan="3"><h2>Onze gegevens:</h2></th></tr>
            <tr>
            	<td class="contactinfo " rowspan="3"><label for="contact">Wie wil je bereiken?</label></td>
                <td class="keuze1"><input class="input" type="radio" name="contact" id="show_info" value="info" <?php if ($contact == 'info'){echo 'checked="checked"';} ?>/>Algemene info</td>
                <td class="keuze"><input class="input" type="radio" name="contact" id="show_leiding" value="leiding" <?php if ($contact == 'leiding'){echo 'checked="checked"';} ?>/>Leiding</td>
            </tr>
            <tr>
            	<td class="keuze1"><input class="input" type="radio" name="contact" id="show_verhuur" value="verhuur" <?php if ($contact == 'verhuur'){echo 'checked="checked"';} ?>/>Verhuur</td>
                <td class="keuze"><input class="input" type="radio" name="contact" id="show_site" value="site" <?php if ($contact == 'site'){echo 'checked="checked"';} ?>/>Webmasters</td>
            </tr>
            <tr>
            	<td class="keuze1"><input class="input" type="radio" name="contact" id="show_muziekkapel" value="muziekkapel" <?php if ($contact == 'muziekkapel'){echo 'checked="checked"';} ?>/>Muziekkkapel</td>
                <td class="keuze"><?php if ($user){ ?><input class="input" type="radio" name="contact" id="show_persoonlijk" value="<?php echo $uid ?>" <?php if ($contact == "" || $contact==$uid){ echo 'checked="checked"' ; }?> /><?php echo $leidingnaam; } ?></td>
            </tr
        ></table>

        <div id="leiding">
       	<table>
       		<tr>
       		<?php

       		?>

            	<td class="contactinfo">Specifieer de leiding</td>
                <td><select name="leiding">
					<option value="0">Kies je afdeling</option>
					<option value="1" <?php if ($afd==1) {echo 'selected="selected"';} ?> >Ribbel Jongens</option>
					<option value="2" <?php if ($afd==2) {echo 'selected="selected"';} ?> >Ribbel Meisjes</option>
					<option value="3" <?php if ($afd==3) {echo 'selected="selected"';} ?> >Speelclub Jongens</option>
					<option value="4" <?php if ($afd==4) {echo 'selected="selected"';} ?> >Speelclub Meisjes</option>
					<option value="5" <?php if ($afd==5) {echo 'selected="selected"';} ?> >Rakkers</option>
					<option value="6" <?php if ($afd==6) {echo 'selected="selected"';} ?> >Kwiks</option>
				    <option value="7" <?php if ($afd==7) {echo 'selected="selected"';} ?> >Toppers</option>
				    <option value="8" <?php if ($afd==8) {echo 'selected="selected"';} ?> >Tippers</option>
				    <option value="9" <?php if ($afd==9) {echo 'selected="selected"';} ?> >Kerels</option>
				    <option value="10" <?php if ($afd==10) {echo 'selected="selected"';} ?> >Tiptiens</option>
				    <option value="11" <?php if ($afd==11) {echo 'selected="selected"';} ?> >Aspi Jongens</option>
				    <option value="12" <?php if ($afd==12) {echo 'selected="selected"';} ?> >Aspi Meisjes</option>
				</select></td>
           </tr>
        </table>
        </div><!--#leiding-->

        <div id="verhuur">
        <table>
        	<tr>
            	<td class="contactinfo radiobuttons" rowspan="2">Duid aan wat je wilt huren</td>
                <td class="radiobuttons"><!--- JOB LOKALEN WORDEN VOORLOPIG TERUG VERHUURD INDIEN NIET 'disabled="disabled" toevoegen --><input class="input" type="checkbox" name="lokalen"  value="1" <?php if ($verhuur == 'lokalen'){echo 'checked="checked"'; } ?> />Lokalen</td>
                <td class="radiobuttons keuze"><input class="input" type="checkbox" name="tenten"  value="1" <?php if ($verhuur == 'tenten'){echo 'checked="checked"'; } ?>/>Tenten</td>
            </tr>
        	<tr>
            	<td><input class="input" type="checkbox" name="garage"  value="1" <?php if ($verhuur == 'garage'){echo 'checked="checked"'; } ?>/>Kookmateriaal</td>
                <td class="keuze"><input class="input" type="checkbox" name="andere"  value="1" <?php if ($verhuur == 'andere'){echo 'checked="checked"'; } ?>/>Andere</td>
           </tr>
        </table>
		</div><!--#verhuur-->

        <div id="bericht">
        <table>
         	<tr><th colspan="2"><h2>Je bericht:</h2></th></tr>
			<tr>
            	<td class="contactinfo"><label for="onderwerp">Onderwerp:</label></td>
                <td><input class="input type=text" name="onderwerp" value="<?php echo $_POST['onderwerp']; ?>" /></td>
            </tr>
         	<tr>
            	<td class="contactinfo"><label for="bericht">Bericht:</label></td>
                <td><textarea name="bericht"><?php echo $_POST['bericht']; ?></textarea></td>
            </tr>
            <tr>
            	<td class="contactinfo"><label for="cc"></label></td>
                <td><input type="checkbox" name="cc" value="1" <?php if ($_POST['cc']==1){echo 'checked="checked"'; } ?> />Stuur mij een kopie van dit bericht.</td>
            </tr>
        	<tr>
            	<td></td>
            	<td><input type="submit" value="Verzenden" name="submit"/><input type="reset" value="Wis formulier" /></td>
            </tr>
        </table>
        </div><!--#bericht-->


		</form>
		<?php
}
?>