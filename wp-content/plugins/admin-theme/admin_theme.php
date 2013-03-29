<?php
/*
Plugin Name: Admin-Thema Chiro Schelle
Plugin URI: http://chiroschelle.be
Description: Chiro Schelle thema voor de admin-kant
Author: Mante Bridts
Version: 1.0
Author URI: mantebridts@gmail.com
*/
function admin_css_link() {
    $url = get_option('siteurl');
    $url = $url . '/wp-content/plugins/admin-theme/wp-admin-chiroschelle.css';
	echo '<link rel="stylesheet" type="text/css" href="' . $url . '"/>';
}
add_action('admin_head', 'admin_css_link');
?>