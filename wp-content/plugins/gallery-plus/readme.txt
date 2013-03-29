=== Plugin Name ===
Contributors: hawkwood
Tags: gallery, plugin, lightbox
Donate link: http://www.hawkwood.com/wp-donate.php
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: 1.4.1

Gallery Plus overrides the built-in Wordpress gallery to add an options page to edit existing and additional options.

== Description ==

The built-in Wordpress gallery has some options that are accessable through the use of **shortcodes**, but if you do not know them or the proper input they can be hard to use.  Similarly, there is now wat to make system wide changes without having to use **shortcodes** on all your galleries.  This plug-in creates an options page for some of those **shortcodes** along with adding other features that can extend the gallery's functionality.

== Installation ==

1. Copy 'gallery-plus' folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Change any settings through the `Gallery Plus` menu in the `Admin` section.

== Frequently Asked Questions ==

= What are the &#91;gallery&#93; shortcode options? =

* orderby - specify the sort order used to display thumbnails. The default is "menu_order ASC, ID ASC". 
* id - specify the post ID. The default behaviour if no ID is specified is to display images attached to the current post.
* itemtag - specify the name of the XHTML tag used to enclose each item in the gallery. The default is "dl".
* icontag - specify the name of the XHTML tag used to enclose each thumbnail icon in the gallery. The default is "dt". 
* captiontag - the name of the XHTML tag used to enclose each caption. The default is "dd".
* columns - specify the number of columns. The default is set in the Gallery Plus options.
* size - specify the image size to use for the thumbnail display. Valid values are "thumbnail", "medium" and "full". The default is set in the Gallery Plus options.
* linktype - specify what type of link to show. Valid values are "none", "post", and "image". The default is set in the Gallery Plus options.
* titlecaption - specify the source settings for both titles and captions. Valid values are "normal", "swap", "title", "caption", and "none". The default is set in the Gallery Plus options.
* atagtitle - set to "1" to specify that the title should be added into the &lt;a&gt; tag.
* link2full - specify if the links should go directly to the full resolution image. (depreciated)
* overlay - specify which overlay system to use. Valid values are "none" and "lightbox". The default is set in the Gallery Plus options.
* singleonly - specify whether gallery should show in the single post only, or when in a group.
* exclude - specify which images (by ordinal number, not ID) should not be shown in the gallery. Valid value is a comma separated list of image numbers.  The default is "" (none).
* adhoc - specify which images by ID to display. This overrides orderby, id, and exclude shortcodes. Valid value is a comma separated list of image IDs.  The default is "" (none).

= What are the &#91;gallery_excerpt&#93; shortcode options? =

* orderby - specify the sort order used to display thumbnails. The default is "menu_order ASC, ID ASC".
* id - specify the post ID. The gallery will display images which are attached to that post. The default behavior if no ID is specified is to display images attached to the current post.
* size - specify the image size to use for the thumbnail display. Valid values include "thumbnail", "medium" and "full". The default is set in the Gallery Plus options.
* imagenumber - specify which image (by ordinal number, not ID) from your sorted gallery to show. The default is "1".
* class - specify additional classes to assign to the image. The default is "alignleft".

== New Features ==

1. Added singleonly shortcode option.