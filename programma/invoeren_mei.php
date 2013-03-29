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
	//gegevens ophalen
	$velden = array ("mtxProgramma1","mtxProgramma2","mtxProgramma3","mtxProgramma4","mtxProgramma5","mtxProgramma6","mtxProgramma7","mtxProgramma8","mtxProgramma9","mtxProgramma10","mtxProgramma11","mtxProgramma12",);
	foreach($velden as $waarde)
	{
		if(array_key_exists($waarde, $_POST))
			$gegevens[$waarde] = trim($_POST[$waarde]);
		else
			$gegevens[$waarde] = "";
	}
	
	
		
	
		$goepiejaar = '2009';//yyyy
		$goepiemaand = '04'; //mm
		$goepiedag = '19'; //dd dag waarop ten laatste moet binnengeleverd worden (nog juist op tijd)
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
		if(!isset($_SESSION['naam'])){
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
		if(($afdeling >= 7) && ($afdeling <= 12)){
			$tikeas=true;
			}
	?>
	<p><a href="invoeren.php">speciale data toevoegen</a><hr /></p>
    <p><strong>Er komt onderaan een melding of het programma al dan niet succesvol is toegevoegd!</strong></p>
	<form method="post" name="invoeren">
		<table id="invoeren" width="550" border="0" cellpadding="2" cellspacing="1">
			<tr>
				<th class="spec">Naam *</th>
				<td colspan="3">
					<input name="txtNaam" type="hidden" value="<?php echo $naam.'" /> '.$naam; ?>
				</td>
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
				<td>Ribbel</td>
				<td><input type="radio" name="radAfdeling" value="1" /> Jongens </td>
				<td><input type="radio" name="radAfdeling" value="2" />Meisjes</td>
			</tr>
			<tr>
				<td class="alt">Speelclub </td>
				<td class="alt"><input type="radio" name="radAfdeling" value="3" />Jongens </td>
				<td class="alt"><input type="radio" name="radAfdeling" value="4" />Meisjes</td>
			</tr>
			<tr>
				<td ></td>
				<td><input type="radio" name="radAfdeling" value="5" />Rakkers</td>
				<td> <input type="radio" name="radAfdeling" value="6" />Kwiks</td>
			</tr>
			<tr>
				<td  class="alt"></td>
				<td class="alt"><input type="radio" name="radAfdeling" value="7" />Toppers </td>
				<td class="alt"><input type="radio" name="radAfdeling" value="8" />Tippers</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="radio" name="radAfdeling" value="9" />Kerels </td>
				<td><input type="radio" name="radAfdeling" value="10" />Tiptiens</td>
			</tr>
			<tr>
				<td>Aspi </td>
				<td class="alt"><input type="radio" name="radAfdeling" value="11" />Jongens </td>
				<td class="alt"><input type="radio" name="radAfdeling" value="12" /> Meisjes</td>
			</tr>
			<tr>
				<td class="alt" colspan="3"><input type="radio" name="radAfdeling" value="13" />IEDEREEN</td>
				<?php
				}
				?>
			</tr>
			
			<tr>
