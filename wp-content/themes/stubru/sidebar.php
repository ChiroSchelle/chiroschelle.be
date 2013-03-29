<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage stubru
 */
?>

<div id="sidebar">
  <?php wp_nav_menu( array('theme_location' => 'sidebarmenu' ) ); ?>
  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar") ) : ?>
  <?php endif; ?>
  <div class="clearfix"></div>
</div>
<!-- Close #sidebar -->
