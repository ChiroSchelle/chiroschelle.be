<?php
include_once('header.php');
include_once './functions.php';
include("config.php");
$session = $_SESSION;
#haal info uit url
$dag = $_GET['dag'];
$maand = $_GET['maand'];
$jaar = $_GET['jaar'];
$toon = $_GET['toon'];
$getafdeling = $_GET['afdeling'];
$nu = time(); //tijd in seconden sinds epoch
$naovergangen = strtotime("7 September 2009 17:00");
if ($nu>=$naovergangen | isset($_SESSION['naam'])){
#kijk na of er per datum moet gesorteerd worden
if ($toon=="datum"){
?>
	</body>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	if (($dag!="")&&($maand!="")&&($jaar!="")){ ?>
		<title>Programma voor <?php echo $dag.'/'.$maand.'/'.$jaar; ?></title>
		<?php
		}
	else{
		?>
		<title>Kies een datum</title>
		<?php
	}
	?>

	</head>
	<body>
	<?php 
	# voeg calender toe
	include_once './calendar.php';
	$dag = maaktweecijfer($_GET['dag']);
	$maand = maaktweecijfer($maand);
	
	#haal programma uit database
	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');
	if (!isset($session['naam'])){
		$query = "SELECT DISTINCT datum FROM programma where afdeling !='14' AND afdeling !='17' ORDER BY datum ASC ";
	}else{
		$query = "SELECT DISTINCT datum FROM programma WHERE afdeling !='17' ORDER BY datum ASC ";
	}
	
	$result = mysql_query($query) or die('Error, query failed');		  
	$i = 0;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		$data[$i] = $row['datum'];
		$i++;
	}	
	
	#zoek de vorige en volgende datum
	for ($n=0;$n<=$i;$n++){
		if ($data[$n] == $jaar.'-'.$maand.'-'.$dag){
			$pdatum = $data[$n-1];
			$ndatum = $data[$n+1]; 
		}
	}
	
	$splits = explode("-",$pdatum);
	$pjaar = $splits[0]; 
	$pmaand = $splits[1];
	$pdag = $splits[2];
	$splits = explode("-",$ndatum);
	$njaar = $splits[0]; 
	$nmaand = $splits[1];
	$ndag = $splits[2];
	if ($dag != ""){
		echo '<p class="noprint" >';
			if ($pdag!=""){
				echo '<a href ="?toon=datum&jaar='.$pjaar.'&maand='.$pmaand.'&dag='.$pdag.'">'.$pdag.'/'.$pmaand.'/'.$pjaar.'</a> || ';
			}
			echo $dag.'/'.$maand.'/'.$jaar;
			if ($ndag!=""){
				echo ' || <a href ="?toon=datum&jaar='.$njaar.'&maand='.$nmaand.'&dag='.$ndag.'">'.$ndag.'/'.$nmaand.'/'.$njaar.'</a>';
			}
			echo '</p>';
	}
	echo '<hr  class="noprint" />';
	if (!isset($session['naam'])){
	$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE datum LIKE '".$jaar."-".$maand."-".$dag."' AND afdeling != '14'  ORDER BY (afdeling+0) ASC ";
	}
	else{
		$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE datum LIKE '".$jaar."-".$maand."-".$dag."'  ORDER BY (afdeling+0) ASC ";
	}
	$result = mysql_query($query) or die('Error, query failed');

	# Geef een bericht als de de db leeg is
	if(mysql_num_rows($result) == 0) {
		?>
		<p><br><br />selecteer een datum </p>
		<?php
	}
	else {
		$naarpdf = "";
		?>
		<table id="programma" cellspacing="0" summary="Het programma">
		<!--<caption>programma voor <?php echo $dag.'/'.$maand.'/'.$jaar ; ?> </caption> -->
		<tr>
		<th class="nobg"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th>
		<th colspan="2">programma</th>
		</tr>
		<?php 
		$even = false;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$programma = htmlspecialchars($row['programma']);
			$programma = nl2br($programma);
			$afdeling = $row['afdeling'];
			$txtafdeling = maaknummerafdeling($afdeling);
					
			if ($even == false){
				?>
				<tr><th class="spec"><?php echo $txtafdeling; ?></th><td><?php echo $programma; ?></td><td>
				<?php if ($session['afdeling']==$afdeling){echo '<a href="wijzig.php?jaar='.$jaar.'&maand='.$maand.'&dag='.$dag.'&afdeling='.$afdeling.'"><img src="images/edit.png" alt="edit" title="wijzig dit programma"/></a>'; }?>
				</td></tr>
				<?php
				$even = true;
			}
			else{
				?>
				<tr><th class="specalt"><?php echo $txtafdeling; ?></th><td><?php echo $programma; ?></td><td>
				<?php if ($session['afdeling']==$afdeling){echo '<a href="wijzig.php?jaar='.$jaar.'&maand='.$maand.'&dag='.$dag.'&afdeling='.$afdeling.'"><img src="images/edit.png" alt="edit" title="wijzig dit programma"/></a>';}?>
				</td></tr>
				<?php
				$even = false;
			}
			
			
			}
	}
		mysql_close($verbind);  
	?>
	</table>
	<?php
}
elseif (($toon=="afdeling") or ($toon="")){?>
	</body><head><title>Programma voor <?php echo maaknummerafdeling($getafdeling); ?></title></head>
	<body>
	<div id="kiesafdeling"><a href="?toon=afdeling&afdeling=1">Ribbel &#9794;</a> ||  <a href="?toon=afdeling&afdeling=2">Ribbel &#9792;</a> ||  <a href="?toon=afdeling&afdeling=3">Speelclub &#9794;</a> ||  <a href="?toon=afdeling&afdeling=4">Speelclub &#9792;</a> ||  <a href="?toon=afdeling&afdeling=5">Rakkers</a> ||  <a href="?toon=afdeling&afdeling=6">Kwiks</a> ||  <a href="?toon=afdeling&afdeling=7">Toppers</a> ||  <a href="?toon=afdeling&afdeling=8">Tippers</a> <br />  <a href="?toon=afdeling&afdeling=9">Kerels</a> ||  <a href="?toon=afdeling&afdeling=10">Tiptiens</a> ||  <a href="?toon=afdeling&afdeling=11">Aspi &#9794;</a> ||  <a href="?toon=afdeling&afdeling=12">Aspi &#9792;</a> ||  <a href="?toon=afdeling&afdeling=15">Muziekkapel</a> || <a href="?toon=afdeling&afdeling=17">Activiteiten</a> <?php if (isset($session['naam'])){ ?>||  <a href="?toon=afdeling&afdeling=14">Leiding</a><?php } ?><br  />
	</div><hr  />  
	<?php 
	$nu = time();
	$vandaag = date('Y-m-d',$nu);
	$dag = maaktweecijfer($dag);
	$maand = maaktweecijfer($maand);

	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');
	if ($getafdeling < 14){ //als afdeling geen speciale is (MK, leiding, tikeas,...) is
		if ($getafdeling>6){ //als afdeling = TiKeAs
			$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE (afdeling LIKE '".$getafdeling."' OR afdeling LIKE '13' OR afdeling LIKE '16')  AND datum >= '$vandaag' ORDER BY datum ASC ";
		}
		else {
			$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE (afdeling LIKE '".$getafdeling."' OR afdeling LIKE '13')  AND datum >= '$vandaag' ORDER BY datum ASC ";
			}
	}
	else { //leiding of MK
		$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE (afdeling LIKE '".$getafdeling."')  AND datum >= '$vandaag' ORDER BY datum ASC ";
	}
	$result = mysql_query($query) or die('Error, query failed');
	if ($getafdeling == 15) {
		?> <p>De muziekkapel repeteert elke woensdag van 19u15 tot 20u30<br />De instappers repeteren elke maandag om 18u00, 18u30 en 19u30. <br />
        De tweede stem repeteert op maandag om 19u00. <br />
        De derde stem repeteert op dinsdag om 18u30.</p><?php
		}
	// if the guestbook is empty show a message
	if ($getafdeling == ""){
		echo '<p><br><br />Kies een afdeling </p>';
		}
	elseif(mysql_num_rows($result) == 0){
		?>
		<p><br><br />Er is voor deze afdeling nog geen programma </p>
		<?php
	}
	else{
		?>
		<table id="programma" cellspacing="0" summary="Het programma">
		<!--<caption>programma voor <?php echo $dag.'/'.$maand.'/'.$jaar ; ?> </caption> -->
		<tr>
		<th class="nobg"><?php echo maaknummerafdeling($getafdeling) ?></th>
		<th colspan="2">Programma</th>
		</tr>

		<?php 
		$even = false;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$programma = htmlspecialchars($row['programma']);
			$programma = nl2br($programma);
			$datum = $row['datum'];
			$splits = explode("-",$datum);
			$jaar = $splits[0]; 
			$maand = $splits[1];
			$dag = $splits[2];
			$afdeling = $getafdeling;
			$txtafdeling = maaknummerafdeling($afdeling);
				if ($even == false){
					?>
					<tr><th class="spec"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th><td><?php echo $programma;?></td><td>
					<?php if ($session['afdeling']==$afdeling){echo '<a href="wijzig.php?jaar='.$jaar.'&maand='.$maand.'&dag='.$dag.'&afdeling='.$afdeling.'"><img src="images/edit.png" alt="edit" title="wijzig dit programma"/></a>';}?>
					</td></tr>
					<?php
					$even = true;
				}
				else{
					?>
					<tr><th class="specalt"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th><td><?php echo $programma;?></td><td>
					<?php if ($session['afdeling']==$afdeling){echo '<a href="wijzig.php?jaar='.$jaar.'&maand='.$maand.'&dag='.$dag.'&afdeling='.$afdeling.'"><img src="images/edit.png" alt="edit" title="wijzig dit programma"/></a>';}?>
					</td></tr>
					<?php
					$even = false;
				}
			}
	}

	mysql_close($verbind);  
	?>
	</table>

	<?php
}
echo '<p class="noprint" ><a href="?toon=afdeling">per afdeling</a> || <a href="?toon=datum">per datum</a>';// || <a href="pdf.php">maak pdf</a></p>	';
}
else{
	?><h3>Nog even geduld</h3><p>Het nieuwe programma zal hier binnenkort verschijnen</p><?php
}
include_once('./footer.php'); 
	
?>
