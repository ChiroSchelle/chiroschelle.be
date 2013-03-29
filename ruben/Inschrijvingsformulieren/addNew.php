<?php
	session_start();
	require_once 'secure/securimage.php';
	include_once("classes.php");
	if(time() <= strtotime("2012-05-18")){
	    $error = false;
		if(isset($_POST['submit'])){
			$image = new Securimage();
			if ($image->check($_POST['code']) == false) {
				echo "Code niet correct<br>";
				$error = true;
			}
			if($_POST['naam'] == ''){
				echo "Naam niet ingevuld<br>";
				$error = true;
			}
			if($_POST['voornaam'] == ''){
				echo "Voornaam niet ingevuld<br>";
				$error = true;
			}
			
			if(!$error){
				$inschrijving = new inschrijving();
				$inschrijving->set($_POST['naam'], $_POST['voornaam'], $_POST['aantal'], $_POST['opmerkingen']);
				$inschrijving->writeToDB();
				echo "U bent ingeschreven<br>";
				echo str_replace("\n", "<br>", $inschrijving->In_print());
			}
		}
		
		if (!isset($_POST['submit']) || $error){
		?>
		<form method="post" action="addNew.php">
			<table>
				<tr><td>
					Naam*:
				</td><td>
					<input type="text" name="naam" value="<? echo $_POST['naam'] ?>">
				</td>
				</tr>
				<tr><td>
					Voornaam*: 
				</td>
				<td>
					<input type="text" name="voornaam" value="<? echo $_POST['voornaam'] ?>">
				</td></tr>
				<tr><td>Aantal personen*:
					</td>
					<td>
						<select name="aantal">
							<? for ($i=1; $i <= 16; $i++) { 
								echo "<option value='" . $i . "'>" . $i . "</option>";
							}?>
						</select>
					</td></tr>
					<tr><td>Opmerkingen:</td>
						<td>
							<textarea name="opmerkingen"><? echo $_POST['opmerkingen']?></textarea>
						</td>
					</tr>
					<tr><td VALIGN="bottom">CAPTCHA sleutel*:</td>
						<td><img id="captcha" src="secure/securimage_show.php" alt="CAPTCHA Image" /><br>
							<input type="text" name="code" maxlength="6" />
							<a href="#" onclick="document.getElementById('captcha').src = 'secure/securimage_show.php?' + Math.random(); return false">
								<img src="secure/images/refresh.png" />
							</a>
						</td>
					</tr>
			</table>
			<p style="font-size: 12px;">*verplicht in te vullen</p>
			<input type="submit" value="Reserveer" name="submit">
		</form>
		<?
		}
	} else {
		echo "Inschrijven even niet mogelijk.";
		
	}?>
</body></html>