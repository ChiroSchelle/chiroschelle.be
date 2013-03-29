<?php

//add_action( 'save_post', 'chiroschelle_sort_sticky' );

function chiroschelle_sort_sticky()
{
// bug: oude sticky's worden terug sticky
	//get all sticky post-IDs
	$sticky = get_option( 'sticky_posts' );
	//get all sticky posts, sorted on date
	$posts = get_posts( array('post__in' => $sticky, 'orderby' => 'date', 'order' => 'ASC') );
	foreach( $posts as $post ) {
		$sorted[] = $post->ID;
	}
	update_option('sticky_posts',$sorted);
}


?>
