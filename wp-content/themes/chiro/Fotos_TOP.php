<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Fotos_TOP
 */

get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="kijkerbackground">
      <div id="kijker">
       	  <div id="pijlgezicht"></div>
                    <div id="kijkerfiguur" class="fotomenuimage">&nbsp;</div>
                    <div id="kijkertekst" class="fotomenutekst">
                      <div id="submenu">
						<?php
                        $activiteit = getthumbbyid(470);
                      	$bivak = getthumbbyid(464);
                      	$oude_doos = getthumbbyid(467);
						?>
                        <div class="fotomenulinks">
                       		<a href="http://www.chiroschelle.be/fotos/activiteiten"><img src="http://www.chiroschelle.be/wp-content/themes/chiro/images/activiteiten.jpg" /></a>
                        	<h1><a href="http://www.chiroschelle.be/fotos/activiteiten">Activiteiten</a></h1>
                        </div>
                        <div class="fotomenumidden">
                       		<a href="http://www.chiroschelle.be/fotos/bivak"><img src="http://www.chiroschelle.be/wp-content/themes/chiro/images/bivak.jpg" />
                        	<h1><a href="http://www.chiroschelle.be/fotos/bivak">Bivak</a></h1>
                        </div>
                        <div class="fotomenurechts">
                        	<a href="http://www.chiroschelle.be/fotos/uit-de-oude-doos"><img src="http://www.chiroschelle.be/wp-content/themes/chiro/images/oudedoos.jpg" />
                        	<h1><a href="http://www.chiroschelle.be/fotos/uit-de-oude-doos">Uit de oude doos</a></h1>
                        </div>
                      <div class="cleaner"></div>
                      </div>

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
                   <div class="fotostekst">          
							<?php
                            $args = array('depth' => 2,'title_li'=> '','echo'=> 0,'sort_column'  => 'menu_order, post_title');
                            $args['child_of'] = '470';
                            $children_activiteiten = wp_list_pages($args);
							$args['child_of'] = '3157';
                            $children_bivak = wp_list_pages($args);
							$args['child_of'] = '467';
                            $children_oudedoos = wp_list_pages($args);
                            ?>
                          
						<table id="submenu_tbl">
                          <tr>
                            <td>
                            	<ul class="fototabel">
							  	<?php echo $children_activiteiten; ?>
                              	</ul>
                      		</td>
                            <td>
                            	<ul class="fototabel">
							  	<?php echo $children_bivak; ?>
                              	</ul>
                      		</td>
                            <td>
                            	<ul class="fototabel">
							  	<?php echo $children_oudedoos; ?>
                              	</ul>
                      		</td>
                          </tr>
                        </table>
						
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