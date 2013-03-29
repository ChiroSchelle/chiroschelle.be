<?php

/**

 * @package YD_WPMU-Sitewide-Options

 * @author Yann Dubois

 * @version 3.0.1

 */



/*

 Plugin Name: YD Network-wide options

 Plugin URI: http://www.yann.com/en/wp-plugins/yd-wpmu-sitewide-options

 Description: Makes selected plugin settings network-wide. Change to a setting of your main blog can now be automatically replicated to all multisite blogs. Centralized management of your plugin options.

 Author: Yann Dubois

 Version: 3.0.1

 Author URI: http://www.yann.com/

 */



/**

 * @copyright 2010  Yann Dubois  ( email : yann _at_ abc.fr )

 *

 *  Original development of this plugin was kindly funded by http://www.pressonline.com

 *  Additional developments were kindly funded by Matt @ http://bossinternetmarketing.com

 *  Dutch translation kindly provided by: Rene @ http://fethiyehotels.com

 *  German translation kindly provided by: Rian @ http://www.pangaea.nl/diensten/exact-webshop

 *

 *  This program is free software; you can redistribute it and/or modify

 *  it under the terms of the GNU General Public License as published by

 *  the Free Software Foundation; either version 2 of the License, or

 *  (at your option) any later version.

 *

 *  This program is distributed in the hope that it will be useful,

 *  but WITHOUT ANY WARRANTY; without even the implied warranty of

 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

 *  GNU General Public License for more details.

 *

 *  You should have received a copy of the GNU General Public License

 *  along with this program; if not, write to the Free Software

 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

/**

 Revision 0.1.0:

 - Original beta release

 Revision 0.1.1:

 - Optional debug code

 Revision 0.2.0:

 - Bugfix: memory leak when replicating to a large number of blogs

 - Bugfix: possible unwanted recursion when updating an option

 - Improved settings page design

 - Debug messages for diagnosing memory problems

 - Dutch version

 Revision 1.0.0:

 - Bugfix: A single child blog should be enough

 - Bugfix: Blogs should not have to be public/immature/... to allow replication (TODO: -> make this into options?)

 - New feature: Autospreading settings change is now an option (enable/disable update action hook)

 - New feature: Auto-apply default options when new blog is created

 - New feature: Can disable overwriting of existing options when updating from the settings page

 Revision 1.1.0

 - Bugfix: Auto-apply default options when new blog is created (funded by Matt Hardy @ bbgqt.org)

 - New feature: default options are displayed in the settings page

 - German version

 Revision 1.1.1

 - Bugfix: unserialize (thanks, Andrew)

 - Added missing credits

 Revision 3.0

 - Wordpress 3.0 compatibility

 - Admin panel W3C compatibility issues

 - Minor bug fixes

 - Documentation upgraded to match WP 3.0 vocabulary

 - Upgraded French version

 - Upgraded funding credits

 - Name changed from YD WPMU Sitewide Options to YD Network-wide options

 - Widget settings buttons renamed to plugin settings (there is no widget)

 Revision 3.0.1

 - Minor text fixes

 

 TODO:

 Rename plugin option key from widget_yd_wpmuso tp plugin_yd_wpmuso / register_option()

 There would be another way of performing this:

 Instead of physically "spreading" the option data on all the sub-blogs,

 we could hook into the get_option call to make it always take the main blog's option setting.

 An option could even be to choose which blog serves as the "master". (right now it is the first blog)

 This could possibly be a choice for each option: spread or centralize.

 Other possible evolutions: 

 - select which blogs to spread to

 - set the auto-spread / overwrite / centralize option individually for each blog / option

 */



/** Install or reset plugin defaults **/

function yd_wpmuso_reset( $force ) {

	/** Init values **/

	$yd_wpmuso_version		= "3.0.1";

	$newoption				= 'widget_yd_wpmuso';

	$newvalue				= '';

	$prev_options = get_option( $newoption );

	if( ( isset( $force ) && $force ) || !isset( $prev_options['plugin_version'] ) ) {

		// those default options are set-up at plugin first-install or manual reset only

		// they will not be changed when the plugin is just upgraded or deactivated/reactivated

		$newvalue['plugin_version'] 	= $yd_wpmuso_version;

		$newvalue[0]['debug'] 			= 0;

		$newvalue[0]['selected_options']= 0;

		$newvalue[0]['disable_backlink']= 0;

		$newvalue[0]['autospread']		= 1;

		$newvalue[0]['auto_new_blog']	= 1;

		$newvalue[0]['over_write']		= 1;

		if( $prev_options ) {

			update_option( $newoption, $newvalue );

		} else {

			add_option( $newoption, $newvalue );

		}

	}

}

