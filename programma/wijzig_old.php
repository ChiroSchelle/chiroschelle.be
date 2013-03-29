<?php
include_once('header.php');
include_once("config.php");
#geef hier de deadline voor de goepie#
$goepiejaar = '2008';//yyyy
$goepiemaand = '11'; //mm
$goepiedag = '09'; //dd dag waarop ten laatste moet binnengeleverd worden (nog juist op tijd)

#geef hier welk level een user moet hebben om admin of user te zijn
$adminlevel = 8;
$userlevel = 1;

#enkele variabelen
$time = time();
$nujaar = date('Y', $time);
$numaand = date('m',$time);
$nudag = date('d',$time);

#haal informatie uit de sessie
$naam = $_SESSION['naam'];
$afdeling = $_SESSION['afdeling'];
$level = $_SESSION['level'];
$toon = 'alles';

#haal info uit GET
$dag = $_GET['dag'];
$maand = $_GET['maand'];
$jaar = $_GET['jaar'];

if ($_GET['afdeling']!=$afdeling){echo 'je hebt kan enkel het programma van je eigen afdeling bewerken!';}
else{


#controleer of de gebruiker geregistreerd is, laat anders inloggen
if(!session_is_registered(myusername)){
//header("location:main_login.php");
echo '<meta http-equiv="refresh" content="0; url=./main_login.php?ref=invoeren">';
}
#controleer of de gebruiker de juiste machtigingen heeft
elseif ($_SESSION['level']<$userlevel){
	include_once('header.php');
	echo 'U heeft niet de juiste machtigingen om deze pagina te bekijken';

}
else{

$title = 'Programma Wijzigen';

#toon een melding als de deadline voor de goepie is verstreken
if (($goepiejaar<=$nujaar)&&($goepiemaand<=$numaand)&&($goepiedag<$nudag)){
	echo '<div class="error">De Deadline voor de goepie is verstreken!<br /> vergeet geen briefjes rond te doen.</div>';
}


 ?>
 
<form method="post" name="invoeren">
<table id="invoeren" width="550" border="0" cellpadding="2" cellspacing="1">
<tr>
<th class="spec">Naam *</th> <td colspan="3">

<input name="txtNaam" type="hidden" value="<?php echo $naam.'" /> '.$naam; ?></td>
</tr>

<tr>
<?php

#toon de juiste afdeling
	$txtafdeling = maaknummerafdeling($afdeling);
	?>
<th  class="specalt">Afdeling</th>

	<?php echo '<td><input type="radio" name="radAfdeling" value='.$afdeling.' checked="checked" /> '.$txtafdeling.'</td>';

#form om gegevens in te voegen:?>
</tr>
<tr>
<th  class="spec">Datum</td>
<td colspan="3">
<?php
//if (is_null($dag)){
	//$dag = 'YYYY-MM-DD';
//}
echo '<input name="txtDatum" type="hidden" size="30"  value="'.$dag.'">'.$dag.'<br />';
?>
</td>
</tr>
<tr>
<th class="specalt">Programma</td> <td colspan="3" class="alt">
<textarea name="mtxProgramma" cols="80" rows="5" <?php if ($level< $adminlevel) {echo 'tabindex="1"';}?> ></textarea></td>
</tr>
<tr>
<td >&nbsp;</td>
<td colspan="3">
<input name="btnVerstuur" type="submit" value="Verstuur" onClick="return checkForm();"></td>
</tr>
</table>
</form>




<?php


#als form verstuurt wordt:
if(isset($_POST['btnVerstuur']))
{

# maak verbinding met de db
	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');

# haal de informatie uit het formulier
   $naam    = trim($_POST['txtNaam']);
   $afdeling   = trim($_POST['radAfdeling']);
   $datum     = trim($_POST['txtDatum']);
   $programma = trim($_POST['mtxProgramma']);
	
   #foutafhandeling
   if ($datum =="")  {
		echo '<div class="error">Je hebt geen datum gekozen <br /></div>';
		$error = true;
   }
   if ($programma == "") {
		echo '<div class="error>Je hebt geen programma ingevuld!</div>';
		$error = true;
   }
   if (($programma != "")&&($datum != "")) $error=false;
   
   if(!get_magic_quotes_gpc())
   {
      $programma = addslashes($programma);
   }


  #Kijk of de gegevens al in db staan
  if ($error != true) {
  	$sql="SELECT * FROM programma WHERE afdeling='$afdeling' and datum='$datum'";
  	$result=mysql_query($sql);
	#tel de uitgevoerde rijen
 	$count=mysql_num_rows($result);
 	
 	#voer data in als er nog geen programma is voor die dag
	if($count==0){
   		$query = "INSERT INTO programma (id,
                                    afdeling,
                                    datum,
                                    programma,
                                    invoerder)
             VALUES (SYSDATE(),
                     '$afdeling',
                     '$datum',
                     '$programma',
                     '$naam')";

   		mysql_query($query) or die('Error, query failed');
   		echo '<div class="error">Programma succesvol toegevoegd!</div>';
	}
	# toon error als er al een programma is voor die dag
	else {
		echo '<div class="error">Je hebt voor deze dag al een programma! </div>';
		}
  	}
	mysql_close($verbind); 
    exit;
	}

}
}
include_once('footer.php');
?>
