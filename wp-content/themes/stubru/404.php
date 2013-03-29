<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage stubru
 * Template Name: 404
 */

get_header(); 
get_sidebar(); ?>

<div id="content" class="">
  <h1>
    <?php _e( 'Not Found', 'twentyten' ); ?>
  </h1>
  <p>
    <?php _e( 'Onze excuses, de pagina die u zocht kon niet worden gevonden.', 'twentyten' ); ?>
  </p>
</div>
<!-- Close #content -->
<div class="clearfix"></div>
</div>
<!-- Close #content_wrapper -->
<?php get_footer(); ?>
