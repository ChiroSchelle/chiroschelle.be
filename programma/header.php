<?php session_start(); 
if (isset($_COOKIE['user'])){
$tbl_name="users"; // Table name
include_once "config.php";
// Connect to server and select databse.
$verbind = mysql_connect("$host", "$user", "$password")or die("cannot connect");
mysql_select_db("$database")or die("cannot select DB");

// Define $myusername and $mypassword
$myusername=$_COOKIE['user'];
$mypassword=$_COOKIE['pwd'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
//$mypassword = md5($mypassword);
$myusername = str_replace('+',' ',$myusername);

$sql="SELECT * FROM $tbl_name WHERE naam='$myusername' and pwd='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
//session_register("myusername");
//session_register("mypassword");
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
$_SESSION['naam'] = $row['naam'];
$_SESSION['afdeling'] = $row['afdeling'];
$_SESSION['level'] = $row['level'];
/*if (isset($_POST['remember'])){
	$expire = time()+(60*60*24*365); //1 jaar geldig
	setcookie('user',$row['naam'],$expire);
	setcookie('pwd',$row['pwd'],$expire);
	ob_end_flush();
}*/
}
//header("location:uitlezen.php");
mysql_close($verbind);
}


}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php if ($_GET['print']==1){ ?>
<link href="print.css" type="text/css" rel="stylesheet" media="screen" />
<link href="print.css" type="text/css" rel="stylesheet" media="print" />
<?php }
else { ?>
<link href="style.css" type="text/css"  rel="stylesheet" media="screen" />
<link href="print.css" type="text/css" rel="stylesheet" media="print" />
<?php } ?>

</head>



<body>
<div id="center">
<div id="header">
<?php 
#toon links bovenaan als wie je bent ingelogd (vooral handing voor mezelf ivm debuggen e.d.)
include_once('randomtxt.php');

if(isset($_SESSION['naam'])){
include_once('functions.php');
echo '<div style="position:absolute; left:5px;"><!--<span style="text-align:left">-->'.$_SESSION['naam'].' - '.maaknummerafdeling($_SESSION['afdeling']).'</div>';
}
else {
toon_txt();
}

?>

<a href="main_login.php">inloggen</a> <?php if(isset($_SESSION['naam'])){ ?>|| <a href="logout.php">uitloggen</a> || <a href="editpwd.php">wachtwoord aanpassen</a> || <a href="uitlezen.php">Uitlezen</a> || <a href="invoeren_2009_nov.php">invoeren</a> || <a href="invoeren.php?activiteit=true">activiteit</a> || <a href="archief.php">archief</a><?php } ?></div> 
<br /><hr /><br />
