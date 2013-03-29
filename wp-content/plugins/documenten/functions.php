<?php

function documenten_update_options($documenten_options){
	$ok = false;
	update_option('documenten_options',$documenten_options);
	$ok = true;

	if ($ok){
		?><div id="message" class="updated fade"><p>Opties opgeslagen</p></div> <?php
	}else {
		?><div id="message" class="error fade"><p>Opties niet opgeslagen</p></div> <?php
	}

}
function documenten_splits($str){
	$array = explode("\n", $str);
	return $array;

}

function documenten_get_image($ext){
	$ext = strtolower($ext);
	switch ($ext){
		default:
			if (file_exists(WP_CONTENT_DIR . '/plugins/documenten/images/'. $ext . '.ico')){
				$img = plugins_url('images/'. $ext . '.ico', __FILE__);
			}else {
				$img = plugins_url('images/default.png', __FILE__);
			}

	}
	return $img;
}

?>
