<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Programma invoeren</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$goepiejaar = '2008';//yyyy
$goepiemaand = '09'; //mm
$goepiedag = '02'; //dd dag waarop ten laatste moet binnengeleverd worden (nog juist op tijd)
$time = time();
$nujaar = date('Y', $time);
$numaand = date('m',$time);
$nudag = date('d',$time);


$naam = $_SESSION['naam'];
$afdeling = $_SESSION['afdeling'];
$level = $_SESSION['level'];
$toon = 'alles';
$adminlevel = 8;
$userlevel = 1;
if(!session_is_registered(myusername)){
//header("location:main_login.php");
echo '<meta http-equiv="refresh" content="0; url=./main_login.php">';
}
#controleer of de gebruiker de juiste machtigingen heeft
elseif ($_SESSION['level']<$userlevel){
	include_once('header.php');
	echo 'U heeft niet de juiste machtigingen om deze pagina te bekijken';

}
else{

$title = 'Programma invoeren';
include_once('header.php'); 

if (($goepiejaar<=$nujaar)&&($goepiemaand<=$numaand)&&($goepiedag<$nudag)){

	echo '<div class="error">De deadline voor deze goepie is verstreken!<br /> vergeet geen briefjes rond te doen.</div>';
}

 ?>
<p><a href="invoeren.php">speciale data toevoegen</a><hr /></p>
<form method="post" name="invoeren">
<table id="invoeren" width="550" border="0" cellpadding="2" cellspacing="1">
<tr>
<th class="spec">Naam *</th> <td colspan="3">

<input name="txtNaam" type="hidden" value="<?php echo $naam.'" /> '.$naam; ?></td>
</tr>
<tr>
<?php


if ($level < $adminlevel){
	$txtafdeling = maaknummerafdeling($afdeling);
	?>
<th  class="specalt">Afdeling</th>

	<?php echo '<td><input type="radio" name="radAfdeling" value='.$afdeling.' checked="checked" /> '.$txtafdeling.'</td>';
}
else {
	?>

<th class="specalt" rowspan="7">Afdeling</th>
<td>
Ribbel</td><td><input type="radio" name="radAfdeling" value="1" /> Jongens </td><td><input type="radio" name="radAfdeling" value="2" />Meisjes</td></tr><tr>
<td class="alt">Speelclub </td><td class="alt"><input type="radio" name="radAfdeling" value="3" />Jongens </td><td class="alt"><input type="radio" name="radAfdeling" value="4" />Meisjes</td></tr><tr>
<td ></td><td><input type="radio" name="radAfdeling" value="5" />Rakkers</td><td> <input type="radio" name="radAfdeling" value="6" />Kwiks</td></tr><tr>
<td  class="alt"></td><td class="alt"><input type="radio" name="radAfdeling" value="7" />Toppers </td><td class="alt"><input type="radio" name="radAfdeling" value="8" />Tippers</td></tr><tr>
<td></td><td><input type="radio" name="radAfdeling" value="9" />Kerels </td><td><input type="radio" name="radAfdeling" value="10" />Tiptiens</td></tr><tr>
<td>Aspi </td><td class="alt"><input type="radio" name="radAfdeling" value="11" />Jongens </td><td class="alt"><input type="radio" name="radAfdeling" value="12" /> Meisjes
</td></tr>
<tr>
<td class="alt" colspan="3"><input type="radio" name="radAfdeling" value="13" />IEDEREEN</td>
<?php
}
?>
</tr>
<tr><th>7 september</th><td>Overgangen</td></tr>
<tr><th class="alt">14 september</th><td class="alt">Afbraak 80 90 2000</td></tr>
<tr><th><input type="hidden" name="txtDatum1" value="2008-09-21" />21 september</th><td ><textarea name="mtxProgramma1" cols="60" rows="5" ></textarea></td></tr>
<tr><th class="alt">28 september</th><td class="alt">Planningsweekend</td></tr>
<tr><th><input type="hidden" name="txtDatum2" value="2008-10-05" />5 oktober</th><td ><textarea name="mtxProgramma2" cols="60" rows="5" ></textarea></td></tr>
<tr><th class="alt"><input type="hidden" name="txtDatum3" value="2008-10-12" />12 oktober</th><td class="alt"><textarea name="mtxProgramma3" cols="60" rows="5" ></textarea></td></tr>
<tr><th>19 oktober</th><td >Schelle Jaarmarkt</td></tr>
<tr><th class="alt"><input type="hidden" name="txtDatum4" value="2008-10-26">26 oktober</th><td class="alt"><textarea name="mtxProgramma4" cols="60" rows="5" ></textarea></td></tr>
<tr><th><input type="hidden" name="txtDatum5" value="2008-11-02">2 november</th><td ><textarea name="mtxProgramma5" cols="60" rows="5" ></textarea></td></tr>
<tr><th class="alt"><input type="hidden" name="txtDatum6" value="2008-11-09">9 november</th><td class="alt"><textarea name="mtxProgramma6" cols="60" rows="5" ></textarea></td></tr>
<tr><th class="alt"><input type="hidden" name="txtDatum7" value="2008-11-16">16 november</th><td class="alt"><textarea name="mtxProgramma7" cols="60" rows="5" ></textarea></td></tr>
<tr><th class="alt">23 november</th><td class="alt">Christus Koning</textarea></td></tr>
<tr><th class="alt"><input type="hidden" name="txtDatum8" value="2008-11-30">30 november</th><td class="alt"><textarea name="mtxProgramma8" cols="60" rows="5" ></textarea></td></tr>
<?php $aantalzondagen = 8; //aantal in te vullen zondagen?>



<tr>
<td >&nbsp;</td>
<td colspan="3">
<input name="btnVerstuur" type="submit" value="Verstuur" onClick="return checkForm();"> 
(dit kan een tiental seconden duren)</td>
</tr>
</table>
</form>




<?php

#include '../library/config.php';
#include '../library/opendb.php';

if(isset($_POST['btnVerstuur']))
{

	include_once("config.php");

	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');




   $naam    = trim($_POST['txtNaam']);
   $afdeling   = trim($_POST['radAfdeling']);
   for ($i=1;$i<=$aantalzondagen;$i++){
   	
   $datum[$i]     = trim($_POST['txtDatum'.$i]);
   $programma[$i] = trim($_POST['mtxProgramma'.$i]);
	if ($programma[$i] ==""){
		echo '<div class="error">Je hebt geen programma voor '.$datum[$i].'<br /></div>';
		$error = true;
		}
		else {
		$error = false;
		}
		
		 if(!get_magic_quotes_gpc())
   {
      $programma[$i] = addslashes($programma[$i]);
   }

	}
   

   // if the visitor do not enter the url
   // set $url to an empty string
  /* if ($url == 'http://')
   {
      $url = '';
   }
*/
  if ($error == false) {
  for ($i=1;$i<=$aantalzondagen;$i++){
  sleep(1);
  $sql="SELECT * FROM programma WHERE afdeling='$afdeling' and datum='$datum[$i]'";
  $result=mysql_query($sql);

// Mysql_num_row is counting table row
 $count=mysql_num_rows($result);
 //$count = mysql_numrows($result);
 //echo $count;
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==0){
   $query = "INSERT INTO programma (id,
                                    afdeling,
                                    datum,
                                    programma,
                                    invoerder)
             VALUES (SYSDATE(),
                     '$afdeling',
                     '$datum[$i]',
                     '$programma[$i]',
                     '$naam')";

   mysql_query($query) or die('<div="error">Error, query failed</div>');
      }
else {
	echo '<div class="error">Je hebt voor al een programma! voor '.$datum[$i].' </div>';
	$toegevoegd = false;
}
  }
  }
mysql_close($verbind); 
   //header("location:uitlezen.php");
   exit;

if (toegevoegd != false){
echo '<div class="error">Programma succevol toegevoegd</div>';
}
}
}
include_once('footer.php');
?>

</body>
</html>
