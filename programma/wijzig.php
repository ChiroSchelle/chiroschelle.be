<?php
include_once('header.php');
include_once("config.php");
#geef hier de deadline voor de goepie#
$goepiejaar = '2008';//yyyy
$goepiemaand = '11'; //mm
$goepiedag = '09'; //dd dag waarop ten laatste moet binnengeleverd worden (nog juist op tijd)

#haal informatie uit de sessie
$naam = $_SESSION['naam'];
$afdeling = $_SESSION['afdeling'];
$level = $_SESSION['level'];

#haal info uit GET
$dag = $_GET['dag'];
$maand = $_GET['maand'];
$jaar = $_GET['jaar'];
$datum =mktime(0,0,0,$maand,$dag,$jaar);
$datum = date("Y-m-d",$datum);

if ($_GET['afdeling']!=$afdeling){echo 'je kan enkel het programma van je eigen afdeling bewerken!';}
else{
	if (isset($_POST['submit'])){
		# maak verbinding met de db
	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');

# haal de informatie uit het formulier
      $mtxprogramma = trim($_POST['mtxprogramma']);
	
   #foutafhandeling
   
   if ($mtxprogramma == "") {
		echo '<div class="error>Je hebt geen programma ingevuld!</div>';
		$error = true;
   } 
   if(!get_magic_quotes_gpc())
   {
      $mtxprogramma = addslashes($mtxprogramma);
   }
	 if ($error != true) {
  	$sql="SELECT * FROM programma WHERE afdeling='$afdeling' and datum='$datum'";
  	$result=mysql_query($sql);
	#tel de uitgevoerde rijen
 	$count=mysql_num_rows($result);
 	
 	#voer data in als er nog geen programma is voor die dag
	if($count==1){
   		$query = "UPDATE programma SET programma ='$mtxprogramma' WHERE afdeling='$afdeling' and datum='$datum'";

   		mysql_query($query) or die('Error, query failed');
   		echo '<div class="error">Programma succesvol Gewijzigd</div>';
	}
	# toon error als er al een programma is voor die dag
	else {
		echo '<div class="error">Je hebt voor deze dag al een programma! </div>';
		}
  	}
	mysql_close($verbind); }

	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');
	$query = "SELECT programma FROM programma WHERE datum LIKE '".$jaar."-".$maand."-".$dag."' AND afdeling = '".$afdeling."'";
	$result = mysql_query($query) or die('Error, query failed');

	# Geef een bericht als de de db leeg is
	if(mysql_num_rows($result) == 0) {
		?>
		Je hebt op deze dag helemaal geen programma!
		<?php
	}
	else {
		
	
		?>
		<form id="wijzig" action="" method="POST">
		<table id="programma" cellspacing="0" summary="Het programma">
		<!--<caption>programma voor <?php echo $dag.'/'.$maand.'/'.$jaar ; ?> </caption> -->
		<tr>
		<th class="nobg"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th>
		<th>programma</th>
		</tr>
		<?php 
		
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$programma = htmlspecialchars($row['programma']);
			$txtafdeling = maaknummerafdeling($afdeling);
			?>
			<tr><th class="spec"><?php echo $txtafdeling; ?></th><td><textarea name="mtxprogramma" cols="80" rows="5"><?php echo $programma; ?></textarea></td></tr>
	<?php			
			}
	
			mysql_close($verbind);  
			?>
			<tr><td colspan="2"><input type="submit" value="Wijzig Programma" name="submit" /></td></tr>
			</table>
			</form>
			<?php
	}
	}
	
include_once('footer.php');
?>