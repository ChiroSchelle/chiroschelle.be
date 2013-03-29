<?php
	get_header(); 
?>
	<?php if ( have_posts() ) : ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<div id="content-blokje">
				<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
				<div class="text">
					<div class="metadata">Geschreven door <?php the_author_posts_link() ?> op <?php the_time('j F Y') ?></div>
					<?php the_content('Lees meer &#155;&#155;'); ?>

					<div class="link">
						<!-- <?php comments_popup_link('Geen reacties', 'één reactie', '% reacties'); ?> --> Reacties zijn uitgeschakeld <?php edit_post_link('Bewerk', ' - '); ?> 
					</div>	
				</div>

				<?php 
					if ( has_post_thumbnail() ) 
					{ 
						?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
							<?php the_post_thumbnail('thumbnail');   ?>
						</a><?php
					}
					else
					{
						 echo '<img src="' . get_bloginfo('template_directory') . '/img/default-thumb.jpg" class="attachment-thumbnail" />';	
					}
				?>
			</div>

		<?php endwhile; ?>

			

			<?php else : ?>

				Onze excuses, het artikel dat u zocht bestaat niet!
				
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>