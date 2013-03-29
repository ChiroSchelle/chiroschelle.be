<?php
include ('header.php');
include ('functions.php');

if ($rank < 1) {
	echo "U heeft geen toegang tot deze pagina";
} else
	if (!$_POST['user']) {
		echo "<form method='post' action='";
		echo $PHP_SELF;
		echo "'>" .
		"User: <select name='user'>";
		$sql = getDB("members");

		while ($row = mysql_fetch_assoc($sql)) {
			echo "<option value='";
			echo $row['id'];
			echo "'>";
			echo $row['username'];
			echo "</option>";
		}

		echo "</select><br>";
		echo "Heeft volgend bedarg betaald: ";
		echo "<input type='text' name='bedrag'> <br>";
		echo "<input type='submit'>";
		echo "</form>";

	} else {
		$str = "INSERT INTO `c7070chi_ruben`.`acties` (`ID`, `Tijdstip`, `user-ID`, `type-actie`, `Hoeveel`) VALUES (NULL, CURRENT_TIMESTAMP, '";
		$str .= $_POST['user'];
		$str .= "', '2', '";
		$str .= $_POST['bedrag'];
		$str .= "');";
		
		if(!mysql_query($str)){
			die ('Error:' . mysql_error());
		}
		
		$str = "SELECT * FROM `c7070chi_ruben`.`members` WHERE `ID`='";
                $str .= $_POST['user'];
                $str .= "';";

                $result = mysql_query($str) or die (mysql_error());
                $row = mysql_fetch_array($result);

                $user = $row['username'];

                $newbedrag = $row['bedrag'] + $_POST['bedrag'];
                $str = "UPDATE `c7070chi_ruben`.`members` SET `bedrag`='";
                $str .= $newbedrag;
                $str .= "' WHERE `ID`='";
                $str .= $_POST['user'];
                $str .= "';";

                mysql_query($str) or die(mysql_error());

		totaal(true, $_POST['bedrag']);
	                
		echo "Betaling toegevoegd bij user: ";
                echo $user;
                echo ". (";
                echo $_POST['bedrag'];
                echo " euro toegevoegd aan rekening).";
		
	
	}
?>
