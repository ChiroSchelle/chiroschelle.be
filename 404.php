<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package chiro-schelle-15
 */

get_header(); ?>

	<section class="container">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oeps, deze pagina bestaat niet!', 'chiro-schelle-15' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Naar wat was je op zoek?', 'chiro-schelle-15' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( chiro_schelle_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'chiro-schelle-15' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
	</section>

<?php get_footer(); ?>
