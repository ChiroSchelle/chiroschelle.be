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

      $uid = $current_user->ID;
	chiroleden_wijzig_eigenschappen();


 $icon_url = plugins_url('images/plugin-menu-icon32.png', __FILE__);

  echo '<div class="wrap">';



  echo '<div id="icon-programma" class="icon32"><img src="'. $icon_url . '"></div><h2>Ledenlijst</h2>';
  ?>
  <form id="kies_afdeling" method="post">
  <p><label for="afdeling">Afdeling:</label><select name="afdeling">
  	<?php
  	for ($i=1;$i<=12;$i++){
  		echo '<option value="' . $i .'" ';
  		if ($i == $afdeling) {echo 'selected="selected" ';}
  		echo '>' . maaknummerafdeling($i) . '</option>';
  	}
  	?>
  		<option value="18" <?php if ($afdeling == 18){echo 'selected="selected"';}?> >Oud-leiding </option>
  		<option value="20" <?php if ($afdeling == 20){echo 'selected="selected"';}?> >Sympathisant </option>
  	</select>
  </p>
  <p class="submit">
	<input type="submit" name="submit" value="Kies Afdeling" class="button-primary">
	</p>
  </form>
  <?php
  $ids = get_user_id('afdeling', $afdeling);
  $idsorted = sort_op_meta($ids, 'last_name');
  if ($idsorted[0]!=""){

  ?>
<h3>Geregistreerde leden:</h3>
  <form id="lijst" method="post">

  <table class="widefat" cellspacing="0">
 <thead>
 <th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead>
  </thead>
  <tfoot><th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead></tfoot>
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
			<th class="check-column <?php echo $lidgeld . ' ' . $actief; ?>" scope="row"><input type="checkbox" name="user[]" value="<?php echo $id; ?>" /></th>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>" ><?php echo $user->first_name . ' ' . $user->last_name; ?><div class="row-actions"><span class='edit'><a href="?page=chiroleden-submenu-wijzig&db=wp&id=<?php echo $id; ?>">Bewerken</a></span></div></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $user->straat . ' '. $user->nr . ',<br /> ' . $user->postcode . ' ' . $user->gemeente; ?></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $user->telefoon; ?></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $user->geboorte; ?></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $user->user_email; ?></td>
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
  $order = 'naam';
	$query = "SELECT  * FROM $table_name WHERE afdeling = $afdeling AND toon != 0 order by $order";
	$result = $wpdb->get_results($query);
	if ($result[0]->id != ""){



	?>
	<h3>Niet op website:</h3>
	<form id="not_registered" method="post" >

	<table class="widefat" cellspacing="0">
 <thead>
 <th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead>
  </thead>
  <tfoot><th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th><th>Naam</th><th>Adres</th><th>Telefoon</th><th>Geboortedatum</th><th>Email</th></thead></tfoot>
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
			<th class="check-column <?php echo $lidgeld . ' ' . $actief; ?>" scope="row"><input type="checkbox" name="user_niet_reg[]" value="<?php echo $row->id; ?>" /></th>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $row->voornaam . ' ' . $row->naam; ?><div class="row-actions"><span class='edit'><a href="?page=chiroleden-submenu-wijzig&db=chiro&id=<?php echo $row->id; ?>">Bewerken</a></span></div></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $row->adres . ',<br /> ' . $row->postcode . ' ' . $row->gemeente; ?></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $row->telefoon; ?></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $row->geboorte; ?></td>
			<td class="<?php echo $lidgeld . ' ' . $actief; ?>"><?php echo $row->email; ?></td>
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
	?>