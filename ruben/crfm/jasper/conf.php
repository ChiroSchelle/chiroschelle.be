<?php
	$sql['host'] = "localhost";
	$sql['name'] = "c7070chi_ruben";
	$sql['username'] = "c7070chi_ruben";
	$sql['password'] = "chrsell882";
	$sql['table'] = "cr-fm";

	mysql_connect($sql['host'], $sql['username'], $sql['password']) or die("Kan geen verbinding maken met database");
	mysql_select_db($sql['name']) or die("Kan geen verbinding maken met database");

	if(mysql_query( "SET NAMES 'utf8'" ) === false)
	{
		 echo 'Fout met instellen charset.';
	}

class Song {
		
	private $artist;
	private $stemmen;
	private $title;
	private $ID;
	private $afbeelding;
	
	function __construct() {
		
	}
	
	function readFromDB($ID){
		$str = "SELECT * FROM `cr-fm` WHERE `ID`=" . $ID;
		$result = mysql_query($str);
		$row = mysql_fetch_array($result);
		$this->ID = $row['ID'];
		$this->stemmen = $row['Stemmen'];
		$this->artist = $row['Artiest'];
		$this->title = $row['Titel'];
		$this->afbeelding = $row['afbeelding'];
		
		if($this->afbeelding == ""){
			$this->afbeelding = "http://www.wolfmother.net/wp-content/uploads/2011/06/UnknownAlbum.png";
		}
	}
	
	function writeToDB(){
		if($this->ID != -1){
			$str = "UPDATE  `c7070chi_ruben`.`cr-fm` SET  `Artiest` =  '" . $this->artist .
			 "',`Titel` =  '" . $this->title . "',`Stemmen` =  '" . $this->stemmen . "' WHERE  `cr-fm`.`ID` =" . $this->ID . ";";
			 mysql_query($str) or die(mysql_error());
		}
		else{
			$str = "INSERT INTO  `c7070chi_ruben`.`cr-fm` (`ID` ,`Artiest` ,`Titel` ,`Stemmen`, `afbeelding`) VALUES (NULL ,  '" .
			 $this->artist  . "',  '"  . $this->title . "',  '" . $this->stemmen . "' , NULL);";
			 mysql_query($str); #or die(mysql_error());
			
		}
	}
	
	function newSong($title, $artist, $stemmen = 0){
		$this->artist = $artist;
		$this->stemmen = $stemmen;
		$this->title = $title;
		$this->ID = -1;
		$this->afbeelding = "http://www.wolfmother.net/wp-content/uploads/2011/06/UnknownAlbum.png";
		$this->writeToDB();
	}
	
	function getTitle(){
		return $this->title;
	}
	function getArtist(){
		return $this->artist;
	}
	function getStemmen(){
		return $this->stemmen;
	}
	
	function getID(){
		return $this->ID;
	}
	
	function setID($ID){
		$this->ID = $ID;
	}
	
	function stem($stemmen = 1){
		$this->stemmen += $stemmen;
		$this->writeToDB();
	}
	
	function getAfbeelding(){
		return $this->afbeelding;
	}
}

class Klassement{
	private $top = array();
	
	function readFromDB(){
		$query = "SELECT * FROM  `cr-fm` ORDER BY  `cr-fm`.`ID` ASC";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			$song = new Song;
			$song->readFromDB($row['ID']);
			$this->top[] = $song;
		}
		
		sort($this->top);
	}
	
	function stem($artist, $title, $stemmen = 1){
		$artist = ucwords(strtolower($artist));
		$title = ucwords(strtolower($title));
		
		foreach ($this->top as $song) {
			//echo "Title = " . $song->getTitle() . " artist = " . $song->getArtist() . '<br>';
			if($song->getTitle() == $title && $song->getArtist() == $artist){
				//echo "ok";
				$song->stem($stemmen);
				return;
			}
		}
		
		$song = new Song;
		$song->newSong($title, $artist, 1);
	}
	
	function writeToDB(){
		foreach ($this->top as $song) {
			$song->writeToDB();
		}	
	}
	
	function getTop($number = 0){
		if($number == 0){
			return $this->top;
		}
		else if($number > count($this->top)){
			return $this->top;
		}
		else{
			$ar = array();
			for ($i=0; $i < $number; $i++) { 
				$ar[] = $this->top[$i];
			}
			return $ar;
		}
	}
	function getSize(){
		return count($this->top);
	}
	function getSugesties(){
		$result = $this->getTop(50);
		shuffle($result);
		
		return $result;
	}
}

class Stem {
	
	private $song1 = array();
	private $song2 = array();
	private $song3 = array();
	
	function __construct() {
		$song1 = array();
		$song2 = array();
		$song3 = array();
	}
	
	function hasSong1(){
		if(sizeof($this->song1) == 0 or $this->song1[0] == "" and $this->song1[1] == ""){
			return false;
		}
		return true;
	}
	function hasSong2(){
		if(sizeof($this->song2) == 0 or $this->song2[0] == "" and $this->song[1] == ""){
			return false;
		}
		return true;
	}
	function hasSong3(){
		if(sizeof($this->song3) == 0 or $this->song3[0] == "" and $this->song3[1] == ""){
			return false;
		}
		return true;
	}
	
