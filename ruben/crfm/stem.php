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
						$mail = $_POST["mail"];
						//$stem = new Stem;
						//$_SESSION['stem'] = serialize($stem);
						if(isset($_SESSION['stem']))
						{
							$stem = unserialize($_SESSION['stem']);
							
							$song1 = $stem->getSong1();
							$song2 = $stem->getSong2();
							$song3 = $stem->getSong3();
							
							$result = $stem->stem($mail);
							
							if(is_array($result))
							{
								$url = "http://crfm.chiroschelle.be/bevestig.php?mail=" . $result[1];
								$to = $result[0];
								$subject = "Bevestig je stem voor de KAMPHIT 2012 van CRFM";
								$message = "Beste<br><br>Bedankt voor te stemmen op jou kamphit. Je moet enkel je stem nog bevestigen door op de volgende link te klikken.<a href='" . $url . "'>" . $url ."</a> . 
								<br><br>
								Alvast bedankt
								<br>
								Het CRFM-team";
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$headers .= 'From: CRFM <no-reply@chiroschelle.be>' . "\r\n";
								$headers .= "Reply-To: no-reply@chiroschelle.be\r\n"; 
								$headers .= "X-Mailer: CRFM-mailer\n"; 
								mail($to, $subject, $message, $headers);
								echo "Uw stem werd ontvangen kijk snel je mail na en bevestig uw stem<br>";
								echo str_replace("\\", "","Uw stem ging naar:<ol><li>" . $song1[0] . " - " . $song1[1] . "</li>");
								echo str_replace("\\", "", "<li>" . $song2[0] . " - " . $song2[1] . "</li>");
								echo str_replace("\\", "","<li>" . $song3[0] . " - " . $song3[1] . "</li></ol>");
								
							}
							else
							{
								echo $result;
							}
						}
						else 
						{
							echo "Geen sessie";
						}
						session_destroy();
					?>
				</div>
			</div>	
		</div>
		
		<footer>
		
		</footer>
	</body>
</html>