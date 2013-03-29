<?php
include_once("db.php");

function getDB($name){
	$slq = "SELECT id, username FROM $name";
	return mysql_query($slq);
}

function totaal($plus, $bedrag){
	$sql = "SELECT * FROM `c7070chi_ruben`.`totaal` ORDER BY `totaal`.`Wanneer` DESC LIMIT 0 , 1;";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	if($plus){
		$newTotal = $row['Totaal'] + $bedrag;
		$sql = "INSERT INTO `c7070chi_ruben`.`totaal`(`Wanneer` , `Totaal`) VALUES (CURRENT_TIMESTAMP, '";
		$sql .= $newTotal;
		$sql .= "');";
	}
	else{
		$newTotal = $row['Totaal'] - $bedrag;
		$sql = "INSERT INTO `c7070chi_ruben`.`totaal`(`Wanneer` , `Totaal`) VALUES (CURRENT_TIMESTAMP, '";
		$sql .= $newTotal;
		$sql .= "');";
	}
	mysql_query($sql) or die(mysql_error());	
}

?>
