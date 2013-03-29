<?php
   include_once 'conf.php';
   include_once 'functions.php';
   
   /**
    * 
    */
   class Ploeg {
       
	   private $ID;
	   private $Ploegnaam;
	   private $Naam;
	   private $Voornaam;
	   private $Telefoon;
	   private $Email;
	   private $Straat;
	   private $Nummer;
	   private $Gemeente;
	   
	   function newPloeg($Ploegnaam, $Naam, $Voornaam, $Telefoon, $Email, $Straat, $Nummer, $Gemeente){
	   		if(!validEmail($Email)){
	   			return -1;
	   		}
			
			if(!isset($Ploegnaam) || !validPloegnaam($Ploegnaam)){
				return -2;
			}
			if(!isset($Naam) || !validNaam($Naam)){
				return -3;
			}
			if(!isset($Voornaam) || !validNaam($Voornaam)){
				return -4;
			}
			if(!isset($Telefoon) || strlen($Telefoon) < 9){
				return -5;
			}
			if(!NotUsedMail($Email)){
				return -6;
			}
			if(!isset($Straat) || !validNaam($Straat)){
				return -7;
			}
			if(!isset($Nummer) || !validNumber($Nummer)){
				return -8;
			}
			if(!isset($Gemeente) || !validNaam($Gemeente)){
				return -9;
			}
			$this->Ploegnaam = $Ploegnaam;
			$this->Naam = $Naam;
			$this->Voornaam = $Voornaam;
			$this->Telefoon = $Telefoon;
			$this->Straat = $Straat;
			$this->Nummer = $Nummer;
			$this->Gemeente = $Gemeente;
			$this->Email = mysql_real_escape_string($Email);
			
			return 1;
			
	   }
	   
	   function getID(){
	   	return $this->ID;
	   }
	   function getPloegnaam(){
	   	return $this->Ploegnaam;
	   }
	   function getNaam(){
	   	return $this->Naam;
	   }
	   function getVoornaam(){
	   	return $this->Voornaam;
	   }
	   function getTelefoon(){
	   	return $this->Telefoon;
	   }
	   function getEmail(){
	   	return $this->Email;
	   }
	   function getStraat(){
	   	return  $this->Straat;
	   }
	   function getNummer(){
	   	return $this->Nummer;
	   }
	   function getGemeente(){
	   	return $this->Gemeente;
	   }
	   
	   function zetInWacht(){
	   	$tempSTR = md5($this->getEmail() . $this->getPloegnaam());
		$tempThis = serialize($this);
		
		$qry = "INSERT INTO `c7070chi_ruben`.`quizWacht` (`ID`, `code`, `Quiz-Ploeg`, `email`) VALUES (NULL, '" . $tempSTR . "', '" . $tempThis . "', '" . $this->getEmail() . "');";
		if(!mysql_query($qry)){
			return false;
		}
		return $tempSTR;
	   }
	   
	   function loadFromWacht($code){
	   	$qry = "SELECT * FROM `c7070chi_ruben`.`quizWacht` WHERE `code`='" . $code . "'";
		$result = mysql_query($qry);
		if(mysql_num_rows($result) == 0){
			return false;
		}
		$row = mysql_fetch_array($result);
		$temp = unserialize($row['Quiz-Ploeg']);
		$this->Email = $temp->getEmail();
		$this->Naam = $temp->getNaam();
		$this->Ploegnaam = $temp->getPloegnaam();
		$this->Telefoon = $temp->getTelefoon();
		$this->Voornaam = $temp->getVoornaam();
		$this->ID = $temp->getID();
		$this->Straat = $temp->getStraat();
		$this->Nummer = $temp->getNummer();
		$this->Gemeente = $temp->getGemeente();
		$qry = "DELETE FROM `c7070chi_ruben`.`quizWacht` WHERE `quizWacht`.`ID` = " . $row['ID'];
		mysql_query($qry);
		return true;
	   }
	   
	   function store(){
	   	$qry = "INSERT INTO `c7070chi_ruben`.`quiz` (`ID`, `Ploegnaam`, `Naam`, `Voornaam`, `Telefoon`, `Email`, `straat`, `nummer`, `gemeente`)
	   	VALUES (NULL, '" . mres($this->getPloegnaam())  . "', '" . mres($this->getNaam()) . "', '" . mres($this->getVoornaam()) ."', '" . mres($this->getTelefoon()) . "', '" . mres($this->getEmail()) . 
	   	"', '" . mres($this->getStraat()) . "', '" . mres($this->getNummer()) . "', '" . mres($this->getGemeente()) . "');";
		return mysql_query($qry);
	   }
       
   }
   
?>