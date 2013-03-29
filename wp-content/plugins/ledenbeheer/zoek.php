<?php
global $wpdb;
$table_name = $wpdb->prefix . 'leden';
chiroleden_wijzig_eigenschappen();
?>
<h3>Zoek Leden</h3>

<form id="zoek_leden" method="get">
Zoek op
<select name="meta">
	<option value="first_name">Voornaam</option>
	<option value="last_name">Achternaam</option>
	<option value="straat">Adres</option>
	<option value="postcode">Postcode</option>
	<option value="gemeente">Gemeente</option>
	<option value="user_email">E-mail</option>
</select>
<input type="text" name="q" />
<p class="submit">
	<input type="hidden" name="page" value="chiroleden-submenu-zoek" />
  	<input type="submit" name="submit" value="Zoek" class="button-primary">
	</p>
</form>

<?php
$meta = $_GET['meta'];
$q = $_GET['q'];
if ($meta!="" && $q!=""){
	$ids=ledenbeheer_zoek_leden($meta,$q);
	if ($ids[0]!=""){
		$idsorted = sort_op_meta($ids, $meta);
	}
  if ($idsorted[0]!=""){

  ?>
<h3>Geregistreerde leden:</h3>
  <form id="lijst" method="post">

  <table class="widefat" cellspacing="0">
 <thead>
 <th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Afdeling</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead>
  </thead>
  <tfoot><th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Afdeling</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead></tfoot>
  <tbody>
<?php


	$j = 1;
	foreach ($idsorted as $id){
		$user = get_userdata($id);
		if ($user->lidgeld==true || $afdeling>12){
			$lidgeld = 'betaald';
		}else{
			$lidgeld = 'nog_betalen';
		}
		if ($user->actief == 'inactief'){
			$actief = 'inactief';

		}else {
			$actief = 'actief';
		}
		?>
		<tr class="<?php echo $lidgeld . ' ' . $actief; ?>">
			<th class="check-column" scope="row"><input type="checkbox" name="user[]" value="<?php echo $id; ?>" /></th>
			<td class="<?php echo ''; ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?><div class="row-actions"><span class='edit'><a href="?page=chiroleden-submenu-wijzig&db=wp&id=<?php echo $id; ?>">Bewerken</a></span></div></td>
			<td><?php echo maaknummerafdeling($user->afdeling); ?></td>
			<td><?php echo $user->straat . ' '. $user->nr . ',<br /> ' . $user->postcode . ' ' . $user->gemeente; ?></td>
			<td><?php echo $user->telefoon; ?></td>
			<td><?php echo $user->geboorte; ?></td>
			<td><?php echo $user->user_email; ?></td>
		</tr>
		<?php
	}
	?>
	</tbody>
	</table>
	<p class="submit">
	<select name="actie">
		<option value="">-- kies een actie --</option>
		<option value="betaal_lidgeld">lidgeld betaald</option>
		<option value="verwijder_lidgeld">lidgeld niet betaald</option>
		<option value="inactief">komt niet meer</option>
		<option value="actief">komt nog</option>
		<?php if ($afdeling>=1 && $afdeling<=12){?>
		<option value="verhoog_afdeling">afdeling hoger</option>
		<option value="verlaag_afdeling">afdeling lager</option>
		<?php } ?>
	</select>
	<input type="hidden" name="afdeling" value="<?php echo $afdeling; ?>" />
	<input type="submit" name="submit_lijst" value="Go!" class="button-secondary">
	</p>
	</form>
	<?php
  }
  $chirometa = ledenbeheer_convert_meta($meta);
  $order = $chirometa;
	$query = "SELECT  * FROM $table_name WHERE $chirometa LIKE '%$q%' AND toon != 0 order by $order";
	$result = $wpdb->get_results($query);
	if ($result[0]->id != ""){



	?>
	<h3>Niet op website:</h3>
	<form id="not_registered" method="post" >

	<table class="widefat" cellspacing="0">
 <thead>
 <th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Afdeling</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead>
  </thead>
  <tfoot><th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Afdeling</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead></tfoot>
  <tbody>
	<?php


	foreach ($result as $row){
		if ($row->lidgeld=='Ja'){
			$lidgeld = 'betaald';
		}else {
			$lidgeld = 'nog_betalen';
		}
		if ($row->actief == 'inactief'){
			$actief = 'inactief';
		}else {
			$actief = 'actief';
		}


		?>

		<tr class="<?php echo "$lidgeld $actief"; ?>">
			<th class="check-column" scope="row"><input type="checkbox" name="user_niet_reg[]" value="<?php echo $row->id; ?>" /></th>
			<td class="<?php echo ''; ?>"><?php echo $row->voornaam . ' ' . $row->naam; ?><div class="row-actions"><span class='edit'><a href="?page=chiroleden-submenu-wijzig&db=chiro&id=<?php echo $row->id; ?>">Bewerken</a></span></div></td>
			<td><?php echo maaknummerafdeling($row->afdeling); ?></td>
			<td><?php echo $row->adres . ',<br /> ' . $row->postcode . ' ' . $row->gemeente; ?></td>
			<td><?php echo $row->telefoon; ?></td>
			<td><?php echo $row->geboorte; ?></td>
			<td><?php echo $row->email; ?></td>
		</tr>
		<?php

	}

	?>
  </tbody>
  </table>
<p class="submit">
	<select name="actie">
		<option value="">--kies een actie--</option>
		<option value="betaal_lidgeld">lidgeld betaald</option>
		<option value="verwijder_lidgeld">lidgeld niet betaald</option>
		<option value="inactief">komt niet meer</option>
		<option value="actief">komt nog</option>
		<option value="verhoog_afdeling">afdeling hoger</option>
		<option value="verlaag_afdeling">afdeling lager</option>
		<option value="register">heeft zich geregistreerd</option>
	</select>
	<input type="hidden" name="afdeling" value="<?php echo $afdeling; ?>" />
	<input type="submit" name="submit_lijst" value="Go!" class="button-secondary">
	</p>
	</form>
	<?php
}
}

?>