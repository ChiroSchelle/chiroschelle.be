<?php

function chirofest_toon_form_html(){

//require_once('functions.php');
$velden = array ("aanspr","voornaam","naam","email","volw","kind","varken", "hamburger", "sate", "kip", "worst", "rib", "steak");
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
	echo '<div class="error">Je hebt geen naam ingevuldd!<br /></div>';
}
if (!is_email($data['email'])){
	$error=true;
	echo '<div class="error">Je hebt geen correct emailadres ingevuld!<br /></div>';
}


if ($data['kind']!=""){
	if (!is_numeric($data['kind'])){
		$error=true;
		echo '<div class="error">Geef een geldig aantal kinderen in<br /></div>';
	}
}
if ($data['volw']!=""){
	if (!is_numeric($data['volw'])){
		$error=true;
		echo '<div class="error">Geef een geldig aantal volwassenen in<br /></div>';
	}
}
if ($data['volw'] == "" && $data['kind'] == ""){
	$error=true;
	echo '<	div class="error">Er moet minstens één iemand komen.<br /></div>';
}
if($data['varken'] != "" && !is_numeric($data['varken'])){
	echo '<div class="error">Geef een geldig aantal varken aan \'t spit in<br /></div>';
}
if ($data['hamburger'] != "" && !is_numeric($data['hamburger'])) {
	echo '<div class="error">Geef een geldig aantal hamburgers in<br /></div>';
}
if ($data['sate'] != "" && !is_numeric($data['sate'])){
	echo '<div class="error">Geef een geldig aantal sat&eacute;s in<br /></div>';
}
if ($data['kip'] != "" && !is_numeric($data['kip'])){
	echo '<div class="error">Geef een geldig aantal kipfilets in<br /></div>';
}
if ($data['worst'] != "" && !is_numeric($data['worst'])){
	echo '<div class="error">Geef een geldig aantal BBQ worsten in<br /></div>';
}
if ($data['rib'] != "" && !is_numeric($data['rib'])){
	echo '<div class="error">Geef een geldig aantal spare ribs in<br /></div>';
}
if ($data['steak'] != "" && !is_numeric($data['rib'])){
	echo '<div class="error">Geef een geldig aantal steaks in<br /></div>';
}

if ($error!=true){

	$data['aantal'] = $data['kind'] + $data['volw'];

	# bereken prijzen
	$fields = array ("volw","kind","varken", "hamburger", "sate", "kip", "worst", "rib","steak");
	foreach($fields as $waarde)
	{
		if($data[$waarde] == ""){
			$data[$waarde] = 0;
		}

	}

	$prijs['kind'] = $data['kind'] * 3;
	$prijs['volw'] = $data['volw'] *5;
	$prijs['varken'] = $data['varken'] * 2;
	$prijs['hamburger'] = $data['hamburger'] * 1.25;
	$prijs['sate'] = $data['sate'] * 2;
	$prijs['kip'] = $data['kip'] * 2;
	$prijs ['worst'] = $data['worst'] * 1.25;
	$prijs['rib'] = $data['rib'] * 4;
	$prijs['steak'] = $data['steak'] * 3.5;
	$prijs['totaal'] = $prijs['kind'] + $prijs['volw'] + $prijs['varken'] + $prijs['hamburger'] + $prijs['sate'] + $prijs['kip'] + $prijs['worst'] + $prijs['rib'] + $prijs['steak'];

	# maak de email
		$bericht="Volgende persoon schreef zich in voor de chirofest-bbq

	".$data['aanspr']." ".$data['voornaam']." ".$data['naam']." (".$data['email'].")

	Bestelling:

	Kinderen: {$data['kind']} x &euro; 3 = &euro; {$prijs['kind']}
	Volwassenen: {$data['volw']} x &euro; 5 = &euro; {$prijs['volw']}

	Varken aan 't spit: {$data['varken']} x &euro; 2 = &euro; {$prijs['varken']}
	Hamburger: {$data['hamburger']} x &euro; 1,25 = &euro; {$prijs['hamburger']}
	Sat&eacute;: {$data['sate']} x &euro; 2 = &euro; {$prijs['sate']}
	Kippenfilet: {$data['kip']} x &euro; 2 = &euro; {$prijs['kip']}
	BBQ Worst: {$data['worst']} x &euro; 1,25 = &euro; {$prijs['worst']}
	Spare Rib: {$data['rib']} x &euro; 4 = &euro; {$prijs['rib']}
	Countrysteak: {$data['steak']} x &euro; 3,5 = &euro; {$prijs['steak']}

	TOTAAL: &euro; {$prijs['totaal']}

	Gelieve het bedrag van &euro; {$prijs['totaal']} over te schrijven op 775-5950072-16 met vermelding {$data['naam']} - {$data['aantal']} pers.



	";
	# toon een bevestigingstabel
	?>
	<form name="chirofest_bevest" method="post">
<table id="chirofest">
<tr>
<th colspan="4"><strong>Kijk de gegevens na</strong></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr><th >Aanspreking</th><td colspan="3"><?php echo $data['aanspr']; ?></td></tr>
<tr><th>Voornaam</th><td colspan="3"><?php echo $data['voornaam']; ?></td></tr>
<tr><th>Naam</th><td colspan="3"><?php echo $data['naam'] ; ?></td></tr>
<tr><th>E-mail</th><td colspan="3" class="alt"><?php echo $data['email'] ; ?></td></tr>
<tr><th colspan="4">&nbsp;</th></tr>
<tr><th colspan="4">Basispaket groenten saus en brood (verplicht)</th></tr>
<tr><th>&nbsp;</th><th>Prijs</th><th>Aantal</th><th>Totaal</th></tr>
<tr><th>Kinderen</th><td>&euro; 3</td><td><?php echo $data['kind']; ?></td><td>&euro; <?php echo $prijs['kind']; ?></tr>
<tr><th>Volwassenen</th><td>&euro; 5</td><td><?php echo $data['volw']; ?></td><td>&euro; <?php echo $prijs['volw']; ?></tr>
<tr><th >&nbsp;</th></tr>
<tr><th >Vrijblijvende bestelling vlees</th></tr>
<tr><th>&nbsp;</th><th>Prijs</th><th>Aantal</th></tr>
<tr><th>Varken aan't spit</th><td>&euro; 2</td><td><?php echo $data['varken']; ?></td><td>&euro; <?php echo $prijs['varken']; ?></tr>
<tr><th>Hamburger</th><td>&euro; 1,25</td><td><?php echo $data['hamburger']; ?></td><td>&euro; <?php echo $prijs['hamburger']; ?></tr>
<tr><th>Sat&eacute;</th><td>&euro; 2</td><td><?php echo $data['sate']; ?></td><td>&euro; <?php echo $prijs['sate']; ?></tr>
<tr><th>Kippenfilet</th><td>&euro; 2</td><td><?php echo $data['kip']; ?></td><td>&euro; <?php echo $prijs['kip']; ?></tr>
<tr><th>BBQ worst</th><td>&euro; 1,25</td><td><?php echo $data['worst']; ?></td><td>&euro; <?php echo $prijs['worst']; ?></tr>
<tr><th>Spare rib</th><td>&euro; 4</td><td><?php echo $data['rib']; ?></td><td>&euro; <?php echo $prijs['rib']; ?></tr>
<tr><th>Countrysteak</th><td>&euro; 3,5</td><td><?php echo $data['steak']; ?></td><td>&euro; <?php echo $prijs['steak']; ?></tr>
<tr><th colspan="4">&nbsp;</th></tr>
<tr><th colspan="3">TOTAAL: </th><th>&euro; <?php echo $prijs['totaal']; ?></th></tr>
<th colspan="4"><input type="submit" name="bevestig" value="Bevestig Inschrijving"></th>
</tr>
</table>
<p>Gelieve het bedrag van &euro; <?php echo $prijs['totaal']; ?> over te schrijven op 775-5950072-16 met vermelding <?php echo $data['naam'] . " - " . $data['aantal'] . " pers."; ?></p>
<input type="hidden" name="bericht" value="<?php echo $bericht; ?>" />
<input type="hidden" name="aan" value="<?php echo  "'{$data['voornaam']} {$data['naam']}' <{$data['email']}>"; ?>" />

</form>


<?php
}
}


	#sendmail($naam,$email,$onderwerp,$bericht,,$cc="",$bcc="",$reply_naam="",$reply_adres="")


