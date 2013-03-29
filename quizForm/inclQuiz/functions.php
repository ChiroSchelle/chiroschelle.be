<?php
    function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

function validPloegnaam($ploegnaam){
	return ereg("[a-zA-Z0-9][a-zA-Z0-9\ ]+", $ploegnaam);
}

function validNaam($naam){
	return ereg("[a-zA-Z][a-zA-Z\ ]+", $naam);
}

function NotUsedMail($mail){
	$qry = "SELECT * FROM `quizWacht` WHERE (`quizWacht`.`email` =  '" . $mail . "')";
	$result = mysql_query($qry);
	$numRows = mysql_num_rows($result);
	if($numRows > 0){
		return false;
	}
	$qry = "SELECT * FROM quiz WHERE (`quiz`.`Email` = '" . $mail . "')";
	$result = mysql_query($qry);
	$numRows = mysql_num_rows($result);
	if($numRows > 0){
		return false;
	}
	return true;
}

function mailWacht($code, $ploeg){
	$to = $ploeg->getEmail();
	$url = "http://chiroschelle.be/quiz/bevestiging/?code=" . $code;
	$subject = "Bevestig je inschrijving voor de Chiro-Schelle-Quiz";
	$message = "Beste<br><br>Voor de inschrijving voor de quiz. Let op uw inschrijving is pas geldig na het bevestigen van uw inschrijving via deze link: <a href='" . $url . "'>" . $url ."</a> . 
	<br>
	De 15 euro inschrijvingsgeld dient door de ploegverantwoordelijke worden cash betaald op de avond zelf.
	<br>
	<table>
	<tr>
	<td>Ploegnaam:</td>
	<td>" . $ploeg->getPloegnaam() . "</td>
	</tr><tr>
	<td>Contactpersoon:</td>
	<td>" . $ploeg->getNaam() . " " . $ploeg->getVoornaam() . "</td>
	</tr><tr>
	<td>Telefoonnummer:</td>
	<td>" . $ploeg->getTelefoon() . "</td>
	</tr>
	<tr>
	<td>Adres:</td>
	<td>" . $ploeg->getStraat() . " " . $ploeg->getNummer() . "</td>
	</tr>
	<tr>
	<td></td>
	<td>" . $ploeg->getGemeente() . "</td>
	</tr>
	</table>
	<br><br>
	Alvast bedankt
	<br>
	Chiro Schelle";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Chiro Schelle <no-reply@chiroschelle.be>' . "\r\n";
	$headers .= "Reply-To: no-reply@chiroschelle.be\r\n"; 
	$headers .= "X-Mailer: ChiroSchelle-mailer\n"; 
	mail($to, $subject, $message, $headers);
}

function mres($str){
	return mysql_real_escape_string($str);
}

function validNumber($number){
	return ereg("[0-9]+", $number);
}
?>