register_activation_hook(__FILE__, 'yd_wpmuso_reset');



/** Create Text Domain For Translations **/

add_action('init', 'yd_wpmuso_textdomain');

function yd_wpmuso_textdomain() {

	$plugin_dir = basename( dirname(__FILE__) );

	load_plugin_textdomain(

		'yd-wpmuso',

		PLUGINDIR . '/' . dirname( plugin_basename( __FILE__ ) ),

		dirname( plugin_basename( __FILE__ ) )

	); 

}



/** Create custom admin menu page **/

add_action('admin_menu', 'yd_wpmuso_menu');

function yd_wpmuso_menu() {

	add_options_page(

	__('YD Network-wide Options',

		'yd-wpmuso'), 

	__('YD Network-wide Options', 'yd-wpmuso'),

	8,

	__FILE__,

		'yd_wpmuso_options'

		);

}

function yd_wpmuso_options() {

	global $wpdb;

	$support_url	= 'http://www.yann.com/en/wp-plugins/yd-wpmu-sitewide-options';

	$yd_logo		= 'http://www.yann.com/yd-wpmuso-v301-logo.gif';

	$jstext			= preg_replace( "/'/", "\\'", __( 'This will disable the link in your blog footer. ' .

							'If you are using this plugin on your site and like it, ' .

							'did you consider making a donation?' .

							' - Thanks.', 'yd-wpmuso' ) );

	$d = false;

	if( $_GET['debug'] == 1 ) $d = true;

	?>

	<script type="text/javascript">

	<!--

	function donatemsg() {

		alert( '<?php echo $jstext ?>' );

	}

	//-->

	</script>

	<?php

	echo '<div class="wrap">';

	

	// ---

	// options/settings page header section: h2 title + warnings / updates

	// ---



	echo '<h2>' . __('YD Network-wide Options', 'yd-wpmuso') . '</h2>';

	

	if( isset( $_GET["do"] ) ) {

		echo '<div class="updated">';

		if($d) echo '<p>' . __('Action:', 'yd-wpmuso') . ' '

		. __( 'I should now', 'yd-wpmuso' ) . ' ' . __( $_GET["do"], 'yd-wpmuso' ) . '.</p>';

		if(			$_GET["do"] == __('Reset plugin settings', 'yd-wpmuso') ) {

			yd_wpmuso_reset( 'force' );

			echo '<p>' . __('Plugin settings are reset', 'yd-wpmuso') . '</p>';

		} elseif(	$_GET["do"] == __('Update plugin settings', 'yd-wpmuso') ) {

			yd_wpmuso_update_options();

			echo '<p>' . __('Plugin settings are updated', 'yd-wpmuso') . '</p>';

		}

		echo '</div>'; // / updated

	} else {

		echo '<div class="updated">';

		echo '<p>'

		. '<a href="' . $support_url . '" target="_blank" title="Plugin FAQ">';

		echo __('Welcome to YD Network-wide Options Admin Page.', 'yd-wpmuso')

		. '</a></p>';

		echo '</div>'; // / updated

	}

	$options = get_option( 'widget_yd_wpmuso' );

	$i = 0;

	if( ! is_array( $options ) ) {

		// Something went wrong

		echo '<div class="updated">'; //TODO: Replace with appropriate error / warning class (red/pink)

		echo __( 'Uh-oh. Looks like I lost my settings. Sorry.', 'yd-wpmuso' );

		echo '<form method="get" style="display:inline;" action="">';

		echo '<input type="submit" name="do" value="' . __( 'Reset plugin settings', 'yd-wpmuso' ) . '" /><br/>';

		echo '<input type="hidden" name="page" value="' . $_GET["page"] . '" />';

		echo '</form>';

		echo '</div>'; // / updated

		return false;

	}

	

	// ---

	// Right sidebar

	// ---

	

	echo '<div class="metabox-holder has-right-sidebar">';

	echo '<div class="inner-sidebar">';

	echo '<div class="meta-box-sortabless ui-sortable">';



	// == Block 1 ==



	echo '<div class="postbox">';

	echo '<h3 class="hndle">' . __( 'Considered donating?', 'yd-wpmuso' ) . '</h3>';

	echo '<div class="inside" style="text-align:center;"><br/>';

	echo '<a href="' . $support_url . '" target="_blank" title="Plugin FAQ">'

	. '<img src="' . $yd_logo . '" alt="YD logo" /></a>'

	. '<br/><small>' . __( 'Enjoy this plugin?', 'yd-wpmuso' ) . '<br/>' . __( 'Help me improve it!', 'yd-wpmuso' ) . '</small><br/>'

	. '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">'

	. '<input type="hidden" name="cmd" value="_s-xclick"/>'

	. '<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----'

	. '" />'

	. '<input type="image" src="https://www.paypal.com/' . __( 'en_US', 'yd-wpmuso' ) . '/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />'

	. '<img alt="" border="0" src="https://www.paypal.com/' . __( 'en_US', 'yd-wpmuso' ) . '/i/scr/pixel.gif" width="1" height="1" />'

	. '</form>'

	. '<small><strong>' . __( 'Thanks', 'yd-wpmuso' ) . ' - Yann.</strong></small><br/><br/>';

	

	echo '</div>'; // / inside

	echo '</div>'; // / postbox

	

	// == Block 2 ==

	

	echo '<div class="postbox">';

	echo '<h3 class="hndle">' . __( 'Credits', 'yd-wpmuso' ) . '</h3>';

	echo '<div class="inside" style="padding:10px;">';

	echo 'v.' . $options['plugin_version'] . '<br/>';

	echo '<b>' . __( 'Funding', 'yd-wpmuso' ) . '</b>';

	echo '<ul>';

	echo '<li>' . __( 'Initial:', 'yd-wpmuso' ) . ' <a href="http://www.wellcom.fr">Wellcom</a></li>';

	echo '<li>' . __( 'Additional:', 'yd-wpmuso' ) . '  <a href="http://bossinternetmarketing.com/">Bossinternetmarketing</a></li>';

	echo '</ul>';

	echo '<b>' . __( 'Translations', 'yd-wpmuso' ) . '</b>';

	echo '<ul>';

	echo '<li>' . __( 'English:', 'yd-wpmuso' ) . ' <a href="http://www.yann.com">Yann</a></li>';

	echo '<li>' . __( 'French:', 'yd-wpmuso' ) . ' <a href="http://www.yann.com">Yann</a></li>';

	echo '<li>' . __( 'Dutch:', 'yd-wpmuso' ) . ' <a href="http://www.fethiyehotels.com">Rene</a></li>';

	echo '<li>' . __( 'German:', 'yd-wpmuso' ) . ' <a href="http://www.pangaea.nl/diensten/exact-webshop">Rian</a></li>';

	echo '</ul>';

	echo __( 'If you want to contribute to a translation of this plugin, please drop me a line by ', 'yd-wpmuso' );

	echo '<a href="mailto:yann@abc.fr">' . __('e-mail', 'yd-wpmuso' ) . '</a> ';

	echo __( 'or leave a comment on the ', 'yd-wpmuso' );

	echo '<a href="' . $support_url . '">' . __( 'plugin\'s page', 'yd-wpmuso' ) . '</a>. ';

	echo __( 'You will get credit for your translation in the plugin file and the documentation page, ', 'yd-wpmuso' );

	echo __( 'as well as a link on this page and on my developers\' blog.', 'yd-wpmuso' );

		

	echo '</div>'; // / inside

	echo '</div>'; // / postbox

	

	// == Block 3 ==

	

	echo '<div class="postbox">';

	echo '<h3 class="hndle">' . __( 'Support' ) . '</h3>';

	echo '<div class="inside" style="padding:10px;">';

	echo '<b>' . __( 'Free support', 'yd-wpmuso' ) . '</b>';

	echo '<ul>';

	echo '<li>' . __( 'Support page:', 'yd-wpmuso' );

	echo ' <a href="' . $support_url . '">' . __( 'here.', 'yd-wpmuso' ) . '</a>';

	echo ' ' . __( '(use comments!)', 'yd-wpmuso' ) . '</li>';

	echo '</ul>';

	echo '<p><b>' . __( 'Professional consulting', 'yd-wpmuso' ) . '</b><br/>';

	echo __( 'I am available as an experienced free-lance Wordpress plugin developer and web consultant. ', 'yd-wpmuso' );

	echo __( 'Please feel free to <a href="mailto:yann@abc.fr">check with me</a> for any adaptation or specific implementation of this plugin. ', 'yd-wpmuso' );

	echo __( 'Or for any WP-related custom development or consulting work. Hourly rates available.', 'yd-wpmuso' ) . '</p>';

	echo '</div>'; // / inside

	echo '</div>'; // / postbox

	

	echo '</div>'; // / meta-box-sortabless ui-sortable

	echo '</div>'; // / inner-sidebar



	// ---

	// Main content area

	// ---

	

	echo '<div class="has-sidebar sm-padded">';

	echo '<div id="post-body-content" class="has-sidebar-content">';

	echo '<div class="meta-box-sortabless">';



	//---

	echo '<form method="get" style="display:inline;" action="">';

	//---

	

	$optionslist = $wpdb->get_results( "SELECT * FROM $wpdb->options WHERE NOT option_name LIKE '\\_%' ORDER BY option_name" );

	

	/**

	// let's try to sort some options...

	global $new_whitelist_options;

	if( $new_whitelist_options ) {

		echo '<div class="postbox">';

		echo '<h3 class="hndle">' . __( 'Registered plugin options:', 'yd-wpmuso' ) . '</h3>';

		echo '<div class="inside">';

		echo '<pre>' . var_dump( $new_whitelist_options ) . '</pre>';	

		echo '<table style="margin:10px;table-layout:fixed;width:95%">';

		echo '<tr><td valign="top" style="width:47%">' . __('Replicate these options network-wide:', 'yd-wpmuso') .

			'</td><td style="width:3%">&nbsp;</td><td style="width:50%">' . __('Value from master blog:', 'yd-wpmuso') . '</td></tr>';

		foreach ( (array) $new_whitelist_options as $group_name => $option_group ) {

			echo '<tr><td colspan="3"><strong>' . __( 'Options from group:', 'yd-wpmuso' ) . ' ' . $group_name 

				. '</strong></td></tr>';

			foreach( (array) $option_group as $option_name ) {

				foreach( $optionslist as $key => $option ) {

					if( esc_attr( $option->option_name ) == $option_name ) {

						$myoption = $option;

						unset( $optionslist[$key] );

					}

				}

				//$val = get_blog_option( 1, $opt );

				yd_wpmuso_display_optfield( $myoption, $options, $i );

			}

		}

		echo '</table>';

		echo '</div>'; // / inside

		echo '</div>'; // / postbox

	}



	echo '<div class="postbox">';

	echo '<h3 class="hndle">' . __( 'Widget options:', 'yd-wpmuso' ) . '</h3>';

	echo '<div class="inside">';

	

	echo '</div>'; // / inside

	echo '</div>'; // / postbox	

	**/

	

	// == Main plugin options ==

	

	echo '<div class="postbox">';

	echo '<h3 class="hndle">' . __( 'Options to propagate:', 'yd-wpmuso' ) . '</h3>';

	echo '<div class="inside">';

	

	echo '<table style="margin:10px;table-layout:fixed;width:95%">';

	

	// List of available options in the main blog

	echo '<tr><td valign="top" style="width:47%">' . __('Replicate these options network-wide:', 'yd-wpmuso') .

		'</td><td style="width:3%">&nbsp;</td><td style="width:50%">' . __('Value from master blog:', 'yd-wpmuso') . '</td></tr>';

	foreach ( (array) $optionslist as $option) {

		yd_wpmuso_display_optfield( $option, $options, $i );

	}

	

	echo '</table>';

	echo '</div>'; // / inside

	echo '</div>'; // / postbox

	

	// == Other options ==



	echo '<div class="postbox">';

	echo '<h3 class="hndle">' . __( 'Global settings:', 'yd-wpmuso' ) . '</h3>';

	echo '<div class="inside">';

	echo '<table style="margin:10px;">';

	

	// over_write

	echo "

		<tr>

			<th scope=\"row\" align=\"right\"><label for=\"yd_wpmuso-over_write-0\">" 

			. __('Overwrite existing blog settings:', 'yd-wpmuso') . "

			</label></th>";

	echo "	<td><input type=\"checkbox\" name=\"yd_wpmuso-over_write-0\" value=\"1\" id=\"yd_wpmuso-over_write-0\" ";

	if( $options[$i]["over_write"] == 1 )

		echo ' checked="checked" ';

	echo ' /></td></tr>';

	// autospreading

	echo "

		<tr>

			<th scope=\"row\" align=\"right\"><label for=\"yd_wpmuso-autospreading-0\">" 

			. __('Automatically apply future changes to all blogs:', 'yd-wpmuso') . "

			</label></th>";

	echo "	<td><input type=\"checkbox\" name=\"yd_wpmuso-autospreading-0\" value=\"1\" id=\"yd_wpmuso-autospreading-0\" ";

	if( $options[$i]["autospreading"] == 1 )

		echo ' checked="checked" ';

	echo ' /></td></tr>';

	// auto_new_blog

	echo "

		<tr>

			<th scope=\"row\" align=\"right\"><label for=\"yd_wpmuso-auto_new_blog-0\">" 

			. __('Spread options to new blogs:', 'yd-wpmuso') . "

			</label></th>";

	echo "	<td><input type=\"checkbox\" name=\"yd_wpmuso-auto_new_blog-0\" value=\"1\" id=\"yd_wpmuso-auto_new_blog-0\" ";

	if( $options[$i]["auto_new_blog"] == 1 )

		echo ' checked="checked" ';	

	echo '/></td></tr>';

	// Debug messages

	echo "

		<tr>

			<th scope=\"row\" align=\"right\"><label for=\"debug\">" 

			. __('Show debug messages:', 'yd-wpmuso') . "

			</label></th>";

	echo "	<td><input type=\"checkbox\" name=\"debug\" value=\"1\" id=\"debug\" ";

	if( $_GET['debug'] == 1 )

		echo ' checked="checked" ';

	echo " /></td></tr>";

	// Disable backlink

	echo '<tr><th scope="row" align="right"><label for="yd_wpmuso-disable_backlink-0">' 

			. __( 'Disable backlink in the blog footer:', 'yd-wpmuso' ) .

		'</label></th><td><input type="checkbox" name="yd_wpmuso-disable_backlink-0" value="1" id="yd_wpmuso-disable_backlink-0" ';

	if( $options[$i]["disable_backlink"] == 1 ) echo ' checked="checked" ';

	echo ' onclick="donatemsg()" ';

	echo ' /></td></tr>';

			

	//---

	

	echo '</table>';

	

	echo '</div>'; // / inside

	echo '</div>'; // / postbox

	

	//echo '<div>';

	echo '<p class="submit">';

	echo '<input type="submit" name="do" value="' . __('Update plugin settings', 'yd-wpmuso') . '" />';

	echo '<input type="hidden" name="page" value="' . $_GET["page"] . '" />';

	echo '<input type="hidden" name="time" value="' . time() . '" />';

	echo '<input type="submit" name="do" value="' . __('Reset plugin settings', 'yd-wpmuso') . '" />';

	echo '</p>'; // / submit

	echo '</form>';

	//echo '</div>'; // /

	

	echo '</div>'; // / meta-box-sortabless

	echo '</div>'; // / has-sidebar-content

	echo '</div>'; // / has-sidebar sm-padded

	echo '</div>'; // / metabox-holder has-right-sidebar

	echo '</div>'; // /wrap

}



