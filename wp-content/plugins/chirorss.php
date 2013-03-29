<?php
/*
Plugin Name: Chiro RSS
Plugin URI: Chiroschelle.be
Description: Geeft de RSS, Twitter en Facebook -links en -logos weer.
Author: Mante Bridts
Version: 2.0
Author URI: www.mantebridts.be
*/

function widget_ChiroRSS($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?><?php echo $after_title;
  ?>
  
			<p>
            <a class="topfooter" href="<?php bloginfo('rss2_url'); ?>">Bezoek ook onze andere webpagina's:</a><br /><br />
					<a class="topfooter" href="http://www.facebook.com/pages/Chiro-Schelle/375803333235">
                	<img class="logofooter" src="<?php bloginfo('template_directory') ?>/images/chiro_fb.jpg" alt="chirologo" /></a>
                    <a class="topfooter" href="http://www.twitter.com/chiroschelle">
                	<img class="logofooter" src="<?php bloginfo('template_directory') ?>/images/chiro_twitter.jpg" alt="chirologo" /></a>
                    <a class="topfooter" href="http://www.youtube.com/chiroschelle#g/u">
                	<img class="logofooter" src="<?php bloginfo('template_directory') ?>/images/chiro_youtube.png" alt="chirologo" /></a>     
                    <a class="topfooter" href="<?php bloginfo('rss2_url'); ?>">
                	<img class="logofooter" src="<?php bloginfo('template_directory') ?>/images/chiro_rss2.jpg" alt="chirologo" /></a> 
                                
            </p>
  <?php
  echo $after_widget;
  
}

function myHelloWorld_init()
{
  register_sidebar_widget(__('Chiro RSS'), 'widget_ChiroRSS');    
}
add_action("plugins_loaded", "myHelloWorld_init");
?>