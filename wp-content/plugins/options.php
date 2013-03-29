<?php
$gpo_location = $gallery_plus_options_page; // Form Action URI

/* Check for admin Options submission and update options*/
if ('process' == $_POST['stage']) {
    update_option('gallery_plus_columns', trim($_POST['gallery_plus_columns']));
    update_option('gallery_plus_size', $_POST['gallery_plus_size']);
    update_option('gallery_plus_fullsize', $_POST['gallery_plus_fullsize']);
//	update_option('gallery_plus_link2full', $_POST['gallery_plus_link2full']);
	update_option('gallery_plus_linktype', $_POST['gallery_plus_linktype']);
	update_option('gallery_plus_titlecaption', $_POST['gallery_plus_titlecaption']);
	update_option('gallery_plus_atagtitle', $_POST['gallery_plus_atagtitle']);
	$new_overlay = trim($_POST['gallery_plus_overlay']);
	if (($_POST['gallery_plus_overlay_enabled'] == 1) && (($new_overlay != '') || ($new_overlay != 'none')))
		update_option('gallery_plus_overlay', $_POST['gallery_plus_overlay']);
	else update_option('gallery_plus_overlay', 'none');
	update_option('gallery_plus_overlay_attr', $_POST['gallery_plus_overlay_attr']);
	update_option('gallery_plus_singleonly', $_POST['gallery_plus_singleonly']);
	update_option('gallery_plus_css', $_POST['gallery_plus_css']);
}

/*Get options for form fields */
$gallery_plus_columns = stripslashes(get_option('gallery_plus_columns'));
$gallery_plus_size = stripslashes(get_option('gallery_plus_size'));
$gallery_plus_fullsize = stripslashes(get_option('gallery_plus_fullsize'));
/*
if (get_option('gallery_plus_link2full') !== false) delete_option('gallery_plus_link2full');
$gallery_plus_link2full = stripslashes(get_option('gallery_plus_link2full'));
$gallery_plus_linktype = get_option('gallery_plus_linktype');
if ($gallery_plus_linktype === false) $gallery_plus_linktype = stripslashes(get_option('gallery_plus_link2full'));
else $gallery_plus_linktype = stripslashes($gallery_plus_linktype);
*/
$gallery_plus_linktype = stripslashes(get_option('gallery_plus_linktype'));
$gallery_plus_titlecaption = stripslashes(get_option('gallery_plus_titlecaption'));
$gallery_plus_atagtitle = stripslashes(get_option('gallery_plus_atagtitle'));
$gallery_plus_overlay = stripslashes(get_option('gallery_plus_overlay'));
$gallery_plus_overlay_attr = stripslashes(get_option('gallery_plus_overlay_attr'));
$gallery_plus_singleonly = stripslashes(get_option('gallery_plus_singleonly'));
$gallery_plus_css = stripslashes(get_option('gallery_plus_css'));
?>

<div class="wrap">
<script type="text/javascript">
function setOverlayEnable(flag, flag2) {
	if (flag) {
		document.getElementById('gallery_plus_overlay').disabled = false;
		document.getElementById('gallery_plus_overlay').value = 'lightbox';
		if (flag2) document.getElementById('gallery_plus_overlay_enabled').checked = true;
		else document.getElementById('gallery_plus_linktype').selectedIndex = 2;
	} else {
		document.getElementById('gallery_plus_overlay').value = '';
		document.getElementById('gallery_plus_overlay').disabled = true;
		if (flag2) document.getElementById('gallery_plus_overlay_enabled').checked = false;
	}
}

</script>
<h2><?php _e('Gallery Plus Options', 'gallery_plus') ?></h2>
  <form name="form1" method="post" action="<?php echo $gpo_location ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
    <table class="form-table" width="100%" cellspacing="2" cellpadding="5" class="editform">
        <tr valign="baseline">
        <th scope="row"><?php _e('Gallery columns:') ?></th> 
        <td><input type="text" value="<?php echo $gallery_plus_columns; ?>" maxlength="3" size="3" name="gallery_plus_columns" /></td></tr>
		
		<tr valign="baseline">
        <th scope="row"><?php _e('Gallery icon size:') ?></th> 
        <td><select name="gallery_plus_size">
			<option value="thumbnail"<?php if ($gallery_plus_size == 'thumbnail') echo ' selected="selected"'; ?>>Thumbnail</option>
			<option value="medium"<?php if ($gallery_plus_size == 'medium') echo ' selected="selected"'; ?>>Medium</option>
			<option value="large"<?php if ($gallery_plus_size == 'large') echo ' selected="selected"'; ?>>Large</option>
			<option value="full"<?php if ($gallery_plus_size == 'full') echo ' selected="selected"'; ?>>Full Size</option>
			</select>
		</td></tr>

