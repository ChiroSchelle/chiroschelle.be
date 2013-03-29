<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<!--[if IE]>
			<style type="text/css">
				body {min-height:100%; height: auto !important;}
				#footer { margin-top: 0px !important;}
			</style>
		<![endif]-->
		<title>
			<?php

				/*
				 * Print the <title> tag based on what is being viewed.
				 */

				global $page, $paged;

				wp_title( '|', true, 'right' );

				// Add the blog name.
				bloginfo( 'name' );

				// Add the blog description for the home/front page.
				$site_description = get_bloginfo( 'description', 'display' );
				if ( $site_description && ( is_home() || is_front_page() ) )
					echo " | $site_description";

				// Add a page number if necessary:
				if ( $paged >= 2 || $page >= 2 )
					echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

			?>
		</title>
	
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/carousel.js"></script>

		<script type="text/javascript">
		$(document).ready(function(){
		  $("#button").click(function(){
			$("#header-balk").slideToggle();
		  });
		});
		</script>
		

		<?php

			/* Always have wp_head() just before the closing </head>
			 * tag of your theme, or you will break many plugins, which
			 * generally use this hook to add elements to <head> such
			 * as styles, scripts, and meta tags.
			 */
			wp_head();

		?>
	</head>

	<body <?php body_class(); ?>>
	<div id="container"> <!-- sticky footer -->	
	<div id="wrap"> <!-- sticky footer -->	
		<div id="header-balk">
			<div class="wrapper">
				<div id="login">
			
					<ul id="sidebar">
					   <?php dynamic_sidebar( 'top-login' ); ?>
					</ul>
				
					<!--
					<form action="" id="login" name="login" method="post">
						<fieldset>
							<div class="input-blok">
								<label>E-mailadres</label><input type="text" name="email" />
								<input type="checkbox" name="onthouden" /><label>Laat mij aangemeld blijven</label>
							</div>
							<div class="input-blok">
								<label>Wachtwoord</label><input type="password" name="wachtwoord" />
								<label><a href="">wachtwoord vergeten?</a></label>
							</div>
									
							<input type="submit" name="login" value="Aanmelden" />
						</fieldset>
					</form>
					-->
				</div>
			</div>
		</div>
		<div id="lijn"></div>
		<div class="wrapper">
			<div id="button">
				<?php
					if (is_user_logged_in()) 
					{
					    echo 'Profiel';
					} 
					else 
					{
					    echo 'Inloggen';
					}
				?>
			</div>
		</div>	
	
	
		<div class="wrapper">
			<div id="balk">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="logo"></a>
				
				<div id="menu">
					
					<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
					
				</div>
			</div>
			
			<!-- makkelijk oplossing voor slider -->
			<a href="#" id="next" style="display: none;">start</a>
			<!-- -->
		
			<div id="content">
				<div id="carousel">
					<div id="slider">
						 <ul>
							<li><img src="<?php echo get_template_directory_uri(); ?>/img/slider.jpg" alt="image 1" border="0"></li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/img/slider2.png" alt="image 2" border="0"></li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/img/slider3.jpg" alt="image 2" border="0"></li>
						</ul>
					</div>
				</div>

			
