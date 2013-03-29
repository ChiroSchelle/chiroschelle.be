<?php

#setup functions
add_theme_support( 'post-thumbnails' );
// show admin bar only for admins
if (!current_user_can('manage_options')) {
	add_filter('show_admin_bar', '__return_false');
}

register_sidebar( array(
	'id'          => 'top-login',
	'name'        => __( 'Login', $text_domain ),
	'description' => __( 'Deze sidebar is in de schuifbalk bovenaan de pagina', $text_domain ),
));

register_sidebar( array(
	'id'          => 'bottom-left',
	'name'        => __( 'Links onder', $text_domain ),
	'description' => __( 'This sidebar is located above the age logo.', $text_domain ),
));

register_sidebar( array(
	'id'          => 'bottom-middle',
	'name'        => __( 'midden onder', $text_domain ),
	'description' => __( 'This sidebar is located above the age logo.', $text_domain ),
));

register_sidebar( array(
	'id'          => 'bottom-right',
	'name'        => __( 'rechts onder', $text_domain ),
	'description' => __( 'This sidebar is located above the age logo.', $text_domain ),
));



function register_my_menus() 
{
	register_nav_menus(
		array( 'header-menu' => __( 'Header Menu' ) )
	);
}
add_action( 'init', 'register_my_menus' );




/**
 * db_filter_values()
 * Replace the default values with ones better suited
 */
function db_filter_values( $replace ) 
{
	$replace['%description%'] = nl2br( $user->description );
	return $replace;
}
add_filter( 'pab_replace_values', 'db_filter_values' );

function copyright()
{
	$date = (date(Y) == '2012' ? '&copy; MK Chiro Schelle 2012' : '&copy; MK Chiro Schelle 2012 - '.date(Y));

	return '<h2 class="widgettitle">Over de site</h2><ul><li>' . $date . '</li><li>Gemaakt door <a href="http://www.jasperdesmet.be">Jasper De Smet</a></li></ul>';
}

?>