<h2>Bewerk lid</h2>
<?php ledenbeheer_verwerk_lid('update');
global $current_user;
global $wpdb;
	$table_name = $wpdb->prefix . 'leden';
      get_currentuserinfo();

      if ($_POST['afdeling']!=0){
      	$afdeling = $_POST['afdeling'];
      }else{
      	$afdeling =$current_user->afdeling;
      }
      $naam = $current_user->first_name . ' ' . $current_user->last_name;
      $id = $_GET['id'];
      $db = $_GET['db'];
      if ($id == "" && $db == ""){
      	echo '<div class="error" > Je hebt geen lid gekozen uit je <a href="?page=chiroleden-submenu-lijst" >Ledenlijst</a></div>';
      }else{
      	if ($db == 'wp'){
      		$user = get_userdata($id);
      	}elseif ($db == 'chiro'){
      		$user = chiroleden_get_data($id);
      	}

?>
<form action="" method="post" name="bewerk_lid">
<table>
	<tr>
    	<td>Afdeling</td>
        <td>
        	<select name="afdeling">
        	<?php
        	$afdeling = $user->afdeling;
        	for ($i = 1; $i<=12; $i++){
        		echo '<option value="' . $i .'" ';
        		if ($i == $user->afdeling){
        			echo 'selected="selected" ';
        		}
        		echo '>' . maaknummerafdeling($i) . '</option>';
        	}
            ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>Voornaam:</td><td><input type="text" name="voornaam" value="<?php echo $user->first_name; ?>" /></td>
	</tr>
	<tr>
		<td>Naam:</td><td><input type="text" name="naam"  value="<?php echo $user->last_name; ?>"/></td>
	</tr>
	<tr>
		<td>Adres:</td>
		<td><input type="text" name="straat" value="<?php echo $user->straat; ?>"<?php if ($db == 'wp'){ ?> <input type="text" name="nr" value="<?php echo $user->nr; ?>" /><?php } ?></td>
	</tr>
	<tr>
		<td>Postcode & Gemeente</td><td><input type="text" name="postcode" size="5"  value="<?php echo $user->postcode; ?>"/><input type="text" name="gemeente" value="<?php echo $user->gemeente; ?>"/></td>
	</tr>
	<tr>
		<td>Telefoon</td><td><input type="text" name="telefoon" value="<?php echo $user->telefoon; ?>"/></td>
	</tr>
	<tr>
		<td>Geboortedatum (YYYY-MM-DD)</td><td><input type="text" name="geboorte" value="<?php echo $user->geboorte; ?>"/></td>
	</tr>

	<tr>
		<td>Email:</td><td><input type="text" name="email" value="<?php echo $user->user_email; ?>"/></td>
	</tr>
	<tr>
		<td>lidgeld?</td><td><input type="radio" name="lidgeld" value="Ja"  <?php if ($user->lidgeld ==1){echo 'checked="checked"';} ?>/>Ja <input type="radio" name="lidgeld" value="Nee" <?php if ($user->lidgeld ==0){echo 'checked="checked"';} ?> />Nee</td>
	</tr>

</table>
  <p class="submit">
  	<input type="hidden" name="invoerder" value="<?php echo $naam; ?>" />
  	<input type="hidden" name="id" value="<?php echo $user->ID; ?>" />
	<input type="submit" name="submit" value="Wijzig" class="button-primary">
	</p>
</form>
<?php
      }

?>