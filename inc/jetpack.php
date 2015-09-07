<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package gidsen-sint-jan
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function gidsen_sint_jan_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'gidsen_sint_jan_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function gidsen_sint_jan_jetpack_setup
add_action( 'after_setup_theme', 'gidsen_sint_jan_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function gidsen_sint_jan_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function gidsen_sint_jan_infinite_scroll_render
