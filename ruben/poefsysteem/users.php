<? include('header.php');
if(isset($user)){

if(!isset($_GET['action'])){
?>
<h2>Kies een actie uit deze lijst:</h2>
<ul>
<li><a href="<? echo $_SERVER['SCRIPT_NAME'] . "?action=3" ?>">Zie gebruikers</a></li>
<li><a href="<? echo $_SERVER['SCRIPT_NAME'] . "?action=1" ?>">Voeg gebruiker toe</a></li>
<li><a href="<? echo $_SERVER['SCRIPT_NAME'] . "?action=2" ?>">Delete gebruiker</a></li>
</ul>
<? }
elseif($_GET['action'] == 1){
?>
<h2>Een gebruiker toevoegen</h2>
<form action="users_proces.php?action=1"  method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
Rank: 
<select name="rank">
<option value=0>Gebruiker</option>
<option value=1>Drankverantwoordelijke / admin</option>
</select><br>
<input type="submit">
</form>
<? }
elseif($_GET['action'] == 2){
?>
<h2>Een gebruiker verwijderen</h2>

<form action="users_proces.php?action=2" method="post">
<select>
<?
$qry = mysql_query("SELECT * FROM members");

while($row = mysql_fetch_array($qry)){
	if($row['username'] == $_SESSION['username']){
		continue;
	}
	?>
	<option value="<? echo $row['id'] ?>"><? echo $row['username']?></option><br>
<? } ?>
</select>
<input type="submit" value="Verwijder">
</form>
<? }
elseif($_GET['action'] == 3){
?>
<table width="60%" border-style="solid" border-width="1px">
<tr>
<td>Gebruiker</td>
<td>Poef</td>
</tr>
<?
$qry = mysql_query("SELECT * FROM members");
	while($row = mysql_fetch_array($qry)){
		echo "<tr><td>";
		echo $row['username'];
		echo "</td><td>";
		echo $row['bedrag'];
		echo "</td></tr>";
	}
?>
</table>
<? }
}
else{
echo "U moet ingelogt zijn voor deze pagina"; 
}
?>
</body>
</html>
