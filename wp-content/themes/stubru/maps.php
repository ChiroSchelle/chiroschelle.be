<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage stubru
 * Template Name: Map
 */

get_header();
get_sidebar(); ?>
<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			//get_template_part( 'loop', 'page' );
			?>

<div id="content" class="">
<div id="map" class="border_grey"></div>
    <!--<button id="drop" onclick="drop()">Waar is er parking?</button>
    <button id="hide" onclick="toggle()">Toggle</button>-->
    <label for="toggleparking">
    <input type="checkbox" name="toggleparking" value="Toon parking" checked="checked" id="toggleparking">Toon parking
	</label>
    <?php if (have_posts()) : while (have_posts()) : the_post();?>
 <div class="post">
 
 <?php the_post_thumbnail(‘thumbnail’, array('class' => 'picture_big' )); ?>
  <div class="entrytext">
   <?php the_content('<p>Lees de rest van de pagina.</p>'); ?>
  </div>
 </div>
 <?php endwhile; endif; ?>
 <?php edit_post_link('Bewerk deze pagina', '<p>', '</p>'); ?>
  </div>
  <!-- Close #content -->
  <div class="clearfix"></div>
</div>
<!-- Close #content_wrapper -->
<?php get_footer(); ?>
