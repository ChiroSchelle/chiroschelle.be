<?php

if (isset($_GET['folder'])){
	$folder = $_GET['folder'];
}else {
	$folder = '';
}
if (isset($_GET['prev'])){
	$prev = $_GET['prev'];
}else {
	$prev = '/';
}


$documenten_options = get_option('documenten_options');
$dir = WP_CONTENT_DIR . '/uploads/documenten/' . $folder . '/';

$url = get_bloginfo('url') . '/wp-content/uploads/documenten/' . $folder . '/';



if (file_exists($dir)){
	if ($handle = opendir($dir)) {

	    /* This is the correct way to loop over the directory. */
	    $i = 0;
	    while (false !== ($file = readdir($handle))) {
	    	if ($file != "." && $file != "..") {
		        $files[$i] = $file;
		        $i ++;
	    	}
	    }
	}
	if ($files){
	sort($files);}

}



?>
<div id="wrap">
<h2>Documenten: <?php if ($folder != "" && $folder != "/" && $folder != "."){echo $folder;} ?></h3>






<?php
if (isset($files)){
	echo '<p><ul>';
	if ($folder != '/' && $folder != '' && $folder != "."){
		echo "<li><a href='?page=documenten-submenu-andere&folder=".dirname($folder) . "'>.. map hoger</a></li>";
	}
	foreach ($files as $f){
		$fileurl = $url . $f;
		$filename = $dir . $f;
		$kB = round(filesize($filename) / 1024, 1);

		if (!is_dir($filename)){
			$pathinfo = pathinfo($f);
			$ext = $pathinfo['extension'];
			$img = documenten_get_image($ext);


			echo "<li><img src='$img' /> <a href='$fileurl'>$f</a> ($kB kB)</li>";
		}else {
			$img = documenten_get_image('dir');
			if ($folder != '/' && $folder != ''){
				echo "<li><img src='$img' width='16px' height='16px' /> <a href='?page=documenten-submenu-andere&folder=$folder/$f'>$f</a> (map)</li>";
			}else {
				echo "<li> <img src='$img' width='16px' height='16px' /> <a href='?page=documenten-submenu-andere&folder=$f'>$f</a> (map)</li>";
			}

		}
	}
	echo '</ul></p>';
}else{
	?>
	<div class="error">Deze map is leeg. Ga <a href="?page=documenten-submenu-andere&folder=<?php echo dirname($folder); ?>">een map hoger</a></div>
	<?php
}

  ?>

  </div>