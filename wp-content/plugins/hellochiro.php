<?php
/**
 * @package Hello_Chiro
 * @author Matt Mullenweg, edits by Ben & Jo Bridts
 * @version 1.5.1
 */
/*
Plugin Name: Hello Chiro
Plugin URI: http://wordpress.org/#
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg, edits by Ben & Jo Bridts
Version: 1.5.1
Author URI: http://ma.tt/
*/

function hello_dolly_get_lyric() {
	/** These are the lyrics to Hello Dolly */
	$lyrics = "Hello, Dolly
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

/** And Here are the Chiro Schelle lyrics: */
$lyrics="Ik blijf in Chiro Geloven
En ik stuur een ballon naar boven
De chiro, een uitdaging
Don't try this at home
Span een draad
C H, C H I, C H I R O
We zijn een toffe bende, we zijn van de chiro
Smijt jezelf erin
Chiro Schelle _ _ _ The place to be
Als je't mij vraagt
Niet zomaar een zondag, niet zomaar een dag
Niet zomaar een spel, van alles goed en wel
Niet zomaar de tijd passeren, vraag en aanbod consumeren
In onze ploeg valt geeneen uit de boot
Trek er mee op uit, breek grenzen open
Samenspel wordt teken om te hopen.
Vlieg erin, doe mee, en blijf niet staan
Een nieuwe wereld roept om door te gaan
Iedereen een maatje meer
Wij zijn gek, wij zijn geksentriek
Bij ons is &#8217;t reuzefijn
Ook jij hoort bij ons te zijn
Met een wenk om chiro te doen
Speel met spel, da's chirotaal
Nog meer dan spel
Gebruik alvast het smiemachien
Kom maar in de kring
Speel met ons, toe nog een keer
We vallen op, maar zelden uit
Geen gedoe, we gaan er voor
Winnen is niet relevant, wat telt is amuseren
Doorploeg de week, zondag een break
We vormen ploeg en we houden vol
Bij ons in de chiro is alles oké";


	// Here we split it into lines
	$lyrics = explode("\n", $lyrics);

	// And then randomly choose a line
	return wptexturize( $lyrics[ mt_rand(0, count($lyrics) - 1) ] );
}

// This just echoes the chosen line, we'll position it later
function hello_dolly() {
	$chosen = hello_dolly_get_lyric();
	echo "<p id='dolly'>$chosen</p>";
}

// Now we set that function up to execute when the admin_footer action is called
add_action('admin_footer', 'hello_dolly');

// We need some CSS to position the paragraph
function dolly_css() {
	// This makes sure that the posinioning is also good for right-to-left languages
	$x = ( 'rtl' == get_bloginfo( 'text_direction' ) ) ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#dolly {
		position: absolute;
		top: 4.5em;
		margin: 0;
		padding: 0;
		$x: 215px;
		font-size: 11px;
	}
	</style>
	";
}

add_action('admin_head', 'dolly_css');

?>
