<!-- wordt niet gebruikt -->
<?php
/*$host="localhost"; // Host name
$username="chiroschel"; // Mysql username
$password="MG0310"; // Mysql password
$db_name="ChiroApps"; // Database name
$tbl_name="users"; // Table name
*/
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
echo $mypassword;

$sql="SELECT * FROM $tbl_name WHERE naam='$myusername' and pwd='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
session_register("myusername");
session_register("mypassword");
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
$_SESSION['naam'] = $row['naam'];
$_SESSION['afdeling'] = $row['afdeling'];
$_SESSION['level'] = $row['level'];
}
header("location:invoeren.php");
}
else {
echo "Wrong Username or Password";
}

ob_end_flush();
?>



