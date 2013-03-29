<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Fotos_TOPSUB
 */

get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="kijkerbackground">
     <div id="kijker">
       	  <div id="pijlgezicht"></div>
                    <div id="kijkerfiguur">
						<?php
                        $parent_title = get_the_title($post);
                        //echo $parent_title;
                        switch ($parent_title) {
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
                   		<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
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
                    <div class="inhoudfiguur" class="fotosfigenkel">
                        &nbsp;
                    </div>

                    <div id="inhoudtekst" class="fotostekstenkel">
		                    <h1><?php /* the_title(); */?></h1>
							<?php
							$args = array('depth' => 2,'title_li'=> '','echo'=> 0,'sort_column'  => 'menu_order, post_title');
							
							switch ($parent_title) {
                            case 'Activiteiten':
                                $args['child_of'] = '470';
                            	$children = wp_list_pages($args);
                                break;
                            case 'Bivak':
                               $args['child_of'] = '3157';
                            	$children = wp_list_pages($args);
                                break;
                            case 'Uit de oude doos':
                                $args['child_of'] = '467';
                           		$children = wp_list_pages($args);
                                break;
                            }?>
                            
                        <table id="submenu_tbl">
                          <tr>
                            <td>
                            	<ul id="submenu">
							  	<?php echo $children; ?>
                              	</ul>
                      		</td>
                            <td>
                            	<ul id="submenu">
							  	<?php echo $children_bivak; ?>
                              	</ul>
                      		</td>
                            <td>
                            	<ul id="submenu">
							  	<?php echo $children_oudedoos; ?>
                              	</ul>
                      		</td>
                          </tr>
                        </table>
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