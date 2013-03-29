<?php
/*
Plugin Name: Contact Formulier
Plugin URI: http://jo.chiroschelle.be/plugins/
Description: Voegt een contactformulier toe met de functie chirocontact_toon_form(). Ontvangers kunnen worden aangepast via de instellingen
Version: 1.1
Author: Jo Bridts
Author URI: http://jo.chiroschelle.be
*/
/*  Copyright 2010  Jo Bridts  (email : jo.bridts@chiroschelle.be)

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

define( 'CONTACT_PLUGIN_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );


require_once(CONTACT_PLUGIN_PATH . '/opties.php');
require_once(CONTACT_PLUGIN_PATH . '/functions.php');
require_once(CONTACT_PLUGIN_PATH . '/form.php');


#voeg default opties toe
$chirocontact_options = array(
	'versie' => '1.1',
	'email_info' =>
'info@chiroschelle.be
vb@chiroschelle.be
groepsleiding@chiroschelle.be',
	'email_site' => 'webmaster@chiroschelle.be',
	'email_verhuur_garage' => '',
	'email_verhuur_lokalen' => '' ,
	'email_verhuur_tenten' => '' ,
	'email_verhuur_andere' => '',
	);

add_option('chirocontact_options',$chirocontact_options);
## creeer een admin pagina ##
add_action('admin_menu', 'chirocontact_menu');

function chirocontact_menu() {

  add_options_page('Contactformulier Opties', 'Contact formulier', 'administrator', 'chirocontact_options', 'chirocontact_options');
}

function chirocontact_options() {
  chirocontact_toon_opties();
}





?>