function yd_wpmuso_display_optfield( $option, $options, $i ) {

	global $ydacount;

	$opt = esc_attr( $option->option_name );

	$val = $option->option_value;

	$opt_id = preg_replace( '/\s+/', '_', $opt );

	$disabled = '';

	echo "

		<tr>

			<th scope=\"row\" align=\"right\"><label for=\"$opt_id\">$opt</label></th>";

	echo "	<td><input type=\"checkbox\" name=\"yd_wpmuso-selected_options-0[]\" value=\"$opt\" id=\"$opt_id\" ";

	if( is_array( $options[$i]["selected_options"] ) && in_array( $opt, $options[$i]["selected_options"] ) )

		echo ' checked="checked" ';

	echo " /></td>";

	if( is_string( $option->option_value ) ) $uns = unserialize( $option->option_value );

	echo '<td>';

	//echo substr( 0, 64, $val ); sub

	if( $uns || is_array( $uns ) || is_object( $uns ) ) {

		if( is_string( $uns ) && $uns2 = unserialize( $uns ) ) $uns = $uns2; //double serialized...

		$ydacount ++;

		echo '<div ' .

			' onmouseover="document.getElementById(\'yda' . $ydacount . '\').style.display=\'block\';" ' .

			' onmouseout="document.getElementById(\'yda' . $ydacount . '\').style.display=\'none\';" ' .

			'><div ' .

			' style="color:blue;text-decoration:underline" ' .

			'>Serial data</div>';

		echo '<div id="yda' . $ydacount . '" style="display:none;color:#333;text-decoration:none;background:white;"><pre style="background:white;border:2px solid #CCC;overflow:scroll;">';

		ob_start();

		var_dump($uns);

		$a=ob_get_contents();

		ob_end_clean();

		echo htmlspecialchars($a,ENT_QUOTES);

		echo '</pre></div>';

		echo '</div>';

	} elseif( is_string( $val ) ) {

		echo '<div style="overflow:hidden;" title="' . htmlentities( $val ) . '">';

		echo htmlentities( substr( $val, 0, 40 ) );

		echo '</div>';

	} else {

		echo 'not displayable';

	}

	echo '</td>';

	echo "</tr>";

}



