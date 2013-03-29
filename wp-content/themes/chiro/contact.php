<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Contactpagina
 */

get_header();
?>

	<div id="kijkerbackground">
      <div id="kijker_single">
       	  <div id="pijlgezicht_single"></div> <!--Sluiten van 'pijlengezicht_single'-->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
              <div id="kijkerfiguur">&nbsp;</div> <!--Sluiten van 'kijkerfiguur'-->
              <div id="kijkertekst">
				 <h1><?php the_title(); ?><?php edit_post_link('Bewerk', ' - ', ''); ?></h1>
                        <?php the_content(); ?>
              </div> <!--Sluiten van 'kijkertekst'-->
            <div class="cleaner"></div>
        </div> <!--Sluiten van 'kijker_single'-->
    </div> <!--Sluiten van 'kijkerbackground'-->

    <div id="main1">
    	<div id="main2">
            <div id="right"></div>
            <div id="left"></div>
            <div id="middle">
            	<div id="pijl"></div>
                     <div class="inhoudfiguur">&nbsp;</div> <!--Sluiten van 'inhoudfiguur'-->
               		<div id="inhoudtekst">

                            <?php
                            ## Laat het contactformulier zien ##
                            chirocontact_toon_form();


							wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                    </div>
                     <div class="cleaner"></div>
				<?php endwhile; ?>
                <div class="navigation">
                    <div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
                    <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
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
