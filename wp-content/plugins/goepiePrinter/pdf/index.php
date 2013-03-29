<html>
<head>
	<title>Programma Goepie</title>
</head>
<body>
<h2>Goepie maker</h2>
<form action="pdf.php" method="post">
	<h3>Eerste zondag goepie</h3>
	Dag: <select name="dag1">
		<?php
		for($i = 1; $i < 32; $i++){
			echo "<option value=" . $i . ">" . $i . "</option>";
		}
		?>
	</select>
	Maand: <select name="maand1">
		<?php
		for($i = 1; $i < 13; $i++){
			echo "<option value=" . $i . ">" . $i . "</option>";
		}
		?>
	</select>
	Jaar: <input name="jaar1" value='<? echo date("Y") ?>'/>
	
	<h3>Laatste zondag goepie</h3>
		Dag: <select name="dag2">
		<?php
		for($i = 1; $i < 32; $i++){
			echo "<option value=" . $i . ">" . $i . "</option>";
		}
		?>
	</select>
	Maand: <select name="maand2">
		<?php
		for($i = 1; $i < 13; $i++){
			echo "<option value=" . $i . ">" . $i . "</option>";
		}
		?>
	</select>
	Jaar: <input type="text" name="jaar2" value="<? echo date('Y') ?>" />
	</select>
	</br><br>
	<input type="submit" value="Download" name="Download">
	<input type="submit" value="Bekijk" name="Download">
</form>
</body>
</html>