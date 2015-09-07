<?php
/**
 * Template part for displaying single posts.
 *
 * @package gidsen-sint-jan
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-thumb">
		<?php
			if(has_post_thumbnail()) {
				the_post_thumbnail( $size, $attr );
			}
			else {
				echo '<img src="" alt="placeholder" title="placeholder" class="placeholder" />';
				//echo get_avatar( get_the_author_meta( 'ID' ), 'avatar');
			}
		?>
	</div>
	<div class="entry-wrapper">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<div class="entry-meta">
				<?php gidsen_sint_jan_posted_on(); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gidsen-sint-jan' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php gidsen_sint_jan_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->

