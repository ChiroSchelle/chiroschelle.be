<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * @template name: more
 */

get_header();
global $more;    // Declare global $more (before the loop). ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
        // deel the content op in 2 delen
    $more = 0;  //enkel de tekst voor <!--more-->
    $kijker_tekst = get_the_content('',FALSE,''); // false om de 'lees meer' te verwijderen

    $more = 1; //alle tekst
    $inhoud_tekst = get_the_content('',FALSE,'');
    $inhoud_tekst = str_replace ( $kijker_tekst, '', $inhoud_tekst);

    // aply all filters to the_content
    $kijker_tekst = apply_filters('the_content', $kijker_tekst);
    $kijker_tekst = str_replace(']]>', ']]&gt;', $kijker_tekst);
    $inhoud_tekst = apply_filters('the_content', $inhoud_tekst);
    $inhoud_tekst = str_replace(']]>', ']]&gt;', $inhoud_tekst);


?>

<div id="kijkerbackground">
      <div id="kijker">   
       	  <div id="pijlgezicht"></div>                               
        <div>
                    <div id="kijkerfiguur">
                    	<?php the_post_thumbnail( array(100,100) ); ?>
                    </div>
                    <div id="kijkertekst">
                        <h1><?php the_title(); ?><?php edit_post_link('Bewerk', ' - ', ''); ?></h1>
<?php echo $kijker_tekst; ?>
                    </div>
        </div>  
                <div class="cleaner"></div>    
            </div>
  
    </div>
    
    <div id="main1">
    	<div id="main2">    
            <div id="right"></div>
            <div id="middle">   
            	<div id="pijl"></div> 
                
                <div class="post">
                    <div class="inhoudfiguur">
                        &nbsp;
                    </div>
                
                    <div id="inhoudtekst">
        	                <?php echo $inhoud_tekst; ?>
							<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                    </div>  
                     <div class="cleaner"></div> 
                </div>            
                
                
                <?php endwhile; endif; ?>
					
	
					<?php comments_template(); ?>
                
                  <div class="cleaner"></div>       
            </div>
		</div>
    </div>
	
	</div>

<?php get_footer(); ?>
