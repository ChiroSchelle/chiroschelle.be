<?php

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<div id="content-blokje">
			<h3><?php the_title(); ?></h3>

			
				<?php the_content(); ?>
		
		</div>				
	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>