<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();
?>

	<div id="kijkerbackground">
      <div id="kijker_single">   
       	  <div id="pijlgezicht_single"></div> <!--Sluiten van 'pijlengezicht_single'-->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
              <?php 
			  	// $iduser = get_the_author_meta('id');
			  	//$user = get_userdata($id);
			  ?>
            
              <div id="kijkerfiguur">
			  	<div id="avatar_single"><a class="" href="<?php bloginfo("url") ?>/author/<?php echo the_author_meta(user_login) ?>"><?php $avtr = get_avatar($post->post_author, 100);  echo $avtr; ?></a></div>
              </div> <!--Sluiten van 'kijkerfiguur'-->
              
              <div id="kijkertekst">
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                <h2>door <a class="" href="<?php bloginfo("url") ?>/author/<?php echo the_author_meta(user_login) ?>"><?php the_author() ?></a> op <?php the_time('d-m-y \o\m H\ui') ?></h2> 
                <p>
					<?php 
						if (get_the_author_posts()==1){ ?>
		                   	<?php the_author_posts(); ?>  bericht geschreven
                         <?php }else { ?>
                        	 <?php the_author_posts(); ?>  berichten geschreven
                      <?php } ?>
					<br/><br/>
                    <?php 
                      if(!VERBERG_AFDELING){
                        get_user_rankafdeling(get_the_author_meta('id'), 1, 1, 0);
                      }
                    ?>                           
				</p>
                <?php edit_post_link('Bewerk dit bericht', '<p>', '</p>');?> 
              </div> <!--Sluiten van 'kijkertekst'--> 
            <div class="cleaner"></div>    
        </div> <!--Sluiten van 'kijker_single'-->
    </div> <!--Sluiten van 'kijkerbackground'-->
    
    <div id="main1">
    	<div id="main2">    
            <div id="right"></div>
            <div id="middle">   
            	<div id="pijl"></div>
        		<div class="post">
                    <div class="inhoudfiguur">
                    				<?php
										if ( has_post_thumbnail() ) {
											// the current post has a thumbnail
											the_post_thumbnail( array(105,999) );
										} else {
											// deze post heeft geen thumbnail, we tonen een andere figuur
											//toonstandaardthumb();
											echo "&nbsp;";
										}
										?>
                    
                    
                    </div> <!--Sluiten van 'inhoudfiguur'-->
               		<div id="inhoudtekst"> 
                    <?php //the_post_thumbnail( array(200,200) );?>
                      <?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                        <?php the_tags( '<p class="tags">Tags: ', ', ', '</p>'); ?>
            		</div> <!--Sluiten van 'inhoudtekst'-->
               		<?php comments_template(); ?>
               		<div class="navigation">
                		<div class="navalignleft"><?php previous_post_link('&laquo; %link') ?></div>
                		<div class="navalignright"><?php next_post_link('%link &raquo;') ?></div>
                    </div><!--Sluiten van 'navigation'-->  
                    <div class="cleaner"></div> 
                </div> <!--Sluiten van 'post'-->   
				<?php endwhile; ?>
                <div class="navigation">
                    <div class="navalignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
                    <div class="navalignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
                </div><!--Sluiten van 'navigation'-->
                <?php else : ?>
                <h2 class="center">Niets gevonden</h2>
                <p class="center">Onze excuses, u zoekt naar iets wat er niet is.</p>
                <?php get_search_form(); ?>
                <?php endif; ?>
                <div class="cleaner"></div>       
           </div><!--Sluiten van 'middle'-->
		</div><!--Sluiten van 'main2'-->
    </div><!--Sluiten van 'main1'-->

<?php get_footer(); ?>
