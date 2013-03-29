<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
// tablen repareren
define('WP_ALLOW_REPAIR', false);


//** tijdelijke plaats voor overgangen instellingen
// instellingen:
define("TOON_ECHT_VANAF", 1346598000); //http://www.wolframalpha.com/input/?i=2012%2F09%2F02+17%3A00+in+unix+time
define("VERBERG_AFDELING", true); //true = verberg afdeling in comments.php, author.php en single.php



// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'c7070chi_wordpress');

/** MySQL database username */
define('DB_USER', 'c7070chi_wp');

/** MySQL database password */
define('DB_PASSWORD', 'wp0310');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Inschakelen multi-domain support */
define( 'SUNRISE', 'on' );
/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',        '=|:ck/dc_LF_+)d8]%UH5=lbj>5/<&1MdX+o=V-y^BQaS4d2E:xW/{{`.VPA[C>^');
define('SECURE_AUTH_KEY', '4i1J-`RP%|++g>%7NAxjal^+7}w+9~0_)cm_1M|rH,+ra^M^~,%|Hba/qQS*w`}J');
define('LOGGED_IN_KEY',   '<J^R+>ht/w:6H Z9H+JDC~<I!G}%.V3qgs+p00xdx|0ER(UQ&V:-Y#A+VBfMB+3e');
define('NONCE_KEY',       'k32iFPbg:]D[3*jMsI@iX8T+|UqY#z5v^qthaaT>/O]779}SRj<~?d,$u|dDdZb=');
define( 'AUTH_SALT', 'kpi9uBZV3`h]ZrXyxfjXOo$P;LZPRnJ5+oChns4_`t+4w@y6i+AzVgp1?>g<[gD<' );
define( 'SECURE_AUTH_SALT', 'O.~6=VV?auXPTB&mmL{8M^ ix@6e^^yhtZ3W-6=lz6+n4{.b$3&A,)l@ 1*`:4R}' );
define( 'LOGGED_IN_SALT', 'tKtY2Bj-&|!e]&pnn~y?p@uL..6)c>$mq<TakOOcdLN{[-p*K0k_&UA)pd9|Ee`0' );
define( 'NONCE_SALT', '!]LK#K*f84Ed^^:2yk]~6;W1$qvA/=gu{(|r{5t&Ny:Jjj2.WGZTs}5KY+9p2pzr' );
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'nl_NL');
/**
* Allow multiple sites (aka network or wordpress MU)
*/
define('WP_ALLOW_MULTISITE', true);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'chiroschelle.be' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
# redirect niet bestaande sites naar de main site.
define( 'NOBLOGREDIRECT', '%siteurl%' );

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
