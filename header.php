<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package chiro-schelle
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/jquery/dist/jquery.min.js"></script>

<?php if (is_page_template('contact.php')) { ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMosxiZ3jRg2z-3DILge7Iazc2tNjdxds"></script>
    <script type="text/javascript">
      	function initialize() {
        	var mapOptions = {
          		center: { lat: 51.1107746, lng: 4.3611509},
          		zoom: 14
        	};
       	 	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

       	 	var marker = new google.maps.Marker({
			    position: { lat: 51.1107746, lng: 4.3611509},
			    map: map,
			    title: 'Gidsen Sint-Jan'
			});
      	}

      	google.maps.event.addDomListener(window, 'load', initialize);
   	</script>
<?php } ; ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'chiro-schelle' ); ?></a>

	<header class="site-header" role="banner">

		<div class="container">
			<div class="site-branding">
				<img class="site-logo" src="<?php bloginfo('template_directory'); ?>/img/chirologo[wit].png" alt="logo" title="logo" />
				<!-- <div class="site-info-wrapper">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div> -->
			</div>
		</div>

	</header>

	<div class="container card main-container">
		<nav class="main-navigation" role="navigation">

			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'chiro-schelle' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>

		</nav>


