<?php

	require_once 'functions.php';
	/**
	 * 
	 */
	class Item {
		
		private $title;
		private $tekst;
		private $afbeelding;
		
		function __construct($title, $tekst, $afbeelding) {
			$this->title = $title;
			$this->tekst = $tekst;
			$this->afbeelding = $afbeelding;
		}
		
		function f__construct()
		{
			
		}
		
		function getTekst(){
			return str_replace("\\", "", $this->tekst);
		}
		
		function getTitle(){
			return $this->title;
		}
		
		function getAfbeelding(){
			if(isset($this->afbeelding) && fileExists($this->afbeelding)){
				return $this->afbeelding;
			}
			if(isset($this->afbeelding) && file_exists($this->afbeelding)){
				//TODO nog afwerken
			}
			return "http://chiroschelle.be/wp-content/themes/chiro/images/avatar.png?s=96";
		}
		
		function setTekst($tekst){
			$this->tekst = $tekst;
		}
		
		function setTitle($title){
			$this->title = $title;
		}
		
		function setAfbeelding($afbeelding){
			unlink("images/" . $this->afbeelding);
			$this->afbeelding = $afbeelding;
		}
		private function getsize(){
			$size = getimagesize($this->getAfbeelding());
			$width = 106;
			$deler = $size[0]/$width;
			$height = intval($size[1]/$deler);
			$return[0] = $width;
			$return[1] = $height;
			return $return;
		}
		
		function getHTML(){
			$html = '<table cellpadding="0" cellspacing="0" align="center" width="480">
                  <tr>
                    <td width="120" valign="top"><img src="';
			$url =  $this->getAfbeelding();
			$size = $this->getsize();
            $html .= $url . '" style="border: 2px solid #302D26; margin-right:10px; margin-top:10px; width:' . $size[0] . 'px; height:' . $size[1] . 'px;"></td>';
			$html .= '<td width="358" valign="top"><h2>' . $this->title . '</h2>
                      <p style="font-family:Helvetica, Arial, sans-serif; font-size:14px; padding-bottom:10px;">';
			$html .= str_replace("<ul>", "<ul style='font-family:Helvetica, Arial, sans-serif; font-size:14px;'>", str_replace("\n", "<br>", addLinks($this->getTekst())));
			$html .= '</p></td></tr></table>';
			return str_replace("\\", "", $html);
		}
	}
	
	/**
	 * 
	 */
	class Nieuwsbrief {
		
		private $items = array();
		
		function addItem($item){
			$this->items[] = $item;
		}
		
		function swap($i, $j){
			$temp = $this->items[$j];
			$this->items[$j] = $this->items[$i];
			$this->items[$i] = $temp;
		}
		
		function removeItem($i){
			unset($this->items[$i]);
		}
		
		function updateItem($i, $item){
			$this->removeItem($i);
			$this->items[$i] = $item;
		}
		
	function getHTML(){
			$html = '<html>
 	   <head>
 	   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 	   <title>Nieuwsbrief Chiro Schelle</title>
 	   </head>
 	   <body style="font-family:Helvetica, Arial, sans-serif; font-size:10px; margin:0; padding:0">
 	   <table width="600px" cellpadding="0" cellspacing="0" align="center" bgcolor="#DED6B2">
 	   	<tr><td bgcolor="#302D26" align="center" style="font-size:10px; color:#ffffff;">Bekijk de <a href="http://www.chiroschelle.be/nieuws" style="color: #DED6B2;"> online versie</a> van deze nieuwsbrief</td></tr>
 	     <tr>
 	       <td valign="top" height="150" width="600"><img src="http://www.chiroschelle.be/images/email/header.jpg" alt="" width="600" height="150" /></td>
 	     </tr>
 	     <tr>
 	       <td valign="top" width="600"><table cellpadding="0" cellspacing="0">
 	           <tr>
 	             <td valign="top" width="60"></td>
 	             <td valign="top" width="480">';
				 
			$first = true;
			foreach ($this->items as $item) {
				if(!$first){
					$html .= '<p><img class="hr" src="http://www.chiroschelle.be/images/email/lijn.gif" alt="Header" width="480" height="3" /> </p>';
				}
				$html .= $item->getHTML();
				$first = false;
			}
			
	$html .= '<td valign="top" width="60"></td>
           </tr>
         </table></td>
     </tr>
     <tr>
       <td valign="top" height="16" width="600" bgcolor="#302D26"><img src="http://www.chiroschelle.be/images/email/footer.jpg" alt="Header" width="600" height="16" /></td>
     </tr>
   </table>
   <table cellpadding="0" cellspacing="0" bgcolor="#302D26" height="97" width="600" align="center" style="color:#ffffff;">
     <tr valign="top">
       <td valign="top" height="54" width="60"><img src="http://www.chiroschelle.be/images/email/krabbel.jpg" alt="Header" width="63" height="52" /></td>
       <td width="272"><p style="font-size:11px; text-align:left;"><span style="font-size:12px"><br/>
           Chiro Schelle</span><br>
           <span style="color:#DED6B2;">Ceulemansstraat 88,
           2627 Schelle</span><br/>
           <a href="http://www.chiroschelle.be" style="color:#DED6B2;">www.chiroschelle.be</a> </p></td>
       <td width="200"><br/>
         <a href="http://www.facebook.com/pages/Chiro-Schelle/375803333235" title="Chiro Schelle op Facebook" target="_blank"><img border="none" src="http://chiroschelle.be/wp-content/themes/chiro/images/chiro_fb.jpg" alt="Chiro_fb" width="43" height="43"></a>
         &nbsp;<a href="http://www.twitter.com/chiroschelle" title="Chiro Schelle op Twitter" target="_blank"><img border="none" src="http://chiroschelle.be/wp-content/themes/chiro/images/chiro_twitter.jpg" alt="Chiro_twitter" width="43" height="43"></a>&nbsp;
         <a class="topfooter" target="_blank" href="http://www.youtube.com/chiroschelle"><img border="none" id="logofooter" src="http://chiroschelle.be/wp-content/themes/chiro/images/chiro_youtube.png" alt="chirologo" /></a>&nbsp;<a href="http://chiroschelle.be/feed/" title="Chiro Schelle RSS-feed" target="_blank"><img border="none" src="http://chiroschelle.be/wp-content/themes/chiro/images/chiro_rss2.jpg" alt="Chiro_rss" width="43" height="43"></a></td>
     </tr>
     <tr>
       <td height="29">
       <td><p style="font-size:10px; text-align:left">Mail niet welkom? <a href="http://www.chiroschelle.be/contact/?contact=site" style="color:#DED6B2;">Laat het ons weten...</a></p></td>
       <td width="52"></td>
     </tr>
    </table>
    </body>
    </html>';
	
	return $html;
			
		}

		function getSubject(){
			$subject = "Nieuwsbrief: ";
			$first = true;
			foreach ($this->items as $item) {
				if(!$first){
					$subject .= " - ";
				}
				$subject .= $item->getTitle();
				$first = false;
			}
			return $subject;
		}

		function send($to){
			
			//SET SUBJECT
			$subject = $this->getSubject();
			
			//SET MESSAGE
			$message = $this->getHTML();
			
			//SET HEADERS;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
			$headers .= 'From: Nieuwsbrief ChiroSchelle <no-reply@chiroschelle.be>' . "\r\n";
			$headers .= 'Reply-To: no-reply@chiroschelle.be' . "\r\n";
			$headers .= "Return-Path: no-reply@chiroschelle.be\r\n";
			$headers .= "X-Mailer: Chiro Schelle\n"; 
			ini_set ( "SMTP", "mail.chiroschelle.be" ); 
			
			//MAIL
			return mail($to, $subject, $message, $headers) or die("Fout bij versturen van e-mail");
			
			
		}
	function send2($to){
		require_once("class.phpmailer.php");
		$mail = new PHPMailer();

		$mail->IsSMTP(); // set mailer to use SMTP
	
		$mail->Host = "mail.chiroschelle.be"; // specify main and backup server
	
		$mail->SMTPAuth = true; // turn on SMTP authentication
	
		$mail->Username = "c7070chi"; // SMTP username
	
		$mail->Password = "chrsell882"; // SMTP password
	
		$mail->From = "no-reply@chiroschelle.be"; //do NOT fake header.
	
		$mail->FromName = "Nieuwsbrief Chiro Schelle";
	
		$mail->AddAddress($to); // Email on which you want to send mail
	
		$mail->AddReplyTo("no-reply@chiroschelle.be"); //optional
	
		$mail->IsHTML(true);
			
		$mail->Subject = $this->getSubject();
	
		$mail->Body = $this->getHTML();
	
		if(!$mail->Send())
	
		{
	
		echo $mail->ErrorInfo;
		echo "</br>";
		return FALSE;
	
		}else{
	
		//echo "email was sent";
		return true;
	
		}					
	}
	
	function getHTMLInterface(){
		$html = "";
		$i = 0;
		foreach ($this->items as $item) {
			if($item->getTitle() == "Op de agenda"){
				continue;
			}
			$html .= "<div>\n<h4>Bericht " . $i . "</h4>\n";
			$html .= "<table>\n<tr>\n<td>Titel:</td>\n<td>\n<input type='text' name='Titel_" . $i . "' size='50' value='" . $item->getTitle() . "'>\n</td>\n</tr>\n";
			$html .= "<tr>\n<td>Image-url:</td>\n<td>\n<input type='text' name='Image-url_" . $i . "' size='50' value='" . $item->getAfbeelding() . "'>\n</td>\n</tr>\n";
			$html .= "<tr>\n<td>Text:</td>\n<td>\n<textarea rows='6' cols='50' name='Text_" . $i . "'>" . $item->getTekst() . "</textarea>\n</td>\n</tr>\n</table>\n</div>";	
			
			$i++;		
		}
		return array($html, $i);
	}
	
	function getAgenda(){
		$i = sizeof($this->items)-1;
		$item = $this->items[$i];
		if($item->getTitle() == "Op de agenda"){
			return str_replace("</ul>", "", str_replace("</li>", "\n", str_replace("<li>", "", str_replace('<ul style="font-family:Helvetica, Arial, sans-serif; font-size:14px;">', "", $item->getTekst()))));
		}
	}
	
	function setAgenda($str){
		$i = 0;
		$html = '<ul style="font-family:Helvetica, Arial, sans-serif; font-size:14px;">';
		while($pos = strpos($str, "\n", $i)){
			$substr = substr($str, $i, $pos-$i);
			$html .= "<li>" . $substr . "</li>";
			$i = $pos+1;
		}
		$substr = substr($str, $i);
		if($substr != ""){
			$html .= "<li>" . $substr . "</li>";
		}
		$html .= "</ul>";
		if($html != '<ul style="font-family:Helvetica, Arial, sans-serif; font-size:14px;"></ul>'){
			$item = new Item("Op de agenda", $html, "http://chiroschelle.be/nieuws/agenda.jpg");
			$this->addItem($item);
		}
	}
	function writeToFile($filepath){
		if(!$file = fopen($filepath,"w")){
			return false;
		}
		fwrite($file, $this->getHTML());
		fclose($file);
		return true;
	}
	}

	
	
	
?>