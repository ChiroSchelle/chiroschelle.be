<?php
#verander formaat van een getal in 01-99, 100-...
function maaktweecijfer($n) {
	switch (strlen($n)){
	case 1:
		$n = '0'.$n;
		break;
	case 2:
		$n = $n;
		break;
	default:
		$n = '';
		break;
	}
	return $n;	
}

#verander het formaat van een getal van 01-09 naar 1-9
function maakeencijfer($n) {
	switch (strlen($n)){
	case 1:
		$n = $n;
		break;
	case 2:
		switch ($n) {
			case 1:
			$n = 1;
			break;
			case 2:
			$n = 2;
			break;
			case 3:
			$n = 3;
			break;
			case 4:
			$n = 4;
			break;
			case 5:
			$n = 5;
			break;
			case 6:
			$n = 6;
			break;
			case 7:
			$n=7;
			break;
			case 8:
			$n = 8;
			break;
			case 9:
			$n=9;
			break;
			default:
			$n=$n;
			break;
			}
		break;
	default:
		$n = '';
		break;
	}
	return $n;	
}

#maak van een nummer zijn bijhorende afdelinge
function maaknummerafdeling($afdeling) {
	switch ($afdeling) {
	case 0:
    	$afdeling = 'geen';	
	    break;
	case 1:
	   $afdeling = 'Ribbel Jongens';
	    break;
	case 2:
    	$afdeling = 'Ribbel Meisjes';
	    break;
	case 3:
		$afdeling = 'Speelclub Jongens';
    	break;
	case 4:
		$afdeling = 'Speelclub Meisjes';
    	break;
	case 5:
		$afdeling = 'Rakkers';
    	break;
	case 6:
		$afdeling = 'Kwiks';
    	break;
	case 7:
		$afdeling = 'Toppers';
    	break;
	case 8:
		$afdeling = 'Tippers';
    	break;
	case 9:
		$afdeling = 'Kerels';
    	break;
	case 10:
		$afdeling = 'Tiptiens';
    	break;
	case 11:
		$afdeling = 'Aspi Jongens';
    	break;
	case 12:
		$afdeling = 'Aspi Meisjes';
    	break;
	case 13:
		$afdeling = 'IEDEREEN';
		break;
	case 14:
		$afdeling = 'Leiding';
		break;
	case 15:
		$afdeling = 'Muziekkapel';
		break;
	case 16:
	    $afdeling = 'Tikeas';
	    break;
	case 17:
		$afdeling = "Activiteiten";
		}
		return $afdeling;
}

#Maak een random wachtwoord
function generatePassword ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIKLMNOPQRSTUVWXYZ"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  // done!
  return $password;

}

#Kijk of een emailadres bestaat
function checkEmail($email)
{
  // checks proper syntax
  if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
  {
    return false;
  }
  else{
  	return true;
  }

  /*// gets domain name
  list($username,$domain)=split('@',$email);
  // checks for if MX records in the DNS
  $mxhosts = array();
  if(!getmxrr($domain, $mxhosts))
  {
    // no mx records, ok to check domain
    if (!fsockopen($domain,25,$errno,$errstr,30))
    {
      return false;
    }
    else
    {
      return true;
    }
  }
  else
  {
    // mx records found
    foreach ($mxhosts as $host)
    {
      if (fsockopen($host,25,$errno,$errstr,30))
      {
        return true;
      }
    }
    return false;
  }*/
}

#Creëer de kalender:

# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
    $first_of_month = gmmktime(0,0,0,$month,1,$year);
    #remember that mktime will automatically correct if invalid dates are entered
    # for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
    # this provides a built in "rounding" feature to generate_calendar()

    $day_names = array(); #generate all the day names according to the current locale
    for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
        $day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

    list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
    $title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

    #Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
    @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
    if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
    if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
    $calendar = '<table class="calendar">'."\n".
        '<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

    if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
        #if day_name_length is >3, the full name of the day will be printed
        foreach($day_names as $d)
            $calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
        $calendar .= "</tr>\n<tr>";
    }

    if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
    for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
        if($weekday == 7){
            $weekday   = 0; #start a new week
            $calendar .= "</tr>\n<tr>";
        }
        if(isset($days[$day]) and is_array($days[$day])){
            @list($link, $classes, $content) = $days[$day];
            if(is_null($content))  $content  = $day;
            $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
                ($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
        }
        else $calendar .= "<td>$day</td>";
    }
    if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

    return $calendar."</tr>\n</table>\n";
}
# stuur een email
function sendmail($naam,$email,$onderwerp,$bericht,$bcc=""){
   
    //$headers = "From: ".$naam_verzender." <".$email_verzender.">\r\n";
    $headers .= "From: Chiroschelle.be <no-reply@chiroschelle.be>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "Return-Path: Mail-Error <jobridts+error@gmail.com>\r\n";
   // $headers .= "Reply-To: ".$naam_verzender." <".$email_verzender.">\r\n";
    if ($bcc != "") $headers .= "Bcc: ".$bcc."\r\n";
	//ini_set('SMTP','relay.edpnet.be'); #dit is enkel nodig op mijn laptopje


    $bericht = '


'.$bericht.'


Tot Zondag! 
Chiro Schelle
    ';

    $bericht = nl2br($bericht);
    mail($naam.'<'.$email.'>', $onderwerp, $bericht, $headers);
}
?>