<?php
	if($tikeas){
	?>	<th><input type="hidden" name="txtDatum1" value="2009-05-03" />3 mei</th>
				<td ><textarea name="mtxProgramma1" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma1']; ?></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum2" value="2009-05-10">10 mei</th>
				<td class="alt"><textarea name="mtxProgramma2" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma2']; ?></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum3" value="2009-05-17">17 mei</th>
				<td ><textarea name="mtxProgramma3" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma3']; ?></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum4" value="2009-05-24">24 mei</th>
				<td class="alt"><textarea name="mtxProgramma4" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma4']; ?></textarea></td>
			</tr>
            <tr>
				<th >31 mei</th>
				<td >Dag van het park</td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum5" value="2009-06-05"><strong>VRIJDAG</strong> 5 juni (19u-21u)</th>
				<td class="alt"><textarea name="mtxProgramma5" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma5']; ?></textarea></td>
			</tr>
			<tr>
				<th>14 - 21 juni</th>
				<td>INSTUIF</td>
			</tr>
            <tr>
				<th class="alt"><input type="hidden" name="txtDatum6" value="2009-06-28">28 juni (zangstonde)</th>
				<td class="alt"><textarea name="mtxProgramma6" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma6']; ?></textarea></td>
			</tr>
            <tr>
				<th><input type="hidden" name="txtDatum7" value="2009-07-05">5 juli</th>
				<td><textarea name="mtxProgramma7" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma7']; ?></textarea></td>
			</tr>
            <tr>
				<th class="alt"><input type="hidden" name="txtDatum8" value="2009-07-12">12 juli</th>
				<td class="alt"><textarea name="mtxProgramma8" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma8']; ?></textarea></td>
			</tr>
            <tr>
				<th>19 juli</th>
				<td>Valiezen binnenbrengen</td>
			</tr>
              <tr>
				<th class="alt">21-31 juli</th>
				<td class="alt">Kamp!</td>
			</tr>
            <?php
		$aantalzondagen = 8; //aantal in te vullen zondagen
	}
	else{
		?>	<th><input type="hidden" name="txtDatum1" value="2009-05-03" />3 mei</th>
				<td ><textarea name="mtxProgramma1" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma1']; ?></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum2" value="2009-05-10">10 mei</th>
				<td class="alt"><textarea name="mtxProgramma2" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma2']; ?></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum3" value="2009-05-17">17 mei</th>
				<td ><textarea name="mtxProgramma3" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma3']; ?></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum4" value="2009-05-24">24 mei</th>
				<td class="alt"><textarea name="mtxProgramma4" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma4']; ?></textarea></td>
			</tr>
            <tr>
				<th >31 mei</th>
				<td >Dag van het park</td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum5" value="2009-06-05"><strong>VRIJDAG</strong> 5 mei (19u-21u)</th>
				<td class="alt"><textarea name="mtxProgramma5" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma5']; ?></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum9" value="2009-06-14">14 juni</th>
				<td ><textarea name="mtxProgramma9" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma9']; ?></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum10" value="2009-06-21">21 juni</th>
				<td class="alt"><textarea name="mtxProgramma10" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma10']; ?></textarea></td>
			</tr>
            <tr>
				<th><input type="hidden" name="txtDatum6" value="2009-06-28">28 juni (zangstonde)</th>
				<td><textarea name="mtxProgramma6" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma6']; ?></textarea></td>
			</tr>
            <tr>
				<th class="alt"><input type="hidden" name="txtDatum7" value="2009-07-05">5 juli</th>
				<td class="alt"><textarea name="mtxProgramma7" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma7']; ?></textarea></td>
			</tr>
            <tr>
				<th><input type="hidden" name="txtDatum8" value="2009-07-12">12 juli</th>
				<td><textarea name="mtxProgramma8" cols="60" rows="5" ><?php echo $gegevens['mtxProgramma8']; ?></textarea></td>
			</tr>
            <tr>
				<th class="alt">19 juli</th>
				<td class="alt">Valiezen binnenbrengen</td>
			</tr>
              <tr>
				<th>21-31 juli</th>
				<td>Kamp!</td>
			</tr>
            <?php
		$aantalzondagen = 10; //aantal in te vullen zondagen
	}


?>



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
		//$error = false;
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
  if ($error != true) {
  $toon= false;
  for ($i=1;$i<=$aantalzondagen;$i++){
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
   if ($toon != true){
   echo '<div class="error">Programma succesvol toegevoegd</div>';
   $toon = true;
   }
      }
else {
	echo '<div class="error">Je hebt voor al een programma! voor '.$datum[$i].' </div>';
	$toegevoegd = false;
}
  }
  }
mysql_close($verbind); 
   //header("location:uitlezen.php");
  // exit;

if ($toegevoegd != false){

}
}
}
include_once('footer.php');
?>

</body>
</html>
