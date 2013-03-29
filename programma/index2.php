<?
//wordt niet gebruikt

$user="chiroschel";
$password="MG0310";
$database="chiroapps";
$host="localhost";
$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
mysql_select_db($database) or die('Cannot select database');
$query = "SELECT DISTINCT datum FROM programma ORDER BY id DESC ";
$result = mysql_query($query) or die('Error, query failed');		  
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
echo '<a href="uitlezen.php?dag='.$row['datum'].'">'.$row['datum'].'</a><br />';
}




$_GET['ref'] = $ref
$_GET['actie'] = $actie

if ($ref != ''){
if ($actie == 'uitlezen'
{
echo '<form name="selecteer" method="get"><select name="dag">';
$query = "SELECT DISTINCT datum FROM programma ORDER BY id DESC ";
$result = mysql_query($query) or die('Error, query failed');		  
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
echo '<option id="'.$row['datum'].'">'.$row['datum'].'</option>';
}
echo '</select><input type="submit" /></form>';

$dag = $_GET['dag'];

echo $dag;
		  
$query = "SELECT id,afdeling,datum,programma,invoerder FROM programma WHERE datum LIKE '".$dag."' ORDER BY afdeling ASC ";

$result = mysql_query($query) or die('Error, query failed');

// if the guestbook is empty show a message
if(mysql_num_rows($result) == 0)
{

echo '<p><br><br>Nog geen programma toegevoegd </p>'

}
else
{
// get the entries
//while($row = mysql_fetch_array($result))
//{
// list() is a convenient way of assign a list of variables
// from an array values
#list($id, $afdeling, $datum, $programma, $naam) = $row;


//$query  = "SELECT  FROM programma";
//$result = mysql_query($query);

echo '<table border="1">';
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
$programma = htmlspecialchars($row['programma']);
$programma = nl2br($programma);

$afdeling = $row['afdeling'];

switch ($afdeling) {
case 0:
    $afdeling = '';
    break;
case 1:
   $afdeling = 'Ribbel Jongens';
    break;
case 2:
    $afdeling = 'Ribbel Meisjes';
    break;
	case 3:
	$afdeling = 'Speelclub Jongens';
    break;
	case 4:
	$afdeling = 'Speelclub Meisjes';
    break;
	case 5:
	$afdeling = 'Rakkers';
    break;
	case 6:
	$afdeling = 'Kwiks';
    break;
	case 7:
	$afdeling = 'Toppers';
    break;
	case 8:
	$afdeling = 'Tippers';
    break;
	case 9:
	$afdeling = 'Kerels';
    break;
	case 10:
	$afdeling = 'Tiptiens';
    break;
	case 11:
	$afdeling = 'Aspi Jongens';
    break;
	case 12:
	$afdeling = 'Aspi Meisjes';
    break;

}



echo '<tr><td>'.$afdeling.'</td><td>'.$programma.'</td></tr>';
/*
<table>
<tr><td>ID :</td><td>'.$row['id'].'</td></tr>
<tr><td>Afdeling :</td><td>'.$afdeling.'</td></tr>
<tr><td>Datum :</td><td>'.$row['datum'].'</td></tr>
<tr><td>Programma :</td><td>'.$programma.'</td></tr>
<tr><td>Ingevoerd door :</td><td>'.$row['invoerder'].'</td></tr>
<hr />
</table><br />';*/
}
}

mysql_close($verbind);  

}