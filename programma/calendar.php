<?php
# laad enkele functies
include_once './functions.php';
##
##
## http://keithdevens.com/software/php_calendar
##
##


//generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array())


## gegevens klaarzetten : ##
include_once "config.php";
# maak verbinding met db #
$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
mysql_select_db($database) or die('Cannot select database');
# haal data op waarvoor een programma bestaat #
if (!isset($_SESSION['naam'])){
$query = "SELECT DISTINCT datum FROM programma WHERE afdeling !='14' ORDER BY id DESC ";
}else{
$query = "SELECT DISTINCT datum FROM programma ORDER BY id DESC ";
}
$result = mysql_query($query) or die('Error, query failed');		  

#steek alle jaren, maanden en dagen in een aparte array;
$n = 1;
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
$datum = $row['datum']; 
$splits = explode("-",$datum);
$jaren[$n] = $splits[0]; 
$maanden[$n] = $splits[1];
$dagen[$n] = $splits[2];
$n++;
}

## en dan nu: de kalender! ##
#include 'gencal.php';

# zorg dat de kalender in het nederlands wordt weergegeven
$oldlocale = setlocale(LC_TIME, NULL); #save current locale
setlocale(LC_TIME, 'nl_NL'); #dutch
# sla huidige datum op in juiste veriabelen (als er geen datum is gespecifieerd in url)
$time = time();
if ($_GET['jaar'] == '') {
	$year= date('Y', $time);
}
else {
	$year =$_GET['jaar'];
}
if ($_GET['maand']=='') {
	$month =date('n', $time);
}
else {
	$month = $_GET['maand'];
}
$month = maaktweecijfer($month);



  # Onderstaand script maakt van elke datum een link (te gebruiken bij om datum te kiezen bij invoeren) #
 if ($toon=='alles'){
 $days = array();
 for ($i = 1; $i <= 9; $i++) {
 	if ($_GET['activiteit']==true){
 		$days[$i] = array('?dag='.$year.'-'.$month.'-0'.$i.'&activiteit=true','linked-day');
 	}else{
 		$days[$i] = array('?dag='.$year.'-'.$month.'-0'.$i,'linked-day');
 	}
 
 };
  for ($i == 10; $i <= 31; $i++) {
  	if($_GET['activiteit']==true){
  		$days[$i] = array('?dag='.$year.'-'.$month.'-'.$i.'&activiteit=true','linked-day');
  	}else{
  		$days[$i] = array('?dag='.$year.'-'.$month.'-'.$i,'linked-day');
  	}
 };
 }
 else{
 
 # Maak een link bij elke dag waarvoor er een programma is ( #
 $days = array();
 
 for ($i = 1; $i<=$n; $i++){
 	if ($jaren[$i] == $year) {
		if ($maanden[$i] == $month) {
			$dag = $dagen[$i];
			$dag = maakeencijfer($dag);
			
			$days[$dag] = array('uitlezen.php?toon=datum&jaar='.$year.'&maand='.$month.'&dag='.$dag,'linked-day');
			
			}
		}
	}
 }
 
# enkele variablen voor de kalender #
$day_name_length = 2; # twee letters voor dag
$month_href = NULL; #link die de maand heeft
$first_day = 1; #begin de week op maandeg (0 = zondag)
//$pn = NULL; 

# maak pijltjes die naar vorige en volgende maand gaan #
$pmonth = $month - 1; $pyear = $year;
$nmonth = $month + 1; $nyear = $year;
if ($pmonth < 1) {$pmonth = 12; $pyear = $year - 1;};
if ($nmonth > 12) {$nmonth = 01; $nyear = $year + 1;};
if ($_GET['activiteit']==true){
	$pn = array('&laquo;'=>'?toon=datum&maand='.$pmonth.'&jaar='.$pyear.'&activiteit=true', '&raquo;'=>'?toon=datum&maand='.$nmonth.'&jaar='.$nyear.'&activiteit=true');
}else{
	$pn = array('&laquo;'=>'?toon=datum&maand='.$pmonth.'&jaar='.$pyear, '&raquo;'=>'?toon=datum&maand='.$nmonth.'&jaar='.$nyear);
}



# en finally ... druk de kalender af #
echo generate_calendar($year, $month, $days, $day_name_length, $month_href, $first_day, $pn); 
mysql_close($verbind);
?> 
