<?php
/**
 * @package WordPress
 * @subpackage Chiro_Schelle
 * De footer - sidebars
 
 */
?>
    	<div id="footerlinks">
        	<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('links') ) : ?><?php endif; ?>
                <?php copyright()?>
            </ul>
        </div><!-- Sluiten van 'footerlinks'-->

        <div id="footermidden">
			<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('midden') ) : ?>
            	<?php endif; ?>
                
                
            </ul>
        </div><!-- Sluiten van 'footermidden'-->
             
        <div id="footerrechts">   
			<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('rechts') ) : ?>
                <?php endif; ?>
            </ul>
        </div><!-- Sluiten van 'footerrechts'-->