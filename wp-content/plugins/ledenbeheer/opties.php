<?php
function chiroleden_options_page(){
	?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>chiroleden Opties</h2>
<?php
if (isset($_POST['submit'])){
	$chiroleden_options['email_updates'] = trim($_POST['email_updates']);


	chiroleden_update_options($chiroleden_options);
}


$chiroleden_options = get_option('chiroleden_options');
?>
<form method="post">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
			<label for="email_info">Updates worden verstuurd naar:</label></th>
			<td><textarea name="email_updates" rows="4" cols="50"><?php echo $chiroleden_options['email_updates']; ?></textarea><br />
			<span class="description">Zet verschillende emailadressen op een andere lijn</span></td>
		</tr>
		<tr valign="top">

	</table>

<p class="submit">
<input type="submit" name="submit" class="button-primary" value="Wijzigingen opslaan" />
</p>
</form>
</div>
<?php
}

?>