<?php
/*
Plugin Name: Hello Dolly [Chiro Schelle edit]
Plugin URI: http://wordpress.org/#
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page. Met Hello Dolly lyrics vervangen door chiro lyrics
Author: Matt Mullenweg
Version: 1.5
Author URI: http://photomatt.net/
*/

// These are the lyrics to Hello Dolly
/*$lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
So, take her wrap, fellas
Find her an empty lap, fellas
Dolly'll never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
Golly, gee, fellas
Find her a vacant knee, fellas
Dolly'll never go away
Dolly'll never go away
Dolly'll never go away again";
*/
/*
Want 't is het teken, 't is het verhaal
Van kind'ren dat ik je zing
Tuimel, Tuimeling
Stotteren en giechelen zo rood als een tomaat
Iets dat heel je leven raakt,
en waar je samen werk van maakt.
Leven op het ritme van de wind en van de zon,
Zingen op de melodie van bos en beek en bron.
Slapen met 't getrommel van de regen op het dak,
Ontwaken met de morgendauw: we zijn weer op bivak.
Ieder die ons ziet, kijkt raar,
Wat niet kon, dat wordt hier waar.
Vreemd wordt vriend en klein is groot

*/
//Chiro Schelle regels:
$lyrics="Ik blijf in Chiro Geloven
En ik stuur een ballon naar boven
De chiro, een uitdaging.
Don't try this at home
Span een draad
C H, C H I, C H I R O
We zijn een toffe bende, we zijn van de chiro
Smijt jezelf erin
Chiro Schelle _ _ _ The place to be
Als je't mij vraagt
niet zomaar een zondag, niet zomaar een dag
niet zomaar een spel, van alles goed en wel.
Niet zomaar de tijd passeren, vraag en aanbod consumeren.
In onze ploeg valt geeneen uit de boot.
Trek er mee op uit, breek grenzen open
Samenspel wordt teken om te hopen.
Vlieg erin, doe mee, en blijf niet staan
Een nieuwe wereld roept om door te gaan.";

// Here we split it into lines
$lyrics = explode("\n", $lyrics);
// And then randomly choose a line
$chosen = $lyrics[ mt_rand(0, count($lyrics) - 1) ] ;

// This just echoes the chosen line, we'll position it later
function toon_txt() {
	global $chosen;
	echo "<p id='randomtxt'>$chosen</p>";
}
/*
// Now we set that function up to execute when the admin_footer action is called
add_action('admin_footer', 'hello_dolly');

// We need some CSS to position the paragraph
function dolly_css() {
	echo "
	<style type='text/css'>
	#dolly {
		position: absolute;
		top: 2.3em;
margin: 0; padding: 0;
		right: 1em;
		font-size: 16px;
		color: #f1f1f1;
	}
	</style>
	";
}

add_action('admin_head', 'dolly_css');
*/
?>