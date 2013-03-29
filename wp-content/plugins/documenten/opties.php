<?php
function documenten_options_page(){
	?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Documenten opties</h2>
<?php
if (isset($_POST['submit'])){
	$documenten_options['email_updates'] = trim($_POST['email_updates']);
	$documenten_options['email_schijf'] = trim($_POST['email_schijf']);


	documenten_update_options($documenten_options);
}


$documenten_options = get_option('documenten_options');
?>
<form method="post">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
			<label for="email_info">Updates worden verstuurd naar:</label></th>
			<td><textarea name="email_updates" rows="4" cols="50"><?php echo $documenten_options['email_updates']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">
			<th scope="row">
			<label for="email_info">Documenten worden verstuurd naar:</label></th>
			<td><textarea name="email_schijf" rows="4" cols="50"><?php echo $documenten_options['email_schijf']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
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