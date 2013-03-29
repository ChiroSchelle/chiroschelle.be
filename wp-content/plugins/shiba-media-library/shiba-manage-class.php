<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists("Shiba_Media_Library_Menu")) :

class Shiba_Media_Library_Menu {
	
	function gallery_columns($posts_columns) {
		$posts_columns['cb'] = '<input type="checkbox" />';
		
		$posts_columns['id'] = __('ID');
		$posts_columns['title'] = _x('Gallery Name', 'column name');
		$posts_columns['images'] = __('Images');
		$posts_columns['author'] = __('Author');
		
		$posts_columns['categories'] = __('Categories');
		$posts_columns['tags'] = __('Tags');
	
		$posts_columns['date'] = _x('Date', 'column name');
	
		return $posts_columns;
	}
	
	
	/**
	 * Adapted from post_rows in wp-admin/includes/template.php
	 */
	function post_galleries( $posts = array() ) {
		global $wp_query, $post, $mode;
	
		add_filter('the_title','esc_html');
	
		// Create array of post IDs.
		$post_ids = array();
	
		if ( empty($posts) )
			$posts = &$wp_query->posts;
	
		foreach ( $posts as $a_post )
			$post_ids[] = $a_post->ID;
	
		$comment_pending_count = get_pending_comments_num($post_ids);
		if ( empty($comment_pending_count) )
			$comment_pending_count = array();
	
		foreach ( $posts as $post ) {
			if ( empty($comment_pending_count[$post->ID]) )
				$comment_pending_count[$post->ID] = 0;
	
			$this->_post_gallery($post, $comment_pending_count[$post->ID], $mode);
		}
	}
	
