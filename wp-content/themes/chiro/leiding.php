<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Leidingspagina
 */

get_header();
?>

	<div id="kijkerbackground">
		<div id="kijker_single">
			<div id="pijlgezicht_single"></div>
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
			<div id="left"></div>
			<div id="middle">
				<div id="pijl"></div>
				<div class="inhoudfiguur"></div>
				<div id="inhoudtekst">
<?php
	//haal de id's op van de groepsleiding:
	$groeps_ids = get_user_id('groeps',1);
	//als er groeps is:
	if ($groeps_ids) {
		echo '		<table class="leidingtabel">
						<tr>
							<td></td>
							<td class="tb_info">
								<h2>Groepsleiding</h2>
							</td>
						</tr>';
		foreach ($groeps_ids as $groeps_id){
			display_leiding_info($groeps_id);
		}
?>
						<tr>
							<td></td>
							<td class="tb_info">
								<a class="contactemaildres" href="<?php echo get_bloginfo('url') . '/contact/?contact=info' ; ?>">Contacteer de groepsleiding</a>
							</td>
						</tr>
					</table>
					<div class="lijnleiding"></div>
<?php
	} //if groepsids

	//haal de rest van de leiding op:
	$leiding_ids = get_user_id('rank','leiding');

	for ($i=1;$i<=12;$i++){
 	   $leiding[$i] = sort_op_afdeling($leiding_ids,$i);
	}
	for ($j=1;$j<=12;$j++){
		$l = $leiding[$j];
		$i= 0;

		//als er leiding is voor die afdeling
		if($l[$i]){
			echo '	<table class="leidingtabel">
						<tr>
							<td></td>
							<td class="tb_info">
								<h2>' . maaknummerafdeling($j) . '</h2>
							</td>
							<td></td>
						</tr>';

			foreach ($l as $id){
				if (fmod($j,2)== 1){
					//lijn rechts uit
					display_leiding_info($id, false);
				}
				else{
					//lijn links uit
					display_leiding_info($id, true);
				}
			} //foreach
?>
						<tr>
							<td></td>
							<td class="tb_info">
								<a class="contactemaildres" href="<?php echo get_bloginfo('url') . "/contact/?contact=leiding&afdeling=$j&toon=leiding"; ?>">
									Contacteer de <?php echo maaknummerafdeling($j); ?>
								</a>
							</td>
							<td></td>
						</tr>
					</table>
					<div class="lijnleiding"></div>
<?php
        } //if $l[$i]
	} //for $j
	
	//haal de veebees op
	$vb_ids = get_user_id('rank','vb');
	if ($vb_ids){
		echo '		<table class="leidingtabel">
						<tr>
							<td></td>
							<td class="tb_info"><h2>Volwassen Begeleiding</h2></td>
							<td></td>
						</tr>
						   ';
		foreach ($vb_ids as $vb_id){
			display_leiding_info($vb_id, false);
		}
?>
						<tr>
							<td></td>
							<td class="tb_info">
								<a class="contactemaildres" href="<?php echo get_bloginfo('url') . '/contact/?contact=info' ; ?>">
									Contacteer de VeeBee
								</a>
							</td>
							<td></td>
						</tr>
					</table>

<?php
	} //if vb_ids
?>
				</div> <!--sluiten van inhoudtekst-->
				<div class="cleaner"></div>
<?php endwhile; ?>
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
