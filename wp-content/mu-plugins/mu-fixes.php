<?php
// some fixes to a mu-installation

// allow 404-pages on existing sites when using NOBLOGREDIRECT
// http://frumph.net/wordpress/wordpress-3-0-multisite-subdomain-installation-noblogredirect-behavior-fix/
remove_action( 'template_redirect', 'maybe_redirect_404' );

/**
* Don't display admin toolbar if user isn't super admin
**/

function my_show_admin_bar(){
	if ( current_user_can('manage_network_options') ) {
		return true;
	}
	else {
		return false;
	}
}
add_filter( 'show_admin_bar' , 'my_show_admin_bar');

add_action( 'admin_print_scripts-profile.php', 'hide_admin_bar_prefs' );
function hide_admin_bar_prefs() {
	if ( ! current_user_can('manage_network_options') ) {
?>
	<style type="text/css">
	    .show-admin-bar { display: none; }
	</style>
<?php
	}
}

/**
* Ensure that new users are registered to the main blog
* see http://wordpress.org/support/topic/adding-all-new-users-to-main-site
**/
function chiro_activate_user( $user_id, $password, $meta )
{
    
    add_user_to_blog( '1', $user_id, get_site_option( 'default_user_role', 'subscriber' ) );
}
add_action( 'wpmu_activate_user', 'chiro_activate_user', 10, 3 );


?>
