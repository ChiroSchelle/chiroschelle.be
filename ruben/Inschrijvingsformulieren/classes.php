<?php

include_once("conf.php");

	class inschrijving {
		var $fNaam;
		var $fVoornaam;
		var $fAantal;
		var $fID;
		var $fOpmerkingen;
		
		function inschrijving(){
		}
		
		function set($naam, $voornaam, $aantal, $opmerkingen = ""){
			$this->fNaam = $naam;
			$this->fVoornaam = $voornaam;
			$this->fAantal = $aantal;
			$this->fOpmerkingen = $opmerkingen;
		}
		
		function getOpmerkingen(){
			return $this->fOpmerkingen;
		}
		
		function getVoornaam(){
			return $this->fVoornaam;
		}
		
		function getNaam(){
			return $this->fNaam;
		}
		
		function getAantal(){
			return $this->fAantal;
		}
		
		function getID(){
			return $this->fID;
		}
		
		function setOpmerking($opmerking){
			$this->fOpmerkingen = $opmerking;
		}
		
		function setVoornaam($voornaam){
			$this->fVoornaam = $voornaam;
		}
		
		function setNaam($naam){
			$this->fNaam = $naam;
		}
		
		function setAantal($aantal){
			$this->fAantal = $aantal;
		}
		
		function writeToDB(){
			if(isset($this->fID)){
				$mysql = "UPDATE  `c7070chi_ruben`.`inschrijvingsavond` SET  `Naam` =  '";
				$mysql .= $this->fNaam;
				$mysql .= "', `Voornaam` =  '";
				$mysql .= $this->fVoornaam;
				$mysql .= "', `Aantal` =  '";
				$mysql .= $this->fAantal;
				$mysql .= "', `Opmerkingen` = '";
				$mysql .= $this->fOpmerkingen;
				$mysql .= "' WHERE  `inschrijvingsavond`.`ID` =";
				$mysql .= $this->fID;
				$mysql .= ";";
				
				$str .= $mysql;
				
				mysql_query($mysql);
			} else {
				$mysql = "INSERT INTO `c7070chi_ruben`.`inschrijvingsavond` (`ID`, `Naam`, `Voornaam`, `Aantal`, `Opmerkingen`) VALUES (NULL, '" . $this->fNaam . "', '" . $this->fVoornaam 
				. "', '" . $this->fAantal . "', '" . $this->fOpmerkingen . "');";
				$str .= $mysql;
				mysql_query($mysql) or die(mysql_error());
				
				$mysql = "SELECT * FROM  `inschrijvingsavond` ORDER BY  `inschrijvingsavond`.`ID` DESC LIMIT 0 , 1";
				
				$result = mysql_query($mysql);
				$row = mysql_fetch_array($result);
				
				$fID = $row['ID'];
			
			}
		}
		function loadFromDB($ID){
			$mysql = "SELECT * FROM  `inschrijvingsavond` WHERE  `ID` =";
			$mysql .= $ID;
			$mysql .= " LIMIT 0 , 30";
			
			$result = mysql_query($mysql);
			$row = mysql_fetch_array($result);
			
			$this->fNaam = $row['Naam'];
			$this->fVoornaam = $row['Voornaam'];
			$this->fAantal = $row['Aantal'];
			$this->fID = $row['ID'];
			$this->fOpmerkingen = $row['Opmerkingen'];
		}
		
		function In_print(){
			$tebetalen = $this->teBetalen();
			$str = "Naam = ";
			$str .= $this->fNaam;
			$str .= "\nVoornaam = ";
			$str .= $this->fVoornaam;
			$str .= "\nAantal personen = ";
			$str .= $this->fAantal;
			$str .= "\nTe Betalen = ";
			$str .= $tebetalen;
			$str .= ".00 euro\n";
			$str .= "Opmerkingen = ";
			$str .= $this->fOpmerkingen;
			$str .="\n-----------------------\n";
			
			return $str;
		}
		
		function teBetalen(){
			$prijs = 5;
			return $this->fAantal*$prijs;
		}
	}
	
	class inschrijvingen{
		var $inschrijvingen = array();
		
		function loadDB(){
			$mysql = "SELECT * FROM  `inschrijvingsavond` ORDER BY  `inschrijvingsavond`.`Naam` ASC ";
			$result = mysql_query($mysql);
			
			while($row = mysql_fetch_array($result)){
				$temp = new inschrijving;
				$temp->loadFromDB($row['ID']);
				$this->inschrijvingen[] = $temp;
			}
		}
		
		function In_print(){
			$str;
			foreach ($this->inschrijvingen as $inschrijving) {
				$str .= "ID = " . $inschrijving->getID() . "\n";
				$str .= $inschrijving->In_print();
				$str .= "\n";
			}
			
			echo str_replace("\n", "<br>", $str);
		}
		
	}
	
	class tshirts{
		var $fID;
		var $fNaam;
		var $fVoornaam;
		var $f6jaar;
		var $f8jaar;
		var $f10jaar;
		var $f12jaar;
		var $fDamesS;
		var $fDamesM;
		var $fDamesL;
		var $fHerenS;
		var $fHerenM;
		var $fHerenL;
		var $fHerenXL;
		var $fHerenXXL;
		
		function loadFromDB($ID){
			$array = array("6jaar", "8jaar", "10jaar", "12jaar", "damesS", "damesM", "damesL", "herenS", "herenM", "herenL", "herenXL", "herenXXL");
			
			$mysql = "SELECT * FROM  `tshirts` WHERE  `ID` =" . $ID;
			$result = mysql_query($mysql);
			$row = mysql_fetch_array($result);
			
			$this->fID = $ID;
			$this->fNaam = $row['Naam'];
			$this->fVoornaam = $row['Voornaam'];
			
			foreach($array as $maat){
				$temp = "f" . ucwords($maat);
				$this->$temp = $row[$maat];
			}
		}
		

		function writeToDB(){
			if(isset($this->fID)){
				$array = array("6jaar", "8jaar", "10jaar", "12jaar", "damesS", "damesM", "damesL", "herenS", "herenM", "herenL", "herenXL", "herenXXL");
				$mysql = "UPDATE  `c7070chi_ruben`.`tshirts` SET  `Naam` = '" . $this->fNaam . "', `Voornaam` = '" . $this->fVoornaam . "'";
				
				foreach ($array as $maat) {
					$mysql .= ", `" . $maat . "` = '";
					$temp = "f" . $maat;
					if(isset($this->$temp)){
						$mysql .= $this->$temp . "'"; 
					} else {
						$mysql .= "0'";
					}
					 
				}
				$mysql .= " WHERE `tshirts`.`ID` =" . $this->fID;
				mysql_query($mysql);
				
			}
			else {
				$mysql = "INSERT INTO `c7070chi_ruben`.`tshirts` (`ID`, `Naam`, `Voornaam`, `6jaar`, `8jaar`, `10jaar`, `12jaar`, `damesS`, `damesM`, `damesL`, `herenS`, `herenM`, `herenL`, `herenXL`, `herenXXL`) VALUES (NULL"; 
				$mysql .= ", '" . $this->fNaam . "', '"  . $this->fVoornaam . "'";
				$array = array("f6jaar", "f8jaar", 'f10jaar', "f12jaar", "fDamesS", "fDamesM", "fDamesL", "fHerenS", "fHerenM", "fHerenL", "fHerenXL", "fHerenXXL");
				
				foreach ($array as $maat) {
					$temp = $this->$maat;
					if(isset($temp)){
						$mysql .= ", '" . $temp . "'";
					}
					else {
						$mysql .= ", '0'";
					}
				}
				
				$mysql .= ");";
			}
			 mysql_query($mysql) or die(mysql_error());
			 $mysql = "SELECT * FROM  `tshirts` ORDER BY  `tshirts`.`ID` DESC LIMIT 0 , 1";
			 $result = mysql_query($mysql) or die(mysql_error());
			 $row = mysql_fetch_array($result);
			 $this->fID = $row['ID'];
		}

		function print1(){
			$array = array("6jaar", "8jaar", "10jaar", "12jaar", "DamesS", "DamesM", "DamesL", "HerenS", "HerenM", "HerenL", "HerenXL", "HerenXXL");
			$str = "Naam = " . $this->fNaam . "\nVoornaam = " . $this->fVoornaam;
			$str .= "\n\nBestelling: ";
			
			foreach ($array as $maat) {
				$temp = "f" . $maat;	
				
				if(isset($this->$temp) && $this->$temp != 0){
					$str .= "\n\t" . $maat . " = ";
					$str .= $this->$temp;
				}
			}
			$str .= "\n\nAantal = " . $this->aantal();
			$str .= "\nTe Betalen = " . $this->teBetalen();
			$str .= ".00 euro\n----------------\n";
			
			return $str;
			
		}
		
		function aantal(){
			$array = array("f6jaar", "f8jaar", 'f10jaar', "f12jaar", "fDamesS", "fDamesM", "fDamesL", "fHerenS", "fHerenM", "fHerenL", "fHerenXL", "fHerenXXL");
			$aantal = 0;
			
			foreach ($array as $maat) {
				if(isset($this->$maat)){
					$aantal += $this->$maat;
				}
			}
			return $aantal;
		}
		
		function teBetalen(){
			$prijs = 10;
			return $this->aantal() * $prijs;
		}
	}
	class bestellingen{
		var $bestellingen = array();
		
		function loadFromDB(){
			$mysql = "SELECT * FROM  `tshirts` ORDER BY  `tshirts`.`Naam` ASC";
			$result = mysql_query($mysql);
			while($row = mysql_fetch_array($result)){
				$temp = new tshirts;
				$temp->fID = $row['ID'];
				$temp->fNaam = $row['Naam'];
				$temp->fVoornaam = $row['Voornaam'];
				$temp->f6jaar = $row['6jaar'];
				$temp->f8jaar = $row['8jaar'];
				$temp->f10jaar = $row['10jaar'];
				$temp->f12jaar = $row['12jaar'];
				$temp->fDamesS = $row['damesS'];
				$temp->fDamesM = $row['damesM'];
				$temp->fDamesL = $row['damesL'];
				$temp->fHerenS = $row['herenS'];
				$temp->fHerenM = $row['herenM'];
				$temp->fHerenL = $row['herenL'];
				$temp->fHerenXL = $row['herenXL'];
				$temp->fHerenXXL = $row['herenXXL'];
				
				$this->bestellingen[] = $temp;
			}
		}
		function print1(){
			$str = "";
			foreach ($this->bestellingen as $bestelling) {
				$str .= $bestelling->print1();
			}
			return $str;
		}
		
		function getMaat($i){
			$array = array("f6jaar", "f8jaar", 'f10jaar', "f12jaar", "fDamesS", "fDamesM", "fDamesL", "fHerenS", "fHerenM", "fHerenL", "fHerenXL", "fHerenXXL");
			$maat = $array[$i];
			$count = 0;
			foreach ($this->bestellingen as $bestelling) {
				$count += $bestelling->$maat;
			}
			
			return $count;
		}
		
		function totaal(){
			$array = array("f6jaar", "f8jaar", 'f10jaar', "f12jaar", "fDamesS", "fDamesM", "fDamesL", "fHerenS", "fHerenM", "fHerenL", "fHerenXL", "fHerenXXL");
			$count = 0;
			foreach ($this->bestellingen as $bestelling) {
				foreach ($array as $maat) {
					$count += $bestelling->$maat;
				}
			}
			return $count;
		}
		
	}
?>