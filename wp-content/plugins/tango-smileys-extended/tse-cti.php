<?php

/*
#	This file contains the array for inserting clickable smileys.
#	This is a separate file so I may easily update TSE with additional smileys.
#	This file also contains the functions for inserting clickable smileys.
#	Please do not edit this file.
*/

function tseCTI_get_smileys( $tse_showcase = 'none' ) {
	$tseCTI_standard = array(
		array(' :-) ','smile.png','Smile'),
		array(' :-)) ','smile-big.png','Big Smile'),
		array(' :-D ','grin.png','Grin'),
		array(' :laugh: ','laugh.png','Laugh'),
		array(' :-( ','frown.png','Frown'),
		array(' :-(( ','frown-big.png','Big Frown'),
		array(' :cry: ','crying.png','Cry'),
		array(' :-| ','neutral.png','Neutral'),
		array(' ;-) ','wink.png','Wink'),
		array(' :-* ','kiss.png','Kiss'),
		array(' :-P ','razz.png','Razz'),
		array(' :chic: ','chic.png','Chic'),
		array(' 8-) ','cool.png','Cool'),
		array(' :-X ','angry.png','Angry'),
		array(' :reallyangry: ','really-angry.png','Really Angry'),
		array(' :-? ','confused.png','Confused'),
		array(' ?:-) ','question.png','Question'),
		array(' :-/ ','thinking.png','Thinking'),
		array(' :pain: ','pain.png','Pain'),
		array(' :shock: ','shock.png','Shock'),
		array(' :yes: ','thumbs-up.png','Yes'),
		array(' :no: ','thumbs-down.png','No')
	);
	$tseCTI_special = array(
		array(' :alien: ','alien.png','Alien'),
		array(' O:-) ','angel.png','Angel'),
		array(' :clown: ','clown.png','Clown'),
		array(' :cowboy: ','cowboy.png','Cowboy'),
		array(' :cyclops: ','cyclops.png','Cyclops'),
		array(' :devil: ','devil.png','Devil'),
		array(' :doctor: ','doctor.png','Doctor'),
		array(' :fighterf: ','fighter-f.png','Female Fighter'),
		array(' :fighterm: ','fighter-m.png','Male Fighter'),
		array(' :mohawk: ','mohawk.png','Mohawk'),
		array(' :music: ','music.png','Music'),
		array(' :nerd: ','nerd.png','Nerd'),
		array(' :party: ','party.png','Party'),
		array(' :pirate: ','pirate.png','Pirate'),
		array(' :skywalker: ','skywalker.png','Skywalker'),
		array(' :snowman: ','snowman.png','Snowman'),
		array(' :soldier: ','soldier.png','Soldier'),
		array(' :vampire: ','vampire.png','Vampire'),
		array(' :zombiekiller: ','zombie-killer.png','Zombie Killer'),
		array(' :ghost: ','ghost.png','Ghost'),
		array(' :skeleton: ','skeleton.png','Skeleton')
	);
	$tseCTI_animals = array(
		array(' :bunny: ','bunny.png','Bunny'),
		array(' :cat: ','cat.png','Cat'),
		array(' :cat2: ','cat2.png','Cat 2'),
		array(' :chick: ','chick.png','Chick'),
		array(' :chicken: ','chicken.png','Chicken'),
		array(' :chicken2: ','chicken2.png','Chicken 2'),
		array(' :cow: ','cow.png','Cow'),
		array(' :cow2: ','cow2.png','Cow 2'),
		array(' :dog: ','dog.png','Dog'),
		array(' :dog2: ','dog2.png','Dog 2'),
		array(' :duck: ','duck.png','Duck'),
		array(' :goat: ','goat.png','Goat'),
		array(' :hippo: ','hippo.png','Hippo'),
		array(' :koala: ','koala.png','Koala'),
		array(' :lion: ','lion.png','Lion'),
		array(' :monkey: ','monkey.png','Monkey'),
		array(' :monkey2: ','monkey2.png','Monkey 2'),
		array(' :mouse: ','mouse.png','Mouse'),
		array(' :panda: ','panda.png','Panda'),
		array(' :pig: ','pig.png','Pig'),
		array(' :pig2: ','pig2.png','Pig 2'),
		array(' :sheep: ','sheep.png','Sheep'),
		array(' :sheep2: ','sheep2.png','Sheep 2'),
		array(' :reindeer: ','reindeer.png','Reindeer'),
		array(' :snail: ','snail.png','Snail'),
		array(' :tiger: ','tiger.png','Tiger'),
		array(' :turtle: ','turtle.png','Turtle')
	);
	$tseCTI_foodndrink = array(
		array(' :beer: ','beer.png','Beer'),
		array(' :drink: ','drink.png','Drink'),
		array(' :liquor: ','liquor.png','Liquor'),
		array(' :coffee: ','coffee.png','Coffee'),
		array(' :cake: ','cake.png','Cake'),
		array(' :pizza: ','pizza.png','Pizza'),
		array(' :watermelon: ','watermelon.png','Watermelon'),
		array(' :bowl: ','bowl.png','Bowl'),
		array(' :plate: ','plate.png','Plate'),
		array(' :can: ','can.png','Can')
	);
	$tseCTI_other = array(
		array(' :female: ','female.png','Female'),
		array(' :male: ','male.png','Male'),
		array(' :heart: ','heart.png','Heart'),
		array(' :brokenheart: ','heart-broken.png','Broken Heart'),
		array(' :rose: ','rose.png','Rose'),
		array(' :deadrose: ','rose-dead.png','Dead Rose'),
		array(' :peace: ','peace.png','Peace'),
		array(' :yinyang: ','yin-yang.png','Yin Yang'),
		array(' :flagus: ','flag-us.png','US Flag'),
		array(' :moon: ','moon.png','Moon'),
		array(' :star: ','star.png','Star'),
		array(' :sun: ','sun.png','Sun'),
		array(' :cloudy: ','cloudy.png','Cloudy'),
		array(' :rain: ','rain.png','Rain'),
		array(' :thunder: ','thunder.png','Thunder'),
		array(' :umbrella: ','umbrella.png','Umbrella'),
		array(' :rainbow: ','rainbow.png','Rainbow'),
		array(' :musicnote: ','music-note.png','Music Note'),
		array(' :airplane: ','airplane.png','Airplane'),
		array(' :car: ','car.png','Car'),
		array(' :island: ','island.png','Island'),
		array(' :announce: ','announce.png','Announce'),
		array(' :brb: ','brb.png','brb'),
		array(' :mail: ','mail.png','Mail'),
		array(' :cell: ','mobile.png','Cell'),
		array(' :phone: ','phone.png','Phone'),
		array(' :camera: ','camera.png','Camera'),
		array(' :film: ','film.png','Film'),
		array(' :tv: ','tv.png','TV'),
		array(' :clock: ','clock.png','Clock'),
		array(' :lamp: ','lamp.png','Lamp'),
		array(' :search: ','search.png','Search'),
		array(' :coins: ','coins.png','Coins'),
		array(' :computer: ','computer.png','Computer'),
		array(' :console: ','console.png','Console'),
		array(' :present: ','present.png','Present'),
		array(' :soccer: ','soccerball.png','Soccer'),
		array(' :clover: ','clover.png','Clover'),
		array(' :pumpkin: ','pumpkin.png','Pumpkin'),
		array(' :bomb: ','bomb.png','Bomb'),
		array(' :hammer: ','hammer.png','Hammer'),
		array(' :knife: ','knife.png','Knife'),
		array(' :handcuffs: ','handcuffs.png','Handcuffs'),
		array(' :pill: ','pill.png','Pill'),
		array(' :poop: ','poop.png','Poop'),
		array(' :cigarette: ','cigarette.png','Cigarette')
	);
	$tseCTI_extended = array(
		array(' :rotfl: ','rotfl.png','LOL'),
		array(' :silly: ','silly.png','Silly'),
		array(' :beauty: ','beauty.png','Beauty'),
		array(' :lashes: ','lashes.png','Lashes'),
		array(' :cute: ','cute.png','Cute'),
		array(' :shy: ','bashful.png','Shy'),
		array(' :blush: ','blush.png','Blush'),
		array(' :kissed: ','kissed.png','Kissed'),
		array(' :inlove: ','in-love.png','In Love'),
		array(' :drool: ','drool.png','Drool'),
		array(' :giggle: ','giggle.png','Giggle'),
		array(' :snicker: ','snicker.png','Snicker'),
		array(' :heh: ','curl-lip.png','Heh!'),
		array(' :smirk: ','smirk.png','Smirk'),
		array(' :wilt: ','wilt.png','Wilt'),
		array(' :weep: ','weep.png','Weep'),
		array(' :idk: ','dont-know.png','IDK'),
		array(' :struggle: ','struggle.png','Struggle'),
		array(' :sidefrown: ','sidefrown.png','Side Frown'),
		array(' :dazed: ','dazed.png','Dazed'),
		array(' :hypnotized: ','hypnotized.png','Hypnotized'),
		array(' :sweat: ','sweat.png','Sweat'),
		array(' :eek: ','bug-eyes.png','Eek!'),
		array(' :roll: ','eyeroll.png','Roll Eyes'),
		array(' :sarcasm: ','sarcastic.png','Sarcasm'),
		array(' :disdain: ','disdain.png','Disdain'),
		array(' :smug: ','arrogant.png','Smug'),
		array(' :-$ ','moneymouth.png','Money Mouth'),
		array(' :footmouth: ','foot-in-mouth.png','Foot in Mouth'),
		array(' :shutmouth: ','shut-mouth.png','Shut Mouth'),
		array(' :quiet: ','quiet.png','Quiet'),
		array(' :shame: ','shame.png','Shame'),
		array(' :beatup: ','beat-up.png','Beat Up'),
		array(' :mean: ','mean.png','Mean'),
		array(' :evilgrin: ','evil-grin.png','Evil Grin'),
		array(' :teeth: ','teeth.png','Grit Teeth'),
		array(' :shout: ','shout.png','Shout'),
		array(' :pissedoff: ','pissed-off.png','Pissed Off'),
		array(' :reallypissed: ','really-pissed.png','Really Pissed'),
		array(' :razzmad: ','razz-mad.png','Mad Razz'),
		array(' :X-P: ','razz-drunk.png','Drunken Razz'),
		array(' :sick: ','sick.png','Sick'),
		array(' :yawn: ','yawn.png','Yawn'),
		array(' :ZZZ: ','sleepy.png','Sleepy')
	);
	$tseCTI_gestures = array(
		array(' :dance: ','dance.png','Dance'),
		array(' :clap: ','clap.png','Clap'),
		array(' :jump: ','jump.png','Jump'),
		array(' :handshake: ','handshake.png','Handshake'),
		array(' :highfive: ','highfive.png','High Five'),
		array(' :hugleft: ','hug-left.png','Hug Left'),
		array(' :hugright: ','hug-right.png','Hug Right'),
		array(' :kissblow: ','kiss-blow.png','Kiss Blow'),
		array(' :kissing: ','kissing.png','Kissing'),
		array(' :bye: ','bye.png','Bye'),
		array(' :goaway: ','go-away.png','Go Away'),
		array(' :callme: ','call-me.png','Call Me'),
		array(' :onthephone: ','on-the-phone.png','On the Phone'),
		array(' :secret: ','secret.png','Secret'),
		array(' :meeting: ','meeting.png','Meeting'),
		array(' :waving: ','waving.png','Waving'),
		array(' :stop: ','stop.png','Stop'),
		array(' :timeout: ','time-out.png','Time Out'),
		array(' :talktothehand: ','talktohand.png','Talk to the Hand'),
		array(' :loser: ','loser.png','Loser'),
		array(' :lying: ','lying.png','Lying'),
		array(' :doh: ','doh.png','DOH!'),
		array(' :fingersxd: ','fingers-xd.png','Fingers Crossed'),
		array(' :waiting: ','waiting.png','Waiting'),
		array(' :suspense: ','nailbiting.png','Suspense'),
		array(' :tremble: ','tremble.png','Tremble'),
		array(' :pray: ','pray.png','Pray'),
		array(' :worship: ','worship.png','Worship'),
		array(' :starving: ','starving.png','Starving'),
		array(' :eat: ','eat.png','Eat'),
		array(' :victory: ','victory.png','Victory'),
		array(' :curse: ','curse.png','Curse')
		);
	$tseCTI_smileys = array();
	if ( $tse_showcase == 'none' ) {
		if ( function_exists( 'get_option' ) ) $tse = get_option( 'tango_smileys_extended' ); // Needed because tsepop.php is called outside of WordPress
		if ( $tse['standard']   == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_standard );
		if ( $tse['extended']   == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_extended );
		if ( $tse['gestures']   == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_gestures );
		if ( $tse['special']    == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_special );
		if ( $tse['animals']    == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_animals );
		if ( $tse['foodndrink'] == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_foodndrink );
		if ( $tse['other']      == 'on' ) $tseCTI_smileys = array_merge( $tseCTI_smileys, $tseCTI_other );
		return $tseCTI_smileys;
	}
	else {
		switch ( $tse_showcase ) {
			case 'standard':
				return $tseCTI_standard;
				break;
			case 'extended':
				return $tseCTI_extended;
				break;
			case 'gestures':
				return $tseCTI_gestures;
				break;
			case 'special':
				return $tseCTI_special;
				break;
			case 'animals':
				return $tseCTI_animals;
				break;
			case 'foodndrink':
				return $tseCTI_foodndrink;
				break;
			case 'other':
				return $tseCTI_other;
				break;
			case 'all':
				$tseCTI_smileys = array_merge( $tseCTI_standard, $tseCTI_extended, $tseCTI_gestures, $tseCTI_special, $tseCTI_animals, $tseCTI_foodndrink, $tseCTI_other );
				return $tseCTI_smileys;
				break;
		}
	}
}

