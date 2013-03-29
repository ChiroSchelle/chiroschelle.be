<?php

	ledenbeheer_verwerk_mail();
	global $current_user;
	get_currentuserinfo();

	if (!$_POST['afdeling']){
		$afdeling = $current_user->afdeling;
    }else {
		$afdeling = $_POST['afdeling'];
	}
	if (trim($_POST['email'])!=""){
		$email = $_POST['email'];
	}elseif ($current_user->first_name != "" && $current_user->last_name != ""){
		$email = str_replace(' ', '', strtolower($current_user->first_name . "." . $current_user->last_name . '@chiroschelle.be') );
	}else {
		$email = $current_user->user_email;
	}

	?>
	 <form  method="post" >
        <table>
        	<tr><th colspan="3"><h4>Jouw Gegevens:</h4></th></tr>
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
                <td colspan="2"><input class="textveld" name="email" type="text" value="<?php echo $email; ?>" /></td>
            </tr>
            <tr>
            	<td><label for="telefoon">Telefoonnummer:</label></td>
                <td colspan="2"><input class="textveld" name="telefoon" type="text" value="<?php if ($current_user->telefoon){echo $current_user->telefoon;} else {echo $data['telefoon'];} ?>" /></td>
            </tr>


            	<tr><th colspan="2"><h4>Je bericht:</h4></th></tr>
            	<tr>
            	<td><label for="afdeling">Bestemming</label></td>
                <td><select name="afdeling">
			  	<?php
			  	for ($i=1;$i<=12;$i++){
			  		echo '<option value="' . $i .'" ';
			  		if ($i == $afdeling) {echo 'selected="selected" ';}
			  		echo '>' . maaknummerafdeling($i) . '</option>';
			  	}
			  	if (current_user_can('administrator')) {
				  	?>
			  		<option value="18" <?php if ($afdeling == 18){echo 'selected="selected"';}?> >Oud-leiding </option>
			  		<option value="20" <?php if ($afdeling == 20){echo 'selected="selected"';}?> >Sympathisant </option>
			  		<?php
			  	}
			  	?>
			  	</select></td>
           </tr>

			<tr>
            	<td class="contactinfo"><label for="onderwerp">Onderwerp:</label></td>
                <td><input class="input type=text" name="onderwerp" value="<?php echo $_POST['onderwerp']; ?>" /></td>
            </tr>
         	<tr>
            	<td class="contactinfo"><label for="bericht">Bericht:</label></td>
                <td><textarea name="bericht"><?php echo $_POST['bericht']; ?></textarea></td>
            </tr>

        	<tr>
            	<td></td>
            	<td><input type="submit" value="Verzenden" name="submit"/><input type="reset" value="Wis formulier" /></td>
            </tr>
        </table>
        </div><!--#bericht-->


		</form>
		<?php


?>