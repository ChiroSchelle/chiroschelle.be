<?php

add_action('admin_menu', 'nieuwsbrief_menu');

function nieuwsbrief_menu(){
	add_options_page('Nieuwsbrief', 'Nieuwsbrief options', 'administrator', 'nieuwsbrief_options_page', 'nieuwsbrief_display_options_page');
	$icon_url = plugins_url('images/plugin-menu-icon16.png', __FILE__);
	add_menu_page('', 'Nieuwsbrief', 'view_niuewsbrief', NIEUWSBRIEF_NAME, 'nieuwsbrief_display_page', $icon_url) ;
}

function nieuwsbrief_display_options_page(){
	?>
	<h2>Hier wordt nog aan gewerkt</h2>
	<?
}

function nieuwsbrief_display_page(){
	$url =  get_option('siteurl');
	$urljs = $url . '/wp-content/plugins/nieuwsbrief/functions.js';
	?>
		<h2>Nieuwsbrief creater</h2>
		<script type="text/javascript" src="<? echo $urljs; ?>"></script>
		<?php
		if((!isset($_POST['make']) && !isset($_POST['send'])) || isset($_POST['Terug'])){
			$terug = isset($_POST['Terug']);
			$brief;
			if($terug){
				require_once 'nieuwsbrief/classes.php';
				$brief = (unserialize(base64_decode($_POST['nieuwsbrief'])));
			}
			?>
				<form method="post" name="form">
					<div id="intoForm">
						<h3>Berichten</h3>
						<? if(!$terug){
						?>
						<script>addField()</script>
						<? } else {
							$html = $brief->getHTMLInterface();
							echo $html[0];
							?><script>i = <? echo $html[1]; ?></script>
						<? } ?>
					</div>
					<input type="button" onclick="addField()" value="Add veld"></input>
					<div id="agenda">
						<h3>Agenda</h3>
						<textarea name="agenda" cols="60" rows="6"><? if($terug){echo $brief->getAgenda();}?></textarea>
						<br>
						<i>Schrijf elk agenda item op een nieuwe lijn.</i>
					</div>	
					<input type="submit" name="make">	
				</form>
			<?
		}else if(isset($_POST['make']) && !isset($_POST['send'])){
			$urlpop = $url . "/wp-content/plugins/nieuwsbrief/js_pop.php";
			require_once 'nieuwsbrief/classes.php';
			$brief = new Nieuwsbrief;
			$i = 0;
			while(isset($_POST["Titel_" . $i])){
				if($_POST["Titel_" . $i] == ""){
					$i++;
					continue;
				}
				$title = $_POST["Titel_" . $i];
				$img = $_POST["Image-url_" . $i];
				$text = $_POST["Text_" . $i];	
				$item = new Item($title, $text, $img);
				$brief->addItem($item);
				$i++;
			}
			$brief->setAgenda($_POST['agenda']);
			$briefbase64 = base64_encode(serialize($brief));
			?>
			<h3>De nieuwsbrief is gemaakt</h3>
			<div id="button1">
			<form action="<? echo $urlpop; ?>" method="post" target="<? echo $brief->getSubject(); ?>" onsubmit="getPopUp(this.target);">
				<input type="hidden" name="nieuwsbrief" value='<? echo $briefbase64; ?>'>
				<input type="submit" value="Voorbeeld" />
			</form>
			</div>
			<div id="button2">
			<form method="post" name="terug">
				<input type="hidden" name="nieuwsbrief" value='<? echo $briefbase64; ?>'>
				<input type="submit" value="Terug" name="Terug"/>
			</form>
			</div>
			<div id="button3">
				<form method="post" onsubmit="return readyToSend()">
					<input type="hidden" name="nieuwsbrief" value='<? echo $briefbase64; ?>'>
					<input type="submit" value="Verstuur" name="send" />
				</form>
			</div>
				<?
		}
		else if(isset($_POST['send'])){
			require_once 'nieuwsbrief/classes.php';
			$brief = unserialize(base64_decode($_POST['nieuwsbrief']));
			$brief->writeToFile("/home/c7070chi/public_html/nieuws/index.html");
			$send = $brief->send2("nieuwsbrief@chiroschelle.be");
			if($send == true){
			?>
				<h3>De nieuwsbrief werd goed verzonden</h3>
			<?
			}
			else {
				?>
				<h3>Er heeft een fout zich voorgedaan bij het versturen van de nieuwsbrief probeer om terug te gaan.</h3>
				<div id="button1">
				<form method="post" name="terug">
					<input type="hidden" name="nieuwsbrief" value='<? echo base64_encode(serialize($brief)); ?>'>
					<input type="submit" value="Terug" name="Terug"/>
				</form>
				</div>
			<?	
			}
		}
}