// Add Click-to-Insert Smileys to Comment Form
function tse_add_cti_smileys() {
	$tse_settings = get_option( 'tango_smileys_extended' );
	echo "<h3 style='text-align: center;'>{$tse_settings['cti_header']}</h3>";
	tse_cti_anywhere();
}

// Add Click-to-Insert Smileys to MCEComments
function tse_add_mce_smileys() {
	$tse_settings = get_option( 'tango_smileys_extended' );
	$tse_smileypx = ( $tse_settings['smileysize'] == '24' ) ? '24' : '';
	echo "<h3 style='text-align: center;'>{$tse_settings['cti_header']}</h3>\n";
	echo "<script type='text/javascript'>\n/* <![CDATA[ */\n";
	echo 'function insertTSESmiley(smiley) { tinyMCE.execCommand("mceInsertContent",false, smiley); }';
	echo "\n/* ]]> */\n</script>\n";
	$tseCTI_smileys = tseCTI_get_smileys();
	$smileysout = '';
	for ( $i = 0; $i < sizeof( $tseCTI_smileys ); $i++ ) {
		$currentsmiley = plugins_url( "/tango{$tse_smileypx}/{$tseCTI_smileys[$i][1]}", __FILE__ );
		$tseCTI_img_full = "<img src='$currentsmiley' alt='{$tseCTI_smileys[$i][2]}' title='{$tseCTI_smileys[$i][2]} ( {$tseCTI_smileys[$i][0]} )' onclick='javascript:insertTSESmiley(\"{$tseCTI_smileys[$i][0]}\");' />";
		$smileysout .= $tseCTI_img_full;
	}
	$ctiout = "<div id='tseCTIsmileys-comment'>$smileysout</div>";
	echo $ctiout;
}

