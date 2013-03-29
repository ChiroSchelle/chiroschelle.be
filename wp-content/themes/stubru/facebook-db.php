<?php

//error_reporting(E_ERROR | E_PARSE);

function connect() {
	mysql_connect('localhost', 'c7070chi_fb', 'faceb00k') or die('Error connecting to mysql');

	$dbname = 'c7070chi_facebook';

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

function steekUserInDb($user, $type = "email"){
	connect();
	
	//print_r($user);
	$id = $user['id'];
	$naam = $user['name'];
	$voornaam = $user['first_name'];
	$achternaam = $user['last_name'];
	$link = $user['link'];
	$username = $user['username'];
	$geslacht = $user['gender'];
	$email = $user['email'];
	$timezone = $user['timezone'];
	$taal = $user['locale'];
	$verified = $user['verified'];
	$updated = $user['updated_time'];
	$array = serialize($user);
	$oud = "1969-01-01 00:01:01";
	$query= "SELECT updated FROM `users` WHERE fb_id = $id AND type = '$type' ORDER BY updated ASC";
	
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)) {
			$oud = $row['updated'];
		}
	}
	if (strtotime($oud) < strtotime($updated)){
	$query = "INSERT INTO users (fb_id, naam, voornaam, achternaam, email, username, geslacht, link, tijdzone, taal, verified, updated, array, type) VALUES ('$id', '$naam', '$voornaam', '$achternaam', '$email', '$username', '$geslacht', '$link', '$timezone', '$taal', '$verified', '$updated', '$array', '$type');";
	mysql_query($query) or die(mysql_error());
	}
	
	
	close();
}

function haalUserArrays(){
	connect();
	
	$query = "SELECT id, fb_id, array FROM users";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)) {
			$data[$row['id']] = unserialize($row['array']);
		}
	}
	return $data;
	
	close();
	
}

function inDb($user, $type="email"){
	connect();
	$id = $user['id'];
	$query = "SELECT naam FROM users WHERE fb_id = '$id' AND type = '$type';";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) > 0){
		return true;
	}else{
		return false;
	}
	close();
	
}