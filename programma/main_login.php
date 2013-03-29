<?php
ob_start(); 
include_once('header.php'); 


?>
</body>
<head><title>Inloggen</title></head>
<body>
<?php
if(isset($_SESSION['naam'])){
echo 'u bent al ingelogd. <a href="./logout.php?ref=main_login">Uitloggen.</a>';
}
else {
	?>

<form name="form1" method="post">
<table id="login">
<tr>
<th colspan="2"><strong>Inloggen </strong></td>
</tr>
<tr>
<th class="spec">Naam</th>
<td ><input name="myusername" type="text" id="myusername"></td>
</tr>
<tr>
<th class="specalt">Wachwoord</th>
<td class="alt"><input name="mypassword" type="password" id="mypassword"></td>
</tr>
<tr>
<th colspan="2"><input type="submit" name="btnLogIn" value="Login"></th>
</tr>
<tr>
<td class="spec" colspan="2"><input type="checkbox" name="remember" checked />remember me</th>
</tr>
</table>
<p style="text-align:left"><a href="newpwd.php">Wachtwoord vergeten?</a></p>
<p style="text-align:left"><a href="username.php">Gebruikersnaam vergeten?</a></p>
</form>

<?php
if (isset($_POST['btnLogIn'])){
$tbl_name="users"; // Table name
include_once "config.php";
// Connect to server and select databse.
mysql_connect("$host", "$user", "$password")or die("cannot connect");
mysql_select_db("$database")or die("cannot select DB");

// Define $myusername and $mypassword
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$mypassword = md5($mypassword);


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
if (isset($_POST['remember'])){
	$expire = time()+(60*60*24*365); //1 jaar geldig
	setcookie('user',$row['naam'],$expire);
	setcookie('pwd',$row['pwd'],$expire);
	ob_end_flush();
}
}

//header("location:uitlezen.php");
$ref =$_GET['ref'];
echo $ref;
if ($ref == ""){
	echo '<meta http-equiv="refresh" content="0; url=./uitlezen.php">';
}
else {
	echo  '<meta http-equiv="refresh" content="0; url=./'.$ref.'.php">';
}
}
else {
echo "Wrong Username or Password";
}

ob_end_flush();
}

}
include_once('footer.php');

?>