elseif (isset($_POST['bevestig'])){

	wp_mail("'Chirofest BBQ' <bbq@chiroschelle.be>, {$_POST['aan']}" , "Inschrijving Chirofest", $_POST['bericht'] ) or die('error!');

	echo '<div class="errorr">Je inschrijving is verzonden.</div>';
}
else{

?>
<form name="chirofest" method="post">
<table id="chirofest">
<tr>
<th colspan="3"><strong>Schrijf Je in voor de chirofest-bbq</strong></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr><th >Aanspreking</th><td colspan="2"><p>
  <input type="radio" name="aanspr" value="Dhr." />
  Dhr. <input type="radio" name="aanspr" value="Mvr." />
  Mvr. <input type="radio" name="aanspr" value="Fam." /> Fam.</p></td></tr>
<tr><th>Voornaam</th><td colspan="2" class="alt"><input type="text" name="voornaam" /></td></tr>
<tr><th>Naam</th><td colspan="2"><input type="text" name="naam"  /></td></tr>
<tr><th>E-mail</th><td colspan="2" class="alt"><input type="text" name="email" /></td></tr>
<tr><th colspan="3">&nbsp;</th></tr>
<tr><th colspan="3">Basispaket groenten saus en brood (verplicht)</th></tr>
<tr><th>&nbsp;</th><th>Prijs</th><th>Aantal</th></tr>
<tr><th>Kinderen</th><td>&euro; 3</td><td><input type="text" name="kind" size="5" /></td></tr>
<tr><th>Volwassenen</th><td>&euro; 5</td><td><input type="text" name="volw" size="5" /></td></tr>
<tr><th >&nbsp;</th></tr>
<tr><th >Vrijblijvende bestelling vlees</th></tr>
<tr><th>&nbsp;</th><th>Prijs</th><th>Aantal</th></tr>
<tr><th>Varken aan't spit</th><td>&euro; 2</td><td><input type="text" name="varken" size="5" /></td></tr>
<tr><th>Hamburger</th><td>&euro; 1,25</td><td><input type="text" name="hamburger" size="5" /></td></tr>
<tr><th>Sat&eacute;</th><td>&euro; 2</td><td><input type="text" name="sate" size="5" /></td></tr>
<tr><th>Kippenfilet</th><td>&euro; 2</td><td><input type="text" name="kip" size="5" /></td></tr>
<tr><th>BBQ worst</th><td>&euro; 1,25</td><td><input type="text" name="worst" size="5" /></td></tr>
<tr><th>Spare rib</th><td>&euro; 4</td><td><input type="text" name="rib" size="5" /></td></tr>
<tr><th>Countrysteak</th><td>&euro; 3,5</td><td><input type="text" name="steak" size="5" /></td></tr>

<th colspan="3"><input type="submit" name="verstuur" value="Verzend Inschrijving"></th>
</tr>
</table>
</form>




<?php
}
}
?>