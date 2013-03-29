
<html>
<body>
<h1>Ruben Mennes</h1>
<br>
Kies uit de onderstaande lijst een project:
<ul>
<?php

#give all forlder
#################
$dir = "./";

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == ".." || $file == ".")continue;
	    if (is_dir($file)){ ?>
	    <li><a href="<? echo $file ?>"><? echo str_replace("-", " ", $file)  ?></a></li>
	    <? }
	    }
        }
        closedir($dh);
    }

?>
</ul>
</body>
</html>
