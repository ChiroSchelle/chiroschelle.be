<?php
include('header.php');
include('db.php');

if(!$rank){
	echo "U heeft geen toegang tot deze pagina";
}
else {
	$str = "SELECT * FROM `c7070chi_ruben`.`members` WHERE `username`='";
	$str .= $_SESSION['username'];
	$str .= "';";
	$result = mysql_query($str) or die(mysql_error());
	$row = mysql_fetch_array($result);

	echo "Beste ";
	echo $_SESSION['username'];
	echo ",<br>";
	echo "U saldo staat momenteel op ";
	echo $row['bedrag'];
	echo " euro. <br><br>";
	
	echo "Laatste wijzigingen:<br>";
	
	//SELECT USER ACTIONS
	$str = "SELECT * FROM `c7070chi_ruben`.`acties` WHERE `user-ID` ='";
	$str .= $row['id'];
	$str .= "' ORDER BY `acties`.`Tijdstip` DESC LIMIT 0 , 30;";
	$result = mysql_query($str) or die(mysql_error());
	
	echo "<ul>";
	while($newrow = mysql_fetch_array($result)){
		//print
		echo "<li>";
		if($newrow['type-actie'] == 1){
			echo "-";
			echo $newrow['Hoeveel'];
			echo " euro. Toegevoegd op ";
			echo $newrow['Tijdstip'];
			echo ".";
			
			if($newrow['Opmerking'] != ''){
				echo " Opmerking: ";
				echo $newrow['Opmerking'];	
			}
			echo "</li>";
		}
		else if ($newrow['type-actie'] == 2){
			echo "+";
			echo $newrow['Hoeveel'];
			echo " euro. Toegevoegd op ";
			echo $newrow['Tijdstip'];
			echo ".";

			if($newrow['Opmerking'] != ''){
				echo " Opmerking: ";
				echo $newrow['Opmerking'];
			}
			echo "</li>";
		}
		else if ($newrow['type-actie'] == 0){
			echo "Algemene Opmerking: ";
			echo $newrow['Opmerking'];
			echo "</li>";
		}
		else {
			echo "FOUT!</li>";
		}
	}
	echo "</ul>";
}	
?>
</body>
</html>
