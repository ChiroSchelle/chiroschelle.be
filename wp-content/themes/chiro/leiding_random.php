<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Leidingspagina-random
 */


get_header();

// doe wat rekenwerk op voorhand
//$all_users = $wpdb->get_results("SELECT ID from $wpdb->users ");
//$all_leiding = get_user_id_can('rank_leiding', $all_users);
//$leiding_id = $all_leiding;
//$vb_id = get_user_id_can('rank_vb', $all_leiding);
$leiding_id = get_user_id('rank','leiding');
$groeps_id = get_user_id('groeps', '1');
$vb_id = get_user_id('rank','vb');
$overgangen = true;
if (strtotime(time()) <= strtotime("2102-09-03")){ 
  $overgangen = false;
  $aantal_groeps = rand(1,3);
  $rand_keys = array_rand($leiding_id,$aantal_groeps);
  if ($aantal_groeps == 1){
    $tmp = $rand_keys;
    unset($rand_keys);
    $rand_keys[0] = $tmp;
  }
  
  for($i=0; $i<$aantal_groeps ; $i++){
    $groeps_id[$i] = $leiding_id[$rand_keys[$i]];
  }
}
?>

	<div id="kijkerbackground">
      <div id="kijker_single">
       	  <div id="pijlgezicht_single"></div> <!--Sluiten van 'pijlengezicht_single'-->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
              <div id="kijkerfiguur">
			  		  <?php the_post_thumbnail( array(100,100) ); ?>
              </div> <!--Sluiten van 'kijkerfiguur'-->
              <div id="kijkertekst">
				 <h1><?php the_title(); ?><?php edit_post_link('Bewerk', ' - ', ''); ?></h1>
                        <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
              </div> <!--Sluiten van 'kijkertekst'-->
            <div class="cleaner"></div>
        </div> <!--Sluiten van 'kijker_single'-->
    </div> <!--Sluiten van 'kijkerbackground'-->

    <div id="main1">
    	<div id="main2">
            <div id="right"></div>
            <div id="middle">
            	<div id="pijl"></div>
                     <div id="inhoudfiguur">
                    </div> <!--Sluiten van 'inhoudfiguur'-->
               		<div id="inhoudtekst">
        	               <?php
// opbouw groepsleiding

        	               //als er groeps is:
        	               if ($groeps_id) {
							   echo '<table class="leidingtabel">
							   <tr>
							   		<td></td>
									<td class="tb_info">
										<h2><a name="Groepsleiding" class="anchor">Groepsleiding</a></h2>
									</td>
								</tr>';
									foreach ($groeps_id as $groeps_id){
										display_leiding_info($groeps_id);	
									} ?>
								   <tr>
									<td></td>
									<td class="tb_info"><a class="contactemaildres" href="<?php echo get_bloginfo('url') . '/contact/?contact=info' ; ?>">Contacteer de groepsleiding</a></td>
								   </tr>
                             </table>
                             <div class="lijnleiding"></div>
                               <?php
        	               }

//opbouw leiding
if($overgangen){
  for ($i=1;$i<=12;$i++){
    //haal de rest van de leiding op:
    $leiding[$i] = sort_op_afdeling($leiding_id,$i);
   }
}
else{
  //zet de leiding in willekeurige volgorde
  shuffle($leiding_id); 
  //zet een de afdelingen in willekeurige volgorde
  for ($i=1;$i<=12;$i++){
    $afdelingnrs[$i-1] = $i;
  }
  shuffle($afdelingnrs);
  
  // vul afdeling per afdeling de leiding in
  $i= 0;
  foreach ($afdelingnrs as $afdelingnr) {
    $i++;
    $count = count($leiding_id);

    //bepaal de grootte van de afdelingen    
    // niet zoveel rekenwerk, in het begin grote afdelingen
    //$max = count($leiding_id)/2 -1;
    // meer rekenwerk, grootte van afdelingen ligt dichter bij elkaar
    // uitleg: sqrt zorgt dat begin afdelingen niet zo groot kunnen zijn,
    // maar hoe kleiner $count wordt, hoe kleiner het verschil tussen de vorige
    // +$i/4 compenseert dit nog wat meer door op het einde de afdelingen 
    // groter te maken.
    // tl;dr: Aantal dingen geprobeerd, deze formule is deftig.
    $max = (int)(sqrt($count)+$i/4);
    
    $grootte = rand(1,$max); //+1 omdat (int) gewoon afkapt
    if($grootte > $count){
      $grootte = $count;
    }
    // vul de afdeling met $grootte aantal leiders, 
    // en verwijder deze leiders uit de array
    for($ii=0;$ii < $grootte; $ii++){
      $afdeling[$ii]=array_pop($leiding_id);
    }
    // zet de afdeling in de normale leiding array.
    $leiding[$afdelingnr] = $afdeling;
    // maak afdeling array leeg, anders problemen als deze loop
    // nog eens doorlopen wordt.
    unset($afdeling); 
  }
  unset($vb_id);
  $vb_id = $leiding_id; //leiding die nu nog overschiet wordt vb.
}
 //vanaf hier terug de originele code
   for ($j=1;$j<=12;$j++){
   	$l = $leiding[$j];
							$i= 0;
							//als er leiding is voor die afdeling
							if($l[$i]){
							echo '<table class="leidingtabel">
									<tr>
										<td></td>
										<td class="tb_info"><h2><a name="'. maaknummerafdeling($j) .'" class="anchor" >' . maaknummerafdeling($j) . '</a></h2></td>
                                        <td></td>
									</tr>';

							foreach ($l as $id){
									if (fmod($j,2)== 1){
									// rechts uitgelijnd
									display_leiding_info($id, false);
									}
									else{
									// links uitgelijnd
									display_leiding_info($id, true);
    	               				}
							}
                       		?>
                                <tr>
                                    <td></td>
                                    <td class="tb_info"><a class="contactemaildres" href="<?php echo get_bloginfo('url') . "/contact/?contact=leiding&afdeling=$j&toon=leiding"; ?>">Contacteer de <?php echo maaknummerafdeling($j); ?></a></td>
                                    <td></td>
                                </tr>
                         	</table>
                            <div class="lijnleiding"></div>
							<?php
                        } //if $l[$i]
					} //for $j

//opbouw vb
        	               if ($vb_id){
        	               echo '<table class="leidingtabel">
						    <tr>
						   	  <td></td>
							  <td class="tb_info"><h2><a name="VB" class="anchor">Volwassen Begeleiding</a></h2></td>
							  <td></td>
							</tr>
						   ';
        	               foreach ($vb_id as $vb_id){
	               				display_leiding_info($vb_id, false);
							} ?>
                                <tr>
                                    <td></td>
                                    <td class="tb_info"><a class="contactemaildres" href="<?php echo get_bloginfo('url') . '/contact/?contact=info' ; ?>">Contacteer de VeeBee</a></td>
                                    <td></td>
                                </tr>
                            </table>

                            <?php }


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
