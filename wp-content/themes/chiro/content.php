<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Chiro_Schelle
 */
?>
<div class="inhoudfiguur">
	<?php
	
	if (  has_post_thumbnail() ) { // the current post has a thumbnail
		the_post_thumbnail( 'thumbnail' );
	}
	else {
		$img = chiroschelle_get_image($post);
		if ( $img ) {
			echo $img;
		}
		else {
			chiroschelle_show_default_thumb();
		}
	}
	?>
</div><!-- .figuur -->
<div class="inhoudzonderimg">
	<h1 class="posttitel"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
		<?php the_title(); ?>
    </a></h1>
    <h2 class="postmeta">
    	<?php chiroschelle_post_meta() ?>
    </h2>
    <?php
    // don't display anything after the <!--more--> tag
//	global $more;
//	$more = 0;
	
	the_content( '<p>Lees meer &raquo;</p>' );
	?>
	<br />
    <br />
    <a href="<?php comments_link(); ?>">
		<?php comments_number('Geen reacties','1 reactie','% reacties'); ?>
	</a>
	<?php edit_post_link('Bewerk', ' - ', '');?>
</div><!-- .inhoudzonderimg -->


<div class="cleaner"></div>
