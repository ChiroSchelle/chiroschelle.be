<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
function connect() {
	mysql_connect('localhost', 'j9023job_cb', 'casablanca') or die('Error connecting to mysql');

	$dbname = 'j9023job_cb';

	mysql_select_db($dbname);

}

function close() {
	mysql_close();
}

function do_mysql($sql) {

	connect();

	mysql_query($sql) or die('Fout in query <br />' . "$sql");

	close();

}

function checkemail($email) {
	list($userName, $mailDomain) = split("@", $email);
	if(checkdnsrr($mailDomain, "MX")) {
		return true;
	} else {
		return false;
	}

}

function checkLogin($name, $pass) {
	connect();
	$query = "SELECT * from users WHERE login LIKE '$name' AND pass = '$pass'";
	$result = mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			$_SESSION['id'] = $row['id'];

		}
		$check = true;
	} else {
		//onmogelijk om hier terecht te komen
		$check = false;

	}
	close();
	return $check;
}

function leesUit($volnaam) {
	connect();
	$query = "SELECT * from personen WHERE concat(voornaam, ' ', naam) = '$volnaam'";
	$result = mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			$geg['voornaam'] = $row['voornaam'];
			$geg['naam'] = $row['naam'];
			$geg['gsm'] = $row['gsm'];
			$geg['email'] = $row['email'];
			$geg['tel'] = $row['tel'];
			$geg['vereniging_id'] = $row['vereniging_id'];
			$geg['bedrijf_id'] = $row['bedrijf_id'];
		}

		if($geg['vereniging_id'] != "") {
			$query = "SELECT * from vereniging WHERE id = {$geg['vereniging_id']}";
			$result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($result)) {
				$geg['ver_naam'] = $row['naam'];
				$geg['ver_gemeente'] = $row['gemeente'];
				$geg['ver_contact_id'] = $row['contactpersoon_id'];
				$geg['ver_site'] = $row['website'];

			}
			$query = "SELECT * from personen WHERE id = {$geg['ver_contact_id']}";
			$result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($result)) {
				$geg['ver_contact_voornaam'] = $row['voornaam'];
				$geg['ver_contact_naam'] = $row['naam'];
				$geg['ver_contact_gsm'] = $row['gsm'];
				$geg['ver_contact_email'] = $row['email'];
				$geg['ver_contact_tel'] = $row['tel'];
			}
		}
		if($geg['bedrijf_id'] != "") {
			$query = "SELECT * from bedrijf WHERE id = {$geg['bedrijf_id']}";
			$result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($result)) {
				$geg['bedr_naam'] = $row['naam'];
				$geg['bedr_tel'] = $row['telefoon'];
				$geg['bedr_contact_id'] = $row['contactpersoon_id'];
				$geg['bedr_site'] = $row['website'];

			}
			$query = "SELECT * from personen WHERE id = {$geg['bedr_contact_id']}";
			$result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($result)) {
				$geg['bedr_contact_voornaam'] = $row['voornaam'];
				$geg['bedr_contact_naam'] = $row['naam'];
				$geg['bedr_contact_gsm'] = $row['gsm'];
				$geg['bedr_contact_email'] = $row['email'];
				$geg['bedr_contact_tel'] = $row['tel'];
			}
		}

	} else {

	}
	return $geg;
}

function haalTaken($start="", $stop="") {
	connect();
	$query = "SELECT * FROM taak ORDER BY naam ASC;";
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)) {
		$geg[$row['id']]['id'] = $row['id'];
		$geg[$row['id']]['naam'] = $row['naam'];
		$geg[$row['id']]['plaats'] = $row['plaats'];
		$geg[$row['id']]['verantw'] = $row['verantwoordelijke_id'];
		
	}
	
	
	close();
	return $geg;
}
function insertTaak($naam, $plaats, $verantw){
	connect();
	if (!is_numeric($verantw)){
		//voeg nieuwe verantwoordelijke toe
	}
	$query = "INSERT INTO taak(naam, plaats, verantwoordelijke_id) VALUES ('$naam' , '$plaats', '$verantw');";
	mysql_query($query) or die(mysql_error());
	return mysql_insert_id();
	close();
}

