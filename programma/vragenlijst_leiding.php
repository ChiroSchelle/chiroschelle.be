<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Programma invoeren</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$naam = $_SESSION['naam'];
$level = $_SESSION['level'];
$toon = 'alles';
$adminlevel = 8;
$userlevel = 1;
if(!session_is_registered(myusername)){
	//header("location:main_login.php");
	echo '<meta http-equiv="refresh" content="0; url=./main_login.php">';
}
#controleer of de gebruiker de juiste machtigingen heeft
elseif ($_SESSION['level']<$userlevel){
	include_once('header.php');
	echo 'U heeft niet de juiste machtigingen om deze pagina te bekijken';
}
else{
	$title = 'Vragenlijst voor leiding';
	include_once('header.php'); 
?>

<form method="post" name="vragenlijst">
	<table id="vragenlijst" width="550" border="0" cellpadding="2" cellspacing="1">
		<tr>
			<th class="spec">Naam *</th>
            <td colspan="3"><input name="txtNaam" type="hidden" value="<?php echo $naam.'" /> '.$naam; ?></td>
		</tr>
		<tr>
    		<th>Straat + nr</th>
	        <td><input type="text"  name="straat" size="70" /></td>
	    </tr>
		<tr>
	    	<th>Plaats</th>
	        <td><input type="text"  name="plaats" size="70" /></td>
    	</tr>
		<tr>
			<th>Telefoon</th>
	        <td><input type="text"  name="telefoon" size="70" /></td>
	    </tr>
		<tr>
			<th>GSM</th>
	        <td><input type="text"  name="gsm" size="70" /></td>
		</tr>
		<tr>
	  		<th>Geboortedatum</th>
	        <td><input type="text"  name="geboortedatum" size="70" /></td>
		</tr>
		<tr>
			<th>Geboorteplaats</th>
	    	<td><input type="text"  name="geboorteplaats" size="70" /></td>
		</tr>
		<tr>
			<th>Haarkleur</th>
	        <td><input type="text"  name="haarkleur" size="70" /></td>
		</tr>
		<tr>
			<th>Kleur van ogen</th>
	        <td><input type="text"  name="oogkleur" size="70" /></td>
    	</tr>
		<tr>
			<th>Lengte</th>
	        <td><input type="text"  name="lengte" size="70" /></td>
		</tr>
		<tr>
			<th>Gewicht</th>
    	    <td><input type="text"  name="gewicht" size="70" /></td>
	    </tr>
		<tr>
			<th>Broer(s)</th>
	        <td><input type="text"  name="broers" size="70" /></td>
	    </tr>
		<tr>
			<th>Zus(sen)</th>
    	    <td><input type="text"  name="zussen" size="70" /></td>
	    </tr>
		<tr>
	    	<th>School of werk</th>
	        <td><input type="text"  name="school" size="70" /></td>
	    </tr>
	    <tr>
	    	<th>Lievelingsvak</th>
	        <td><input type="text"  name="vak" size="70" /></td>
	    </tr>
	    <tr>
	    	<th>Hobby's</th>
	        <td><input type="text"  name="hobby" size="70" /></td>
	    </tr>
	    <tr>
	  	  	<th>Lievelingssport</th>
	      	<td><input type="text"  name="sport" size="70" /></td>
	    </tr>
	    <tr>
	    	<th>Idool</th>
	        <td><input type="text"  name="idool" size="70" /></td>
	    </tr>
	    <tr>
	    	<th>Lievelingspopgroep</th>
	        <td><input type="text"  name="popgroep" size="70" /></td>
	    </tr>
	    <tr>
	    	<th>Lievelingslied</th>
		    <td><input type="text"  name="lied" size="70" /></td>
	    </tr>
    	<tr>
	    	<th>Favoriete TV-programma</th>
		    <td><input type="text"  name="tv" size="70" /></td>
	    </tr>
	    <tr>
    		<th>Lievelingsfilm</th>
	    	<td><input type="text"  name="film" size="70" /></td>
	    </tr>
        <tr>
        	<th>Lievelingsboek</th>
            <td><input type="text" name="boek" size="70" /></td>
	    <tr>
    		<th>Lievelingsdier</th>
	    	<td><input type="text"  name="dier" size="70" /></td>
	    </tr>
	    <tr>
    		<th>Lievelingseten</th>
	    	<td><input type="text"  name="eten" size="70" /></td
	    >
	    </tr>
    	<tr>
    		<th>Dit vind ik helemaal niet leuk</th>
		    <td><input name="niet_leuk" type="text" value="" size="70" /></td>
    	</tr>
	    <tr>
    		<th>Dit wil ik later worden</th>
	    	<td><input type="text"  name="later_worden" size="70" /></td>
	    </tr>
	    <tr>
	    	<th>Leukste chiroherinnering</th>
		    <td><input name="chiroherinnering" type="text" value="" size="70" /></td>
	    </tr>
	    <tr>
			<td>&nbsp;</td>
			<td colspan="3"><input name="btnVerstuur" type="submit" value="Verstuur" onClick="return checkForm();"></td>
		</tr>
	</table>
</form>
<?php
	#include '../library/config.php';
	#include '../library/opendb.php';
	if(isset($_POST['btnVerstuur'])){
		include_once("config.php");
		$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
		mysql_select_db($database) or die('Cannot select database');

	    # zet alle tekstvakken om in variabelen
		$naam    = trim($_POST['txtNaam']);
		$afdeling   = trim($_POST['radAfdeling']);
		$straat   = trim($_POST['straat']);
		$plaats   = trim($_POST['plaats']);
		$telefoon   = trim($_POST['telefoon']);
		$gsm   = trim($_POST['gsm']);
		$geboortedatum    = trim($_POST['geboortedatum']);
		$geboorteplaats    = trim($_POST['geboorteplaats']);
		$haarkleur   = trim($_POST['haarkleur']);
		$oogkleur   = trim($_POST['txtNaam']);
		$lengte   = trim($_POST['lengte']);
		$gewicht    = trim($_POST['gewicht']);
		$broers   = trim($_POST['broers']);
		$zussen   = trim($_POST['zussen']);
		$school   = trim($_POST['school']);
		$vak   = trim($_POST['vak']);
		$hobby   = trim($_POST['hobby']);
		$sport   = trim($_POST['sport']);
		$idool   = trim($_POST['idool']);
		$popgroep    = trim($_POST['popgroep']);
		$lied   = trim($_POST['lied']);
		$tv    = trim($_POST['tv']);
		$film    = trim($_POST['film']);
		$boek   = trim($_POST['boek']);
		$dier    = trim($_POST['dier']);
		$eten    = trim($_POST['eten']);
		$niet_leuk   = trim($_POST['niet_leuk']);
		$later_worden   = trim($_POST['later_worden']);
		$chiroherinnering   = trim($_POST['chiroherinnering']);

		#kijk na hoeveel records er van deze persoon zijn
		$sql="SELECT * FROM gegevens_leiding WHERE naam='$naam'";
		$result=mysql_query($sql);
		// Mysql_num_row is counting table row
		$count=mysql_num_rows($result);
		if($count==0){
			$query = "INSERT INTO gegevens_leiding(
				id,
				naam,
				straat,
				plaats,
				telefoon,
				gsm,
				geboortedatum,
				geboorteplaats,
				haarkleur,
				oogkleur,
				lengte,
				gewicht,
				broers,
				zussen,
				school,
				vak,
				hobby,
				sport,
				idool,
				popgroep,
				lied,
				tv,
				film,
				boek,
				eten,
				niet_leuk,
				later_worden,
			    chiroherinnering
			)
            VALUES (
				SYSDATE(),
				'$naam',
				'$straat',
				'$plaats',
				'$telefoon',
				'$gsm',
				'$geboortedatum',
				'$geboorteplaats',
				'$haarkleur',
				'$oogkleur',
				'$lengte',
				'$gewicht',
			    '$broers',
				'$zussen',
				'$school',
				'$vak',
				'$hobby',
				'$sport',
				'$idool',
				'$popgroep',
				'$lied',
				'$tv',
				'$film',
				'$boek',
				'$eten',
				'$niet_leuk',
				'$later_worden',
                '$chiroherinnering'
			)";
			
			mysql_query($query) or die('Error, query failed');
			echo '<div class="error">Gegevens succesvol toegevoegd!</div>';
		}
		else {
			echo '<div class="error">Je hebt dit al eens ingevuld.</div>';
		}
	}
	mysql_close($verbind); 
   //header("location:uitlezen.php");
   exit;
}
include_once('footer.php');
?>
</body>
</html>