	function setSong($title, $artist){
		$title = ucwords(strtolower($title));
		$artist = ucwords(strtolower($artist));
		if($this->hasSong1() == false){
			$this->song1[0] = $artist;
			$this->song1[1] = $title;
			return 1;
		}
		else if($this->hasSong2() == false){
			$this->song2[0] = $artist;
			$this->song2[1] = $title;
			return 2;
		}
		else if($this->hasSong3() == false){
			$this->song3[0] = $artist;
			$this->song3[1] = $title;
			return 3;
		}
		else {
			return false;
		}
	}
	function getSong1(){
		return $this->song1;
	}
	function getSong2(){
		return $this->song2;
	}
	function getSong3(){
		return $this->song3;
	}
	
	function check($title, $artist){
		if($this->hasSong1()){
			if($title == $this->song1[1] && $artist == $this->song1[0]){
				return true;
			}
		}
		if($this->hasSong2()){
			if($title == $this->song2[1] && $artist == $this->song2[0]){
				return true;
			}
		}
		if($this->hasSong3()){
			if($title == $this->song3[1] && $artist == $this->song3[0]){
				return true;
			}
		}
		return false;
	}
	
	function stem($mail){
		if($this->hasSong1()){
			$artist1 = $this->song1[0];
			$title1 = $this->song1[1];
		}
		else{
			return "Geen enkele song";
		}
		if($this->hasSong2()){
			$artist2 = $this->song2[0];
			$title2 = $this->song2[1];
		}
		if($this->hasSong3()){
			$artist3 = $this->song3[0];
			$title3 = $this->song3[1];
		}
		
		return stemVoorlopig($artist1, $title1, $artist2, $title2, $artist3, $title3, $mail);
	}
	
}


function checkmail($mail){
	$str = "SELECT * FROM `cr-fmMail` WHERE `mail`='" . $mail . "'";
	$result = mysql_query($str);
	//echo $numbers;
	if(mysql_num_rows($result) == 0){
		return true;
	}
	return false;
}

function setmail($mail){
	$str = "INSERT INTO  `c7070chi_ruben`.`cr-fmMail` (`mail`) VALUES ('" . $mail . "');";
	mysql_query($str) or die(mysql_error());
}

/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

function stem($artist1, $title1, $artist2, $title2, $artist3, $title3, &$klassement){
	//if(!validEmail($mailadress)){
	//	echo "Geen correct e-mail adress\n";
	//	return false;
	//}
	//if(!checkmail($mailadress)){
	//	echo "E-mail adres werd al eens gebruikt\n";
	//	return false;
	//}
	if(!isset($artist1) or !isset($title1)){
		echo "Geen stem\n";
		return false;
	}
	$klassement->stem($artist1, $title1, 3);
	if(isset($artist2) && isset($title2) && $artist2 != "" && $title2 != ""){
		$klassement->stem($artist2, $title2, 2);
	}
	//echo $artist3 . " - " . $title3;
	if(isset($artist3) && isset($title3) && $artist3 != "" && $title3 != ""){
		//echo "Passed";
		$klassement->stem($artist3, $title3, 1);
	}
	//setmail($mailadress);
	return true;
	
}

function stemVoorlopig($artist1, $title1, $artist2, $title2, $artist3, $title3, $mail){
	if(!validEmail($mail)){
		return "Geen correct mailadress";
	}
	if(!checkmail($mail)){
		return "Email adres werd al eens gebruikt";
	}
	if(!isset($artist1) or !isset($title1)){
		return "Geen stem";
	}
	
	$mailMD5 = md5($mail);
	$str = "INSERT INTO `c7070chi_ruben`.`cr-fmWacht` (`ID`, `mail`, `Title1`, `Artist1`, `Title2`, `Artist2`, `Title3`, `Artist3`) VALUES (NULL, '" . $mailMD5 . "', '" . $title1 . "', '" . $artist1 . "', '" . $title2 . "', '" . $artist2 . "', '" . $title3 . "', '" . $artist3 . "');";
	if(mysql_query($str)){
		setmail($mail);
		return array($mail, $mailMD5);
	}
	#echo mysql_error();
	return "Stemmen mislukt probeer later opnieuw";
}	

function getSugestieLijst(&$Klassement, $stem = NULL, $max = 15){
	$sugesties = $Klassement->getSugesties();
	$n = $Klassement->getSize();
	if($n > $max){
		$n = $max;
	}
	$i = 0;
	$count = 0;
	$result = array();
	while ($count < $n){
		$i++; 
		if($i > $Klassement->getSize()){
			break;
		}
		$sug = $sugesties[$i];
		if(isset($stem)){
			if($stem->check($sug->getTitle(), $sug->getArtist())){
				continue;
			}
		}
		$result[] = $sug;
		$count++;
	}
	return $result;
	
}

$Klassement = new Klassement;
$Klassement->readFromDB();
?>