function voegMwToe($data){
	$d = $data;
	connect();
	$type = maakTypeNr($d['type']);
	if ($type != 0){
		$query = "INSERT INTO personen (voornaam, naam, email, gsm, telefoon, type_id) VALUES ('{$d['voornaam']}', '{$d['naam']}', '{$d['email']}', '{$d['gsm']}', '{$d['tel']}', '$type' );";
	}else{
		$query = "INSERT INTO personen (voornaam, naam, email, gsm, telefoon) VALUES ('{$d['voornaam']}', '{$d['naam']}', '{$d['email']}', '{$d['gsm']}', '{$d['tel']}' );";
	}
	mysql_query($query) or die(mysql_error());
	$pers_id = mysql_insert_id();

	switch ($d['type']){
		case 'vip':
			$pid = '3' ;//vip parking
			break;
		case 'intro':
			$pid = '4'; //gehandicaptenparking
			break;
		default:
			$pid = '1'; //medewerkersparking
			break;
	}
	foreach ($d['parking'] as $dag){
		switch ($dag){
			case 'woe':
				$dag = 1;
				break;
			case 'don':
				$dag = 2;
				break;
			case 'vrij':
				$dag = 3;
				break;
			case 'zat':
				$dag = 4;
				break;
			default:
				$dag = 0;
				break;
		}
		if ($dag != 0) {
		
			$nummerplaten = explode( "\n", $d['nummerplaat'] );
			foreach ($nummerplaten as $nummerplaat ) {
				$query = "INSERT INTO parking (personen_id, dagen_id, nummerplaat, parkings_id) VALUES ('$pers_id', '$dag', '$nummerplaat', '$pid');";
			mysql_query($query) or die(mysql_error());
			}
		}
	}
	foreach($d['toegang_ok'] as $zone){
		//dagen nog te selecteren
		for ($i = 1; $i <=4; $i++){
			$query = "INSERT INTO toegang (personen_id, zone_id, dag_id, toegestaan) VALUES ('$pers_id', '$zone', $i, '1');";
			mysql_query($query) or die(mysql_error());
		}
	}
	foreach($d['toegang_vraag'] as $zone){
		//dagen nog te selecteren
		for ($i = 1; $i <=4; $i++){
			$query = "INSERT INTO toegang (personen_id, zone_id, dag_id, reden) VALUES ('$pers_id', '$zone', $i, '{$d['reden_vraag']}');";
			mysql_query($query) or die(mysql_error());
		}
	}
	if ($d['type'] == 'vrijw') {
		//voer per dag de taak in
		for ($i = 1; $i <= 4; $i++){
			foreach ($d['taak'][$i] as $taak){
				$query = "INSERT INTO koppel_taak (persoon_id, taak_id, dag_id) VALUES ('$pers_id', '$taak', '$i');";
				mysql_query($query) or die(mysql_error());
			}
		}
		if ($d['ver_id'] != ""){
			$query = "UPDATE personen SET vereniging_id ='{$d['ver_id']}' WHERE id = '$pers_id';";
			mysql_query($query) or die(mysql_error() . "<br /> $query");
		}elseif ($d['ver_naam'] != ""){
			include_once('vereniging.php');
		}
	}elseif ($d['type'] == 'extern') {
		//voeg gegevens bedrijf toe
	}elseif ($d['type'] == 'vip'){
		//geen extra info nodig
	}
	return true;
	close();
}

function maakTypeNr($type){
	switch ($type){
		case 'vrijw':
			$t = 1;
			break;
		case 'extern':
			$t = 2;
			break;
		case 'artiest':
			$t = 3;
			break;
		case 'intro':
			$t = 4;
			break;
		case 'vip':
			$t = 5;
			break;
		default:
			$t = 0;
	}
	return $t;
}

function voegVerToe($naam, $gemeente, $site, $contact_id){
	connect();
	$query = "INSERT INTO vereniging (naam, gemeente, website, contactpersoon_id) VALUES ('$naam', '$gemeente', '$site', '$contact_id');";
	mysql_query($query) or die(mysql_error());
	return mysql_insert_id();
	close();
}
function koppelVerPers($ver_id, $pers_id){
	$query = "UPDATE personen SET vereniging_id = '$ver_id' WHERE id = '$pers_id';";
	mysql_query($query) or die(mysql_error());
	close();
}