/** Update display options of the options admin page **/

function yd_wpmuso_update_options(){

	$options = get_option( 'widget_yd_wpmuso' );

	$i = 0;

	$to_update = Array(

		'selected_options',

		'disable_backlink',

		'autospreading',

		'auto_new_blog',

		'over_write'

	);

	yd_update_options_nostrip_array( 'widget_yd_wpmuso', 0, $to_update, $_GET, 'yd_wpmuso-' );

	yd_wpmuso_set_action_hooks();

	yd_wpmuso_replicate_options();

}



/** Add links on the plugin page (short description) **/

add_filter( 'plugin_row_meta', 'yd_wpmuso_links' , 10, 2 );

function yd_wpmuso_links( $links, $file ) {

	$base = plugin_basename(__FILE__);

	if ( $file == $base ) {

		$links[] = '<a href="options-general.php?page=yd-wpmu-sitewide-options%2F' . basename( __FILE__ ) . '">' . __('Settings') . '</a>';

		$links[] = '<a href="http://www.yann.com/en/wp-plugins/yd-wpmu-sitewide-options">' . __('Support') . '</a>';

	}

	return $links;

}



function yd_wpmuso_action_links( $links ) {

	$settings_link = '<a href="options-general.php?page=yd-wpmu-sitewide-options%2F' . basename( __FILE__ ) . '">' . __('Settings') . '</a>';

	array_unshift( $links, $settings_link );

	return $links;

}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'yd_wpmuso_action_links', 10, 4 );



