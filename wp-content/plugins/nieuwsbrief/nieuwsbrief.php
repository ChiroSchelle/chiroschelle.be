<?php
/*
Plugin Name: Nieuwsbrief
Plugin URI: http://www.chiroschelle.be/nieuws
Description: Deze plugin is instaat om een nieuwsbrief te maken en te sturen in de juiste chiro lay-out
Version: 1.0
Author: Ruben Mennes
Author URI: http://www.rubenmennes.be
*/

/*  Copyright 2010  Ruben Mennes  (email : ruben.mennes@me.com)

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


//een aantal instellingen 
// http://ottodestruct.com/blog/2009/wordpress-settings-api-tutorial/


define( 'NIEUWSBRIEF_FILE', basename(__FILE__) );
define( 'NIEUWSBRIEF_NAME', basename(__FILE__, ".php") );
define( 'NIEUWSBRIEF_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

require_once( NIEUWSBRIEF_PATH . '/functions.php' );
require_once( NIEUWSBRIEF_PATH . '/pages.php' );

//include vannalles
set_global_options();

//register capabilties
// get the "admin" role object
$role = get_role( 'administrator' );
// add "view_ledenbeheer" to this role object
//$role->add_cap( 'view_ledenbeheer' );
// add "edit_ledenbeheer" to this role object
//$role->add_cap( 'edit_ledenbeheer' );

//add our css-styles
function nieuwsbrief_admin_css_link() {
    $url = get_option('siteurl');
    $url = $url . '/wp-content/plugins/gap/css/wp-admin.css';
   echo '<link rel="stylesheet" type="text/css" href="' . $url . '" />';
}

//add_action('admin_head', 'gap_admin_css_link');

?>