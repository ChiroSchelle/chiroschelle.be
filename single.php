<?php
/**
 * The template for displaying all single posts.
 *
 * @package gidsen-sint-jan
 */

get_header(); ?>

	<section class="container">
		<div class="col-md-10">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>


			<?php endwhile; // End of the loop. ?>

		</div>

	</section>

<?php get_footer(); ?>
