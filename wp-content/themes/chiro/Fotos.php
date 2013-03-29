<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Fotos
 */

get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="kijkerbackground">
      <div id="kijker">
       	  <div id="pijlgezicht"></div>
                    <div id="kijkerfiguur">
					<?php  
					$current = $post->ID;
					$parent = $post->post_parent;
					$grandparent_get = get_post($parent);
					$grandparent = $grandparent_get->post_parent;
					$grandparent_title = get_the_title($grandparent);
					$parent_title = get_the_title($post->post_parent);
 					/*
					if ($root_parent = $grandparent_title !== $root_parent = get_the_title($current)) {
						echo $grandparent_title;
					}else {
						echo get_the_title($parent);
					}
					*/
                       switch ($grandparent_title) {
                            case 'Activiteiten': ?>
                                <a href="http://www.chiroschelle.be/fotos/activiteiten"><img class="zonderkader" src="http://www.chiroschelle.be/wp-content/themes/chiro/images/activiteiten.jpg" /></a>
                                <?php
                                break;
                            case 'Bivak':?>
                                <a href="http://www.chiroschelle.be/fotos/bivak"><img class="zonderkader" src="http://www.chiroschelle.be/wp-content/themes/chiro/images/bivak.jpg" />
                                <?php
                                break;
                            case 'Uit de oude doos':?>
                                <a href="http://www.chiroschelle.be/fotos/uit-de-oude-doos"><img class="zonderkader" src="http://www.chiroschelle.be/wp-content/themes/chiro/images/oudedoos.jpg" />
                                <?php
                                break;
                        }?>
                    </div>
                    <div id="kijkertekst">
                      <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo $grandparent_title . " " . $parent_title?>
					  <br />
					  <?php the_title(); ?></a></h1>
						<br/>
                        <h2>Foto's</h2>
                                        <?php
										global $more;
										$more = 0;
										?>
                            			<?php the_content('<p>Lees meer &raquo;</p>');?>
						<?php edit_post_link('Bewerk deze pagina', '<p>', '</p>'); ?>
                    </div>
        </div>
                <div class="cleaner"></div>
            </div>
    </div>
    <div id="main1">
    	<div id="main2">
            <div id="right"></div>
            <div id="left"></div>
            <div id="middle">
            	<div id="pijl"></div>
                <div class="post">
                    <div class="inhoudfiguur">
                        &nbsp;
                    </div>
                    <div id="inhoudtekst">
		                    <h1><?php the_title(); ?></h1>
							<?php echo do_shortcode('[gallery itemtag="div" icontag="span"  captiontag="p" link="file"]'); ?>
							<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                    </div>
                     <div class="cleaner"></div>
                </div>
               <?php endwhile; endif; ?>
			<?php /*?>	<?php comments_template(); ?><?php */?>
 <div class="cleaner"></div>
</div>
		</div>
    </div>
	</div>
<?php get_footer(); ?>