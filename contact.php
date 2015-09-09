<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package chiro-schelle-15
 * Template Name: contactpagina
 */

get_header(); ?>

	<section class="container contact">
		<div class="entry">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php

					// NOOIT COMMENTS TOELATEN BIJ EEN GEWONE PAGINA!

					// If comments are open or we have at least one comment, load up the comment template.
					//if ( comments_open() || get_comments_number() ) :
					//	comments_template();
					//endif;

				?>

			<?php endwhile; // End of the loop. ?>
		</div>

		<div id="map-canvas"></div>

	</section>

<?php get_footer(); ?>