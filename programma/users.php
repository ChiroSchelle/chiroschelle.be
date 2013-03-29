<?php 
include_once('header.php');
#enkele variabelen
include_once('functions.php');
$userlevel = 1; //minimaal level om iets te mogen doen
$adminlevel = 8; //minimaal level om admin te zijn

include_once("config.php");

#als de gebruiker niet is ingelogd, ga dan naar de login pagina
?>
</body><head><title>Geregistreerd Leden</title></head>
<body>
<?php
if(!isset($_SESSION['naam'])){
	//header("location:main_login.php");
	echo '<meta http-equiv="refresh" content="3" url="./main_login.php?ref=users">';
}

#controleer of de gebruiker de juiste machtigingen heeft
elseif ($_SESSION['level']<$userlevel){
	echo 'U heeft niet de juiste machtigingen om deze pagina te bekijken';
}

#druk de lijst met leden af
else{
	?>
	<table id="programma">
	<tr>
	<th class="nobg">geregistreerde leden</th><th>Afdeling</th><th>Level</th></tr>
	<?php 
	#haal leden op
	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');
	$query = "SELECT naam, afdeling, level FROM users ORDER BY afdeling+0 ASC ";
	$result = mysql_query($query) or die('Error, query failed');		  

	$i= 1; //deze variabele gebruiken we om de kleuren van afwisselende rijen te beinvloeden
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		#als de gebruiker geen admin is toen dan geen gebruikers met level 9 (super-admins)
		if (($_SESSION['level'] < $adminlevel)&&($row['level']<9)){
			if ($i==1)  { #even rijen?>
				<tr><th class="spec"><?php echo $row['naam']; ?></th><td><?php echo maaknummerafdeling($row['afdeling']); ?></td><td><?php echo $row['level']; ?></td></tr>
				<?php
			}
			if ($i==2) { #oneven rijen
				?>
				<tr><th class="specalt"><?php echo $row['naam']; ?></th><td class="alt"><?php echo maaknummerafdeling($row['afdeling']); ?></td><td class="alt"><?php echo $row['level']; ?></td></tr>
				<?php
			}
		}
		if ($_SESSION['level'] >= $adminlevel){
			if ($i==1) { #oneven rijen?>
				<tr><th class="spec"><?php echo $row['naam']; ?></th><td><?php echo maaknummerafdeling($row['afdeling']); ?></td><td><?php echo $row['level']; ?></td></tr>
				<?php
			}	
			elseif ($i==2) { #even rijen
				?>
				<tr><th class="specalt"><?php echo $row['naam']; ?></th><td class="alt"><?php echo maaknummerafdeling($row['afdeling']); ?></td><td class="alt"><?php echo $row['level']; ?></td></tr>
				<?php
			}
		}
		#maak $i even/oneven
		if ($i==1) $i=2; else $i=1;		
		
	}
}
include_once('footer.php');

?>
