<?php
/**
 * @package WordPress
 * @subpackage Chiro_Schelle
 */
get_header();
?>
 <div id="kijkerbackground">
      <div id="kijker_single">
       	  <div id="pijlgezicht_single"></div>
        	 <div id="kijkerfiguur">&nbsp;</div> <!--Sluiten van 'kijkerfiguur'-->
             <div id="kijkertekst">
             	<h1>OEPS...</h2>
             	<h2>Er is iets misgegaan</h2>
                        <p>De pagina die u wilt bezoeken, bestaat blijkbaar niet.</p>
                        <h2>Geen paniek</h2>
                        <p>Je kan altijd opnieuw beginnen vanaf onze <a href="<?php bloginfo('url'); ?>" >Homepage</a>.<br /> Vind je echt niet wat je zoekt, of is er iets grondig mis. Neem dan gerust contact op met <a href="<?php echo bloginfo('url') . '/contact/?contact=site'; ?>">de webmasters</a></p>
             </div> <!--Sluiten van 'kijkertekst'-->
             <div class="cleaner"></div>
          </div><!--Sluiten van 'kijker'-->
 </div><!--Sluiten van 'kijkerbackground'-->
 <div id="main1">
    	<div id="main2">
            <div id="right"></div>
            <div id="middle">
            	<div id="pijl"></div>
        		<div class="post">
                    <div class="inhoudfiguur">&nbsp;<!--<?php
										if ( has_post_thumbnail() ) {
											// the current post has a thumbnail
											the_post_thumbnail( array(150,150) );
										} else {
											// deze post heeft geen thumbnail, we tonen een andere figuur
											toonstandaardthumb();
										}
										?>--></div><!--Sluiten van 'inhoudfiguur'-->
                	<div id="inhoud">
                    	<br />
                    	<p>

                        <img src="<?php echo get_bloginfo('template_url').'/images/404.jpg'; ?>" /></p>
                    </div> <!--Sluiten van 'inhoudzonderimg'-->
                    <div class="cleaner"></div>
                </div> <!--Sluiten van 'post'-->
				<div class="cleaner"></div>
            </div><!--Sluiten van 'middle'-->
		</div><!--Sluiten van 'main2'-->
    </div><!--Sluiten van 'main1'-->
<?php get_footer(); ?>