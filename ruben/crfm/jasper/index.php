<?php
	
	 # errors weergeven
	ini_set('display_errors',0); // 1 == aan , 0 == uit
	error_reporting(E_ALL | E_STRICT);
	
	#Sessie starten
	session_start();

	#Config includen
	include_once("conf.php");
	
	#Start Script
	if(isset($_POST['submit3']))
	{
		//$stem = new Stem;
		//$_SESSION['stem'] = serialize($stem);
		$stem = unserialize($_SESSION['stem']);
		$stem->setSong($_POST['title'], $_POST['artist']);
		$_SESSION['stem'] = serialize($stem);
		
		$song1 = $stem->getSong1();
		$song2 = $stem->getSong2();
		$song3 = $stem->getSong3();
		
		
		$output = '
			<div class="overzicht">
				<h3>Bedankt voor uw stem!</h3>
				<span class="inspringen">
					U hebt gekozen voor:
				</span>
					<ol>
						<li><b>'.$song1[1].'</b> - '.$song1[0].'</li>
						<li><b>'.$song2[1].'</b> - '.$song2[0].'</li>
						<li><b>'.$song3[1].'</b> - '.$song3[0].'</li>
					</ol>
					<br>
				Indien dit correct is vul dan hieronder uw email adres in en bevestig uw stem. 
				
				<form method="post" action="stem.php" class="email">
					<label>E-mail: </label><input type="text" name="mail" />
					<input type="submit" name="Bevestig" value="Verzend" class="button-blokje" />
				</form>
			</div>	
		';
	}
	else if(isset($_POST['submit2']))
	{
		#########################
		#	Stem voor 1 punt	#
		#########################
		
		# Onthoud vorige stemmen
		$stem = unserialize($_SESSION['stem']);
		$stem->setSong($_POST['title'], $_POST['artist']);
		$_SESSION['stem'] = serialize($stem);
		
		$submit = 'submit3';
		$count = '1';
		
		$song1 = $stem->getSong1();
		$song2 = $stem->getSong2();
		$stemmen = '<li><b>'.$song1[1].'</b> - '.$song1[0].'</li><li><b>'.$song2[1].'</b> - '.$song2[0].'</li><li> - </li>';
	}
	else if(isset($_POST['submit1']))
	{
		##########################
		#	Stem voor 2 punten	 #
		##########################
		
		# Onthoud vorige stem
		$stem = new Stem;
		$stem->setSong($_POST["title"], $_POST['artist']);
		$_SESSION['stem'] = serialize($stem); 
		
		$submit = 'submit2';
		$count = '2';		
		
		$song1 = $stem->getSong1();
		$stemmen = '<li><b>'.$song1[1].'</b> - '.$song1[0].'</li><li> - </li><li> - </li>';
	}
	else
	{
		# Stem voor 3 punten
		$submit = 'submit1';
		$count = '3';
		
		$stemmen = '<li> - </li><li> - </li><li> - </li>';
					
	}	
	
			
	

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
				<h1>Stem op jouw favoriete kamp-nummer!</h1>
				<?php 
				if($output)
				{
					echo $output;
				}
				else
				{
					?>
					<div class="blokje">
						<p>
							Stem vanop deze site je favoriete liedje in de kamp-hitlijst! Je kan op drie liedjes stemmen.
							<? echo $uitleg; ?>
						</p>
					</div>
					
					<div class="blokje">
						<h3>Jouw voorlopige top 3:</h3>
						<ol>
							<?php echo $stemmen; ?>
						</ol>
					</div>
					
					<div class="blokje">
						<h3>Voeg zelf een nummertje toe!</h3>
						<form name="nieuw" action="" method="post">
							<fieldset>
								<label>Titel:</label><input type="text" name="titel" />
								<label>Artiest:</label><input type="text" name="artiest" />
								<input type="submit" value="Stem" name="<?php echo $submit; ?>" />
							</fieldset>	
						</form>
					</div>			
					
					
					<?php
						$sugesties = getSugestieLijst($Klassement, $stem);
						foreach ($sugesties as $sug) 
						{
							?>
								<form method="post" action="index.php" class="blokje">
									<input name="title" type="hidden" value="<?php echo $sug->getTitle(); ?>" />
									<input name="artist" type="hidden" value="<?php echo $sug->getArtist(); ?>" />	
									<img src="<?php echo $sug->getAfbeelding(); ?>" class="album"/>
									<p>
										<?php echo $sug->getArtist(); ?><br/>
										<span class="titel"><?php echo $sug->getTitle(); ?></span>
									</p>
									<input type="submit" name="<?php echo $submit; ?>" value="Stem!" class="button-blokje"/>
								</form>
							<?
						}	
					?>		
				<? } ?>	
			</div>	
		</div>
		
		<footer>
		
		</footer>
	</body>
</html>