function yd_wpmuso_linkware() {

	$options = get_option( 'widget_yd_wpmuso' );

	$i = 0;

	if( $options[$i]['disable_backlink'] ) echo "<!--\n";

	//echo '<p style="text-align:center" class="yd_linkware"><small><a href="http://www.yann.com/en/wp-plugins/yd-wpmu-sitewide-options">Network-wide options by YD Freelance Wordpress Development</a></small></p>';

	if( $options[$i]['disable_backlink'] ) echo "\n-->";

}

add_action('wp_footer', 'yd_wpmuso_linkware');



// ============================ Plugin specific functions ============================



function yd_wpmuso_set_action_hooks() {

	$options = get_option( 'widget_yd_wpmuso' );

	$i = 0;

	if( $options[$i]["autospreading"] == 1 && is_array( $options[$i]["selected_options"] ) ) {

		foreach( $options[$i]["selected_options"] as $opt ) {

			remove_action( 'update_option_' . $opt, 'yd_wpmuso_options_hook' );

			add_action ( 'update_option_' . $opt, 'yd_wpmuso_options_hook' );

		}

	} else {

		global $wpdb;

		$optionslist = $wpdb->get_results( "SELECT * FROM $wpdb->options WHERE NOT option_name LIKE '\\_%'" );

		foreach ( (array) $optionslist as $option) {

			$opt = esc_attr( $option->option_name );

			remove_action( 'update_option_' . $opt, 'yd_wpmuso_options_hook' );

		}

	}

}

