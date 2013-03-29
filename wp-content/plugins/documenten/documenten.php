<?php
/*
Plugin Name: Documenten
Plugin URI: http://www.jo.chiroschelle.be/plugins/
Description: Verslagen LK, andere documenten
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
define( 'DOCUMENTEN_VERSION', "1.1");						#  Plugin Database Version: Change this value every time you make changes to your Plugin.
define( 'DOCUMENTEN_PURGE_DATA', '1' );				#  When Plugin is deactivated, if 'true', all Tables, and Options will be removed.

//define( 'WP_ADMIN_PATH', ABSPATH . '/wp-admin/');  // If you have a better answer to this Constant, feel free to send me an e-mail.

define( 'DOCUMENTEN_FILE', basename(__FILE__) );
define( 'DOCUMENTEN_NAME', basename(__FILE__, ".php") );
define( 'DOCUMENTEN_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

require_once( DOCUMENTEN_PATH . '/functions.php' );
require_once( DOCUMENTEN_PATH . '/opties.php' );
require_once( DOCUMENTEN_PATH . '/menus.php' );
//require_once( DOCUMENTEN_PATH . '/class.chirolid.php' );


define( 'DOCUMENTEN_URL', plugins_url('', __FILE__) );  // NOTE: It is recommended that every time you reference a url, that you specify the plugins_url('xxx.xxx',__FILE__), WP_PLUGIN_URL, WP_CONTENT_URL, WP_ADMIN_URL view the video by Will Norris.


$documenten_options = array(
	'versie' => '0.1',
	'email_updates' =>
'jobridts+leiding@gmail.com'
	);

add_option('documenten_options',$documenten_options);



?>