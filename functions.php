<?php
/**
 * chiro-schelle functions and definitions
 *
 * @package chiro-schelle
 */

require_once('classes/UserMapper.php');

if ( ! function_exists( 'chiro_schelle_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chiro_schelle_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on chiro-schelle, use a find and replace
	 * to change 'chiro-schelle' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'chiro-schelle', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'chiro-schelle' ),
		'info' => esc_html__( 'Info Menu', 'chiro-schelle' ),
		'footer' => esc_html__( 'Footer Menu', 'chiro-schelle' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'chiro_schelle_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // chiro_schelle_setup
add_action( 'after_setup_theme', 'chiro_schelle_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function chiro_schelle_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'chiro_schelle_content_width', 640 );
}
add_action( 'after_setup_theme', 'chiro_schelle_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function chiro_schelle_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'chiro-schelle' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'chiro_schelle_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function chiro_schelle_scripts() {
	wp_enqueue_style( 'chiro-schelle-style', get_stylesheet_uri() );

	wp_enqueue_script( 'chiro-schelle-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'chiro-schelle-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chiro_schelle_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_image_size('avatar', 180, 180, 1);


/**
 * Standaardfiguurtje laten zien als er geen thumbnail is
 */
$aantal = 7;
$i=rand(1,$aantal);
$gebruikt = array();

function chiroschelle_show_default_thumb($archive=0){
	global $i;
	global $gebruikt;
	global $aantal;

	array_push($gebruikt,$i);
	$j = 0;
	while (in_array($i, $gebruikt)) {
   		$i = rand(1,$aantal);
		$j = $j +1;

		if ($j == 7){
			break;
			}
		$i = rand(1,$aantal);
	}

		$imgpath = get_bloginfo('template_url') . "/img/thumbs/thumb_" .	$i .".jpg";

	return "<img class=\"thumb\" src='$imgpath' />";
}


function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body row">
	<?php endif; ?>

	<div class="avatar col-md-2">
		<?php echo get_avatar( $comment, 60); ?>
	</div>

	<div class="content col-md-10">

		<div class="comment-author vcard">
			<div class="author-name"><?php echo get_comment_author_link(); ?></div>
			<div class="comment-meta commentmetadata">
				op <?php echo get_comment_date() . ' ' . get_comment_time(); ?>
			</div>
		</div>

		<div class="content-body">
			<?php comment_text(); ?>
		</div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>

	</div>



	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<br />
	<?php endif; ?>

	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/*
Geef user id terug
*/

function get_user_id($meta_key, $meta_value){
	global $wpdb;
	$table_name = $wpdb->prefix . "usermeta";
	$sql = "SELECT DISTINCT user_id as ID  FROM " . $table_name ." WHERE `meta_key` LIKE '". $meta_key ."' AND meta_value LIKE '". $meta_value . "';";
	$result = $wpdb->get_results($sql);
	$i = 0;
	foreach ($result as $row){
		$ids[$i] = $row->ID;
		$i++;
	}
	return $ids;
}

function maaknummerafdeling($afdeling) {
	switch ($afdeling) {
	case 0:
    	$afdeling = 'geen';
	    break;
	case 1:
	   $afdeling = 'Ribbel Jongens';
	    break;
	case 2:
    	$afdeling = 'Ribbel Meisjes';
	    break;
	case 3:
		$afdeling = 'Speelclub Jongens';
    	break;
	case 4:
		$afdeling = 'Speelclub Meisjes';
    	break;
	case 5:
		$afdeling = 'Rakkers';
    	break;
	case 6:
		$afdeling = 'Kwiks';
    	break;
	case 7:
		$afdeling = 'Toppers';
    	break;
	case 8:
		$afdeling = 'Tippers';
    	break;
	case 9:
		$afdeling = 'Kerels';
    	break;
	case 10:
		$afdeling = 'Tiptiens';
    	break;
	case 11:
		$afdeling = 'Aspi Jongens';
    	break;
	case 12:
		$afdeling = 'Aspi Meisjes';
    	break;
	case 13:
		$afdeling = 'IEDEREEN';
		break;
	case 14:
		$afdeling = 'Leiding';
		break;
	case 15:
		$afdeling = 'Muziekkapel';
		break;
	case 16:
	    $afdeling = 'Tikeas';
	    break;
	case 17:
		$afdeling = "Activiteiten";
		}
		return $afdeling;
}

function sort_op_afdeling($user_id, $afdeling){
	global  $wpdb;
	$table_name = $wpdb->prefix . "usermeta";
	$where = "WHERE meta_key LIKE 'afdeling' AND meta_value = $afdeling AND ( ";
	$i = 0;
	foreach ($user_id as $id){
		if ($i>0){
			$where .= " OR ";

		}

		$where .= "user_id = '$id'";
		$i++;
	}

	$where .= ")";
	$sql = "SELECT DISTINCT user_id as ID, meta_value as afdeling FROM $table_name $where ORDER BY afdeling;";



	$result = $wpdb->get_results($sql);
	$i = 0;

	foreach ($result as $row){

		$users[$i] =  $row->ID;

		$i++;

	}
	return $users;
}