add_action( 'plugins_loaded', 'yd_wpmuso_set_action_hooks' );



function yd_wpmuso_replicate_options() {

	//echo 'replicating...<br/>';

	$options = get_option( 'widget_yd_wpmuso' );

	$i = 0;

	$order = '';

	$limit = '';

	$d = false;

	if( $_GET['debug'] == 1 ) $d = true;

    $blog_list = yd_get_blog_list();

    $blog_count = count( $blog_list );

    if($d) echo $blog_count . ' blogs to update.<br/>';

	if( $blog_count > 1 ) {

	    if( is_array( $options[$i]["selected_options"] ) ) {

	    	if($d) $option_count = count( $options[$i]["selected_options"] );

	    	if($d) echo $option_count . ' options to update.<br/>';

	    	if($d) $total_ops = ( $blog_count * $option_count );

	    	if($d) echo 'total: ' . $total_ops . ' operations to perform.<br/>';

	    	if($d) echo 'max execution time: ' . ini_get('max_execution_time') . '<br/>';

	    	if($d) echo 'max memory: ' . ini_get('memory_limit') . '<br/>';

	    	if($d) echo 'memory usage: ' . memory_get_usage( FALSE ) . '<br/>';

	    	if($d) echo 'memory usage (real): ' . memory_get_usage( TRUE ) . '<br/>';

	    	wp_cache_flush();

	    	if($d) echo 'cache flushed - memory usage: ' . memory_get_usage( FALSE ) . '<br/>';

	    	if($d) echo 'memory usage (real): ' . memory_get_usage( TRUE ) . '<br/>';	    	

	    	//if($d) set_time_limit ( 35 );

	    	//if($d) echo 'new max execution time: ' . ini_get('max_execution_time') . '<br/>';

	    	if($d) $count_op = 0;

	    	if($d) $start_t = microtime();

	    	foreach( $options[$i]["selected_options"] as $opt ) {

	    		$value = get_option( $opt );

	    		$newoption[$opt] = $value;

	    	}

	    	//maybe looping through the blogs first is more efficient?!?!

		    foreach( $blog_list as $blog ) {

		    	if( $blog['blog_id'] == 1 ) continue;

		    	wp_cache_flush();

		    	//switch_to_blog( $blog['blog_id'] );

	    		foreach( $newoption as $opt => $value ) {

		    		if($d) $count_op ++;

		    		if($d) echo 'updating op (' . $count_op . '/' . $total_ops . ') ' .

		    			't: ' . ( microtime() - $start_t ) .

		    			' blog: ' . $blog['blog_id'] . ' opt: ' . $opt . ' val: ' . $value . ' ';

		    		if($d) echo 'mem: ' . floor( memory_get_usage( TRUE ) / 1024 / 1024 ) . ' ...';

		    		if( $options[$i]['over_write'] || !get_blog_option( $blog['blog_id'], $opt )  )

		    			update_blog_option( $blog['blog_id'], $opt, $value, FALSE );

		    		//update_option( $opt, $value );

		    		if($d) echo 'ok.<br/>';

		    		if($d) {

		    			$allowed = intval( ini_get('memory_limit') );

		    			$used = floor( memory_get_usage( TRUE ) / 1024 / 1024 ); //  + 92

		    			$left = $allowed - $used;

		    			echo ' allowed: ' . $allowed . ' used: ' . $used . ' ';

		    			if( $left < 5 ) {

		    				$new = $allowed + 5;

		    				echo 'memory is getting low... trying to allocate more... ';

		    				ini_set( 'memory_limit', $new . 'M' );

		    				echo $new . ' allocated ok.<br/>';

		    			}

		    		}

		    		if($d) flush();

		    	}

		    }

		    //restore_current_blog();

		    if($d) echo 'End of updating operations.<br/>';

		    if($d) flush();

		}

	}

}



