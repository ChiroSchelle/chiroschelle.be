<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $shiba_mlib, $is_trash;
// Tags in $_POST['tax_input']['post_tag']
// Categories in $_POST['post_category'][1] - onwards

$title = __('Add New Gallery');
$action = NULL;
if (isset($_POST['action'])) $action = esc_attr($_POST['action']);
elseif (isset($_REQUEST['action'])) $action = esc_attr($_REQUEST['action']);
	
	
if (isset($_REQUEST['gallery'])) $id = absint($_REQUEST['gallery']);
else $id= 0;

if (isset($_POST['_wpnonce'])) $nonce=esc_attr($_POST['_wpnonce']);
else $nonce = '';

$location = 'upload.php?page=shiba_add_gallery';	
switch($action) {

case 'addgallery':

	if ( !current_user_can('edit_posts') )
		wp_die(__('You are not allowed to create galleries.'));
	check_admin_referer('addgallery0');
	
	// NOTE - thumb doesn't get added for new posts either so we can't add it for new galleries	
	// Create gallery object
	
	// Insert the post into the database
	$id = wp_insert_post( $_POST );
	if ( $id && !is_wp_error($id)) {
		$location = add_query_arg('message', 6, $location);
		$title = __('Edit Gallery');
	} else
		$location = add_query_arg('message', 7, $location);
	// Add gallery meta data	
	if ($id) {
		update_post_meta($id, '_gallery_type', esc_attr($_POST['gallery_type']) );
	}
	
	$location = add_query_arg('action', 'editgallery', $location);
	$location = add_query_arg('gallery', $id, $location);
	$shiba_mlib->javascript_redirect($location);
	exit();

case 'editgallery':
	if ( !current_user_can('edit_posts') )
			wp_die(__('You are not allowed to edit galleries.'));

	$title = __('Edit Gallery');
	break;

case 'updategallery':
	if ( !current_user_can('edit_posts') )
		wp_die(__('You are not allowed to save galleries.'));
	$title = __('Edit Gallery');
			
	if (isset($_POST['ID'])) {
		$id = absint($_POST['ID']);	
		check_admin_referer('updategallery'.$id);
		
		// Update post
		// Update the post into the database
		if ( wp_update_post( $_POST ) )
			$location = add_query_arg('message', 8, $location);
		else
			$location = add_query_arg('message', 9, $location);
		
	} else 
		$location = add_query_arg('message', 9, $location);


	// Add gallery meta data	
	if ($id) {
		$post_type = esc_attr($_POST['gallery_type']);
		update_post_meta($id, '_gallery_type', $post_type );
	}
	$location = add_query_arg('action', 'editgallery', $location);
	$location = add_query_arg('gallery', $id, $location);
	$shiba_mlib->javascript_redirect($location);
	exit();	
default:
}

$messages[1] = __('Media attachment updated.');
$messages[2] = __('Media permanently deleted.');
$messages[3] = __('Error saving media attachment.');
$messages[4] = __('Media moved to the trash.') . ' <a href="' . esc_url( wp_nonce_url( 'upload.php?doaction=undo&action=untrash&ids='.(isset($_GET['ids']) ? $_GET['ids'] : ''), "bulk-media" ) ) . '">' . __('Undo') . '</a>';
$messages[5] = __('Media restored from the trash.');
$messages[6] = __('Gallery added.');
$messages[7] = __('Gallery creation failed.');
$messages[8] = __('Gallery updated.');
$messages[9] = __('Gallery update failed.');
$message = '';
if ( isset($_GET['message']) && (int) $_GET['message'] ) {
	$message = $messages[$_GET['message']];
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
}

if ( isset($_GET['posted']) && (int) $_GET['posted'] ) {
	$message = $messages[1];
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('posted'), $_SERVER['REQUEST_URI']);
}

if ( isset($_GET['attached']) && (int) $_GET['attached'] ) {
	$attached = (int) $_GET['attached'];
	$message = sprintf( _n('Reattached %d attachment', 'Reattached %d attachments', $attached), $attached );
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('attached'), $_SERVER['REQUEST_URI']);
}

