<?php
function chirocontact_toon_opties(){
	?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>chirocontact Opties</h2>
<?php
if (isset($_POST['submit'])){
	$chirocontact_options['email_info'] = trim($_POST['email_info']);
	$chirocontact_options['email_site'] = trim($_POST['email_site']);
	$chirocontact_options['email_verhuur_tenten'] = trim($_POST['email_verhuur_tenten']);
	$chirocontact_options['email_verhuur_garage'] = trim($_POST['email_verhuur_garage']);
	$chirocontact_options['email_verhuur_lokalen'] = trim($_POST['email_verhuur_lokalen']);
	$chirocontact_options['email_verhuur_andere'] = trim($_POST['email_verhuur_andere']);
	$chirocontact_options['email_muziekkapel'] = trim($_POST['email_muziekkapel']);

	chirocontact_update_options($chirocontact_options);
}


$chirocontact_options = get_option('chirocontact_options');
?>
<form method="post">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
			<label for="email_info">Info stuurt naar:</label></th>
			<td><textarea name="email_info" rows="4" cols="50"><?php echo $chirocontact_options['email_info']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_site">Site stuurt naar:</label></th>
			<td><textarea name="email_site" rows="4" cols="50"><?php echo $chirocontact_options['email_site']; ?></textarea><br/>
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_verhuur_lokalen">Verhuur lokalen stuurt naar:</label></th>
			<td><textarea name="email_verhuur_lokalen" rows="4" cols="50"><?php echo $chirocontact_options['email_verhuur_lokalen']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_verhuur_garage">Verhuur kookmateriaal stuurt naar:</label></th>
			<td><textarea name="email_verhuur_garage" rows="4" cols="50"><?php echo $chirocontact_options['email_verhuur_garage']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_verhuur_tenten">Verhuur tenten stuurt naar:</label></th>
			<td><textarea name="email_verhuur_tenten"  cols="50" rows="4"><?php echo $chirocontact_options['email_verhuur_tenten']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_verhuur_andere">Verhuur 'andere' stuurt naar:</label></th>
			<td><textarea name="email_verhuur_andere" cols="50" rows="4" ><?php echo $chirocontact_options['email_verhuur_andere']; ?></textarea><br />
			<span class="description">Zet verschillende emaildressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_muziekkapel">Muziekkapel stuurt naar:</label></th>
			<td><textarea name="email_muziekkapel" cols="50" rows="4" ><?php echo $chirocontact_options['email_muziekkapel']; ?></textarea><br />
			<span class="description">Zet verschillende emaildressen op een andere lijn</span></td>
		</tr>

	</table>

<p class="submit">
<input type="submit" name="submit" class="button-primary" value="Wijzigingen opslaan" />
</p>
</form>
</div>
<?php
}

?>