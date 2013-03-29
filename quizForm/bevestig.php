<?php
	include 'inclQuiz/classes.php';
	$ploeg;
	$good = true;
    if(!isset($_GET['code'])){
    	echo "Geen code om inschrijving te bevestigen";
		$good = false;

    }
	if($good){
		$ploeg = new Ploeg;
		if(!$ploeg->loadFromWacht($_GET['code'])){
			echo "Deze code is ongeldig of al gebruikt";
		}
		
		else if(!$ploeg->store()){
			echo "Er is iets mis gegaan bij het opslaan van de gegevens. Neem contact op met quiz@chiroschelle.be";
		}
		else {
			echo $ploeg->getPloegnaam() . " is ingeschreven in de quiz. Alvast bedankt en tot 24 November in 't Passeureke";
		}
	}
?>