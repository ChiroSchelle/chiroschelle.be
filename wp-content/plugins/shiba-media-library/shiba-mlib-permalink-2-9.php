<?php
// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


if (!class_exists("Shiba_Media_Permalink_2_9")) :

class Shiba_Media_Permalink_2_9 {

	function activate() {
		global $wpdb;
	
		add_option('gallery_base', '');
		$permalink_structure = get_option('permalink_structure');
		if ($permalink_structure)
 			add_option('gallery_structure', "/gallery/%gallery%");
		else
 			add_option('gallery_structure', "");
		
		// Need things exactly like this if you want to flush rules. Don't understand why rules are added before the flush
   		global $wp_rewrite;
 	 	$wp_rewrite->add_rewrite_tag("%gallery%", '([^/]+)', "gallery=");
	 	$wp_rewrite->add_rewrite_tag("%galleryatt%", '[^/]+/_([^/]+)', "gallery_attachment=");
		$this->set_gallery_permastruct();
		$wp_rewrite->flush_rules();
	}
	
	
	function init() {
		global $wp_rewrite, $wp;	
		
		add_filter('post_class', array(&$this,'post_class') );
		add_filter('post_link', array(&$this,'gallery_permalink'), 10, 3);		

		add_filter('attachment_link', array(&$this,'gallery_attachment_permalink'), 10, 2);

		// Add 'gallery' to permalink structure					
	 	$wp_rewrite->add_rewrite_tag("%gallery%", '([^/]+)', "gallery=");
		$wp->add_query_var('gallery');
		$this->set_gallery_permastruct();

		add_filter('request', array(&$this,'process_attachment_query')); 
		$wp_rewrite->add_rewrite_tag("%galleryatt%", '[^/]+/_([^/]+)', "gallery_attachment=");
		$wp->add_query_var('gallery_attachment');		
	}
	
	function show_gallery_structure() {
		global $shiba_mlib;
		$gallery_structure = get_option('gallery_structure');
		echo "<input name=\"gallery_structure\" id=\"gallery_structure\" type=\"text\" value=\"{$gallery_structure}\" class=\"regular-text code\" />";
		echo "<p>Your gallery structure can only contain tags from your main blog structure. If you enter an invalid structure, it will default to your blog structure.</p>";
	}

	function show_gallery_base() {
		$gallery_base = get_option('gallery_base');
		echo "<input name=\"gallery_base\" id=\"gallery_base\" type=\"text\" value=\"{$gallery_base}\" class=\"regular-text code\" />";
	}

	 
	function post_class($classes) {
		$classes[] = 'post';
		return $classes;
	}

	function get_gallery_permastruct() {
		return get_option('gallery_structure');
	
	}
	
