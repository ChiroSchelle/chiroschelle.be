<?php
include('header.php');
include('functions.php');

if (!$rank){
	echo "U heeft geen toegang tot deze pagina";
}
else {
	//get poef
	$sql = "SELECT * FROM `c7070chi_ruben`.`totaal` ORDER BY `totaal`.`Wanneer` DESC LIMIT 0, 30;";
	$result = mysql_query($sql) or die(mysql_error());
	$firstrow = mysql_fetch_array($result);
	
	echo "De poefkas bedraagt op dit moment ";
	echo $firstrow['Totaal'];
	echo " euro. En is het laatst gewijsigd op ";
	echo $firstrow['Wanneer'];
	echo "<br>";
	
	if($rank > 0){
		echo "<h3>Geschiedis:</h3><ul>";
		while($row=mysql_fetch_array($result)){
			echo "<li>";
			echo $row['Totaal'];
			echo " euro op ";
			echo $row['Wanneer'];
			echo "</li>";
		}
		echo "</ul>";
	}
}
?>
</body>
</html>
