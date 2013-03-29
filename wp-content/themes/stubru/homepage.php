<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage stubru
 * Template Name: Programmapage
 */

get_header();
get_sidebar(); ?>
<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			//get_template_part( 'loop', 'page' );
			?>

<div id="content" class="">
  <div class="picture" id="pic1"> <a href="http://stubru.chiroschelle.be/programma/studio-brussel-fuif/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Studio Brussel Fuif</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_stubru.jpg" /> </a></div>
  
  <div class="picture" id="pic2"><a href="programma/scheve-toren-feest/speeldorp-en-ketnetband/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Speeldorp &amp; Ketnetband</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_kinderdorp.jpg" /></a> </div>
 
  <div class="picture" id="pic3"><a href="programma/scheve-toren-feest/ark-van-schelle/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Ark van Schelle</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_ark.jpg" /> </a></div>
 
  <div class="picture" id="pic4"><a href="programma/scheve-toren-feest/hapje-tapje/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Hapje Tapje</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_hapjetapje.jpg" /></a> </div>
 
  <div class="picture" id="pic5"><a href="programma/scheve-toren-feest/torekesworp/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Torekesworp</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_torekesworp.jpg" /></a> </div>
 
  <div class="picture" id="pic6"><a href="programma/scheve-toren-feest/lichtparadijs/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Lichtparadijs</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_lichtparadijs.jpg" /></a> </div>
 
  <div class="picture" id="pic7"><a href="programma/scheve-toren-feest/wat-weet-je-van-water/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Wat weet je van water?</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_water.jpg" /></a> </div>
 
  <div class="picture" id="pic8"><a href="programma/scheve-toren-feest/laser-en-lichtshow/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Licht- &amp; Lasershow</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_laser.jpg" /></a> </div>
 
  <div class="picture" id="pic9"><a href="programma/scheve-toren-feest/vuurvogel/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Feniks: de vuurvogel</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_vuurvogel.jpg" /></a> </div>
 
  <div class="picture" id="pic10"><a href="programma/scheve-toren-feest/hemelfiets/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Fietsen in de hemel</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_hemelfiets.jpg" /></a> </div>
 
  <div class="picture" id="pic11"><a href="programma/scheve-toren-feest/glas/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Glasblazen</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_glas.jpg" /></a> </div>

  <div class="picture" id="pic12"><a href="programma/scheve-toren-feest/klinkt/">
    <div class="pic_bg">
      <div class="white_banner">
        <h2>Schelle klinkt</h2>
      </div>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/img/thumb_harmonie.jpg" /></a> </div>
  <!-- Close .picture -->
  <div class="clearfix"></div>
</div>
<!-- Close #content -->
<div class="clearfix"></div>
</div>
<!-- Close #content_wrapper -->
<?php get_footer(); ?>
