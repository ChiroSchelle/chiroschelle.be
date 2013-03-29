<?php
include_once('header.php');
include_once('functions.php');
include_once('config.php');
?>
</body><head><title>Registreren</title></head>
<body>
<?php
if(session_is_registered(myusername)){
echo 'U Bent al geregistreerd';
}
else{
	?>


<form name="register" method="post" >

<table id="login">
<tr>
<th colspan="2"><strong>Gebruiker Toevoegen </strong></th>
</tr>
<tr>
<th class="spec">Naam:</th>
<td ><input name="naam" type="text" id="myusername"></td>
</tr>
<tr><th class="specalt">E-mail</th><td class="alt"><input type="text" name="email" /></td></tr>
<tr>
<th class="spec">Wachtwoord:</th>
<td><input name="pwd" type="password" id="mypassword"></td>
</tr>
<tr><th class="specalt">bevestig wachtwoord:</th><td class="alt"><input type="password" name="pwd2"  /></td></tr>
<tr>
<th class="spec">Afdeling</th><td class="alt">
    <select name="afdeling" id="afdeling">
     <option value="0">Kies je afdeling</option>
      <option value="1">Ribbel Jongens</option>
      <option value="2">Ribbel Meisjes</option>
      <option value="3">Speelclub Jongens</option>
      <option value="4">Speelclub Meisjes</option>
      <option value="5">Rakkers</option>
      <option value="6">Kwiks</option>
      <option value="7">Toppers</option>
      <option value="8">Tippers</option>
      <option value="9">Kerels</option>
      <option value="10">Tiptiens</option>
      <option value="11">Aspi Jongens</option>
      <option value="12">Aspi Meisjes</option>
      <option value="14">Leiding</option>
      <option value="15">Muziekkapel</option>
             
    </select></td>
    </tr>
<tr>

<th colspan="2" class="alt"><input type="submit" name="btnVerstuur" value="register"></th>
</tr>
</table>


</form>

<?php

if(isset($_POST['btnVerstuur']))
{

	

	$verbind = mysql_connect("$host","$user","$password") or die ("could not connect");
	mysql_select_db("$database") or die('Cannot select database');




   $naam    = trim($_POST['naam']);
   $afdeling   = trim($_POST['afdeling']);
   $pwd     = trim($_POST['pwd']);
   $level = 1;
   $pwd2 = trim($_POST['pwd2']);
   $email = trim($_POST['email']);
   
   	
   if ($naam=="") {
   	echo '<div class="error">Je hebt je naam niet ingevuld!<br /></div>';
   	$error=true;
   }
   if ($afdeling =="0")  {
   echo '<div class="error">Je hebt geen afdeling gekozen <br /></div>';
   $error = true;
   }
   if ($pwd == "") {
   echo '<div class="error">Je hebt geen wachtwoord ingevuld!<br /></div';
   $error = true;
   }
   if (checkEmail($email)==false) {
   	echo '<div class="error">Je E-mailadres bestaat niet!</div>';
   	$error = true;
   }
   elseif  ($pwd != $pwd2) {
   	echo 'div class="error">Je twee wachtwoorden zijn niet identiek!</div>';
   	$error=true;
   }
   if (($naam != "")&&($pwd != "")&&($afdeling!=0)&&($pwd==$pwd2)&&(checkEmail($email)==true)) $error=false;
   $nmd5=$pwd;
   $pwd = md5($pwd);
  if ($error == false) {
   $sql="SELECT * FROM users WHERE naam='$naam'";
  $result=mysql_query($sql);

// Mysql_num_row is counting table row
 $count=mysql_num_rows($result);
 //$count = mysql_numrows($result);
 //echo $count;
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==0){
   $query = "INSERT INTO users (   naam,
                                    pwd,
                                    afdeling,
                                    level,
                                    email)
             VALUES ( '$naam',
                     '$pwd',
                     '$afdeling',
                     '$level',
                     '$email')";

   mysql_query($query) or die('Error, query failed');
  
mysql_close($verbind); 
$bericht = "Beste,
Welkom op chiroschelle.be, dit zijn je gegevens:
naam: $naam
email: $email
wachtwoord: $nmd5
";
sendmail($naam,$email,'Je registratie op Chiroschelle.be',$bericht,"");
  // header("location:main_login.php");
  echo '<meta http-equiv="refresh" content="0; url=./main_login.php">';
   exit;
}
else {
	echo '<div class="error">Deze gebruiker bestaat al</div>';
}
}
}
}
include_once('footer.php');
?>