<?php /*
		<tr valign="baseline">
        <th scope="row"><?php _e('Link Images To Full Resolution:') ?></th>
		<td><input type="checkbox" value="1" name="gallery_plus_link2full"<?php if ($gallery_plus_link2full) echo ' checked="checked"'; ?> /> Image links will go directly to the full resolution image instead of the images post page.
		</td></tr>
	  */ ?>
		<tr valign="baseline">
        <th scope="row"><?php _e('Link type:') ?></th>
		<td><select id="gallery_plus_linktype" name="gallery_plus_linktype" onchange="if (this.options[this.selectedIndex].value != 'image') setOverlayEnable(false, true);">
			<option value="none"<?php if ($gallery_plus_linktype == 'none') echo ' selected="selected"'; ?>>none</option>
			<option value="post"<?php if ($gallery_plus_linktype == 'post') echo ' selected="selected"'; ?>>post</option>
			<option value="image"<?php if ($gallery_plus_linktype == 'image') echo ' selected="selected"'; ?>>image</option>
		</select> Type of link that will be inserted: no link, image post, or full resolution image.
		</td></tr>		
		
		<tr valign="baseline">
        <th scope="row"><?php _e('Title/Caption:') ?></th>
		<td>Modify title and caption of images as follows:<br />
		<label for="tcr0"><input id="tcr0" type="radio" name="gallery_plus_titlecaption" value=""<?php if ($gallery_plus_titlecaption == '') echo ' checked="checked"'; ?> />
		Normal: use image title as display title, and image caption as display caption.</label><br />
		<label for="tcr1"><input id="tcr1" type="radio" name="gallery_plus_titlecaption" value="swap"<?php if ($gallery_plus_titlecaption == 'swap') echo ' checked="checked"'; ?> />
		Swap: image title as display caption, and vice versa.</label><br />
		<label for="tcr2"><input id="tcr2" type="radio" name="gallery_plus_titlecaption" value="title"<?php if ($gallery_plus_titlecaption == 'title') echo ' checked="checked"'; ?> />
		Title: image title for both display title and caption.</label><br />
		<label for="tcr3"><input id="tcr3" type="radio" name="gallery_plus_titlecaption" value="caption"<?php if ($gallery_plus_titlecaption == 'caption') echo ' checked="checked"'; ?> />
		Caption: image caption for both display title and caption.</label><br />
		<label for="tcr4"><input id="tcr4" type="radio" name="gallery_plus_titlecaption" value="none"<?php if ($gallery_plus_titlecaption == 'none') echo ' checked="checked"'; ?> />
		None: hide both display title and caption.</label>

		</td></tr>

		<tr valign="baseline">
        <th scope="row"><?php _e('Show title in link:') ?></th>
		<td><label for="gallery_plus_atagtitle"><input type="checkbox" value="1" id="gallery_plus_atagtitle" name="gallery_plus_atagtitle"<?php if ($gallery_plus_atagtitle) echo ' checked="checked"'; ?> /> Title will be included in the link (&lt;a&gt; tag) which is useful for some overlay packages.</label>
		</td></tr>

		<tr valign="baseline">
        <th scope="row"><?php _e('Image overlay package:') ?></th>
		<td><label for="gallery_plus_overlay_enabled"><input type="checkbox" value="1" id="gallery_plus_overlay_enabled" name="gallery_plus_overlay_enabled"<?php if ($gallery_plus_overlay != 'none') echo ' checked="checked"'; ?> onchange="setOverlayEnable(this.checked, false);" /> Enable </label><input type="text" size="10" maxlength="40" value="<?php echo $gallery_plus_overlay; ?>" id="gallery_plus_overlay" name="gallery_plus_overlay" />
<?php /*		<select name="gallery_plus_overlay">
			<option value="none"<?php if ($gallery_plus_overlay == 'none') echo ' selected="selected"'; ?>>none</option>
			<option value="lightbox"<?php if ($gallery_plus_overlay == 'lightbox') echo ' selected="selected"'; ?>>lightbox</option>
			</select> */ ?>
			 as
			 <select name="gallery_plus_overlay_attr">
			<option value="rel"<?php if ($gallery_plus_overlay_attr == 'rel') echo ' selected="selected"'; ?>>rel</option>
			<option value="class"<?php if ($gallery_plus_overlay_attr == 'class') echo ' selected="selected"'; ?>>class</option>
			</select>
			attribute in link (&lt;a&gt; tag).
			<br />
			Specify which image overlay package to use, such as lightbox.<br />
			<strong>THIS PLUGIN DOES NOT INSTALL ANY OVERLAY PACKAGES.</strong>
		</td></tr>
		<tr valign="baseline">
        <th scope="row"><?php _e('Gallery link size:') ?></th> 
        <td><select name="gallery_plus_fullsize">
			<option value="thumbnail"<?php if ($gallery_plus_fullsize == 'thumbnail') echo ' selected="selected"'; ?>>Thumbnail</option>
			<option value="medium"<?php if ($gallery_plus_fullsize == 'medium') echo ' selected="selected"'; ?>>Medium</option>
			<option value="large"<?php if ($gallery_plus_fullsize == 'large') echo ' selected="selected"'; ?>>Large</option>
			<option value="full"<?php if ($gallery_plus_fullsize == 'full') echo ' selected="selected"'; ?>>Full Size</option>
			</select>If linked to an image, what size should it be?
		</td></tr>


		<tr valign="baseline">
        <th scope="row"><?php _e('Only show gallery when single post:') ?></th>
		<td><label for="gallery_plus_singleonly"><input type="checkbox" value="1" id="gallery_plus_singleonly" name="gallery_plus_singleonly"<?php if ($gallery_plus_singleonly) echo ' checked="checked"'; ?> /> The gallery will only show up when the post is viewed directly, not in a list of other posts.</label>
		</td></tr>
		
		<tr valign="baseline">
        <th scope="row"><?php _e('CSS:') ?></th>
		<td><textarea name="gallery_plus_css" style="width: 400px; height: 200px;"><?php echo $gallery_plus_css; ?></textarea>
		</td></tr>
     </table>

    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'lightbox_2') ?> &raquo;" />
    </p>
  </form>
</div>
