<?php
/*
Plugin Name: GAP Ledenbeheer
Plugin URI: http://www.chiroschelle.be/ben/
Description: Deze plugin geeft de leden weer zoals ze in het GAP zitten
Version: 0.5
Author: Ben Bridts
Author URI: http://www.chiroschelle.be/ben
*/

/*  Copyright 2010  Ben Bridts  (email : ben.bridts@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
TODO:
-) Instellingen in wp-db
-) wp-cron werkend krijgen en clear uploads verwijderen (of ergens in config)
-) api schrijven voor nationaal, zodat we meer kunnen ophalen zonder 30 volledige htmlpagina's te moeten vragen ;-)
-) Verkeerde instellingen opvangen en een duidelijke foutmelding geven
*/

//een aantal instellingen 
// http://ottodestruct.com/blog/2009/wordpress-settings-api-tutorial/


define( 'GAP_FILE', basename(__FILE__) );
define( 'GAP_NAME', basename(__FILE__, ".php") );
define( 'GAP_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

require_once( GAP_PATH . '/functions.php' );
require_once( GAP_PATH . '/pages.php' );

//include vannalles
set_global_options();

//register capabilties
// get the "admin" role object
$role = get_role( 'administrator' );
// add "view_ledenbeheer" to this role object
$role->add_cap( 'view_ledenbeheer' );
// add "edit_ledenbeheer" to this role object
$role->add_cap( 'edit_ledenbeheer' );

//add our css-styles
function gap_admin_css_link() {
    $url = get_option('siteurl');
    $url = $url . '/wp-content/plugins/gap/css/wp-admin.css';
   echo '<link rel="stylesheet" type="text/css" href="' . $url . '" />';
}

add_action('admin_head', 'gap_admin_css_link');

?>
