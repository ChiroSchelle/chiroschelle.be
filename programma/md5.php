<form method="POST">
<input type="text" name="string" action="md5.php" />
<button type="submit" name="md5" value="md5" />
</form>
<?php
if (isset($_GET['md5'])) {
	$string = $_GET['string'];
	echo md5($string);
}