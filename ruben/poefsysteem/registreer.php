<?php
include('db.php');

$password = md5($_POST['mypassword']);

$query = ("INSERT INTO `" .  $db_name . "`.`" . $tbl_name . "` (`id` , `username` , `password`) VALUES ( NULL ,  '" . $_POST['myusername'] . "',  '" . $password . "');");

mysql_query($query);

echo "Toegevoegd";