	function set_gallery_permastruct() {
		global $wp_rewrite, $shiba_mlib;	
		
		$permalink_structure = get_option('permalink_structure');
		$gallery_structure = get_option('gallery_structure');
		$galleryatt_structure = str_replace('%gallery%', '%galleryatt%', $gallery_structure);

//		$page_structure = $wp_rewrite->get_page_permastruct();
//		print_r($wp_rewrite->generate_rewrite_rules($page_structure, EP_PAGES));		
//		exit();

		if  ( $gallery_structure ) {
			$gallery_structure = $this->get_gallery_permastruct();
			
			// false is important in add_permastruct so that it does not append the general blog structure our gallery structure
			$wp_rewrite->add_permastruct('gallery', $gallery_structure, false);    
			// write permastruct for attachments  
			if ( (strpos($gallery_structure, "%gallery%") !== FALSE) && (strpos($gallery_structure, "%post_id%") === FALSE) )
				$wp_rewrite->add_permastruct('attachment', $galleryatt_structure, false);
			else				
				$wp_rewrite->add_permastruct('attachment', "", false);
		} else {
			$wp_rewrite->add_permastruct('gallery', "", false);  
			$wp_rewrite->add_permastruct('attachment', "", false);
		}	   
	}
	
	
	function set_gallery_structure($input) {
		global $shiba_mlib;
		if ( isset($_POST['gallery_structure']) ) {
			check_admin_referer('update-permalink');
			$permalink_structure = get_option('permalink_structure');
			$gallery_structure = $_POST['gallery_structure'];

			
			// MUST NOT contain %postname% tag
			if ($gallery_structure && (strpos($gallery_structure, "%postname%") !== FALSE)) {
				$gallery_structure = str_replace("%postname%","%gallery%", $gallery_structure);
			}
			

			// Must be using permalink structure
			if ( !$permalink_structure ) {
				$gallery_structure = $permalink_structure;
			} elseif (! empty($gallery_structure) ) {
				$gallery_structure = preg_replace('#/+#', '/', '/' . $gallery_structure);

				//build an array of the tags (note that said array ends up being in $tokens[0])
				preg_match_all('/%.+?%/', $gallery_structure, $tokens);
				$gallery_tags = $tokens[0];

				if (!is_array($gallery_tags)) { // no tokens
					$gallery_structure = ""; // str_replace("%postname%","%gallery%", $permalink_structure);

				
				// MUST contain %gallery% or %post_id% tokens
				} elseif (!in_array("%gallery%", $gallery_tags) && !in_array("%post_id%", $gallery_tags)) {
					$gallery_structure = ""; // str_replace("%postname%","%gallery%", $permalink_structure);
				
					
				} else {
					// only allow tags in blog permalink structure for 2.9
					
					preg_match_all('/%.+?%/', $permalink_structure, $tokens);
					$allowed_tags = $tokens[0];
				
					foreach ($gallery_tags as $tag) 
						if ($tag && ($tag != '%gallery%') && !in_array($tag,$allowed_tags)) {
							// contains tags that are not allowed, replace gallery structure with permalink structure
							$gallery_structure = str_replace("%postname%","%gallery%", $permalink_structure);
							break;
						}	
				}		
			} else {// empty gallery struct
				$gallery_structure = ""; //str_replace("%postname%","%gallery%", $permalink_structure);
			}

			
			if ($gallery_structure) {

				// %gallery% tag MUST be at the end
				$pos = strpos($gallery_structure, "%gallery%");
				if ($pos !== FALSE) {
					$pos += strlen("%gallery%");
					$gallery_structure = substr($gallery_structure, 0, $pos);
				}
				$gallery_structure = rtrim($gallery_structure, '/');
				// gallery structure must have trailing slash or not according to permalink structure
				$last = $permalink_structure[strlen($permalink_structure)-1];
				if ($last == '/')
					$gallery_structure .= '/';

				// It can't just be gallery because if so, the rules will disrupt page structure rules
				$trim_gallery_structure = trim($gallery_structure,'/');
				if ( $trim_gallery_structure == "%gallery%")
					$gallery_structure = "";
					
				// It can't just be %author% or %category% and gallery because that will desrupt category and tag rules
				if (($trim_gallery_structure == '%category%/%gallery%') || 
					($trim_gallery_structure == '%author%/%gallery%') ) {
						$gallery_structure = "";
				}		
			}
			
			// check if gallery structure is duplicate of general permalink structure
			if (str_replace('%gallery%','%postname%', $gallery_structure) == $permalink_structure)
				$gallery_structure = "";	
			// check if gallery structure is new
			$old_structure = get_option('gallery_structure');
			if ($gallery_structure != $old_structure)	
				update_option('gallery_structure', $gallery_structure);

			
			$this->set_gallery_permastruct();
		}
		return $input;
	
	}
	
	
	function set_gallery_base($input) {
		if ( isset($_POST['gallery_base']) ) {
			check_admin_referer('update-permalink');
			$gallery_base = $_POST['gallery_base'];
			if (! empty($gallery_base) ) {
				// only allow alpha numeric characters
				$gallery_base = preg_replace('#[^\w]#', '', $_POST['gallery_base']);	
				$gallery_base = preg_replace('#/+#', '/',$gallery_base);	
			}	
			// check if gallery base is new
			$old_base = get_option('gallery_base');
			if ($gallery_base != $old_base)	{
				update_option('gallery_base', $gallery_base);
				// also update gallery_struct
				$gallery_struct = get_option('gallery_structure');
				if (strpos($gallery_struct, $old_base) !== FALSE)
					update_option('gallery_structure', str_replace($old_base, $gallery_base, $gallery_struct));
				elseif (strpos($gallery_struct, "%gallery%") !== FALSE) 
					update_option('gallery_structure', 	str_replace("%gallery%",$gallery_base."/%gallery%",$gallery_struct));
				else	
 					update_option('gallery_structure', str_replace("%postname%","%gallery%", $permalink_structure));
			}
			$this->set_gallery_permastruct();
		}
		return $input;
	}
		
