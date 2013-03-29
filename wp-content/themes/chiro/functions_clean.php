<?php
include_once( dirname( __FILE__ ) . '/functions/actions.php' );
function chiroschelle_get_image($post)
{
	$content = $post->post_content;
	$searchimages = '~<img [^>]* />~';
	$zoeksrc = '&src="[^"]*"&';
	$zoektitle = '&title="[^"]*"&';
	$zoekalt = '&alt="[^"]*"&';

	/*Run preg_match_all to grab all the images and save the results in $pics*/

	preg_match_all( $searchimages, $content, $pics );

	// Check to see if we have at least 1 image
	$iNumberOfPics = count($pics[0]);


	if ( $iNumberOfPics > 0 ) {

			preg_match_all($zoeksrc, $pics[0][0], $source);
			preg_match_all($zoektitle, $pics[0][0], $titles);
			preg_match_all($zoekalt, $pics[0][0], $alts);

			$src = str_replace('src="',"", $source[0][0]);
			$src = str_replace('"','',$src);
			$title = str_replace('title="',"", $titles[0][0]);
			$title = str_replace('"','',$title);
			$alt = str_replace('alt="',"", $alts[0][0]);
			$alt = str_replace('"','',$alt);



		 return '<img width="150px" height="auto" src="'. $src . '" class="attachment-150x150 wp-post-image" alt="' . $alt . '" title="'. $title . '" />';
	}else {
		return false;
	}

}

/**
standaardfiguurtje laten zien als er geen thumbnail is
**/
$aantal = 14;
$i=rand(8,$aantal);
$gebruikt = array();

function chiroschelle_show_default_thumb($archive=0){
	global $i;
	global $gebruikt;
	global $aantal;

	array_push($gebruikt,$i);
	$j = 0;	
	while (in_array($i, $gebruikt)) {
   		$i = rand(8,$aantal);
		$j = $j +1;

		if ($j == 10){
			break;
			}
		$i = rand(8,$aantal);
	}

		$imgpath = get_bloginfo('template_url') . "/images/thumbs/thumb_" .	$i .".jpg";

	echo "<img class=\"thumb\" src='$imgpath' />";
}

function chiroschelle_post_meta() {
	printf( 'Geschreven door <a class="url" href="%1$s" title="%2$s" rel="author">%3$s</a> op %4$s',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), //link naar author page
		sprintf( esc_attr( 'Meer berichten van %s' ), get_the_author() ),
		esc_html( get_the_author() ), //author name
		esc_html( get_the_date() ) // date in default format (blog settings)
	);
}
