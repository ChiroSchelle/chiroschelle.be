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

include '../inc/config.php';
include '../inc/functies.php';

if(!isset($_SESSION['ingelogged']))
{
	header('Location: ../login.php');
}

$form = '<h2>Blogbericht toevoegen</h2>
				<br/>
				<form action="" method="post" name="form1" class="form panel">
					<h3 class="form">Plaats een bericht</h3>
					<fieldset>
						<label>Titel:</label><input type="text" name="titel" value="'.$_POST['titel'].'" />
						<label>Uw naam:</label><input type="text" name="auteur" value="'.$_POST['auteur'].'" />
						<label>Bericht:</label><textarea name="bericht" rows="15">'.$_POST['bericht'].'</textarea>
						
						<input type="submit" name="verzend" value="Plaats Bericht!">		
					</fieldset>
				</form>';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$error = array();
	
	if(strlen($_POST['titel']) < 3)
	{
		$error[] = 'Titel moet langer zijn dan 3 tekens';
	}
	
	if(strlen($_POST['auteur']) < 5)
	{
		$error[] = 'Uw naam moet minstens 5 tekens bevatten, voornaam + achternaam';
	}
	
	if(strlen($_POST['bericht']) < 10)
	{
		$error[] = 'Uw blog moet minstens 10 tekens bevatten';
	}
	
	# Tel de fouten en weergeef ze indien nodig
	$fouten = count($error); // aantal errors tellen
	if($fouten != 0) 
	{ 
		$validatie  = '<div class="error">';
		$validatie .= 'Uw reactie kon niet worden toegevoegd omwille van de volgende reden(en):';
		$validatie .= '<ul>';
				
		for($i = 0; $i < $fouten; $i++) 
		{
			$validatie .=  '<li>'.$error[$i].'</li>';
		}
				
		$validatie .= '</ul>';
		$validatie .= '</div>';
	}
	else
	{
		$sql_update = 	"INSERT INTO blog
						 VALUES	('',
								 '".mysql_real_escape_string($_POST['titel'])."',
								 NOW(),
								 '".mysql_real_escape_string($_POST['auteur'])."',
								 '".mysql_real_escape_string($_POST['bericht'])."'
								)
						";
		if($qry_update = mysql_query($sql_update) === false)					
		{
			$form = showSQLError($sql_update,mysql_error(),'<div class="error">Er liep iets mis bij het ophalen van het blog bericht.</div>');
		}
		else
		{
			$form = '<div class="success">Bericht is toegevoegd!</div>';
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Poerkwaspi</title>

		<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />

	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<img src="../img/header.png" alt="poerkwaspi" />
			</div>
			
			<div id="menu">
				<ul>
					<li><a href="index.php">Blog's</a></li>
					<li><a href="blog_toevoegen.php"  class="active">Nieuwe blog</a></li>
					<li><a href="afmelden.php">Log out</a></li>
				</ul>
				
				<div id="fb">
					<div class="fb-like" data-href="www.poerkwaspi.chiroschelle.be" data-send="true" data-layout="box_count" data-width="80" data-show-faces="false" data-font="arial"></div>
				</div>
			</div>
			
			<div id="content">	
			<?php
				echo $validatie;
				echo $form;
			?>	
				
				
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
