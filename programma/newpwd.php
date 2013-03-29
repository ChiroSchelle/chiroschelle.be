<?php include_once('header.php'); ?>
</body>
<head><title>Niew Wachtwoord</title></head>
<body>

<form name="form1" method="post">
<table id="login">
<tr>
<th colspan="2"><strong>Vraag een nieuw wachtwoord </strong></td>
</tr>
<tr>
<th class="spec">Naam</th>
<td ><input name="myusername" type="text" id="myusername"></td>
</tr>
<th colspan="2"><input type="submit" name="btnLogIn" value="Stuur mij een nieuw wachtwoord"></th>
</tr>
</table>
</form>

<?php
include_once('functions.php');
include_once('config.php');
if (isset($_POST['btnLogIn'])){
/*$host="localhost"; // Host name
$username="chiroschel"; // Mysql username
$password="MG0310"; // Mysql password
$db_name="ChiroApps"; // Database name
*/$tbl_name="users"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$user", "$password")or die("cannot connect");
mysql_select_db("$database")or die("cannot select DB");

// Define $myusername and $mypassword
$naam = $_POST['myusername'];

// To protect MySQL injection (more detail about MySQL injection)
$naam = stripslashes($naam);
$mypassword = stripslashes($mypassword);
$naam = mysql_real_escape_string($naam);
$mypassword = mysql_real_escape_string($mypassword);
$mypassword = md5($mypassword);


$sql="SELECT * FROM users WHERE naam='".$naam."'";
$result=mysql_query($sql) or die("Oops");

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
$newpwd =generatePassword();
$md5pwd = md5($newpwd);

while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
$email = $row['email'];

}
$sql="UPDATE users SET pwd = '".$md5pwd."' WHERE naam ='".$naam."' LIMIT 1 ";
$result = mysql_query($sql);
$bericht="Beste ".$naam.",

Je hebt een nieuw wachtwoord aangevraagd voor chiroschelle.be
Je nieuwe wachtwoord is ".$newpwd." .
";
sendmail($naam,$email,"Nieuw wachtwoord",$bericht);
echo "Er is een mail verstuurd naar ".$email." met je nieuwe wachtwoord.";
}
else {
echo "Deze gebruiker bestaat niet";
}

ob_end_flush();
}

include_once('footer.php');

?>
</body>
</html>



