<?php
	include("printInschr.php");
    if(isset($_POST['submit'])){
    	printPDF();
	}
	
	if(isset($_POST['submit-tshirt'])){
		tshirtPrintPDF();
	}
	else{
		?>
		<title>Inschrijvingen</title>
		Inschrijvingsavond:<br>
		<form method="post" action="index.php">
			<ul>
				<li><input type="submit" name="submit" value="Maak pdf"></li>
			</ul>
			
		</form>
		<br><br>
		Tshirts:<br>
		<form method="post" action="index.php">
			<ul>
				<li><input type="submit" name="submit-tshirt" value="Maak pdf"></li>
			</ul>
		</form>
		<?
	}
?>