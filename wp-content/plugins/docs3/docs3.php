<?php
/*
Plugin Name: Documenten S3
Plugin URI: http://www.chiroschelle.be/ben/
Description: Verslagen en andere documenten opslaan op een Amazon S3 server
Version: 0.1
Author: Ben Bridts
Author URI: http://www.chiroschelle.be/ben
*/

/*
OPGEPAST:
een aanvaller kan door het aanpassen van de post-variablen alle bestanden op de
S3 server bekijken en overschrijven.
DIT IS GEEN VEILIGE PLUGIN
*/

/*  Copyright 2010-2011  Ben Bridts  (email : ben.bridts@gmail.com)

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

// een aantal instellingen 
// http://ottodestruct.com/blog/2009/wordpress-settings-api-tutorial/

define( 'DOCS3_FILE', basename(__FILE__) );
define( 'DOCS3_NAME', basename(__FILE__, ".php") );
define( 'DOCS3_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

//require_once( DOCS3_PATH . '/functions.php' );
require_once( DOCS3_PATH . '/sdk-1.3.3/sdk.class.php' );
require_once( DOCS3_PATH . '/functions.php' );
require_once( DOCS3_PATH . '/pages.php' );


//include vanalles ??? #TODO #TOFIX
//set_global_options();

//register capabilties
// get the "admin" role object
$role = get_role( 'administrator' );
// add "create_documents" to this role object
$role->add_cap( 'create_documents' );
// add "edit_documents" to this role object
// $role->add_cap( 'edit_documents' );

?>
