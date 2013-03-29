<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists("Shiba_Media_Library_2_9")) :

class Shiba_Media_Library_2_9 {


	function init_admin_2_9() {
		global $shiba_mlib;

		// Handle permalink for add new gallery screen
		add_filter('get_sample_permalink_html', array(&$shiba_mlib->permalink_obj,'filter_sample_permalink'), 10, 4); 

		// Gallery find_posts_div - run by admin-ajax function
		add_action( 'wp_ajax_shiba_find_posts', array(&$shiba_mlib->ajax,'ajax_library_actions') );

		// This is necessary for the links on 'gallery' type objects to show properly
		add_filter('get_edit_post_link', array(&$this,'get_edit_gallery_link'), 10, 3);
		add_filter('get_delete_post_link', array(&$this,'get_delete_gallery_link'), 10, 3);

		if (strpos($_SERVER["REQUEST_URI"], "wp-admin/upload.php") === FALSE)
			return;

		// Dealing with the display of non-attachment object types in shiba-mlib-new menu
		add_filter('get_attached_file', array(&$this,'get_attached_file'), 10, 2); 	
	}

	function add_pages() {
		global $shiba_mlib;
		
		// Add a new submenu under Options:
		$shiba_mlib->add_gallery = add_media_page('Add Gallery', 'Add Gallery', 'administrator', 'shiba_add_gallery', array(&$this,'add_gallery_page') );
		$shiba_mlib->manage_gallery = add_media_page('Manage Gallery', 'Manage Gallery', 'administrator', 'shiba_manage_gallery', array(&$this,'manage_gallery_page') );
		$shiba_mlib->media_tools = add_media_page('Media Tools', 'Media Tools', 'administrator', 'shiba_media_tools', array(&$this,'media_tools_page') );
		add_action("admin_print_styles-{$shiba_mlib->add_gallery}", array(&$this,'add_gallery_admin_styles') );
		add_action("admin_print_scripts-{$shiba_mlib->add_gallery}", array(&$this,'add_gallery_admin_scripts') );
		add_action("load-{$shiba_mlib->add_gallery}", array(&$this, 'add_gallery_on_load'));	
	}

	function manage_gallery_page() {
		include('shiba-mlib-manage.php');
	}
	
	
	function add_gallery_page() {
		include('shiba-mlib-new.php');
	}

	function media_tools_page() {
		include('shiba-mlib-controls.php');
	}
	
	function add_gallery_admin_styles() {
		wp_enqueue_style('thickbox'); // needed for thumbnail meta box
	}
	
	function add_gallery_admin_scripts() {
		wp_enqueue_script('thickbox'); // needed for thumbnail meta box
		add_filter('screen_layout_columns', array(&$this,'add_gallery_num_columns'), 10, 2);
	}

	function add_gallery_on_load() {
		global $shiba_mlib;

		require_once('includes/meta-boxes.php');
			
		add_meta_box(	'tagsdiv-post_tag', __('Gallery Tags'), 
						array(&$shiba_mlib->tag_metabox,'post_tags_meta_box'), $shiba_mlib->add_gallery, 'side', 'core'); 
		add_meta_box('categorydiv', __('Categories'), 'post_categories_meta_box', $shiba_mlib->add_gallery, 'side', 'core');
		if ( (isset($_GET['gallery']) && $_GET['gallery']) || (isset($_GET['post_id']) && $_GET['post_id']) ) 
			if ( function_exists('current_theme_supports') ) //&& current_theme_supports( 'post-thumbnails', 'post' ) )
				add_meta_box('postimagediv', __('Post Thumbnail'), 'post_thumbnail_meta_box', $shiba_mlib->add_gallery, 'side', 'low');
		//add_meta_box('postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', 'gallery', 'side', 'core');	
	}
	 
	function add_gallery_num_columns($columns, $screen) {
		global $shiba_mlib;
		if ($screen == $shiba_mlib->add_gallery) {
			$columns[$shiba_mlib->add_gallery] = 2;
		}
		return $columns;
	}


	// For the manage gallery menu page
	function get_attached_file($file, $attachment_id) {
		if (!isset($_GET['page']) || (!$_GET['page'] == 'shiba_manage_gallery')) return $file;
		$obj = get_post($attachment_id);
		if (!$obj) return $file;
		switch ($obj->post_type) :
		case 'attachment':
			return $file;
		default:
			return $obj->post_type;
		endswitch;	
	}	
	/*
	 * Helper functions for the Manage Gallery menu.
	 *
	 * shiba-mlib-manage.php
	 *
	 */	 
	function get_delete_gallery_link($url = '', $id, $context = 'display') {
		// There is a bug in the wordpress core get_delete_post_link function. One of the calls to apply_filters get_delete_post_link
		// only contains TWO arguments (with no post->id argument) instead of THREE.
		if ($url) return $url;
		if ( !$post = &get_post( $id ) )
			return;
	
		if ( 'display' == $context )
			$action = 'action=trash&amp;';
		else
			$action = 'action=trash&';
		
		switch ( $post->post_type ) :
		case 'gallery':
			if ( !current_user_can( 'delete_post', $post->ID ) )
				return;
			$file = 'post';
			$var  = 'post';
			$url = admin_url("$file.php?{$action}$var=$post->ID");
			
			return apply_filters( 'get_delete_gallery_link', wp_nonce_url($url, "trash-{$file}_" . $post->ID), $context );		
			break;
		default:
			return $url;	
		endswitch;
	
	}		
	
	
	function get_edit_gallery_link( $url = '', $id = 0, $context = 'display' ) {
	
		if ( !$post = &get_post( $id ) )
			return;
	
		if ( 'display' == $context )
			$action = '&amp;action=editgallery&amp;';
		else
			$action = '&action=editgallery&';
	
		switch ( $post->post_type ) :
		case 'gallery' :
			if ( !current_user_can( 'edit_post', $post->ID ) )
				return;
			$file = 'upload';
			$var  = 'gallery';
			return apply_filters( 'get_edit_gallery_link', admin_url("$file.php?page=shiba_add_gallery{$action}$var=$post->ID"), $post->ID, $context );		
			break;
		default:
			return $url;	
		endswitch;
	
	}
} // end Shiba_Media_Library_2_9 class
endif;
?>