<?php
	session_start();
	$error = false;
	$error2 = false;
	include_once("classes.php");
	require_once 'secure/securimage.php';
	
	if(time() <= strtotime("2012-05-12")){
		if(isset($_POST['submit2'])){
			$array = array("6jaar", "8jaar", "10jaar", "12jaar", "damesS", "damesM", "damesL", "herenS", "herenM", "herenL", "herenXL", "herenXXL");
			$count = 0;
			foreach ($array as $maat) {
				$count += $_POST[$maat];
			}
			if($_POST['aantal'] != $count){
				echo "Aantal is niet correct<br>";
				$error2 = true;
			}
			else {
				$bestelling = new tshirts;
				$bestelling->fNaam = $_POST['naam'];
				$bestelling->fVoornaam = $_POST['voornaam'];
		
				foreach ($array as $maat) {
					$temp = "f" . ucwords($maat);
					$bestelling->$temp = $_POST[$maat];
				}
				
				$bestelling->writeToDB();
				echo "Bestelling voltooid<br>";
				echo str_replace("\t", str_repeat("&nbsp", 4), str_replace("\n", "<br>", $bestelling->print1()));
			}
		}
		
		if(isset($_POST['submit1']) || $error2){
			$image = new Securimage();
			if ($image->check($_POST['code']) == false) {
				echo "Code niet correct<br>";
				$error = true;
			}
			
			if($_POST['naam'] == ''){
				$error = true;
				echo "Naam niet ingevuld<br>";
			}
			if($_POST['voornaam'] == ''){
				$error = true;
				echo "Voornaam niet ingevuld<br>";
			}
			if(!$error){
				$aantal = $_POST['aantal'];
				$array = array(array("6 jaar" , "6jaar"), array("8 jaar" , "8jaar"), array("10 jaar", "10jaar"), array("12 jaar", "12jaar"),
				array("Dames Small", "damesS"), array("Dames Medium", "damesM"), array("Dames Large", "damesL"), array("Heren Small", "herenS"),
				array("Heren Medium", "herenM"), array("Heren Large", "herenL"), array("Heren XLarge", "herenXL"), array("Heren XXLarge", "herenXXL"));
				?>
				<form action="addBestelling.php" method="post">
					<input type="hidden" name="naam"value="<? echo $_POST['naam'] ?>" />
					<input type="hidden" name="voornaam" value="<? echo $_POST['voornaam'] ?>" /> 
					<input type="hidden" name="aantal" value="<? echo $_POST['aantal'] ?>" />
					<table>
						<? foreach ($array as $maat) {
						echo "<tr><td>Aantal " . $maat[0] . ":</td><td>\n";
							echo "<select name=" . $maat[1] . ">";
							for ($i=0; $i <= $aantal ; $i++) { 
								echo "<option value='" . $i . "'>" . $i . "</option>";
							}
							echo "</select></td></tr>";
						}
						?>
					</table>
					<input type="submit" name="submit2" value="Bestel" />
				</form>
		<?	}
		}
	
		if((!isset($_POST['submit1']) && !isset($_POST['submit2'])) || $error){
			?>
			<form action="addBestelling.php" method="post">
				<table>
					<tr>
						<td>Naam:</td>
						<td><input type="text" name="naam" value="<? echo $_POST['naam'] ?>"></td>
					</tr>
					<tr>
						<td>Voornaam:</td>
						<td><input type="text" name="voornaam" value="<? echo $_POST['voornaam'] ?>"></td>
					</tr>
					<tr>
						<td>Aantal t-shirts:</td>
						<td>
							<select name="aantal">
								<? for ($i=1; $i <= 20 ; $i++) { 
									echo "<option value='" . $i . "'>" . $i . "</option>";
								}?>
							</select>
						</td>
					</tr>
					<tr>
						<td>CAPTCHA:</td>
						<td><img id="captcha" src="secure/securimage_show.php?" alt="CAPTCHA Image" /><br>
							<input type="text" name="code" maxlength="6" />
							<a href="#" onclick="document.getElementById('captcha').src = 'secure/securimage_show.php?' + Math.random(); return false">
								<img src="secure/images/refresh.png" />
							</a>
						</td>
					</tr>
				</table>
				<input type="submit" name="submit1" value="Kies maten" />
			</form>
		<?
		}
	} else {
		echo "U bent helaas te laat en bestellen is niet meer mogelijk.";
	}
?>