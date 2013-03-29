<?php
# errors weergeven
$error_reporting = 0;

#start sessie
session_start();

if($error_reporting == 1)
{
	ini_set('display_errors',1);
	error_reporting(E_ALL | E_STRICT);

	# sql debug (AAN - UIT)
	define('DEBUG_MODE',true);
}
else
{
	ini_set('display_errors',0);
	error_reporting(E_ALL | E_STRICT);

	# sql debug (AAN - UIT)
	define('DEBUG_MODE',false);
}

$gebruikersnaam = "aspiranten";
$wachtwoord		= "poerkwaspi2012";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($_POST['gebruikersnaam'] == $gebruikersnaam && $_POST['wachtwoord'] == $wachtwoord)
	{
		$_SESSION['ingelogged'] = true;
		header('Location: admin/index.php');
	}
	else
	{
		$melding = 'Foute gegevens!';
	}
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Inloggen - Poerkwaspi</title>

		<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />

	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<img src="img/header.png" alt="poerkwaspi" />
			</div>
			
			<div id="content">	
				<h2>Inloggen op systeem</h2>
				<form method="post" action="" id="registreren">
					<fieldset>
						<label for="gebruikersnaam">Gebruikersnaam:</label><input type="text" name="gebruikersnaam" id="gebruikersnaam" class="input" />
						<label for="wachtwoord">Wachtwoord:</label><input type="password" name="wachtwoord" id="wachtwoord" class="input" />
						
						<input type="submit" name="submit" value="Inloggen!" class="submit" />
						
						<div class="melding">	
							<?php
								if(isset($melding))
								{
									echo $melding;
								}
							?>
						</div>
					</fieldset>
					
				</form>
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
