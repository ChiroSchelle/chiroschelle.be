<?php
include_once("config.php");

// Connect to server and select databse.
mysql_connect("$host", "$user", "$password")or die("cannot connect");
mysql_select_db("$database")or die("cannot select DB");

// Define $myusername and $mypassword
$naam=$_POST['naam'];
$pwd=$_POST['pwd'];
$afdeling=$_POST['afdeling'];
$level = 1;

// To protect MySQL injection (more detail about MySQL injection)
$naam = stripslashes($naam);
$pwd = stripslashes($pwd);
$naam = mysql_real_escape_string($naam);
$pwd = mysql_real_escape_string($pwd);
$pwd = md5($pwd);
//echo $mypassword;

$sql=" INSERT INTO $tbl_name (
`naam` ,
`pwd` ,
`afdeling` ,
`level`
)
VALUES (
$naam, $pwd, $afdeling, $level
) ";
$result=mysql_query($sql) or die("Oeps...");

header("location:main_login.php");

ob_end_flush();
?>



