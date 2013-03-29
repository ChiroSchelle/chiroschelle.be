<?php include_once('header.php') ?>

<form name="form1" method="post">
<table id="login">
<tr>
<th colspan="2"><strong>Vraag je gebruikersnaam op</strong></td>
</tr>
<tr>
<th class="spec">emailadres:</th>
<td ><input name="myusername" type="text" id="myusername"></td>
</tr>
<th colspan="2"><input type="submit" name="btnLogIn" value="Stuur mij mijn gebruikersnaam"></th>
</tr>
</table>
</form>

<?php
include_once('config.php');
include_once('functions.php');
//include_once('mail.php');
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
$email=$_POST['myusername'];

// To protect MySQL injection (more detail about MySQL injection)
//$email = stripslashes($email);
//$email = mysql_real_escape_string($email);


$sql="SELECT * FROM $tbl_name WHERE email LIKE '$email'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count>=1){
// Register $myusername, $mypassword and redirect to file "login_success.php"



while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
$email = $row['email'];
$naam = $row['naam'];

$bericht="Beste $naam,

Je was blijkbaar je gebruikersnaam vergeten.
Je gebruikersnaam is '$naam'.
";
sendmail($naam,$email,"Je gebruikersnaam",$bericht);

}
echo "Er is een mail verstuurd naar $email met je gebruikersnaam.";
}
else{
	
echo "Dit emailadres is niet aan een gebruiker gekoppeld";
}


}

include_once('footer.php');

?>
</body>
</html>