if ( isset($_GET['deleted']) && (int) $_GET['deleted'] ) {
	$message = $messages[2];
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('deleted'), $_SERVER['REQUEST_URI']);
}

if ( isset($_GET['trashed']) && (int) $_GET['trashed'] ) {
	$message = $messages[4];
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('trashed'), $_SERVER['REQUEST_URI']);
}

if ( isset($_GET['untrashed']) && (int) $_GET['untrashed'] ) {
	$message = $messages[5];
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('untrashed'), $_SERVER['REQUEST_URI']);
}




global $post;
if ($id) {
	$gallery = get_post($id);
	$gallery_name =$gallery->post_title;
	$gallery_description =$gallery->post_content;
	$gallery_excerpt = $gallery->post_excerpt;
	$action = 'updategallery';
	$post = $gallery;
	$post_type = $gallery_type = get_post_meta($id, '_gallery_type', TRUE);
	if (!$post_type) $post_type = 'attachment';
	// Can't paginate if we are adding in tagged attachment results    
	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'post_status' => 'any',
		'post_parent' => $id
		); 		
	query_posts($args);
	}
else {
	$action = 'addgallery';
	$temp_ID = -1 * time(); // don't change this formula without looking at wp_write_post()
	$id=0; $gallery = NULL;
	$gallery_type = 'attachment';
	$gallery_name = $gallery_description = $gallery_excerpt = NULL;
	}	

?>
<div class="wrap">   
	<?php screen_icon(); ?>
	<h2><?php echo esc_html( $title ); ?></h2>

	<?php
		if ( !empty($message) ) : 
		?>
		<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
		<?php 
		endif; 
	?>

<a href="media-upload.php?post_id=<?php if (!$id) echo $temp_ID; else echo $id;?>&amp;type=image&amp;TB_iframe=true" id="add_image" class="thickbox" title='Add an Image' onclick="return false;"></a>

    <form name="editgallery" id="editgallery" method="post" action="" class="">

    <?php global $screen_layout_columns;?>
    <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
    <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
    <div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
        <div id="side-info-column" class="inner-sidebar">

   		<?php $side_meta_boxes = do_meta_boxes($shiba_mlib->add_gallery, 'side', $gallery); ?>
 	</div>

        <input type="hidden" name="action" value="<?php echo $action;?>" />
        <input type="hidden" name="ID" value="<?php echo $id;?>" />
        
        <input type="hidden" name="post_type" value="gallery" />
        <input type="hidden" name="post_status" value="publish" />
 		        
		<?php 
			if (!$id) {
				echo "<input type='hidden' id='post_ID' name='temp_ID' value='" . esc_attr($temp_ID) . "' />";
			} else
				echo "<input type='hidden' id='post_ID' name='post_ID' value='" . esc_attr($id) . "' />";
		?>			
        <?php wp_nonce_field($action.$id); ?> 

       <div id="post-body" class="has-sidebar">
       <div id="post-body-content" class="has-sidebar-content">
        
        <div class="form-field form-required">
        <div id="titlediv">
            <div id="titlewrap">
                <label class="screen-reader-text" for="title">Title</label>
                <input type="text" name="post_title" id="title" size="30" tabindex="1" value="<?php echo $gallery_name;?>" autocomplete="off" />
            </div>
           <div class="inside">
				<?php 
				// From get_sample_permalink_html
				if ($id) :
					$sample_permalink_html = get_sample_permalink_html($post->ID);
					if ( !( 'pending' == $post->post_status && !current_user_can( 'publish_posts' ) ) ) { ?>
						<div id="edit-slug-box">
					<?php
						if ( ! empty($post->ID) && ! empty($sample_permalink_html) ) :
							echo $sample_permalink_html;
						endif; ?>
						</div>
					<?php
					} 				
				endif; ?>
			</div> <!-- End inside -->
     
        </div>  <!-- end titlediv -->          
        </div> <!-- end form-field -->
        
        <div style="padding-top:30px;">
            <h3><?php _e('Gallery Type') ?></h3>
            <input type="radio" name="gallery_type" value="any" <?php if ($gallery_type == 'any') echo "checked=1";?>> Any.<br/>
            <input type="radio" name="gallery_type" value="attachment" <?php if ($gallery_type == 'attachment') echo "checked=1";?>> Only Attachments.<br/>
			<input type="radio" name="gallery_type" value="post" <?php if ($gallery_type == 'post') echo "checked=1";?>> Only Posts.<br/>
			<input type="radio" name="gallery_type" value="gallery" <?php if ($gallery_type == 'gallery') echo "checked=1";?>> Only Galleries.<br/>
            <?php
			?>
        </div>
        
        <div class="form-field" style="padding-top:30px;">
            <h3><?php _e('Gallery Description') ?></h3>
            <textarea name="post_content" id="gallery_description" rows="5" cols="50"><?php echo $gallery_description;?></textarea>
            <p><?php _e('The description is not prominent by default, however some plugins may show it.'); ?></p>
        </div> <!-- end form-field -->
 
 		<p class="submit"><input type="submit" class="button" name="submit" value="<?php esc_attr_e('Update Gallery'); ?>" onClick="processEditGalleryForm('editgallery');"/></p>
 
 
 		<?php $meta_boxes = do_meta_boxes($shiba_mlib->add_gallery, 'normal', $gallery); ?>
		<?php $meta_boxes = do_meta_boxes($shiba_mlib->add_gallery, 'additional', $gallery); ?>

 	</div>
    </div> <!-- End post-body-content -->

	<?php
    wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
    wp_nonce_field( 'getpermalink', 'getpermalinknonce', false );
    wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );
    wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
          
    </div><!-- /poststuff -->
    
