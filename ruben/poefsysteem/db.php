<?
$host="localhost"; // Host name 
$username="c7070chi_ruben"; // Mysql username 
$password="chrsell882"; // Mysql password 
$db_name="c7070chi_ruben"; // Database name 
$tbl_name="members"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");


/*
 * Acties:
 * 		-1: Fout
 * 		0: Noting
 * 		1: Add poef
 * 		2: Pay poef
 */


?>
