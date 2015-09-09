<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package chiro-schelle-15
 * Template Name: Programma
 */

get_header(); ?>

	<section class="container padding">

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
  		<?php /*if ($_GET['toon']== 'datum'){*/include_once( TEMPLATEPATH . '/template-parts/calendar.php');/*}*/ ?>
  		</div><!--#kalender-->

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'template-parts/content', 'page' ); ?>

        <?php endwhile; // End of the loop. ?>

	</section>

<?php get_footer(); ?>