	function get_link_name($link) {
		
		$pos = strrpos(substr($link,0,strlen($link)-1), '/');
		return substr($link, $pos+1);		
	}
	
	function pre_gallery_permalink($permalink, $post, $leavename) { 
		if  ($post->post_type == 'gallery') {
			$permalink = $this->get_gallery_permastruct();	
		}
		return $permalink;		
	}
		
	function gallery_attachment_permalink($link, $id) {
		$gallery_structure = get_option('gallery_structure');
		if (!$gallery_structure || (strpos($gallery_structure, "%post_id%") !== FALSE)) return $link;
		
		global $wp_rewrite;
		$object = get_post($id);
		if ( $wp_rewrite->using_permalinks() && ($object->post_parent > 0) && ($object->post_parent != $id) ) {
			// object parent has been added
			$parent = get_post($object->post_parent);
			if  (($parent->post_type == 'gallery') && ($parent->post_status == 'publish')) {
				// if permalink has %category% then 'attachment' weirdly gets appended to attachment names
				$permalink_structure = get_option('permalink_structure');
				if (strpos($permalink_structure, '%category%') !== FALSE) {
					$link = str_replace('/attachment/', '/', $link);
				}
				// append underscore to beginning of name
				$name = $this->get_link_name($link);				
				$link = str_replace($name,'_'.$name,$link);
			}	
		}
		return $link;
	}
	
	function gallery_permalink($permalink, $post, $leavename) {
		if  ($post->post_type == 'gallery') {
			$permalink_structure = get_option('permalink_structure');

			// Assign each permalink component to their respective permalink placeholders
			// trim beginning and end slashes
			$perma_placeholders = explode('/', trim($permalink_structure, '/'));
			$perma_segments = explode('/', trim(str_replace(get_bloginfo('url'),"",$permalink), '/') );

			// Create associative array between placeholders and segments
			$perma_array = array();
			for ($i = 0; $i < count($perma_placeholders); $i++) {
				if ($perma_placeholders[$i])  
					$perma_array[$perma_placeholders[$i]] = $perma_segments[$i];
			}
			$perma_array['%gallery%'] = $post->post_name;		
			$new_permalink = $this->get_gallery_permastruct();
			if ($leavename)
				$new_permalink = str_replace("%gallery%", "%postname%", $new_permalink);
			if (!is_array($perma_array) || (count($perma_array) <= 0) || !$new_permalink) return $permalink;
			foreach ($perma_array as $key => $value) {
				if ($leavename && ($key == "%postname%")) continue;
				$new_permalink = str_replace($key, $value, $new_permalink);
			}					
			return get_bloginfo('url') . $new_permalink;

		}
		return $permalink;
	}


	function filter_sample_permalink($return, $id, $new_title, $new_slug) {
		global $shiba_mlib;
		// Only take out shortlink for gallery objects
		$post = get_post($id);
		if ($post && ($post->post_type == 'gallery')) {
			// remove shortlink button for gallery
			$shortlink = $shiba_mlib->substring($return, '<input id="shortlink"', '</a>');
			$shortlink = '<input id="shortlink"' . $shortlink . '</a>';
			if ($shortlink)
				$return = str_replace($shortlink, "", $return);
		}
		return $return;
	}
	
	function process_attachment_query($query) {
		if (isset($query['name']) && !get_option('gallery_structure')) {
			$query['post_type'] = array('post','gallery');
			$query['post_status'] = 'published';
		} elseif (isset($query['gallery'])) {
			return array(	'name' => $query['gallery'],
							'post_type' => 'gallery' );
		} elseif (isset($query['gallery_attachment'])) {
			return array('attachment' => $query['gallery_attachment']);
		}
		return $query;
	}
	
} // end class	
endif;
?>