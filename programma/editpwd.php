<?php include_once('header.php') ;
include_once('config.php');
if(!isset($_SESSION['naam'])){
echo 'U bent niet ingelogd!';
}
else {

	if (isset($_POST['btnLogIn'])){
		$tbl_name = "users";
		$verbind = mysql_connect($host,$user,$password)or die("can't connect");
		mysql_select_db("$database")or die("cannot select DB");
		$naam = $_SESSION['naam'];
		$pwd1 = $_POST['pwd1'];
		$pwd2 = $_POST['pwd2'];
		if ($pwd1!=$pwd2){echo '<div class="error">Je Hebt niet tweemaal hetzelfde wachwoord ingegeven</div';}
		else {
		$sql="SELECT * FROM ".$tbl_name." WHERE naam LIKE'".$naam."'";
		$result=mysql_query($sql) or die ("wtf1");

// Mysql_num_row is counting table row
		$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

		if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
		$newpwd =$pwd1;
		$md5pwd = md5($newpwd);

		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		
		$id = $row['id'];
		}
	$sql="UPDATE users SET pwd ='".$md5pwd."' WHERE id ='".$id."'";
	$result = mysql_query($sql) or die('wtf?');
	
	echo '<div class="error">Wachwoord succesvol aangepast!</div>';
		}else {echo '<div class="error">Er ging iets mis!</div>';}
		}
	}	
?>
<form name="form1" method="post">
<table id="login">
<tr>
<th colspan="2"><strong>Wijzig je wachtwoord </strong></td>
</tr>
<tr>
<th class="spec">Naam</th>
<td ><?php echo $_SESSION['naam'];?></td>
</tr>
<tr><td>Nieuw Wachtwoord</td><td><input type="password" name="pwd1" /></td>
</tr>
<tr><td>Bevestig Wachtwoord</td><td><input type="password" name="pwd2"/></td>
</tr>
<th colspan="2"><input type="submit" name="btnLogIn" value="Wijzig Wachtwoord"></th>
</tr>
</table>
</form>

<?php





}

include_once('footer.php');

?>
</body>
</html>