function yd_wpmuso_options_new_blog_action( $blog_id ) {

	if( $blog_id == 1 ) return;

	$options = get_option( 'widget_yd_wpmuso' );

	if( !$options ) $options = get_blog_option( 1, 'widget_yd_wpmuso' );

	$i = 0;

	/**

	 *debug

	 **

	echo "auto_new_blog: " . $options[$i]["auto_new_blog"] . '<br/>';

	echo "selected_options: " . $options[$i]["selected_options"] . '<br/>';

	echo "blog_id: " . $blog_id . '<br/>';

	echo '<pre>';

	var_dump( $options[$i]["selected_options"] );

	echo '</pre>';

	/**

	exit(0);

	**/

	if( $options[$i]["auto_new_blog"] && is_array( $options[$i]["selected_options"] ) ) {

		foreach( $options[$i]["selected_options"] as $opt ) {

			//echo $opt . ': ';

			$value = false;

    		//$value = get_option( $opt );

    		if( !$value ) $value = get_blog_option( 1, $opt );

    		//echo $value . '<br/>';

    		$newoption[$opt] = $value;

    	}

		foreach( $newoption as $opt => $value ) {

			//echo $opt . ': ' . $value . '<br/>';

     		update_blog_option( $blog_id, $opt, $value, FALSE );

     	}

	}

	//exit(0);

}

add_action( 'wpmu_new_blog', 'yd_wpmuso_options_new_blog_action' );



