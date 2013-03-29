<?php
    require("class.phpmailer.php");
	$sql['host'] = "localhost";
	$sql['name'] = "c7070chi_ruben";
	$sql['username'] = "c7070chi_ruben";
	$sql['password'] = "chrsell882";
	$sql['table'] = "inschrijvingsavond";

	mysql_connect($sql['host'], $sql['username'], $sql['password']) or die("Kan geen verbinding maken met database");
	mysql_select_db($sql['name']) or die("Kan geen verbinding maken met database");
	
	$result = mysql_query("SELECT * FROM `quiz`");

	while($row = mysql_fetch_array($result)){
	
		$mail = new PHPMailer();
		
		$mail->From = "quiz@chiroschelle.be";
		$mail->FromName = "Chiro Schelle";
		$mail->AddAddress($row["Email"]);
		
		$mail->Subject  = "Quiz";
		$mail->Body     = "Beste ". $row["Voornaam"] . " " . $row["Naam"] . "\n\nDeze zaterdag is het zover. U komt mee quizen op de quiz van Chiro Schelle in de ploeg '" . $row["Ploegnaam"] . "'. Daarom zetten we nog even alles op een rijdtje.\n";
		$mail->Body		.= "De quiz gaat door in 't passeurke op het kerkplein van Schelle en start om 20u. Deuren zijn open vanaf 19u30.";
		$mail->Body		.= "In het begin van de quiz dient 15 euro inschijvings geld betaald te worden. \n\n";
		$mail->Body		.= "Wij wensen jullie al vast veel succes en tot zaterdag.\n\nDe leiding van Chiro Schelle";
		
		if($mail->Send()){
			echo "Mail verzonden naar " . $row["Email"] . "<br>"; 
		}
	else{
		echo "FOUT bij versturen van mail naar " . $row["Email"] . "<br>";
	}
	}
?>
