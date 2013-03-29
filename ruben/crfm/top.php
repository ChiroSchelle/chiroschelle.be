<?php
$blokked = 2;
require_once 'conf.php';
session_start();
$try = false;
if(isset($_POST['username']) && isset($_POST['pasword'])){
	$try = true;
	if($_POST['username'] == "crfmcrew" && $_POST['pasword'] == "kamp2012crfm0310"){
		$_SESSION['login'] = true;
	}
	else {
		echo "U gebruikte verkeerde gegevens";
		$try = true;
	}
}
if(isset($_SESSION["login"]) && $_SESSION['login'] == true){
	?>
	<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CRFM Klassement</title>
	</head>
	<?
	//Bereken aantal huidig stemmen
		$str = "SELECT * FROM `cr-fmMail`";
		$result = mysql_query($str);
		$aantal = mysql_num_rows($result);
		$str = "SELECT * FROM `cr-fmWacht`";
		$result = mysql_query($str);
		$inWacht = mysql_num_rows($result);
		$aantal -= $inWacht;
		$aantal -= $blokked;
		
		echo "Er is door " . $aantal . " personen gestemd en er staan nog " . $inWacht . " stemmen in de wacht. </ br>";
		
		//Haal HitLijstOp
		$top = $Klassement->getTop();
		arsort($top);
		echo "<table id='klassement'>";
		$i = 1;
		foreach ($top as $song) {
			?>
				<tr>
					<td>
						<? echo $i; ?>
					</td>
					<td>
						
						<img src="<? echo $song->getAfbeelding(); ?>" style="max-width: 30px;"/>
					</td>
					<td>
						Artiest: <? echo $song->getArtist(); ?> </br>
						Titel: <? echo $song->getTitle(); ?>
					</td>
					<td>
						<? echo $song->getStemmen(); ?> Stemmen
					</td>
				</tr>
			<?
			$i += 1;
		}
		echo "</table>";
}
else {
	if(!$try){?>	
	U dient u aan te melden.
	<? } ?>
	<form action="top.php" method="post">
		<table>
			<tr>
				<td>Login:</td>
				<td><input name="username" type="text"/></td>
			</tr>
			<tr>
				<td>Paswoord:</td>
				<td><input name="pasword" type="password" /></td>
			</tr>
		</table>
		<input type="submit" />
	</form>
	<?
}
?>