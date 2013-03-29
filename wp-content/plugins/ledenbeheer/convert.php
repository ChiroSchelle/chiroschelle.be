<div id="wrap">
<h1>Download Excel bestand</h1>
<form method="post">
<label for="afdeling">Kies Afdeling:</label>
<select name="afdeling">
<?php
for ($j = 1; $j<=12; $j ++){
	?>
	<option value="<?php echo $j; ?>"><?php echo maaknummerafdeling($j); ?></option>
	<?php
}
?>
<p class="submit">
<input type="submit" name="submit" value="Exporteer" />
</p>
</form>
<?php
//Written by Dan Zarrella. Some additional tweaks provided by JP Honeywell
//pear excel package has support for fonts and formulas etc.. more complicated
//this is good for quick table dumps (deliverables)

global $wpdb;
if (isset($_POST['submit'])){
	$afdeling = $_POST['afdeling'];

	## HAAL INFO UIT LEDEN DB ##
	$table_name = $wpdb->prefix . 'leden';
	$query = "SELECT naam, voornaam, adres, postcode, gemeente, telefoon, geboorte as datum, email FROM $table_name WHERE afdeling = $afdeling ORDER BY naam";

	$result = $wpdb->get_results($query) or die(($query));



	$columns = $wpdb->get_col_info('name');

	foreach ($columns as $c){
		$header .= $c . "\t";

	}
	$i = 0;
	while ($result[$i] != "") {
		$line = '';
		foreach ($result[$i] as $value){
		    if(!isset($value) || $value == ""){
		      $value = "\t";
		    }else{
		# important to escape any quotes to preserve them in the data.
		      $value = str_replace('"', '""', $value);
		# needed to encapsulate data in quotes because some data might be multi line.
		# the good news is that numbers remain numbers in Excel even though quoted.
		      $value = '"' . $value . '"' . "\t";
		    }
		    $line .= $value;
		}
		$data .= trim($line)."\n";
		$i++;
	}

	##HAAL INFO VAN WORDPRESS USERS ##

	$leden = get_user_id('afdeling', $afdeling);
	$leden = sort_op_meta($leden, 'afdeling');
	$velden = array('last_name', 'first_name', 'adres', 'postcode', 'gemeente', 'telefoon', 'geboorte', 'user_email');
	$data .= "\n";
	foreach ($leden as $id){
		$adres = $l->straat . ' ' . $l->nr;

		$line = '';
		$u = get_userdata($id);
		foreach ($velden as $v){
			if ($v!='adres'){
			if (!isset($u->$v) || $u->$v == ""){
				$value = "\t";
			}else {
				$value = str_replace('"','""', $u->$v);
				$value = '"' . $value . '"' . "\t";
			}
			}else {
				if ($adres == ""){
					$value = "\t";
				}else {
					$value = str_replace('"','""', $u->straat . " " .$u->nr);
					$value = '"' . $value . '"' . "\t";
				}
			}
			$line .= $value;


		}
		$data .= trim($line) . "\n";

	}


	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
	  $data = str_replace("\r", "", $data);


	# Nice to let someone know that the search came up empty.
	# Otherwise only the column name headers will be output to Excel.
	if ($data == "") {
	  $data = "\nno matching records found\n";
	}

	# This line will stream the file to the user rather than spray it across the screen
	//header("Content-type: application/octet-stream");

	# replace excelfile.xls with whatever you want the filename to default to
	//header("Content-Disposition: attachment; filename=excelfile.xls");
	//header("Pragma: no-cache");
	//header("Expires: 0");
	$file_name = maaknummerafdeling($afdeling) .'.xls';
	$target_path = WP_CONTENT_DIR . '/uploads/documenten/.temp/' . $file_name;
	$url =  get_bloginfo('url') . '/wp-content/uploads/documenten/.temp/' . $file_name;
	$fh = fopen($target_path, 'wB');
	#

	fwrite($fh, $header . "\n" . $data);
	?>
	<form>
	<p><a href="<?php echo $url; ?>"><input type="button" value="Download <?php echo  $file_name; ?>" /></a></p>
	<?php


}
?>

</div>