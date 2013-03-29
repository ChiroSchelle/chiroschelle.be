<?php session_start(); 
$prijs = 0.6;
?>
<html>
<body>
<title>Poef (test fase)</title>
<?php
include_once ('db.php');
if(isset($_SESSION['username'])){
?>
<a href="saldo.php">Mijn Saldo</a>
-
<a href="totaal.php">Zie totaal poefschuld</a>
<?
$qry = "SELECT * FROM $tbl_name WHERE  username = '" .  $_SESSION['username'] . "'";
$user = mysql_query($qry);
$row = mysql_fetch_array( $user );
$rank = $row['rank'];

if($rank == 1){
?>
-
<a href="users.php">Beheer leiding</a>
-
<a href="pay.php">Voer betalingen in</a>
-
<a href="poefindienen.php">Poef indienen</a>
-
<a href="stat.php">Statistieken</a>
<?}
?>
-
<a href="logout.php">Logout</a>
<?} else {
?>
<a href="login.php">Login</a>
<?}
?>
<br>