function voegPersToe($vnaam, $naam, $email, $gsm, $tel, $ver_id){
	connect();
	$query = "INSERT INTO personen (voornaam, naam, email, gsm, telefoon, vereniging_id) VALUES ('$vnaam', '$naam', '$email', '$gsm', '$tel', '$ver_id');";
	mysql_query($query) or die(mysql_error());
	return mysql_insert_id();
	close();
}

function maakLogin ($login, $pass, $email, $pers_id){
	connect();
	$query = "INSERT INTO users (login, pass, email, personen_id) VALUES ('$login', '$pass', '$email', '$pers_id');";
	mysql_query($query) or die(mysql_error());
	return mysql_insert_id();
	close();
}

function listPersonenCB(){
	connect();
	$query = "SELECT * FROM personen WHERE vereniging_id = '1';";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)){
		$r[$row['id']]['id'] = $row['id'];
		$r[$row['id']]['voornaam'] = $row['voornaam'];
		$r[$row['id']]['naam'] = $row['naam'];
	}
	return $r;
}

function nogGeenToegang($zone = 0){
	connect();
	$query = "SELECT t.id as tid, p. voornaam, p.naam, d.naam as dag, d.id as did, z.code, z.naam as zone, t.reden as reden from personen as p 
	JOIN toegang as t ON (t.personen_id = p.id) 
	JOIN dagen as d ON (t.dag_id = d.id) 
	JOIN zones as z ON (t.zone_id = z.id) 
	WHERE t.toegestaan = 0 AND t.toon = 1";
	if ($zone != 0){
		$query .= " AND t.zone_id = '$zone'";
	}
	$result = mysql_query($query) or die(mysql_error());
	 while ($row = mysql_fetch_array($result)){
		 $d[$row['tid']]['tid'] = $row['tid'];
		 $d[$row['tid']]['voornaam'] = $row['voornaam'];
		 $d[$row['tid']]['naam'] = $row['naam'];
		 $d[$row['tid']]['code'] = $row['code'];
		 $d[$row['tid']]['zone'] = $row['zone'];
		 $d[$row['tid']]['reden'] = $row['reden'];
		 $d[$row['tid']]['did'] = $row['did'];
		 $i++;
		 
		 
		 
	 }
	 return $d;
	 close();
}

function geefToegang($id){
	connect();
	$query = "UPDATE toegang SET toegestaan = 1 WHERE id = '$id';";
	 mysql_query($query) or die(mysql_error());
	close();
}

function weigerToegang($id){
	connect();
	$query = "UPDATE toegang SET toon = 0 WHERE id = '$id';";
	mysql_query($query) or die(mysql_error());
	close();
}
function haalZones(){
	connect();
	$query = "SELECT * FROM zones;";
	$result = mysql_query($query) or die(mysql_error());
	while ($r = mysql_fetch_array($result)){
		$d[$r['id']]['id'] = $r['id'];
		$d[$r['id']]['naam'] = $r['naam'];
		$d[$r['id']]['code'] = $r['code'];
	}
	return $d;
}
function NietGebruikt(){
	$sql = "SELECT DISTINCT concat(p.voornaam, ' ', p.naam) as naam, v.naam, z.code, d.naam, ta.naam, pk.nummerplaat, pks.naam, po.naam
FROM personen as p
JOIN vereniging as v ON (p.vereniging_id = v.id)
JOIN personen as po ON (po.id = v.contactpersoon_id)
JOIN toegang as t ON (t.personen_id = p.id)
JOIN zones as z ON (t.zone_id = z.id)
JOIN dagen as d ON (d.id = t.dag_id)
JOIN koppel_taak as k ON (p.id = k.persoon_id AND d.id = k.dag_id)
JOIN taak as ta ON (ta.id = k.taak_id)
JOIN parking as pk ON (pk.personen_id = p.id AND d.id = pk.dagen_id)
JOIN parkings as pks ON (pk.parkings_id = pk.id)
WHERE t.toegestaan = 1";
}

?>
