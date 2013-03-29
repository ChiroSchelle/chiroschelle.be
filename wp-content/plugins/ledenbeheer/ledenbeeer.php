<?php
/*
Plugin Name: Ledenbeheer
Plugin URI: http://www.jo.chiroschelle.be/plugins/
Description: Plugin om je leden te beheren, overgangen, mails, adressenlijst,....
Version: 0.1
Author: Jo Bridts
Author URI: http://www.jo.chiroschelle.be
*/

/*  Copyright 2008-2010  Jo Bridts  (email : jo.bridts@chiroschelle.be)

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


// Sets up Plugin configuration and routing based on names of Plugin folder and files.

# define Plugin constants
define( 'CHIROLEDEN_VERSION', "1.1");						#  Plugin Database Version: Change this value every time you make changes to your Plugin.
define( 'CHIROLEDEN_PURGE_DATA', '1' );				#  When Plugin is deactivated, if 'true', all Tables, and Options will be removed.

//define( 'WP_ADMIN_PATH', ABSPATH . '/wp-admin/');  // If you have a better answer to this Constant, feel free to send me an e-mail.

define( 'CHIROLEDEN_FILE', basename(__FILE__) );
define( 'CHIROLEDEN_NAME', basename(__FILE__, ".php") );
define( 'CHIROLEDEN_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

require_once( CHIROLEDEN_PATH . '/functions.php' );
require_once( CHIROLEDEN_PATH . '/opties.php' );
require_once( CHIROLEDEN_PATH . '/menus.php' );
require_once( CHIROLEDEN_PATH . '/class.chirolid.php' );


define( 'CHIROLEDEN_URL', plugins_url('', __FILE__) );  // NOTE: It is recommended that every time you reference a url, that you specify the plugins_url('xxx.xxx',__FILE__), WP_PLUGIN_URL, WP_CONTENT_URL, WP_ADMIN_URL view the video by Will Norris.


$chirocontact_options = array(
	'versie' => '0.1',
	'email_updates' =>
'vb@chiroschelle.be
jo.bridts@chiroschelle.be'
	);

add_option('chirocontact_options',$chirocontact_options);



?>