<?php 
include('header.php');
include('functions.php');
if ($rank < 1) {
        echo "U heeft geen toegang tot deze pagina";
}
else {
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
                echo "Heeft volgend aantal kruisjes van " . $prijs . " euro: ";
                echo "<input type='text' name='bedrag'> <br>";
                echo "<input type='submit'>";
                echo "</form>";

        } else {
		$bedrag = $_POST['bedrag'] * $prijs;
                $str = "INSERT INTO `c7070chi_ruben`.`acties` (`ID`, `Tijdstip`, `user-ID`, `type-actie`, `Hoeveel`) VALUES (NULL, CURRENT_TIMESTAMP, '";
                $str .= $_POST['user'];
                $str .= "', '1', '";
                $str .= $bedrag;
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
		
		$newbedrag = $row['bedrag'] - $bedrag;
		$str = "UPDATE `c7070chi_ruben`.`members` SET `bedrag`='";
		$str .= $newbedrag;
		$str .= "' WHERE `ID`='";
		$str .= $_POST['user'];
		$str .= "';";
		
		mysql_query($str) or die(mysql_error());
		
		totaal(false, $bedrag);
                echo "Betaling toegevoegd bij user: ";
		echo $user;
		echo ". (";
		echo $bedrag;
		echo " euro afgetrokken van rekening).";
        }
}
?>
