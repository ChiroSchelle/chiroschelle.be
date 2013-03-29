<?php
/*
Plugin Name: Gallery Plus
Plugin URI: http://www.hawkwood.com/archives/category/wordpress/plugins/gallery-plus
Description: AANGEPAST This plugin overrides the built-in Wordpress gallery to enable additional options. 
Author: Justin Hawkwood, aangepast door Ben Bridts
Author URI: http://www.hawkwood.com/
Version: 1.4.1
*/

/* Set the default theme to Black */
add_option('gallery_plus_columns', '3');
add_option('gallery_plus_size', 'thumbnail');
//add_option('gallery_plus_link2full', 0);
$gpl2f = get_option('gallery_plus_link2full');
if ($gpl2f !== false) {
	add_option('gallery_plus_linktype', ((stripslashes($gpl2f) == 1) ? 'image' : 'post'));
	delete_option('gallery_plus_link2full');
} else add_option('gallery_plus_linktype', 'post');
add_option('gallery_plus_titlecaption', '');
add_option('gallery_plus_atagtitle', 0);
add_option('gallery_plus_overlay', 'none');
add_option('gallery_plus_singleonly', 0);
$gpcss = '<style type="text/css" media="screen">
/* Begin Gallery Plus CSS */
.gallery {
	margin: auto;
}
.gallery-item {
	float: left;
	margin-top: 10px;
	text-align: center;
/*	width: {$itemwidth}%; */
}
.gallery img {
	border: 2px solid #cfcfcf;
}
.gallery-caption {
	margin-left: 0;
	}
/* End Gallery Plus CSS */
	</style>
';
add_option('gallery_plus_css', $gpcss);
add_option('gallery_plus_overlay_attr', 'rel');

$gallery_plus_options_page = get_option('siteurl') . '/wp-admin/admin.php?page=gallery-plus/options.php';
function add_gallery_plus_options_page() {
	add_options_page('Gallery Plus Options', 'Gallery Plus', 10, 'gallery-plus/options.php');
}
add_action('admin_menu', 'add_gallery_plus_options_page');

add_shortcode('gallery_excerpt', 'gallery_excerpt');

function gallery_excerpt($attr) {
	global $wpdb, $post;
	
	if (is_single()) return '';
	
	extract(shortcode_atts(array(
		'orderby'    => 'menu_order ASC, ID ASC',
		'id'         => $post->ID,
		'size'       => get_option('gallery_plus_size'),
		'imagenumber'    => 1,
		'class'      => 'alignleft',
	), $attr));

	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] ) unset( $attr['orderby'] );
	}
	
	if ($imagenumber > 0) $imagenumber--;
	else $imagenumber = 0;
	
	$id = intval($id);
	$attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$id' AND post_type='attachment' AND post_mime_type LIKE  '%image%' ORDER BY $orderby LIMIT $imagenumber, 1");
	
	$thumbnail_link = wp_get_attachment_image_src($attachment_id, $size, false);
	$output = '<a href="' . get_permalink($id) . "\" rel=\"attachment wp-att-$attachment_id\">" . "<img src=\"$thumbnail_link[0]\" width=\"$thumbnail_link[1]\" height=\"$thumbnail_link[2]\" class=\"$class size-$size wp-image-$attachment_id\" />" . '</a>';

	return $output;
}

add_shortcode('gallery', 'gallery_plus');

function gallery_plus($attr) {
	global $post;
	
//	if (get_option('gallery_plus_singleonly') && !is_single()) return '';
	
/*	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;
*/

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'orderby'    => 'menu_order ASC, ID ASC',
// WP 2.6 uses these
//		'order'      => 'ASC',
//		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => get_option('gallery_plus_columns'),
		'size'       => get_option('gallery_plus_size'),
		'fullsize'   => get_option('gallery_plus_fullsize'),
//		'link2full'  => get_option('gallery_plus_link2full'),
		'linktype'  => get_option('gallery_plus_linktype'),
		'titlecaption'  => get_option('gallery_plus_titlecaption'),
		'atagtitle'  => get_option('gallery_plus_atagtitle'),
		'overlay'  => stripslashes(get_option('gallery_plus_overlay')),
		'attribute'  => stripslashes(get_option('gallery_plus_overlay_attr')),
		'singleonly' => get_option('gallery_plus_singleonly'),
		'exclude' => '',
		'adhoc' => ''
	), $attr));

	if ($singleonly && !is_single()) return '';
	
	$id = intval($id);
	if (strlen(trim($adhoc)) > 0) $adhoc = array_map('trim', explode(',', $adhoc));
	else $adhoc = array();
	
	if (count($adhoc) > 0) {
		echo "<!-- adhoc = ";
		print_r($adhoc);
		echo "--> \n";
		$id = $post->ID;
		$exclude = '';
		//- load images as attachments
		foreach ($adhoc as $id) {
			$attachments[$id] = get_post($id);
		}
	} else {
		$attachments = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");
		//fix om de afbeeldingen in omgekeerde volgorde te tonen, Mante
		$attachments = array_reverse($attachments);
	}
