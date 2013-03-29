<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Info
 */

get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="kijkerbackground">
      <div id="kijker_single">   
       	  <div id="pijlgezicht_single"></div>                               
                    <div id="kijkerfiguur">&nbsp;</div>
                    <div id="kijkertekst">
                      <div id="submenu">
                      	<div id="submenulinks">
                        <a name="submenu"></a>
                          <a href="<?php bloginfo("url")?>/info/algemeen">Algemeen</a><br/>
                          <a href="<?php bloginfo("url")?>/info/verhuur">Verhuur</a><br/>
                          <a href="<?php bloginfo("url")?>/info/afdelingen">Afdelingen</a>
                        </div>
                        <div id="submenurechts">
                          <a href="<?php bloginfo("url")?>/info/jaarthema">Jaarthema</a><br/>
                          <a href="<?php bloginfo("url")?>/info/bivak">Bivak</a><br/>
                          <a href="<?php bloginfo("url")?>/info/downloads">Downloads</a><br/>
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
                    <div class="inhoudfiguur">
                        &nbsp;
                    </div>
                
                    <div id="inhoudtekst">
		                    <h1><?php the_title(); ?></h1>
        	                <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
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
