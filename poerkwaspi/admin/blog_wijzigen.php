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

$sql_get_blog =	"SELECT titel, auteur, DATE_FORMAT(datum, '%d %M %Y om %H uur') AS datum, bericht
				 FROM blog
				 WHERE id = '".mysql_real_escape_string($_GET['id'])."'
				";
if(($result_get_blog = mysql_query($sql_get_blog)) === false)
{
	$output = showSQLError($sql_get_blog,mysql_error(),'<div id="error">Er liep iets mis bij het ophalen van het blog bericht.</div>');
}
elseif(mysql_num_rows($result_get_blog) <1)
{
	$output = '<div class="info">Blog die u zoekt bestaat niet!</div>';
}
else
{
	$result_blog = mysql_fetch_assoc($result_get_blog);
		
	$output = '
		<form action="" method="post" name="form1" class="form panel">
			<h3 class="form">Plaats een bericht</h3>
			<fieldset>
				<label>Titel:</label><input type="text" name="titel" value="'.(isset($_POST['titel']) ? $_POST['titel'] : $result_blog['titel']).'" />
				<label>Uw naam:</label><input type="text" name="auteur" value="'.(isset($_POST['auteur']) ? $_POST['auteur'] : $result_blog['auteur']).'" />
				<label>Bericht:</label><textarea name="bericht" rows="15">'.(isset($_POST['bericht']) ? $_POST['bericht'] : $result_blog['bericht']).'	</textarea>
						
				<input type="submit" name="verzend" value="Wijzig Bericht!">		
			</fieldset>
		</form>		
	';	
}

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
		$sql_update = 	"UPDATE blog
						 SET 	titel = '".mysql_real_escape_string($_POST['titel'])."',
								auteur = '".mysql_real_escape_string($_POST['auteur'])."',
								bericht = '".mysql_real_escape_string($_POST['bericht'])."'
						 WHERE id = '".mysql_real_escape_string($_GET['id'])."'	
						";
		if($qry_update = mysql_query($sql_update) === false)					
		{
			$output = showSQLError($sql_update,mysql_error(),'<div class="error">Er liep iets mis bij het ophalen van het blog bericht.</div>');
		}
		else
		{
			$output = '<div class="success">Bericht is gewijzigd</div>';
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
					<li><a href="blog_toevoegen.php">Nieuwe blog</a></li>
					<li><a href="afmelden.php">Log out</a></li>
				</ul>
				
				<div id="fb">
					<div class="fb-like" data-href="www.poerkwaspi.chiroschelle.be" data-send="true" data-layout="box_count" data-width="80" data-show-faces="false" data-font="arial"></div>
				</div>
			</div>
			
			<div id="content">	
				<h2>Blogbericht wijzigen</h2>
				<br/>
				<?php 
					echo $validatie; 
					echo $output; 
				?>
				
				
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
