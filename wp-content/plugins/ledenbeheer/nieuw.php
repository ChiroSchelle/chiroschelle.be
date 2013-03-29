<?php
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

?>
<h2>Voeg een nieuw lid toe</h2>
<?php ledenbeheer_verwerk_lid('nieuw'); ?>
<form action="" method="post" name="nieuw_lid">
<table>
	<tr>
    	<td>Afdeling</td>
        <td>
        	<select name="afdeling">
        	<?php
        	for ($i = 1; $i<=12; $i++){
        		echo '<option value="' . $i .'" ';
        		if ($i == $afdeling){
        			echo 'selected="selected" ';
        		}
        		echo '>' . maaknummerafdeling($i) . '</option>';
        	}
            ?>
            </select>
        </td>
	</tr>
	<tr>
		<td>Voornaam:</td><td><input type="text" name="voornaam" /></td>
	</tr>
	<tr>
		<td>Naam:</td><td><input type="text" name="naam" /></td>
	</tr>
	<tr>
		<td>Adres:</td><td><input type="text" name="adres" /></td>
	</tr>
	<tr>
		<td>Postcode & Gemeente</td><td><input type="text" name="postcode" size="5" /><input type="text" name="gemeente" /></td>
	</tr>
	<tr>
		<td>Telefoon</td><td><input type="text" name="telefoon" /></td>
	</tr>
	<tr>
		<td>Geboortedatum (YYYY-MM-DD)</td><td><input type="text" name="geboorte" /></td>
	</tr>
	<tr>
	<td>Geslacht:</td><td><input type="radio" name="geslacht" value="Man" />Man <input type="radio" name="geslacht value="Vrouw" />Vrouw</td>
	</tr>
	<tr>
		<td>Email:</td><td><input type="text" name="email" /></td>
	</tr>
	<tr>
		<td>lidgeld?</td><td><input type="radio" name="lidgeld" value="Ja"  />Ja <input type="radio" name="lidgeld" value="Nee" checked="checked" />Nee</td>
	</tr>

</table>
  <p class="submit">
  	<input type="hidden" name="invoerder" value="<?php echo $naam; ?>" />
	<input type="submit" name="submit" value="Voeg Toe" class="button-primary">
	</p>
</form>