</form> <!-- End form EditGallery -->


<?php
	// list images in gallery
if ($id) :	
	$image_title = __('Add an Image');    

	?>
    <div style="clear:both;"></div>
	
    <h3 style="float:left;padding-right:20px;">Gallery Images</h3>
    
    <div style="position:relative; top:10px;">    
   	<form id="gallery-add-image" action="media-new.php" method="get"> 
    	<input type="hidden" name="post_id" id="post_id" value="<?php echo $id;?>" />        
        <input type="submit" value="<?php esc_attr_e('Add New'); ?>" name="addimage-to-gallery" class="button-secondary action"/>
 	</form>
	</div>
 
	<form id="gallery-list" action="upload.php" method="get">
		<?php wp_nonce_field('bulk-media'); ?>
        
        <div class="tablenav">
       
         <div class="alignleft actions">
        <select name="action" id="mlib_action" class="select-action">
        <option value="-1" selected="selected"><?php _e('Bulk Actions'); ?></option>
        <option value="remove"><?php _e('Detach from Gallery'); ?></option>
		<?php if (function_exists('wp_trash_post') && !$is_trash) { ?>
        <option value="trash"><?php _e('Move to Trash'); ?></option>
        <?php } ?>       
        <option value="delete"><?php _e('Delete Permanently'); ?></option>             
        </select>
        <input type="submit" value="<?php esc_attr_e('Apply'); ?>" name="doaction" id="mlib_doaction" class="button-secondary action" onClick="processGalleryForm('gallery-list');"/>
        </div> <!-- End alignleft actions -->
        
        <div style="clear:both;"></div>
    	</div> <!-- End tablenav -->
        
        <style>
			.column-new_icon { width: 70px; }
			.column-att_tag { width: 150px; }

		</style>

        <?php
//		global $post;
		include( 'edit-attachment-rows.php' );
            
		?>       	
        <div style="clear:both;"></div>
	</form> <!-- End gallery-list form -->
	<?php
endif;
?>
</div> <!-- End wrap --> 

<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) { 
             postboxes.add_postbox_toggles("<?php echo $shiba_mlib->add_gallery; ?>");
        });
	//]]>
</script>