function yd_wpmuso_options_hook( $value ) {

	//echo 'options hook...<br/>';

	$bt = debug_backtrace(false);

	$caller = $bt[2]['args'][0];

	$caller_file = $bt[3]['file'];

	if( preg_match( '/wpmu-functions.php$/', $caller_file ) ) return $value;

	/**

	echo 'caller: ' . $caller . '<br/>';

	echo '<pre>';

	//echo "BT:\n";

	//var_dump( $bt );

	echo "CALLER:\n";

	var_dump( $caller );

	echo "CALLER_FILE:\n";

	var_dump( $caller_file );

	echo "CURRENT SITE:\n";

	var_dump( get_current_site() );

	echo '</pre>';

	**/

	if( is_string( $caller ) ) {

		$opt = preg_replace( '/^update_option_/', '', $caller );

		$blog_list = yd_get_blog_list();

		if( $ct = count( $blog_list ) > 1 ) {

			set_time_limit ( $ct * 3 );

			wp_cache_flush();

			$value = get_option( $opt );

			/**/

			foreach( $blog_list as $blog ) {

				if( $blog['blog_id'] == 1 ) continue;

				//switch_to_blog( $blog['blog_id'] );

				//update_option( $opt, $value );

	    		update_blog_option( $blog['blog_id'], $opt, $value, FALSE );

	    		//wp_cache_flush();

	    		if( $d ) {

	    			echo '<br/>Caller: <b>' . $caller . '</b>';

	    			echo '<br/>' . $blog['blog_id'] . ' - ';

	    			$allowed = intval( ini_get('memory_limit') );

	    			$used = floor( memory_get_usage( TRUE ) / 1024 / 1024 ); //  + 92

	    			$left = $allowed - $used;

	    			echo ' allowed: ' . $allowed . ' used: ' . $used . ' ';

	    			if( $left < 5 ) {

	    				$new = $allowed + 5;

	    				echo 'memory is getting low... trying to allocate more... ';

	    				ini_set( 'memory_limit', $new . 'M' );

	    				echo $new . ' allocated ok.<br/>';

	    			}

	    			flush();

	    		}

			}

			/**/

	    	//restore_current_blog();

		}

	}

	return $value;

}



function yd_get_blog_list() {

	//TODO: this function is too restrictive!

	// need to select all blogs except maybe first one.

	global $wpdb;

	return $wpdb->get_results( $q =

    	"	SELECT blog_id, domain, last_updated 

    		FROM " . $wpdb->blogs, 

    	ARRAY_A 

    );

    /**

     * used to be a WHERE clause:

     *  . " 

     		WHERE public = '1' 

    			AND blog_id!='1' 

    			AND archived = '0' 

    			AND mature = '0' 

    			AND spam = '0' 

    			AND deleted ='0' 	" . $order . " 

    								" . $limit . ""

     */

}



// ============================ Generic YD WP functions ==============================



include( 'yd-wp-lib.inc.php' );



if( !function_exists( 'yd_update_options_nostrip_array' ) ) {

	function yd_update_options_nostrip_array( $option_key, $number, $to_update, $fields, $prefix ) {

		$options = $newoptions = get_option( $option_key );

		/*echo '<pre>';

		echo 'fields: ';

		var_dump( $fields );*/

		foreach( $to_update as $key ) {

			// reset the value

			if( is_array( $newoptions[$number][$key] ) ) {

				$newoptions[$number][$key] = array();

			} else {

				$newoptions[$number][$key] = '';

			}

			/*echo $key . ': ';

			var_dump( $fields[$prefix . $key . '-' . $number] );*/

			if( !is_array( $fields[$prefix . $key . '-' . $number] ) ) {

				$value = html_entity_decode( stripslashes( $fields[$prefix . $key . '-' . $number] ) );

				$newoptions[$number][$key] = $value;

			} else {

				//it's a multi-valued field, make an array...

				if( !is_array( $newoptions[$number][$key] ) )

					$newoptions[$number][$key] = array( $newoptions[$number][$key] );

				foreach( $fields[$prefix . $key . '-' . $number] as $v )

					$newoptions[$number][$key][] = html_entity_decode( stripslashes( $v ) );	

			}

			//echo $key . " = " . $prefix . $key . '-' . $number . " = " . $newoptions[$number][$key] . "<br/>";

		}

		//echo '</pre>';

		if ( $options != $newoptions ) {

			$options = $newoptions;

			update_option( $option_key, $options );

			return TRUE;

		} else {

			return FALSE;

		}

	}

}



?>