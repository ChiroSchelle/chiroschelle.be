<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Chiro_Schelle
 */

get_header(); ?>

<div id="kijkerbackground">
	<div id="kijker">
		<div id="pijlgezicht"></div>
		
		<?php if( have_posts() ) : the_post() //only first post ?>

			<?php get_template_part( 'content_kijker', get_post_format() ); ?>
		
		<?php else : //no posts found ?>

		<h3 class="center">Oeps, we vinden niet wat je zoekt</h3>
		<div class="cleaner"></div>

		<?php endif; ?>

	</div> <!-- #kijker -->
</div><!-- #kijkerbackground-->
<div id="main1">
	<div id="main2">
		<div id="right"></div>
		<div id="left"></div>
		<div id="middle">
			<div id="pijl"></div>

			<?php while( have_posts() ) : the_post() //all but first post ?>

			<div class="post lijn">
				<?php get_template_part( 'content', get_post_format() ); ?>
			</div><!-- .post .lijn -->

			<?php endwhile; ?>
			
			<div class="navigation">
			
			<?php
			if( function_exists('wp_page_numbers') ) : 
				wp_page_numbers(); 
			else : 
			?>
				<div class="navalignleft">
					<?php previous_post_link('&laquo; %link') ?>hier moet die komen
				</div>
                <div class="navalignright">
                	<?php next_post_link('%link &raquo;') ?>en hier ook
				</div>
			<?php endif; ?>
			</div> <!-- .navigation -->
			<div class="cleaner"></div>
		</div><!-- #middle -->
	</div><!-- #main2 -->
</div><!-- #main1 -->
<?php get_footer(); ?>
