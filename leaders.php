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
 * Template Name: Leidingspagina
 */

//haal de id's op van de groepsleiding:
$groeps_ids = get_user_id('groeps',1);

//haal de rest van de leiding op:
$leiding_ids = get_user_id('rank','leiding');

for ($i=1;$i<=12;$i++){
	$leiding[$i] = sort_op_afdeling($leiding_ids,$i);
}

//haal de veebees op
$vb_ids = get_user_id('rank','vb');

function displayUser($user_id) {
	$l = get_userdata($user_id);
	$author_url = get_bloginfo('url') . '/author/'. $user->user_nicename;
	$edit_url = 'http://www.chiroschelle.be/wp-admin/user-edit.php?user_id=' . $user_id;
	$contact_url = get_bloginfo('url') . '/contact/?uid=' . $user_id;
	?>
	<li>
		<?php echo get_avatar($l->ID, 'avatar'); ?>
		<div class="details">
			<p class="name"><?php echo $l->first_name . ' ' . $l->last_name; ?></p>
			<p class="street"><?php echo $l->street; ?></p>
			<p class="city"><?php echo $l->zipcode . ' ' . $l->city; ?></p>
			<p class="phone"><?php echo $l->phone; ?></p>
			<p class="mail"></p>
		</div>
	</li>
<?php }


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

			<ul class="leaders">
				<li>
					<h3>Groepies</h3>
					<ul>
				<?php
					foreach($groepies as $l) {
						echo displayUser($l);
					}
				?>
					</ul>
				</li>
				<?php
					foreach($leiders as $group => $members) {
						echo '<li><h3>' . $group . '</h3><ul>';

						foreach($members as $l) {
							echo displayUser($l);
						}

						echo '</ul></li>';
					}
				?>
			</ul>

	</section>

<?php get_footer(); ?>