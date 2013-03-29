<?php

	include_once 'inclQuiz/classes.php';

	$invulveld = true;
    if(isset($_POST['ploegnaam'])){
    	$ploeg = new Ploeg;
		$errorValue = $ploeg->newPloeg($_POST['ploegnaam'], $_POST['naam'], $_POST['voornaam'], $_POST['telefoon'], $_POST['email'], $_POST['straat'], $_POST['nummer'], $_POST['gemeente']);
		if($errorValue < O){
			echo "<div id='error' style='color: red;'>";
			switch ($errorValue) {
				case -1:
					echo "Email adres is niet correct";
					$_POST['email'] = NULL;
					break;
				
				case -2:
					echo "Ploegnaam is niet ingevuld of tekort. Moet minsten 2 letters bevatten";
					$_POST['ploegnaam'] = NULL;
					break;
				
				case -3:
					echo "Naam wordt niet aanvaard";
					$_POST['naam'] = NULL;
					break;
					
				case -4:
					echo "Voornaam wordt niet aanvaard";
					$_POST['voornaam'] = NULL;
					break;
					
				case -5:
					echo "Telefoonnummer wordt niet aanvaard";
					$_POST['telefoon'] = NULL;
					break;
				
				case -6:
					echo "Dit email adres werd al een keer gebruikt";
					$_POST['email'] = NULL;
					break;
					
				case -7:
					echo "Straat wordt niet aanvaard";
					$_POST['straat'] = NULL;
					break;
					
				case -8:
					echo "Nummer wordt niet aanvaard";
					$_POST['nummer'] = NULL;
					break;
				
				case -9:
					echo "Gemeente wordt niet aanvaard";
					$_POST['gemeente'] = NULL;
					break;
					
				default:
					
					break;
			}
		}
		else if($errorValue == 1){
			$invulveld = false;
			$code = $ploeg->zetInWacht();
			if($code == false){
				echo "Er is iets mis gegaan bij het inschrijven. Probeer later opnieuw";
			}
			else {
				mailWacht($code, $ploeg);
				echo "U dient u inschrijving te bevestigen via de mail die verstuurd is naar: " . $ploeg->getEmail();
				echo "<br>De 15 euro inschrijvingsgeld dient door de ploegverantwoordelijke worden cash betaald op de avond zelf.";
			}
		}
    }
	if($invulveld){
		$qry = "SELECT * FROM `quiz`";
		$result = mysql_query($qry);
		$numRows = mysql_num_rows($result);
		if($numRows >= 20){
			$invulveld = false;
			echo "Inschrijven voor de quiz is helaas niet meer mogelijk.";
		} 
	}
	if($invulveld){
    ?>
    <form method="post" action="index.php">
    	<table>
    		<tr>
    			<td>Ploegnaam:</td>
    			<td><input name="ploegnaam" type="text" value="<? echo $_POST['ploegnaam']; ?>"/></td>
    		</tr>
    		<tr>
	    		<td>
	    			Naam contactpersoon:
	    		</td>
	    		<td><input name='naam' type="text" value="<? echo $_POST['naam']; ?>"/></td>
	    	</tr>
	    	<tr>
	    		<td>Voornaam contacpersoon:</td>
	    		<td><input name="voornaam" type="text" value="<? echo $_POST['voornaam']; ?>"/></td>
	    	</tr>
	    	<tr>
	    		<td>Telefoonnummer:</td>
	    		<td><input name="telefoon" type="text" value="<? echo $_POST['telefoon']; ?>"/></td>
	    	</tr>
	    	<tr>
	    		<td>Email-adres:</td>
	    		<td><input name="email" type="text" value="<? echo $_POST['email']; ?>"/></td>
	    	</tr>
	    	<tr>
	    		<td>Straat:</td>
	    		<td><input name="straat" type="text" value="<? echo $_POST['straat']; ?>"</td>
	    	</tr>
	    	<tr>
	    		<td>Nummer:</td>
	    		<td><input name="nummer" type="text" value="<? echo $_POST['nummer']; ?>" /></td>
	    	</tr>
	    	<tr>
	    		<td>Gemeente:</td>
	    		<td><input name="gemeente" type="text" value="<? echo $_POST['gemeente']; ?>" /></td>
	    	</tr>
    	</table>
    	<input type="submit" />
    </form>
    <?
    }
?>