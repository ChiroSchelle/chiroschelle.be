<?php

# errors weergeven
$error_reporting = 1;

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

$sql_get_blog =	"SELECT id, titel, auteur, DATE_FORMAT(datum, '%d %M %Y') AS datum
				 FROM blog
				";
if(($result_get_blog = mysql_query($sql_get_blog)) === false)
{
	$output = showSQLError($sql_get_blog,mysql_error(),'<div id="error">Er liep iets mis bij het ophalen van het blog bericht.</div>');
}
elseif(mysql_num_rows($result_get_blog) <1)
{
	$output = 'bestaat niet';
}
else
{
	$output = '<table><thead><tr><th>Titel</th><th>Auteur</th><th>Datum</th></tr></thead>';
	while($result_blog = mysql_fetch_assoc($result_get_blog))
	{
		$output .= '<tbody><tr><td><a href="blog_wijzigen.php?id='.$result_blog['id'].'">'.$result_blog['titel'].'</a></td><td>'.$result_blog['auteur'].'</td><td>'.$result_blog['datum'].'</td></tr></tbody>';
	}
	$output .= '</table>';	
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
					<li><a href="index.php" class="active">Blog's</a></li>
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
				<?php echo $output; ?>
				
				
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
