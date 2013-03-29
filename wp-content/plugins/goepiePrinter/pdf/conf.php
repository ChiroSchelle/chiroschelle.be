<?php
    //phpinfo();
	
	$sql['host'] = "localhost";
	$sql['name'] = "c7070chi_wordpress";
	$sql['username'] = "c7070chi_prog";
	$sql['password'] = "chrsell882";

	mysql_connect($sql['host'], $sql['username'], $sql['password']) or die("Kan geen verbinding maken met database");
	mysql_select_db($sql['name']) or die("Kan geen verbinding maken met database");

?>