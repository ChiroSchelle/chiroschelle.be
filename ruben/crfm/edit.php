<?php
require_once 'conf.php';
session_start();
$try = false;
if(isset($_POST['username']) && isset($_POST['pasword'])){
	$try = true;
	if($_POST['username'] == "crfmcrew" && $_POST['pasword'] == "kamp2012crfm0310"){
		$_SESSION['login'] = true;
	}
	else {
		echo "U gebruikte verkeerde gegevens";
		$try = true;
	}
}
if(isset($_SESSION['login']) && $_SESSION['login'] == true){
	if(isset($_POST['song'])){
		if(isset($_POST['image'])){
			$sql = "UPDATE `cr-fm` SET `afbeelding`='" . $_POST['image'] . "' WHERE `cr-fm`.`ID`=" . $_POST['song'];
			mysql_query($sql);	
		}
	}
	$top = $Klassement->getTop();
	?>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CRFM Klassement</title>
	</head>
	<table>
		<?
	$count = 0;
	foreach ($top as $song) {
		?>		
		<tr>
			<form action="edit.php" method="post">
				<input type="hidden" name="song" value="<? echo $song->getID(); ?>" />
			<td><? echo $count++; ?></td>
			<td>
				Artiest: <? echo $song->getArtist(); ?> </br>
				Song: <? echo $song->getTitle(); ?>
			</td>
			<td>
				<? if($song->getAfbeelding() == "http://www.wolfmother.net/wp-content/uploads/2011/06/UnknownAlbum.png"){
					?>
					Afbeelding: <input type="text" name="image"/>
					<?
				} ?>
			</td>
			<td>
				Zelfde als: <select name="sameAs">
					<? foreach ($top as $tempSong) {
						if ($tempSong == $song){
							continue;
						}
						echo "<option value='" . $tempSong->getID() . "'>" . $tempSong->getArtist() . " - " . $tempSong->getTitle() . "</option>";
					} ?>
				</select>
			</td>
			<td><input type="submit"></td>
			</form>
		</tr>
		
		<?
	}
	?>
	</table>
	<?
}
else {
	if(!$try){?>	
	U dient u aan te melden.
	<? } ?>
	<form action="edit.php" method="post">
		<table>
			<tr>
				<td>Login:</td>
				<td><input name="username" type="text"/></td>
			</tr>
			<tr>
				<td>Paswoord:</td>
				<td><input name="pasword" type="password" /></td>
			</tr>
		</table>
		<input type="submit" />
	</form>
<?
}
?>
