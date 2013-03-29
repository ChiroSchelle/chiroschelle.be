<?php
	require_once 'nieuwsbrief/classes.php';
	require_once 'nieuwsbrief/functions.php';
    $brief = (unserialize(base64_decode($_POST['nieuwsbrief'])));
	echo $brief->getHTML();
?>