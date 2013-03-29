=== User Avatar ===
Contributors: sgagan, enej, oltdev, ctlt-dev
Tags: people lists, people, list, form, user profile, user avatar, thumbnail, upload photo, user, users, profile, biography, profile biography, user profile, description, profile description, rich text, wysiwyg, tinyMCE, photos, images,  members, directory, profiles, jQuery, sortable, tabbable, thickbox, overlay, media button, Your Profile
Requires at least: 3.0
Tested up to: 3.2
Stable Tag: trunk

Provides a thumbnail area in Your Profile, for users to upload & crop new images in an overlay to be saved and stored to their profile.

== Description ==

This plugin provides a thumbnail area in the Your Profile section, where users can upload & crop new images in an overlay and upon cropping the image, the new image will be saved and stored. This gives users with any role the chance to easily upload an image and view their current thumbnail, all in one go. In Discussion, the default image associated with the user will be replaced with the user avatar image uploaded and this will then be the image shown in comments and also in People Lists (see below).

**This plugin was developed for [People Lists](http://wordpress.org/extend/plugins/people-lists/ "People Lists WordPress Plugin Homepage") and this plugin  provides a rich text editor on the profile page for easy modifications of specific user profile information that can be displayed on any page using the [people-lists list=example-list] shortcode. Admins will also be able to add custom fields to the Your Profile section on WordPress and these fields can be displayed on any page using the People Lists template (which can be styled using HTML) that provides codes for every field that is desired to be displayed.  There is a specific code in People Lists that hooks this thumbnail into your lists template display, so grab People Lists plugin as well!!**

Take a look at the screenshots!

This plugin was developed using PHP 5.1 and hasn't been tested on other version of php
But if you are able to run upload picture and set them as featured image then you 
also shouldn't be have problems using this plugin.

== Installation ==

1. Download the plugin package `user-avatar.zip`
1. Unzip the package and upload to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. The user avatar thumbnail area in Your Profile.
2. Step 1: Upload an image
3. Step 2: Crop your image
4. Step 3: Image is ready

== Changelog ==
= 1.3.7 =
* Removed up some PHP notices
* Smaller default image created, so that it looks nicer in  some transations

== Changelog ==
= 1.3.6 =
* Improved compatibility issues with some plugins. (this might fix the issue of having some js errors and the crop area not showing up.)

= 1.3.5 =
* Added the Russian Translation thanks to - iV@N1971 

= 1.3.4 =
* Added the Italian Translation thanks to - Punxsutawney Phil
* generated html validates better in html strictmode 
* This is not a necessary update

= 1.3.3 =
* some more bugs resolved. Thanks to @ronymehta and @lilos
* 3.1 backwards compatibility for editing user avatars for people that have these sort of privileges. 

= 1.3.2 =
* Changed esc_url to esc_url_raw thanks to @ronymehta
* fixed a bug thanks to  @BandB

= 1.3.1 =
* Caching fixes
* Translation ready
* Security improvements

= 1.3 =
* Fixed bugs that were result of the WP 3.1 update and also making it more future prof
* Resizes images and caches them using timthumb script. 
* Better classes added to the avatar image so that less theme should break

= 1.2.1 =
* Fixed Error bug in comments

= 1.2 =
* Added functionality to remove avatar 
* Default image is Gravatar if it exists, else it will be the image selected from settings >> discussion

= 0.5 =
* First Public Release

== Upgrade Notice ==

= Upgrade to version 1.2.1 =
* September 2nd, 2010

= Upgrade to version 1.2 =
* August 27th, 2010

= No Upgrades yet =
* August 1st, 2010