//	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );	// WP 2.6 uses this

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}

	$exclude = array_map('trim', explode(',', $exclude)); // removed array_flip()

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	
	$output = apply_filters('gallery_style', "
		<div class='gallery'>");
	$c = 0;
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$c++;
		if (in_array($c, $exclude, false)) //if(isset($exclude[$c]))
			continue;
		$output .= "<{$itemtag} class='gallery-item' style='width: {$itemwidth}%;'>";
		// legacy: replace linktype with link2full if it's set from shortcode
		if (isset($link2full)) $linktype = ($link2full ? 'image' : 'none');
		if ($linktype == 'none') {
			// show image without a link
			$thumbnail_link = wp_get_attachment_image_src($attachment->ID, $size, false);
//			$output .= "<{$itemtag} class='gallery-item' style='width: {$itemwidth}%;'>"; 
			$output .= "
			<{$icontag} class='gallery-icon'>
				<img src=\"$thumbnail_link[0]\" title=\"".trim(htmlspecialchars($attachment->post_title, ENT_QUOTES ))."\" alt=\"".trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES))."\" width=\"$thumbnail_link[1]\" height=\"$thumbnail_link[2]\" class=\"attachment-thumbnail\" />
			</{$icontag}>";
		} else if ($linktype == 'image') {
			// show full res link to image
			$thumbnail_link = wp_get_attachment_image_src($attachment->ID, $size, false);
			// Gebruik fullsize-optie ipv 'full' in de links.
			$full_image_href = wp_get_attachment_image_src($attachment->ID, $fullsize, false);
//			$img_title = trim(htmlspecialchars($attachment->post_title, ENT_QUOTES ));
//			$img_caption = trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES));
			if ($titlecaption == 'none') {
				$img_title = '';
				$img_caption = '';
			} else if ($titlecaption == 'swap') {
				$img_title = trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES));
				$img_caption = trim(htmlspecialchars($attachment->post_title, ENT_QUOTES ));
			} else if ($titlecaption == 'title') {
				$img_title = trim(htmlspecialchars($attachment->post_title, ENT_QUOTES ));
				$img_caption = trim(htmlspecialchars($attachment->post_title, ENT_QUOTES ));
			} else if ($titlecaption == 'caption') {
				$img_title = trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES));
				$img_caption = trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES));
			} else if ($titlecaption == 'download') {
			    $download_link = wp_get_attachment_image_src($attachment->ID, 'full', false);
				$img_title = trim(htmlspecialchars($attachment->post_title, ENT_QUOTES));
				$img_title .= " <a href='{$download_link[0]}'>download origineel</a>";
				$img_caption = ''; //trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES));
			} else {
				$img_title = trim(htmlspecialchars($attachment->post_title, ENT_QUOTES ));
				$img_caption = trim(htmlspecialchars($attachment->post_excerpt, ENT_QUOTES));
			}
//			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
			<{$icontag} class='gallery-icon'>
				<a href=\"$full_image_href[0]\"" . (($overlay == 'none') ? '' : (($attribute == 'rel') ? ' rel="' . $overlay . '[' . $post->ID . ']"' : ' class="' . $overlay . '"')) . ($atagtitle ? " title=\"$img_title\"" : '') . "><img src=\"$thumbnail_link[0]\" title=\"$img_title\" alt=\"$img_caption\" width=\"$thumbnail_link[1]\" height=\"$thumbnail_link[2]\" class=\"attachment-thumbnail\" /></a>
			</{$icontag}>";
		} else {			
			$link = wp_get_attachment_link($id, $size, true);
//			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";		
		}
		if ( $captiontag && $img_caption ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				{$img_caption}
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

add_filter('wp_head', 'gallery_plus_css');

function gallery_plus_css() {
	echo stripslashes(get_option('gallery_plus_css'));
}

/*
ORIGINAL CODE FROM WORDPRESS 2.7.1 wp-includes/media.php FOR UPDATE COMPARISON

function gallery_shortcode($attr) {
	global $post;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail'
	), $attr));

	$id = intval($id);
	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

	$output = apply_filters('gallery_style', "
		<style type='text/css'>
			.gallery {
				margin: auto;
			}
			.gallery-item {
				float: left;
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;			}
			.gallery img {
				border: 2px solid #cfcfcf;
			}
			.gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div class='gallery'>");

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				{$attachment->post_excerpt}
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

*/

?>
