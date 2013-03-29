<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: GoCartTocht
 */

get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="kijkerbackground">
  <div id="kijker">
    <div id="pijlgezicht"></div>
    <div>
      <div id="kijkerfiguur">
        <?php the_post_thumbnail( array(100,100) ); ?>
      </div>
      <div id="kijkertekst">
        <h1>
          <?php the_title(); ?>
          <?php edit_post_link('Bewerk', ' - ', ''); ?>
        </h1>
        <p>De Go-carttocht van de kerels begint stilaan een bekend concept te worden. Deze afdeling gaat drie vermoeiende fietsdagen tegemoet om de afdelingskas te spijzen.<br/>
        <ul>
          <li><strong>Wanneer?</strong> 6 tot 9 juli 2011</li>
          <li><strong>Wie?</strong> de MT(tuut) Kerels</li>
          <li><strong>Waar?</strong>(tot waar) Van Oostende tot Schelle (met enkele tussenstoppen )</li>
        </ul>
       <p> Meer info volgt !!!<br/>
        <br/>
        U kan ons helpen. Kies een bedrag dat u per kilometer zou willen sponsoren en <a href="http://chiroschelle.be/contact/?contact=leiding&afdeling=9&toon=leiding">laat ons iets weten.</a><br/>
        <br/>
        De Kerels zullen u dankbaar zijn!
        </p>
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
        <div class="inhoudfiguur"> &nbsp; </div>
        <div id="inhoudtekst">
          <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
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
