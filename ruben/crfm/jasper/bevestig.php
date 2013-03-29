<?php
	
	# errors weergeven
	ini_set('display_errors',0); // 1 == aan , 0 == uit
	error_reporting(E_ALL | E_STRICT);
	
	#Sessie starten
	session_start();

	#Config includen
	include_once("conf.php");
	
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CRFM</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	
	<body>
		<header>
			<div class="wrapper">
				<a href="index.php"><img src="img/logo.png" alt="logo crfm" class="logo"/></a>
			</div> 	
		</header>
		
		<div id="page-wrap">
			 <!-- onze mannen mooi bij elkaar -->
			<div id="man1"></div>
			<div id="man2"></div>
			
			<div id="content">
				<div class="overzicht">
					<?php
						include_once("conf.php");
						if(isset($_GET['mail'])){
							$str = "SELECT * FROM cr-fmWacht WHERE mail ='" . mysql_real_escape_string($_GET['mail']) . "'";
							if(!$result = mysql_query($str)){
								echo "Uw stem werd niet gevonden";
							}
							else{
								$row = mysql_fetch_array($result);
							
								if(stem($row['Artist1'], $row['Title1'], $row['Artist2'], $row['Title2'], $row['Artist3'], $row['Title3'], $Klassement)){
									$str = "DELETE FROM `c7070chi_ruben`.`cr-fmWacht` WHERE `cr-fmWacht`.`ID` = " . $row['ID'];
									if(mysql_query($str) === false)
									{
										echo 'Hier stond een lelijke die, en u query is fout trouwens.';
									}
									header("Refresh: 5; url=http://www.chiroschelle.be");
									echo "Uw stem is goed ontvangen.<br>";
									echo "Uw stem ging naar:<ol><li>" . $row['Artist1'] . " - " . $row['Title1'] . "</li>";
									echo "<li>" . $row['Artist2'] . " - " . $row['Title2'] . "</li>";
									echo "<li>" . $row['Artist3'] . " - " . $row['Title3'] . "</li></ol>";
								}
								else {
									echo "Uw stem is niet ontvangen probeer later nog eens opnieuw.";
								}
							}
						}
						else {
							echo "U heeft geen toegang tot deze pagina.";
						}
					?>
				</div>	
			</div>	
		</div>
		
		<footer>
		
		</footer>
	</body>
</html>