<?php
include_once('header.php');
include_once './functions.php';
include("config.php");
?>
<form action="" method="post" name="archief">
<h3>Zoek in het archief (vanaf 2008-2009)</h3>
<table>
<tr><td>Afdeling</td><td>
<select name="afdeling">
  <option>Kies een afdeling</option>
  <option value="1">ribbel jongens</option>
  <option value="2">ribbel meisjes</option>
  <option value="3">speelclub jongens</option>
  <option value="4">speelclub meisjes</option>
  <option value="5">rakkers</option>
  <option value="6">kwiks</option>
  <option value="7">toppers</option>
  <option value="8">tippers</option>
  <option value="9">kerels</option>
  <option value="10">tiptiens</option>
  <option value="11">aspi jongens</option>
  <option value="12">aspi meisjes</option>
  <option value="13">iedereen</option>
  <option value="14">leiding</option>
  <option value="15">muziekkapel</option>
  <option value="16">tikeas</option>
  <option value="17">activiteiten</option>
</select></td></tr>
<tr><td>begin datum (YYYY-MM-DD)</td><td><input name="start" type="text" maxlength="10" /></td></tr>
<tr><td>eind datum (YYYY-MM-DD)</td><td><input name="stop" type="text" maxlength="10" /></td></tr>
<tr><td colspan="2"><input name="submit" type="submit" value="Archief Bekijken" /></td></tr>
</table>
<p style="text-align:left"><a href="http://www.chiroschelle.net/chirolalala/Programma.htm">programma 2007- 2008 (chirolalala)</a><br />
  <a href="http://www.chiroschelle.net/geksentriek/Programma.htm">programma 2006 - 2007 (geksentriek)</a><br />
  <a href="http://www.chiroschelle.net/verdraaidewereld/Programma.htm">programma 2005 - 2006 (verdraai de wereld)</a><br /> 
  <a href="http://www.chiroschelle.net/natuurleuk/Programma.htm">programma 2004 - 2005 (natuurleuk)</a><br /> 
  <a href="http://www.chiroschelle.net/plays2b/Programma.htm">programma 2003 - 2004 (play's 2 b)</a><br />
  <a href="http://www.chiroschelle.net/Speelgoed/Programma.htm">programma 2002 - 2003 (speelgoed)</a><br />
  <a href="http://www.chiroschelle.net/Zindering/Programma.htm">programma 2001 - 2002 (zindering)</a><br />
</p>
</form>
<br /><hr /><br />
<?php

$velden = array ("start","stop","afdeling");
	foreach($velden as $waarde)
	{
		if(array_key_exists($waarde, $_POST))
			$data[$waarde] = trim($_POST[$waarde]);
		else
			$data[$waarde] = "";
	}
	

if (isset($_POST['submit'])){
	if ($data['afdeling']) {$afdeling = "afdeling = '".$data['afdeling']."'";
		if ($data['start']) {$start = "AND datum >= '".$data['start']."'";}
		if ($data['stop']) {$stop = "AND datum <= '".$data['stop']."'";}
		$query = "SELECT * FROM programma WHERE $afdeling $start $stop";
	} else {
		if ($data['start']) {
			$start = "WHERE datum >= '".$data['start']."'";
			if ($data['stop']) {$stop = "AND datum <= '".$data['stop']."'";}
			$query = "SELECT * FROM programma $start $stop";
		} else{
			if ($data['stop']) {$stop = "WHERE datum <= '".$data['stop']."'";}
			$query = "SELECT * FROM programma $stop";
		}
	}
	$verbind = mysql_connect($host,$user,$password) or die ("could not connect");
	mysql_select_db($database) or die('Cannot select database');
	$result = mysql_query($query);
	echo "<h3> Programma voor ".maaknummerafdeling($data['afdeling'])." van ".$data['start']." tot ".$data['stop']."</h3>";
	echo "<table><tr>
	<th>datum</th><th>programma</th></tr>";
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		?><tr><td><?php echo $row['datum']; ?></td><td><?php echo nl2br($row['programma']); ?></td></tr><?php
	}
	echo "</table>";	
}
?>


		
	
