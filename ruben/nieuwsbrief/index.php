<?php
	require_once "incl/mailman.php";
	require_once "incl/config.php";
	
	$mm = new Mailman($_adminurl,$_list,$_adminpw);
	$members=$mm->members();
	print_r($members);
	echo count($members[0]);
?>