	/**
	 * Adapted from _post_row in wp-admin/includes/template.php
	 */
	function _post_gallery($a_post, $pending_comments, $mode) {
		global $post, $current_user, $wpdb, $shiba_mlib, $is_trash;
		static $rowclass;
	
		$global_post = $post;
		$post = $a_post;
		setup_postdata($post);
	
		$rowclass = 'alternate' == $rowclass ? '' : 'alternate';
		$post_owner = ( $current_user->ID == $post->post_author ? 'self' : 'other' );
		$edit_link = $shiba_mlib->manage_2_9->get_edit_gallery_link( '', $post->ID );
		$title = _draft_or_post_title();
	?>
		<tr id='post-<?php echo $post->ID; ?>' class='<?php echo trim( $rowclass . ' author-' . $post_owner . ' status-' . $post->post_status ); ?> iedit' valign="top">
	<?php
		$posts_columns = get_column_headers('shiba_mlib');
		$hidden = get_hidden_columns('shiba_mlib');
		foreach ( $posts_columns as $column_name=>$column_display_name ) {
			$class = "class=\"$column_name column-$column_name\"";
	
			$style = '';
			if ( in_array($column_name, $hidden) )
				$style = ' style="display:none;"';
	
			$attributes = "$class$style";
			switch ($column_name) {
	
			case 'cb':
			?>
			<th scope="row" class="check-column"><?php if ( current_user_can( 'edit_post', $post->ID ) ) { ?><input type="checkbox" name="gallery[]" value="<?php the_ID(); ?>" /><?php } ?></th>
			<?php
			break;
			
			case 'id':
			?>
			<td <?php echo $attributes ?>><?php echo the_ID(); ?></td>
			<?php
			break;
	
			
			case 'date':
				if ( '0000-00-00 00:00:00' == $post->post_date && 'date' == $column_name ) {
					$t_time = $h_time = __('Unpublished');
					$time_diff = 0;
				} else {
					$t_time = get_the_time(__('Y/m/d g:i:s A'));
					$m_time = $post->post_date;
					$time = get_post_time('G', true, $post);
	
					$time_diff = time() - $time;
	
					if ( $time_diff > 0 && $time_diff < 24*60*60 )
						$h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
					else
						$h_time = mysql2date(__('Y/m/d'), $m_time);
				}
	
				echo '<td ' . $attributes . '>';
				if ( 'excerpt' == $mode )
					echo apply_filters('post_date_column_time', $t_time, $post, $column_name, $mode);
				else
					echo '<abbr title="' . $t_time . '">' . apply_filters('post_date_column_time', $h_time, $post, $column_name, $mode) . '</abbr>';
				echo '<br />';
				if ( 'publish' == $post->post_status ) {
					_e('Published');
				} elseif ( 'future' == $post->post_status ) {
					if ( $time_diff > 0 )
						echo '<strong class="attention">' . __('Missed schedule') . '</strong>';
					else
						_e('Scheduled');
				} else {
					_e('Last Modified');
				}
				echo '</td>';
			break;
	
			case 'title':
				$attributes = 'class="post-title column-title"' . $style;
			?>
			<td <?php echo $attributes ?>>
			<strong><?php if ( current_user_can('edit_post', $post->ID) && $post->post_status != 'trash' ) { 
				?><a class="row-title" href="<?php echo $edit_link; ?>" title="<?php echo esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $title)); ?>"><?php echo $title ?></a>
				<?php } else { echo $title; }; 
	
	
			?></strong>
			<?php
				if ( 'excerpt' == $mode )
					the_excerpt();
	
				$actions = array();
				if ( current_user_can('edit_post', $post->ID) && 'trash' != $post->post_status ) {
					$actions['edit'] = '<a href="' . $edit_link . '" title="' . esc_attr(__('Edit this post')) . '">' . __('Edit') . '</a>';
				}
	
	
				if ( current_user_can('delete_post', $post->ID) ) {
					if ( 'trash' == $post->post_status )
						$actions['untrash'] = "<a title='" . esc_attr(__('Restore this post from the Trash')) . "' href='" . wp_nonce_url("post.php?action=untrash&amp;post=$post->ID", "untrash-post_" . $post->ID) . "'>" . __('Restore') . "</a>";
					elseif ( defined('EMPTY_TRASH_DAYS') && EMPTY_TRASH_DAYS )
						$actions['trash'] = "<a class='submitdelete' title='" . esc_attr(__('Move this post to the Trash')) . "' href='" . $shiba_mlib->manage_2_9->get_delete_gallery_link('', $post->ID) . "'>" . __('Trash') . "</a>";
					if ( 'trash' == $post->post_status || !defined('EMPTY_TRASH_DAYS') || !EMPTY_TRASH_DAYS )
						$actions['delete'] = "<a class='submitdelete' title='" . esc_attr(__('Delete this post permanently')) . "' href='" . wp_nonce_url("post.php?action=delete&amp;post=$post->ID", "delete-post_" . $post->ID) . "'>" . __('Delete Permanently') . "</a>";
				}
				
				if ( !$is_trash )
					$actions['view'] = '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr(sprintf(__('View &#8220;%s&#8221;'), $title)) . '" rel="permalink">' . __('View') . '</a>';
	
				$actions = apply_filters('gallery_row_actions', $actions, $post);
				$action_count = count($actions);
				$i = 0;
				echo '<div class="row-actions">';
				foreach ( $actions as $action => $link ) {
					++$i;
					( $i == $action_count ) ? $sep = '' : $sep = ' | ';
					echo "<span class='$action'>$link$sep</span>";
				}
				echo '</div>';
	
				get_inline_data($post);
			?>
			</td>
			<?php
			break;
	
			case 'categories':
			?>
			<td <?php echo $attributes ?>><?php
				$categories = get_the_category();
				if ( !empty( $categories ) ) {
					$out = array();
					foreach ( $categories as $c )
						$out[] = "<a href='upload.php?page=shiba_manage_gallery&category_name=$c->slug'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
						echo join( ', ', $out );
				} else {
					_e('Uncategorized');
				}
			?></td>
			<?php
			break;
	
			case 'tags':
			?>
			<td <?php echo $attributes ?>><?php
				$tags = get_the_tags($post->ID);
				if ( !empty( $tags ) ) {
					$out = array();
					foreach ( $tags as $c )
						$out[] = "<a href='upload.php?page=shiba_manage_gallery&tag=$c->slug'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'post_tag', 'display')) . "</a>";
					echo join( ', ', $out );
				} else {
					_e('No Tags');
				}
			?></td>
			<?php
			break;
	
			case 'images':
			?>
			<td <?php echo $attributes ?>><div class="post-com-count-wrapper">
			<?php
				$gallery_type = get_post_meta($post->ID, '_gallery_type', TRUE);
				if (!$gallery_type) $gallery_type = 'attachment';
	
				// Get count directly from database
				$num_images = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE post_parent = {$post->ID};"));
				
				// Add tag string count
				$tag_str = $shiba_mlib->get_post_tags_slug($post->ID);
				if ($tag_str) {
					$args = array(
						'tag' => $tag_str,
						'post_type' => $gallery_type,
						'posts_per_page' => -1,	
						'post_status' => 'any',
						'suppress_filters' => TRUE
					); 
		
					$tmp_query = new WP_Query;
					$images = $tmp_query->query($args);
				}
				if (is_array($images)) $num_images += count($images);
				// Remove self from count
				if (($gallery_type == 'any') || ($gallery_type == 'gallery')) $num_images--;
				echo $num_images; 
				unset($tmp_query); unset($images);
			?>
			</div></td>
			<?php
			break;
	
			case 'author':
			?>
			<td <?php echo $attributes ?>><a href="upload.php?page=shiba_manage_gallery&author=<?php the_author_meta('ID'); ?>"><?php the_author() ?></a></td>
			<?php
			break;
	
			default:
			?>
			<td <?php echo $attributes ?>><?php do_action('manage_shiba_mlib_custom_column', $column_name, $post->ID); ?></td>
			<?php
			break;
		}
	}
	?>
		</tr>
	<?php
		$post = $global_post;
	}

} // end Shiba_Media_Library_Menu class
endif;


?>