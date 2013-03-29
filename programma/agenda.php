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

<?php
include_once './functions.php';
include("config.php");
$session = $_SESSION;
#haal info uit url

$nu = time();
	$vandaag = date('Y-m-d',$nu);
	$dag = maaktweecijfer($dag);
	$maand = maaktweecijfer($maand);

	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');
	$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE (afdeling LIKE '17' OR afdeling LIKE '13')  AND datum >= '$vandaag' ORDER BY datum ASC ";
	$result = mysql_query($query) or die('Error, query failed');
	if(mysql_num_rows($result) == 0){
		?>
		<p><br><br />Er zijn nog geen activiteiten gepland </p>
		<?php
	}
	else{
		?>
		<table id="programma" cellspacing="0" summary="Het programma">
		<!--<caption>programma voor <?php echo $dag.'/'.$maand.'/'.$jaar ; ?> </caption> -->
		<tr>
		<th class="nobg"><?php echo maaknummerafdeling(17); ?></th>
		<th colspan="2">Programma</th>
		</tr>

		<?php 
		$even = false;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$programma = htmlspecialchars($row['programma']);
			$programma = nl2br($programma);
			$datum = $row['datum'];
			$splits = explode("-",$datum);
			$jaar = $splits[0]; 
			$maand = $splits[1];
			$dag = $splits[2];
			$afdeling = $getafdeling;
			$txtafdeling = maaknummerafdeling($afdeling);
				if ($even == false){
					?>
					<tr><th class="spec"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th><td><?php echo $programma;?>
					</td></tr>
					<?php
					$even = true;
				}
				else{
					?>
					<tr><th class="specalt"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th><td><?php echo $programma;?>
					</td></tr>
					<?php
					$even = false;
				}
			}
	}

	mysql_close($verbind);  
	?>
	</table>
