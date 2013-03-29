<?php
//include 'config.php';

$user="chiroschel";
$password="MG0310";
$database="chiroapps";
$host="localhost";

$verbind = mysql_connect($host,$user,$password) or die ("could not connect");

/*
Uit welke database wil je de tabellen ophalen.
*/

//$tabellen = mysql_list_tables( $database);

/*
Tellertje en loop om de tabellen te tonen.
*/
/*
$i=0;
while ($i < mysql_num_rows($tabellen)){
    $t_name[$i] = mysql_tablename ($tabellen, $i);
    echo $t_name[$i]. "<br>";
    $i++;
}  
*/

mysql_select_db($database) or die('Cannot select database');

//$query = 'select * from programma';
//$result = mysql_query($query);

$query  = "SELECT * FROM programma";
$result = mysql_query($query);

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
    echo "ID :".$row['id']." <br>
         Afdeling : ".$row['afdeling']."<br>
         Datum : ".$row['datum']." <br>
		 Programma : ".$row['programma']." <br>
		 Ingevoerd door : ".$row['invoerder']." <br /><br />";
}




mysql_close($verbind);  
?>