<?php

# errors weergeven
$error_reporting = 0;

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

include 'inc/config.php';
include 'inc/functies.php';

$form = '	<form action="" method="post" name="form1" class="form panel">
					<h3 class="form">Plaats een bericht</h3>
					<fieldset>
						<label>Naam:</label><input type="text" name="naam" value="" />
						<label>E-mail:</label><input type="text" name="mail" value="" />
						<label>Bericht:</label><textarea name="bericht" rows="5"></textarea>
						
						<input type="submit" name="verzend" value="Plaats Bericht!">		
					</fieldset>
				</form>';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$validatie = validate($_POST);
	
	if($validatie != 'valid')
	{
		$output = $validatie.$form;
	}
	else
	{
		$output = addBericht($_POST['naam'], $_POST['mail'], $_POST['bericht'], $_SERVER['REMOTE_ADDR'], $_GET['id']);
	}
}
else
{
	$output = '';
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Blog - Poerkwaspi</title>

		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

	</head>
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) {return;}
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1&appId=170695056324556";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	
		<div id="wrapper">
			<div id="header">
				<img src="img/header.png" alt="poerkwaspi" />
			</div>
			
			<div id="menu">
				<ul>
					<li><a href="index.php" >Home</a></li>
					<li><a href="blog.php" class="active">Blog</a></li>
					<li><a href="contact.php" >Contact</a></li>
				</ul>
			</div>
			
			<div id="content">	
				<?php
					if(isset($_GET['id']))
					{
						$blog = leesBlogbericht($_GET['id']);
						
						if($blog == 'bestaat niet')
						{
							echo '<div class="info">Het bericht dat u zoekt bestaat niet.</div>';
						}
						else
						{
							echo $blog;
							//echo '<h2>Reacties</h2>';
							//echo getReacties($_GET['id']);				
							//echo '<br/>'.$output;
						}
					}
					else
					{
						echo '<div class="info">Het bericht dat u zoekt bestaat niet.</div>';
					}
				?>			
				

				
				
				
				
				
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
