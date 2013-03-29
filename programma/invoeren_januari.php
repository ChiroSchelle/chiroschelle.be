<?php include_once('header.php');
		$goepiejaar = '2009';//yyyy
		$goepiemaand = '01'; //mm
		$goepiedag = '30'; //dd dag waarop ten laatste moet binnengeleverd worden (nog juist op tijd)
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
		elseif(($afdeling>=5)&&($afdeling <=6)){
			$rakwi=true;
			}
		elseif(($afdelin>=1)&&($afdeling<-4)){
			$ribspe=true;
			}	
	?>
	<p><a href="invoeren.php">speciale data toevoegen</a><hr /></p>
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
	if($tikeas){ ?>
			<th class="alt"> 15 februari</th>
				<td class="alt">TiKeAs</td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum1" value="2009-02-22" />22 februari</th>
				<td ><textarea name="mtxProgramma1" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum2" value="2009-03-01">1 maart</th>
				<td class="alt"><textarea name="mtxProgramma2" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th ><input type="hidden" name="txtDatum3" value="2009-03-08">8 maart</th>
				<td ><textarea name="mtxProgramma3" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum4" value="2009-03-15">15 maart</th>
				<td class="alt"><textarea name="mtxProgramma4" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum5" value="2009-03-22">22 maart</th>
				<td><textarea name="mtxProgramma5" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum6" value="2009-03-29">29 maart</th>
				<td class="alt"><textarea name="mtxProgramma6" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum7" value="2009-04-05">5 april</th>
				<td><textarea name="mtxProgramma7" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"> 12 April</th>
				<td class="alt">Planningsweekend</td>
			</tr>
				<th><input type="hidden" name="txtDatum8" value="2009-04-19">19 april</th>
				<td><textarea name="mtxProgramma8" cols="60" rows="5" ></textarea></td>
			</tr>
<?php
		$aantalzondagen = 8; //aantal in te vullen zondagen
	}
	elseif($rakwi==true){
		?>		<th class="alt"><input type="hidden" name="txtDatum1" value="2009-02-15" /> 15 februari</th>
				<td class="alt"><textarea name="mtxProgramma1" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th>22 februari</th>
				<td >Rakwiweekend</td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum2" value="2009-03-01">1 maart</th>
				<td class="alt"><textarea name="mtxProgramma2" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th ><input type="hidden" name="txtDatum3" value="2009-03-08">8 maart</th>
				<td ><textarea name="mtxProgramma3" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum4" value="2009-03-15">15 maart</th>
				<td class="alt"><textarea name="mtxProgramma4" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum5" value="2009-03-22">22 maart</th>
				<td><textarea name="mtxProgramma5" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum6" value="2009-03-29">29 maart</th>
				<td class="alt"><textarea name="mtxProgramma6" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum7" value="2009-04-05">5 april</th>
				<td><textarea name="mtxProgramma7" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"> 12 April</th>
				<td class="alt">Planningsweekend</td>
			</tr>
				<th><input type="hidden" name="txtDatum8" value="2009-04-19">19 april</th>
				<td><textarea name="mtxProgramma8" cols="60" rows="5" ></textarea></td>
			</tr>
            <?php
		$aantalzondagen = 8; //aantal in te vullen zondagen
	}
	elseif($ribspe==true){ ?>
    			<th class="alt"><input type="hidden" name="txtDatum1" value="2009-02-15" /> 15 februari</th>
				<td class="alt"><textarea name="mtxProgramma1" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum2" value="2009-02-22">22 februari</th>
				<td><textarea name="mtxProgramma2" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum3" value="2009-03-01">1 maart</th>
				<td class="alt"><textarea name="mtxProgramma3" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th ><input type="hidden" name="txtDatum4" value="2009-03-08">8 maart</th>
				<td ><textarea name="mtxProgramma4" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum5" value="2009-03-15">15 maart</th>
				<td class="alt"><textarea name="mtxProgramma5" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th>22 maart</th>
				<td>Ribbel-Speelclubweekend</td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum6" value="2009-03-29">29 maart</th>
				<td class="alt"><textarea name="mtxProgramma6" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum7" value="2009-04-05">5 april</th>
				<td><textarea name="mtxProgramma7" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"> 12 April</th>
				<td class="alt">Planningsweekend</td>
			</tr>
				<th><input type="hidden" name="txtDatum8" value="2009-04-19">19 april</th>
				<td><textarea name="mtxProgramma8" cols="60" rows="5" ></textarea></td>
			</tr>
<?php
		$aantalzondagen = 8; //aantal in te vullen zondagen
	}
	else{ ?> //admin moet deze keer enkel ribspeelclub doen
    			<th class="alt"><input type="hidden" name="txtDatum1" value="2009-02-15" /> 15 februari</th>
				<td class="alt"><textarea name="mtxProgramma1" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum2" value="2009-02-22">22 februari</th>
				<td><textarea name="mtxProgramma2" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum3" value="2009-03-01">1 maart</th>
				<td class="alt"><textarea name="mtxProgramma3" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th ><input type="hidden" name="txtDatum4" value="2009-03-08">8 maart</th>
				<td ><textarea name="mtxProgramma4" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum5" value="2009-03-15">15 maart</th>
				<td class="alt"><textarea name="mtxProgramma5" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th>22 maart</th>
				<td>Ribbel-Speelclubweekend</td>
			</tr>
			<tr>
				<th class="alt"><input type="hidden" name="txtDatum6" value="2009-03-29">29 maart</th>
				<td class="alt"><textarea name="mtxProgramma6" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th><input type="hidden" name="txtDatum7" value="2009-04-05">5 april</th>
				<td><textarea name="mtxProgramma7" cols="60" rows="5" ></textarea></td>
			</tr>
			<tr>
				<th class="alt"> 12 April</th>
				<td class="alt">Planningsweekend</td>
			</tr>
				<th><input type="hidden" name="txtDatum8" value="2009-04-19">19 april</th>
				<td><textarea name="mtxProgramma8" cols="60" rows="5" ></textarea></td>
			</tr>
<?php
		$aantalzondagen = 8; //aantal in te vullen zondagen
	}
?>
			<tr>
				<th class="alt"> 26 April</th>
				<td class="alt">Ol&eacute; Pistol&eacute;</td>
			</tr>


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
  //sleep(1);
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

if (toegevoegd == true){
echo '<div class="error">Programma succevol toegevoegd</div>';
}
}
}
include_once('footer.php');
?>

</body>
</html>
