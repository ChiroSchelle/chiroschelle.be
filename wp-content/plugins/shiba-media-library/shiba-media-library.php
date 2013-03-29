<?php
/*
Plugin Name: Shiba Media Library
Plugin URI: http://shibashake.com/wordpress-theme/media-library-plus-plugin
Description: This plugin enhances the existing WordPress Media Library; allowing you to easily attach and reattach images as well as link an image to multiple galleries by using tags.
Version: 3.0
Author: ShibaShake
Author URI: http://shibashake.com
*/


/*  Copyright 2009  ShibaShake 

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );


define( 'SHIBA_MLIB_DIR', WP_PLUGIN_DIR . '/shiba-media-library' );
define( 'SHIBA_MLIB_URL', WP_PLUGIN_URL . '/shiba-media-library' );


// Load helper functions
require_once(SHIBA_MLIB_DIR."/shiba-mlib-parallel.php");
		

if (!class_exists("Shiba_Media_Library")) :


class Shiba_Media_Library {
	var $add_gallery, $manage_gallery, $media_tools, $library_menu, $tag_metabox, $ajax;
	var $wp30, $manage_3_0, $manage_2_9;
	var $query_args='';
	var $parallelize_obj, $permalink_obj;
	var $debug;
	
	function Shiba_Media_Library() {	
		$version = get_bloginfo('version');
		if (version_compare($version, '3', '>=')) $this->wp30  = TRUE;
		else $this->wp30  = FALSE;
		$this->debug = FALSE;

		if (class_exists("Shiba_Media_Parallelize")) 
   			$this->parallelize_obj = new Shiba_Media_Parallelize();	

		if ($this->wp30) { 
			require('shiba-mlib-permalink-3-0.php');
			if (class_exists("Shiba_Media_Permalink_3_0")) 
				$this->permalink_obj = new Shiba_Media_Permalink_3_0();	
				
		} else {
			require('shiba-mlib-permalink-2-9.php');		
			if (class_exists("Shiba_Media_Permalink_2_9"))  { 
				$this->permalink_obj = new Shiba_Media_Permalink_2_9();	}	
		}
		
		if (is_admin()) :
			if ($this->wp30) { 
				require('shiba-mlib-3-0.php');
				if (class_exists("Shiba_Media_Library_3_0")) {
					$this->manage_3_0 = new Shiba_Media_Library_3_0();	
					add_action('admin_menu', array(&$this->manage_3_0,'add_pages') );
				}		
			} else {
				require('shiba-mlib-2-9.php');		
				if (class_exists("Shiba_Media_Library_2_9")) {
					$this->manage_2_9 = new Shiba_Media_Library_2_9();		
					add_action('admin_menu', array(&$this->manage_2_9,'add_pages') );
				}
			}
		endif;	

		add_action('admin_init', array(&$this,'init_admin') );
		add_action('init', array(&$this,'init_general') );
		register_activation_hook( __FILE__, array(&$this,'activate' ) );
		register_deactivation_hook( __FILE__, array(&$this,'deactivate' ) );
	}
	
	function activate() {
		// Activate gallery permalink
		$this->permalink_obj->activate();
				
		// Media tools - parallelize images
		$wud = wp_upload_dir();
		add_option('image_domains', $wud['baseurl']);
		add_option('parallel_option', 'none');

	}


	function deactivate() {
    	global $wp_rewrite;
		$wp_rewrite->flush_rules();	
	}
	
	function init_admin() {

		require(SHIBA_MLIB_DIR.'/shiba-tag-metabox.php');
		if (class_exists("Shiba_Tag_Metabox"))
			$this->tag_metabox = new Shiba_Tag_Metabox();	

		require(SHIBA_MLIB_DIR.'/shiba-mlib-ajax.php');
		if (class_exists("Shiba_Media_Ajax"))
			$this->ajax = new Shiba_Media_Ajax();	
		
		if ($this->wp30) $this->manage_3_0->init_admin_3_0();
		else $this->manage_2_9->init_admin_2_9();
			
		// Filters for all admin pages
		add_filter('attachment_fields_to_edit', array(&$this,'attachment_fields_to_edit'), 10, 2);
		add_filter('attachment_fields_to_save', array(&$this,'attachment_fields_to_save'), 10, 2);

		// Register gallery permalink option in settings menu
		add_settings_field(	'gallery_structure', "Gallery Structure", array(&$this->permalink_obj, 'show_gallery_structure'), 
							'permalink', 'optional',
							array('label_for' => 'gallery_structure') );
		// This is a way to hook into a call to permalink save - for the case where only gallery base has changed
		add_filter('iis7_supports_permalinks', array(&$this->permalink_obj, 'set_gallery_structure') );
		// Need this to capture the case where permalink structure has changed
		add_action('permalink_structure_changed', array(&$this->permalink_obj, 'set_gallery_structure') );

		// AJAX support functions
		// Add attachment tags to tag box
		add_filter('sanitize_title', array(&$this->ajax,'tag_box_title'), 10, 2);   

			
		// Only activate these for the Media Library page
		if (strpos($_SERVER["REQUEST_URI"], "wp-admin/upload.php") === FALSE)
			return;

		// Register our script
		wp_register_script('mediaPlusScript', SHIBA_MLIB_URL . '/shiba-mlib.dev.js');
		wp_enqueue_script('mediaPlusScript');
		wp_enqueue_script('wp-ajax-response');
		wp_enqueue_script('post');

		require_once(SHIBA_MLIB_DIR.'/shiba-library-menu.php');
		if (class_exists("Shiba_Library_Menu"))
			$shiba_mlib->library_menu = new Shiba_Library_Menu();	
			 
		add_action('admin_head', array(&$shiba_mlib->library_menu,'library_header'), 51);
		add_action('restrict_manage_posts', array(&$shiba_mlib->library_menu,'library_expanded_menu') );	
		add_filter('wp_redirect', array(&$shiba_mlib->library_menu,'library_redirect'), 10, 2);

		// Adds tag column to the media library page
		add_filter('manage_media_columns', array(&$this,'add_admin_columns') );	
		add_action('manage_media_custom_column', array(&$this,'manage_admin_columns'), 10, 2);

		// Filter for expanded search - in media library and manage_gallery page
		add_filter('request', array(&$this,'expanded_media_search'));  // parse_request function
		add_filter( 'get_search_query', array(&$this, 'get_search_query') );
	}

	

	
	/*
	 * Media Plus initialization functions for general blog pages
	 *
	 * Handles drawing of gallery objects, as well as how to get gallery object contents using get_posts or query_posts.
	 *
	 */

	function init_general() {
		
		// mplus get_posts function [allows gallery objects to do grouping with tags]
		add_action('pre_get_posts', array(&$this,'get_posts_init') );
		add_filter('posts_results', array(&$this,'get_posts_filter') );	
		add_filter('found_posts', array(&$this,'found_posts_filter') );
		
		// Functions to properly show a gallery object in your blog
		add_filter('the_content', array(&$this,'process_gallery_content') );

		$this->permalink_obj->init();			
		
		if (is_admin()) return;
		$this->parallelize_obj->link_cache = array();
		$this->parallelize_obj->update_image_domains();
		add_filter('the_content', array(&$this->parallelize_obj,'get_parallel_content'), 98);
		add_filter('the_excerpt', array(&$this->parallelize_obj,'get_parallel_content'), 98);
		// From Shiba Gallery plugin
		add_filter('shiba_get_attachment_link', array(&$this,'filter_attachment_link'), 10, 2);
	}

	
	function print_debug($str) {
		if ($this->debug)
			echo "<!-- $str -->\n";
	}


	function substring($str, $startPattern, $endPattern) {
			
		$pos = strpos($str, $startPattern);
		if($pos === false) {
			return "";
		}
	 
		$pos = $pos + strlen($startPattern);
		$temppos = $pos;
		$pos = strpos($str, $endPattern, $pos);
		$datalength = $pos - $temppos;
	 
		$data = substr($str, $temppos , $datalength);
		return $data;
	}

	function expanded_media_search($q) {
		// Added section for dealing with galleries
		if (isset($_GET['page']) && ($_GET['page'] == 'shiba_manage_gallery')) {
			$q['post_type'] = 'gallery';
			if ($q['post_status'] != 'trash') $q['post_status'] = 'any';
		}
		
		// Now for the expanded search
		global $wpdb;
		// process additional search options
		if (isset($_GET['s']) && isset($_GET['search_attribute'])) {
			$searchStr = $_GET['s'];
			$search = esc_sql(like_escape($_GET['s']));
			$q['s'] = $search;
			$_GET['search'] = $search;
			switch ($_GET['search_attribute']) {
			case 'title':
				break;
			case 'tag':
				// get all tags that are like search string
				$query = "SELECT slug FROM {$wpdb->terms} WHERE name LIKE '%{$search}%'";
				$tags = $wpdb->get_col($query);
				// create comma separated string of slugs
				if (count($tags) <= 0) 
					$tagStr = $search;
				else {	
					$tagStr = '';
					foreach ($tags as $tag) {
						$tagStr .= $tag . ',';
					}
					$tagStr = substr($tagStr, 0, strlen($tagStr)-1);
				}
				$q['tag'] = $tagStr;
				unset($q['s']);	
				break;
			case 'category':	
				// get all tags that are like search string
				$query = "SELECT term_id FROM wp_terms WHERE name LIKE '%{$search}%'";
				$categories = $wpdb->get_col($query);
				// create comma separated string of category ids
				if (count($categories) <= 0) 
					$q['category_name'] = $search;
				else {	
					$catStr = '';
					foreach ($categories as $category) {
						$catStr .= $category . ',';
					}
					$catStr = substr($catStr, 0, strlen($catStr)-1);
					$q['cat'] = $catStr;
				}
				unset($q['s']);	
				break;
			default:
				break;
			} // end switch
		}	
		return $q;
	}
	
	function get_search_query($value) {
		if (!$value && isset($_GET['search'])) {
			$value = $_GET['search'];
		}	
		return $value;
	}


	
	/*
	 * Allow tags for attachments.
	 *
	 */
 
	// Get tag string for a given post id
	 function get_post_tags_string($postID) {
		$tags = wp_get_object_terms( $postID, 'post_tag' );
	
		$tagStr = '';
		if (count($tags)) {
			$tagStr = $tags[0]->name;
			for ($i = 1; $i < count($tags); $i++) 
				$tagStr .= ',' . $tags[$i]->name;
		}
			
		return $tagStr;	
	}
	
	// Get tag-slug string for a given post id - this is required for get_posts
	 function get_post_tags_slug($postID) {
		$tags = wp_get_object_terms( $postID, 'post_tag' );
	
		$tagStr = '';
		if (count($tags)) {
			$tagStr = $tags[0]->slug;
			for ($i = 1; $i < count($tags); $i++) 
				$tagStr .= ',' . $tags[$i]->slug;
		}
			
		return $tagStr;	
	}


	 
	/*
	 * Tag field menu expansions.
	 *
	 */
 
	// Add tag field for attachment edit menu
	function attachment_fields_to_edit( $form_fields, $post ) {
		$tags = $this->get_post_tags_string($post->ID);
	
		$form_fields['tags'] = array(
			'value' => $tags,
			'label' => __('Attachment Tags'),
			'helps' => __('Associate tags with image attachments to easily include them in multiple image galleries.')
		);
		return $form_fields;
	}
	
	// Save tag field from attachment edit menu
	function attachment_fields_to_save($post, $attachment) {
		$tags = esc_attr($_POST['attachments'][$post['ID']]['tags']);
	
		$tag_arr = explode(',', $tags);
		wp_set_object_terms( $post['ID'], $tag_arr, 'post_tag' );
		return $post;
	}
	
	function array_insert($array,$pos,$key,$val)
	{
		$tmp_array = array_splice($array,$pos);
		$array[$key] = $val;
		$array = array_merge($array,$tmp_array);
	  
		return $array;
	}
	
	// Add tag column to the attachment Media Library page
	function add_admin_columns($posts_columns) {
		$posts_columns['att_tag'] = _x('Tags', 'column name');
		unset($posts_columns['comments']);
	
		if (isset($_GET['page']) && ($_GET['page'] == 'shiba_add_gallery')) {
			// replace icon with new_icon but preserve key position
			unset($posts_columns['icon']);
			$posts_columns = $this->array_insert($posts_columns, 1, 'new_icon', '');
		}
		return $posts_columns;
	}
	
	function manage_admin_columns($column_name, $id) {
		global $post;
		
		switch($column_name) {
		case 'att_tag':
			$tagparent = "upload.php?";
			$tags = get_the_tags();
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c )
					$out[] = "<a href='".$tagparent."tag=$c->slug'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'post_tag', 'display')) . "</a>";
				echo join( ', ', $out );
			} else {
				_e('No Tags');
			}
			break;
			
		case 'new_icon':
			$attachment_id = 0;
			if ($post->post_type == 'attachment')
				$attachment_id = $post->ID;
			 else if (function_exists('get_post_thumbnail_id')) 
				$attachment_id = get_post_thumbnail_id($post->ID);
			if (!$attachment_id) break;	
						
			if ( $thumb = wp_get_attachment_image( $attachment_id, array(80, 60), true ) ) {
				if ( $post->post_status == 'trash' ) echo $thumb;
				else {
				echo '	
				<a href="media.php?action=edit&amp;attachment_id='.$attachment_id.'" title="'.esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $post->post_title)).'">';
				echo $thumb;
				echo "</a>\n";
				}
			}
			break;		
		default:
			break;
		}
		
	}

	/*
	 * Display Gallery Objects
	 *
	 * Allows the display of gallery objects similar to attachment objects.
	 * The native WordPress 'gallery' shortcode is used here to display galleries.
	 *
	 */
	
	function process_gallery_content($content) {
		global $post;
		if (is_object($post) && ($post->post_type == 'gallery')) {
			// Fix Twenty Ten theme
			if (get_current_theme() == 'Twenty Ten') { ?>
                <style>
				#content .gallery { margin: 0 0 36px 0; }
				</style>
            <?php }    
			$content = "<div class='gallery-main' style='text-align:center;'>[gallery]</div>";
			return apply_filters('the_gallery_content', $content);
		}
		return $content;	
	}


	/*
	 * get_posts
	 *
	 * Key gallery object functionality is encapsulated here. 
	 * Get all objects (attachments, posts, pages, and galleries) with tags contained by the gallery, 
	 * and add that to the get_posts results.
	 *
	 */
	 
	function merge_posts($array1, $array2) {
		
		$mplus_ID = $this->query_args['id'];
		$result = array();
		$keys = array();
		$j = 0;
		if ($mplus_ID) // Don't include self
			$keys[$mplus_ID] = TRUE;
		for ($i = 0; $i < count($array1); $i++) {
			if (!isset($keys[$array1[$i]->ID])) {
				$keys[$array1[$i]->ID] = TRUE;
				// Only include published objects
				if (($array1[$i]->post_type == 'post') || ($array1[$i]->post_type == 'page'))
					if ($array1[$i]->post_status != 'publish')
						continue;
				$result[$j++] = $array1[$i];
			}
		}
		
		for ($i = 0; $i < count($array2); $i++) {
			if (!isset($keys[$array2[$i]->ID])) {
				$keys[$array2[$i]->ID] = TRUE;
				// Only include published objects
				if (($array2[$i]->post_type == 'post') || ($array2[$i]->post_type == 'page'))
					if ($array2[$i]->post_status != 'publish')
						continue;
	
				$result[$j++] = $array2[$i];
			}
		}
		return $result;
	}
	
	function get_posts_init($qobj) {
		
		$num_images = 0;
		if ($qobj->query_vars['post__in']) // only include specified posts
			return;

		if ($qobj->query_vars['p'])  { // looking for single post		
			$tmp_obj = get_post(absint($qobj->query_vars['p']));
			if (!$tmp_obj) return;
			$qobj->query_vars['post_type'] = $tmp_obj->post_type;
			return;
		}	
						
		//Only process gallery objects
		$objID = $qobj->get('post_parent');
		if (!$objID) return;
		$obj = get_post($objID);
		if (!$obj || !$obj->post_type || !($obj->post_type == 'gallery')) return;
	
		// Global post_type and post_status only exists within WordPress loop
		// Save query state so that we can use it later when processing the query results.
		$post_type = $qobj->get('post_type');
		$post_status = $qobj->get('post_status');
		// Get which object type(s) the gallery should contain
		$gallery_type = get_post_meta($obj->ID, '_gallery_type', TRUE);
		if (!$gallery_type) $gallery_type = 'attachment';
		if (($post_type == 'attachment') || ($gallery_type == 'attachment')) $gallery_type = 'attachment';
		
		$qobj->query_vars['suppress_filters'] = FALSE;	
		
		// Store the tag string for the gallery object
		$tag_str = $this->get_post_tags_slug($objID);
		$id = $objID;
		
		// Store include and exclude elements
		$exclude =$qobj->query_vars['post__not_in'];	
		$this->query_args = compact('id', 'post_type', 'post_status', 'gallery_type', 'num_images', 'tag_str','exclude');
	}
	
	function clear_query() {
		unset($this->query_args);
	}
	
	// Add additional tag attachments to the gallery get_posts results
	function get_posts_filter($results) {
		
		if (!is_array($this->query_args)) return $results;
		extract($this->query_args);
		if (!$tag_str) return $results;
	
		// create string from array
		$args = array(
			'tag' => $tag_str,
			'posts_per_page' => -1,	
			'post_status' => $post_status,
			'suppress_filters' => TRUE
			); 
		if ($exclude) $args['post__not_in'] = $exclude;	
		// process post_type based on gallery_type and query post type
		if ($gallery_type == $post_type)
			$args['post_type'] = $gallery_type;
		else if ($gallery_type == 'any')
			$args['post_type'] = $post_type;
		else if ($post_type == 'any')
			$args['post_type'] = $gallery_type;
		else {
			$this->clear_query();
			return $results;
		}	
		
		$tmp_query = new WP_Query;
		$addimages = $tmp_query->query($args);
			
		//	Combine both arrays manually while removing duplicate IDs
		$newResult = $this->merge_posts($results, $addimages); //array_merge($results, $addimages);	
		$this->query_args['num_images'] = count($newResult);
		unset($tmp_query);
		return $newResult;
	}
	
	function found_posts_filter($results) {
		if (isset($this->query_args['num_images']))
			return max($results,$this->query_args['num_images']);
		else return $results;	
	}

	function javascript_redirect($location) {
		// redirect after header here can't use wp_redirect($location);
		?>
		  <script type="text/javascript">
		  <!--
		  window.location= <?php echo "'" . $location . "'"; ?>;
		  //-->
		  </script>
		<?php
		exit;
	}
	 
	function filter_attachment_link($link, $id) {
		return preg_replace('/<br\s*?\/+>/', '', $link);
	}
	
	function parallelize_image($image) {
		return $this->parallelize_obj->parallelize_image($image);
	}

	function parallelize_link($image_link) {
		return $this->parallelize_obj->_parallelize_link($image_link);
	}

} // End Shiba_Library class	

endif;

if (class_exists("Shiba_Media_Library")) {
    $shiba_mlib = new Shiba_Media_Library();	
}	
?>