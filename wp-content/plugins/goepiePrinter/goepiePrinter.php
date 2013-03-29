<?php
/*
Plugin Name: Goepie Printer
Plugin URI: http://www.chiroschelle.be/
Description: Deze plugin kan het programma printen voor de mensen van de goepie (Nog niet af!!!!)
Version: 0.5
Author: Ruben Mennes
Author URI: http://www.chiroschelle.be/ben
*/

/*  Copyright 2012  Ruben Mennes  (email : ruben.mennes@me.com)

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

*/

//een aantal instellingen 
// http://ottodestruct.com/blog/2009/wordpress-settings-api-tutorial/
define( 'GOEPIEPRINTER_FILE', basename(__FILE__) );
define( 'GOEPIEPRINTER_NAME', basename(__FILE__, ".php") );
define( 'GOEPIEPRINTER_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

require_once( GOEPIEPRINTER_PATH . '/functions.php' );
require_once( GOEPIEPRINTER_PATH . '/pages.php' );

//include vannalles
set_global_options();

//register capabilties
// get the "admin" role object
$role = get_role( 'goepie' );

$role->add_cap( 'view_goepie' );

