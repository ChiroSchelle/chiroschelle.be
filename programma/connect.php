<!-- wordt niet gebruikt-->
<?php
$user="chiroschel";
$password="MG0310";
$database="ChiroApps";
$host="localhost";
$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
mysql_select_db($database) or die('Cannot select database');
?>