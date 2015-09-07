<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package gidsen-sint-jan
 * Template Name: Foto-album
 */

$args = array(
   'post_type' => 'attachment',
   'numberposts' => -1,
   'post_status' => null,
   'post_parent' => $post->ID
  );

  $media = get_posts( $args );


get_header(); ?>

	<section class="container">

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

		<ul class="photo-gallery row">
			<?php foreach($media as $m) : $image = wp_get_attachment_image_src( $m->ID, 'large'); $thumb = wp_get_attachment_image_src( $m->ID, 'medium');?>
				<li class="image-wrapper">
					<a class="example-image-link" href="<?php echo $image[0]; ?>" data-lightbox="example-1"><img class="image" src="<?php echo $thumb[0]; ?>" alt=""></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

<?php get_footer(); ?>
