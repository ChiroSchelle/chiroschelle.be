<?php
/**
 * @package WordPress
 * @subpackage Chiro_Schelle
 */

get_header(); ?>
 <div id="kijkerbackground">
      <div id="kijker_single">   
       	  <div id="pijlgezicht_single"></div>

		<?php if (have_posts()) : 
			$id = $post->post_author;
			
				$ids = array();
				while (have_posts()) : the_post();
						if ($count == "5"){
							break 1;
							}
						else { 
							array_push($ids, get_the_author_meta('ID'));
							$ids = array_unique($ids);
							$count++;
						}
				endwhile;
				rewind_posts();
		?>
        	
       		
            <div id="kijkerfiguur">&nbsp;</div> <!--Sluiten van 'kijkerfiguur'-->
            <div id="kijkertekst">
				<div class="navigation">
                	<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
                	<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
             	</div><!--Sluiten van 'navigation'-->
				  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
                  <?php /* If this is a category archive */ if (is_category()) { ?>
                    <h1>Categorie &#8216;<?php single_cat_title(); ?>&#8217;</h1>
                    <h3>
                    	De laatste berichten werden gepost door:
                    </h3>
                  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                    <h2 class="pagetitle">Alle berichten met &#8216;<?php single_tag_title(); ?>&#8217;</h2>
                  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                    <h2 class="pagetitle">Alle berichten van  <?php the_time('F jS, Y'); ?></h2>
                  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                    <h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
                  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                    <h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
                  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                    <h2 class="pagetitle">
                    	Alle berichten van <?php echo get_userdata($id)->display_name; ?>
                    </h2>                        
                  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                    <h2 class="pagetitle">Blog Archives</h2>
                  <?php } ?>
                  
                  <?php 
				  	$ids = array_slice($ids, 0, 4);
					foreach ($ids as $id){?>
						<div class="auteur">
	                        <a href="<?php bloginfo("url") ?>/author/<?php echo get_userdata($id)->user_login; ?>"><?php echo get_avatar($id, 100); ?></a>
                            <br/>
                            <a class="naam" href="<?php bloginfo("url") ?>/author/<?php echo get_userdata($id)->user_login; ?>"><?php echo get_userdata($id)->first_name;?></a>
                        </div>
                        
					<?php }	?>
            </div> <!--Sluiten van 'kijkertekst'-->
            <div class="cleaner"></div>    
            </div><!--Sluiten van 'kijker'-->
  
 </div><!--Sluiten van 'kijkerbackground'-->
<div id="main1">
    	<div id="main2">    
            <div id="right"></div>
            <div id="middle">   
            	<div id="pijl"></div>

<?php while (have_posts()) : the_post(); ?>
        	 <div class="post lijn">
                     <div class="inhoudfiguur">
                         <?php
										if ( has_post_thumbnail() ) {
											// the current post has a thumbnail
											the_post_thumbnail( array(150,150) );
										} else {
											// deze post heeft geen thumbnail, we tonen een andere figuur - 2 mappen hoger ../../
											toonstandaardthumb(1);
										}
										?>
                    </div><!--Sluiten van 'inhoudfiguur'--> 
 					 <div class="inhoudzonderimg">		
                       <h1 class="posttitel"><a href="<?php the_permalink() ?>" rel="bookmark" title="Link naar <?php the_title_attribute(); ?>"><?php the_title(); ?>
</a></h1>
                        <h2 class="postmeta">Geschreven door <?php the_author() ?> op <?php the_time('l j F Y') ?></h2>
                            <?php the_content() ?>
        
                        <div id="postlinks"><?php the_tags('Tags: ', ', ', '<br />'); ?> Geplaatst in <?php the_category(', ') ?> - <?php edit_post_link('Bewerk', '', ' - '); ?>  <?php comments_popup_link('Geen reacties &#187;', '1 Reactie &#187;', '% Reacties &#187;'); ?></div>
        

				 </div> <!--Sluiten van 'inhoud'--> 
				 <div class="cleaner"></div> 
           </div> <!--Sluiten van 'post lijn'-->  
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div> <!--Sluiten van 'navigation'-->
	<?php else :
		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		get_search_form();
	endif;
?>
	 <div class="cleaner"></div>       
            </div><!--Sluiten van 'middle'-->
		</div><!--Sluiten van 'main2'-->
    </div><!--Sluiten van 'main1'-->
<?php get_footer(); ?>
