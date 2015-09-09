<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package chiro-schelle-15
 */

$authorDetails = get_userdata($author);
var_dump($authorDetails);

get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<section class="highlighted">
			<div class="container padding">
				<div class="row">
					<div class="col-md-12">
						<div class="row profile">

							<div class="col-md-3">
								<?php echo get_avatar($post->post_author, 160); ?>
							</div>

							<div class="col-md-9">
								<h2><?php echo $authorDetails->display_name; ?></h2>
								<div class="street">
									<?php echo $authorDetails->straat . " ". $authorDetails->nr; ?>
								</div>
								<div class="city">
									<?php echo $authorDetails->postcode . " ". $authorDetails->gemeente; ?>
								</div>
								<div class="phone">
									<?php echo $authorDetails->telefoon; ?>
								</div>
								<div class="contact">
									<a href="<?php echo get_bloginfo('url') . '/contact/?uid=' . $authorDetails->ID; ?>">
							        	Contacteer <?php echo $authorDetails->first_name; ?>
							        </a>
								</div>
							</div>

						</div>
					</div>
					<div class="row vragenlijst">
						<div class="col-md-9 col-md-offset-3">
							<?php get_vragenlijst($authorDetails); ?>
						</div>
					</div>
				</div>
			</div>

		</section>

		<section class="container">
			<div class="col-md-10">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php // the_posts_navigation(); ?>

			</div>
		</section>
	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>
