<?php

add_action('admin_menu', 'goepiePrinter_menu');

function goepiePrinter_menu(){
	//add_options_page('GoepiePrinter');
	$icon_url = plugins_url('images/plugin-menu-icon16.png', __FILE__);
	add_menu_page('', 'Goepie Printer', 'administrator', GOEPIEPRINTER_NAME, 'goepieprinter_display_page', $icon_url) ;
}

function goepieprinter_display_page(){
if(isset($_POST['dag1']) && isset($_POST['dag2'])){
	require_once('pdf/pdf.php');
	//MAKE THE PDF BY _POST
	$dag1 = $_POST['dag1'];
	$dag2 = $_POST['dag2'];
	$maand1 = $_POST['maand1'];
	$maand2 = $_POST['maand2'];
	$jaar1 = $_POST['jaar1'];
	$jaar2 = $_POST['jaar2'];
	$download = TRUE;
	//if($_POST['Download'] == "Download"){
	//	$download = true;
	//}
	//else {
	//	$download = false;
	//}
	
	date_fix_date($maand1, $dag1, $jaar1);
	date_fix_date($maand2, $dag2, $jaar2);
	
	$date1 = new DateTime($jaar1 . "-" . $maand1 . "-" . $dag1);
	$date2 = new DateTime($jaar1 . "-" . $maand1 . "-" . $dag1);
	
	if ($date2 > $date1){
		die("Laatste zondag valt voor eerste!");
	}
		
	$dates = getProgramBetween($jaar1, $maand1, $dag1, $jaar2, $maand2, $dag2);
	if(count($dates) < 1){
		die("Geen zondagen");
	}
	makeGoepiePDF($dates, $download);
	//print_r($test);
}
?>

<div class="wrap">
	<h2>Goepie Printer</h2>
	<form action=<? echo curPageURL(); ?> method="post">
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
</form>
</div>

<?
}
?>