// Add CTI to any textarea - Even if target does not support converting shorthand to smileys (for custom support requests)
function tse_cti_anywhere( $target = 'comment', $output = true, $tse_showcase = 'none' ) {
	$jsout = <<<JAVASCRIPT
	<script language="javascript" type="text/javascript">
	//<![CDATA[
	function tseCTI$target(tseClicked) {
		var target;
		if (document.getElementById('$target') && document.getElementById('$target').type == 'textarea') {
			target = document.getElementById('$target');
		}
		else {
			return false;
		}
		if (document.selection) {
			target.focus();
			sel = document.selection.createRange();
			sel.text = tseClicked;
			target.focus();
		}
		else if (target.selectionStart || target.selectionStart == '0') {
			var startPos = target.selectionStart;
			var endPos = target.selectionEnd;
			var cursorPos = endPos;
			target.value = target.value.substring(0, startPos) + tseClicked + target.value.substring(endPos, target.value.length);
			cursorPos += tseClicked.length;
			target.focus();
			target.selectionStart = cursorPos;
			target.selectionEnd = cursorPos;
		}
		else {
			target.value += tseClicked;
			target.focus();
		}
	}
	//]]>
	</script>
JAVASCRIPT;
	$tseCTI_smileys = tseCTI_get_smileys( $tse_showcase );
	$tse_settings = get_option( 'tango_smileys_extended' );
	$tse_smileypx = ( $tse_settings['smileysize'] == '24' ) ? '24' : '';
	$smileysout = '';
	for ( $i = 0; $i < sizeof( $tseCTI_smileys ); $i++ ) {
		$currentsmiley = plugins_url( "/tango{$tse_smileypx}/{$tseCTI_smileys[$i][1]}", __FILE__ );
		$tseCTI_img_full = "<img src='$currentsmiley' alt='{$tseCTI_smileys[$i][2]}' title='{$tseCTI_smileys[$i][2]} ( {$tseCTI_smileys[$i][0]} )' onclick='javascript:tseCTI$target(\"{$tseCTI_smileys[$i][0]}\");' />";
		$smileysout .= $tseCTI_img_full;
	}
	$ctiout = "$jsout<div id='tseCTIsmileys-$target'>$smileysout</div>";
	
	if( $output ) {
		echo $ctiout;
	}
	else return $ctiout;
}

// Add CTI style as valid XHTML
function CTIStyle() {
	global $tse_version;
	$tse_settings = get_option( 'tango_smileys_extended' );
echo <<<CSS
	<!-- TSE Version $tse_version //-->
	<style type="text/css">
	#tseCTIsmileys-comment {
		background: {$tse_settings['cti_bg']};
		border: {$tse_settings['cti_borders']}px {$tse_settings['cti_bordert']} {$tse_settings['cti_borderc']};
		height: {$tse_settings['cti_height']}px;
		padding: 0px;
		margin: 0px auto 5px auto;
		overflow: auto;
		text-align: center;
		width: {$tse_settings['cti_width']}px;
	}
	#tseCTIsmileys-comment img {
		border: 0px;
		margin: 0px;
		padding: 0px 2px 1px 1px;
	}
	</style>
CSS;
}

?>