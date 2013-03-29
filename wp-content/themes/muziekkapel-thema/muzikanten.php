<?php
/*
Template Name: Muzikanten
*/
?>

<?php

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<div id="content-blokje">
			<h3><?php the_title(); ?></h3>

			
				<?php the_content(); ?>

				<!-- lijst voor elk instrument -->
				<ul class="muzikanten">
					<li class="titel">Dirigent</li>
					<li>
						<?php echo '<img src="' . get_bloginfo('template_directory') . '/img/default-thumb.jpg" class="attachment-thumbnail" />'; ?>
						<ul class="info-muzikanten">
							<li><span class="name">Wietse R.</span></li>
							<li>extra info ...</li>
							<li>...</li>
						</ul>
					</li>
				</ul>

				<ul class="muzikanten">
					<li class="titel">1ste trompet</li>
					<li>
						<?php echo '<img src="' . get_bloginfo('template_directory') . '/img/default-thumb.jpg" class="attachment-thumbnail" />'; ?>
						
						<ul class="info-muzikanten">
							<li><span class="name">Jelle P.</span></li>
							<li>extra info ...</li>
							<li>...</li>
						</ul>
					</li>
				</ul>
				
				<ul class="muzikanten">
					<li class="titel">Klaroen</li>
					<li>
						<?php echo '<img src="' . get_bloginfo('template_directory') . '/img/default-thumb.jpg" class="attachment-thumbnail" />'; ?>
						
						<ul class="info-muzikanten">
							<li><span class="name">Bette M.</span></li>
							<li>extra info ...</li>
							<li>...</li>
						</ul>
					</li>
					<li>
						<?php echo '<img src="' . get_bloginfo('template_directory') . '/img/default-thumb.jpg" class="attachment-thumbnail" />'; ?>
						
						<ul class="info-muzikanten">
							<li><span class="name">Hannah M.</span></li>
							<li>extra info ...</li>
							<li>...</li>
						</ul>
					</li>
					<li>
						<?php echo '<img src="' . get_bloginfo('template_directory') . '/img/default-thumb.jpg" class="attachment-thumbnail" />'; ?>
						
						<ul class="info-muzikanten">
							<li><span class="name">Lies D.G.</span></li>
							<li>extra info ...</li>
							<li>...</li>
						</ul>
					</li>
				</ul>
		</div>				
	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>