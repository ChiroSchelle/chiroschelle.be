<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Programma
 */

get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="kijkerbackground">
      <div id="kijker_single">
       	  <div id="pijlgezicht_single"></div>
                    <div id="kijkerfiguur">&nbsp;</div>
                    <div id="kijkertekst">
                        <h1><?php the_title(); ?></h1>
                        <div id="kiesafdeling" class="noprint">
                        	<a href="?toon=afdeling&afdeling=1">Ribbel &#9794;</a> ||
                            <a href="?toon=afdeling&afdeling=3">Speelclub &#9794;</a> ||
                            <a href="?toon=afdeling&afdeling=5">Rakkers</a> ||
                            <a href="?toon=afdeling&afdeling=7">Toppers</a> ||
                            <a href="?toon=afdeling&afdeling=9">Kerels</a> ||
                            <a href="?toon=afdeling&afdeling=11">Aspi &#9794;</a> ||
                            <br/>
                            <a href="?toon=afdeling&afdeling=2">Ribbel &#9792;</a> ||
                            <a href="?toon=afdeling&afdeling=4">Speelclub &#9792;</a> ||
                            <a href="?toon=afdeling&afdeling=6">Kwiks</a> ||
                            <a href="?toon=afdeling&afdeling=8">Tippers</a> ||
                            <a href="?toon=afdeling&afdeling=10">Tiptiens</a> ||
                            <a href="?toon=afdeling&afdeling=12">Aspi &#9792;</a> ||
                             <br/>
                            <a href="?toon=afdeling&afdeling=15">Muziekkapel</a>
                            <!--<br/><br/>--> ||
                            <a href="?toon=afdeling&afdeling=17">Activiteiten</a>
                            <br/><br />
                            <a id="show_kalender" href="#">Bekijk per datum</a><br  />
						</div> <!--Sluiten van 'kiesafdeling'-->
						<div id="kalender" class="noprint">
						<br /><hr /><br>
                  		<?php /*if ($_GET['toon']== 'datum'){*/include_once( TEMPLATEPATH . '/calendar.php');/*}*/ ?>
                  		</div><!--#kalender-->
                    </div><!--Sluiten van 'kijkertekst'-->
                <div class="cleaner"></div>
            </div><!--Sluiten van 'pijlgezicht'-->
    </div><!--Sluiten van 'kijker'-->
</div><!--Sluiten van 'kijkerbackground'-->
    <div id="main1">
    	<div id="main2">
            <div id="right"></div>
            <div id="middle">
            	<div id="pijl"></div>
                <div class="post">
                    <div class="inhoudfiguur">
                        &nbsp;
                    </div><!--Sluiten van 'inhoudfiguur'-->

                    <div id="inhoudtekst">
        	                <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
							<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                    </div><!--Sluiten van 'inhoudfiguur'-->
                     <div class="cleaner"></div>
                </div><!--Sluiten van 'post'-->
                <?php endwhile; endif; ?>
				<?php /*?>	<?php comments_template(); ?><?php */?>
                  <div class="cleaner"></div>
            </div><!--Sluiten van 'middle'-->
		</div><!--Sluiten van 'main2'-->
    </div><!--Sluiten van 'main1'-->
<?php get_footer(); ?>
