<?php

function gocarttocht_toon_form_html(){

//require_once('functions.php');
$velden = array ("aanspr","voornaam","naam","email","euro");
foreach($velden as $waarde)
{
	if(array_key_exists($waarde, $_POST))
		$data[$waarde] = trim($_POST[$waarde]);
	else
		$data[$waarde] = "";
}
if (isset($_POST['verstuur'])){
$error=false;
#validate form

if ($data['aanspr']==""){
	$error=true;
	echo '<div class="error">Je hebt geen aanspreking aangeduid!<br /></div>';
}
if ($data['naam']==""){
	$error=true;
	echo '<div class="error">Je hebt geen naam ingevuld!<br /></div>';
}
if (!is_email($data['email'])){
	$error=true;
	echo '<div class="error">Je hebt geen correct emailadres ingevuld!<br /></div>';
}

if ($data['euro']!=""){
	if (!is_numeric($data['euro'])){
		$error=true;
		echo '<div class="error">Er is iets mis met het ingevulde bedrag.<br /></div>';
	}
}

if ($error!=true){

	# maak de email
		$bericht="Volgende persoon wilt de kerels sponsoren op hun gocart-tocht: ".$data['aanspr']." ".$data['voornaam']." ".$data['naam']." (".$data['email'].")
		
		Voor het bedrag van:".$data['euro']. " euro per kilometer.";
	# toon een bevestigingstabel
	?>
	<form name="gocarttocht_bevest" method="post">
<table id="gocarttocht">
<tr>
<th colspan="4"><strong>Kijk de gegevens na</strong></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr><th >Aanspreking</th><td colspan="3"><?php echo $data['aanspr']; ?></td></tr>
<tr><th>Voornaam</th><td colspan="3"><?php echo $data['voornaam']; ?></td></tr>
<tr><th>Naam</th><td colspan="3"><?php echo $data['naam'] ; ?></td></tr>
<tr><th>E-mail</th><td colspan="3" class="alt"><?php echo $data['email'] ; ?></td></tr>
<tr><th colspan="4">&nbsp;</th></tr>
<tr><th width="145px">Totaal sponsoring</th><td colspan="3">&euro;<?php echo $data['euro'] * 140; ?></td></tr>
<tr><th colspan="4"><input type="submit" name="bevestig" value="Bevestig Inschrijving"></th>
</tr>
</table>
<p>Gelieve het bedrag van &euro; <?php echo $data['euro'] * 140; ?> over te schrijven op rekeningnummer 860-1056935-05 met vermelding <b><?php echo $data['naam']. " gocarttocht"; ?></b></p>
<input type="hidden" name="bericht" value="<?php echo $bericht; ?>" />
<input type="hidden" name="aan" value="<?php echo  "'{$data['voornaam']} {$data['naam']}' <{$data['email']}>"; ?>" />

</form>


<?php
}
}


	#sendmail($naam,$email,$onderwerp,$bericht,,$cc="",$bcc="",$reply_naam="",$reply_adres="")


elseif (isset($_POST['bevestig'])){

	wp_mail("'Gocarttocht Kerels' <mante.bridts@chiroschelle.be>, {$_POST['aan']}" , "Sponsoring Gocarttocht", $_POST['bericht'] ) or die('error!');

	echo '<div class="errorr">Alles is verzonden, hartelijk bedankt!</div>';
}
else{

?>
<form name="gocarttocht" method="post">
<table id="gocarttocht">
<tr>
<th colspan="3"><strong>Sponsor de gocarttocht van de kerels!</strong></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
<tr><th >Aanspreking</th><td colspan="2"><p>
  <input type="radio" name="aanspr" value="Dhr." />
  Dhr. <input type="radio" name="aanspr" value="Mvr." />
  Mvr. <input type="radio" name="aanspr" value="Fam." /> Fam.</p></td></tr>
<tr><th>Voornaam</th><td colspan="2" class="alt"><input type="text" name="voornaam" /></td></tr>
<tr><th>Naam</th><td colspan="2"><input type="text" name="naam"  /></td></tr>
<tr><th>E-mail</th><td colspan="2" class="alt"><input type="text" name="email" /></td></tr>
<tr><th colspan="3">&nbsp;</th></tr>
<tr><th width="170px;">Aantal euro per kilometer</th><td colspan="2"><input type="text" name="euro" size="5" /></td></tr>
<th colspan="3"><input type="submit" name="verstuur" value="Verzend"></th>
</tr>
</table>
</form>




<?php
}
}
?>