  <?php

function sendmail($naam,$email,$onderwerp,$bericht,$bcc=""){
   
    //$headers = "From: ".$naam_verzender." <".$email_verzender.">\r\n";
    $headers .= "From: Chiroschelle.be <jo@bridts.be>\r\n";
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