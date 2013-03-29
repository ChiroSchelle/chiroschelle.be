<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inloggen</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form id="inloggen" method="post" action="inloggen.php">
<table id="inloggen">
<tr>
<th class="spec">Naam:</th><td><input type="text" name="naam" /></td></tr>
<tr><th class="specalt">Wachtwoord:</th><td><input type="password" name="pwq" /></td></tr>
<tr>
<td colspan="2">
<input type="submit" name="btnLogIn" id="button" value="Log In" />
  <input type="submit" name="btnLogUit" value="Log Uit"  /></td>
  </tr>
  </table>
</form>
<?php


$naam = $_POST['naam'];
$pwd = $_POST['pwd'] ;

if (isset($_POST['btnLogIn'])){
	echo 'naam '.md5($naam).'<br />';
	echo 'pwd '.md5($pwd);
}
	/*if (($_POST['naam']=='jo')&&($_POST['pwd']=='test')){
	$_SESSION['ingelogd'] = true;
	echo '<p>je bent ingelogd, klik <a href="invoeren.php">hier</a> om je programma toe te voegen</p>';
	}
	else {
		echo 'Foutieve gerbuikersnaam en/of paswoord!';
	}
}
elseif (isset($_POST['btnLogUit'])) {
	$_SESSION['ingelogd'] = false;
	echo '<p>Je bent nu uitgelogd</p>';
}
elseif ($_SESSION['ingelogd']==true) {
	echo '<p>je bent ingelogd, klik <a href="invoeren.php">hier</a> om je programma toe te voegen</p>';
}
else { 
	echo '<p>Je bent nu uitgelogd</p>';
}
*/
?>