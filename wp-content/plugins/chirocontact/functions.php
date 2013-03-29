<?php
function chirocontact_update_options($chirocontact_options){
	$ok = false;
	update_option('chirocontact_options',$chirocontact_options);
	$ok = true;

	if ($ok){
		?><div id="message" class="update fade"><p>Opties opgeslagen</p></div> <?php
	}else {
		?><div id="message" class="error fade"><p>Opties niet opgeslagen</p></div> <?php
	}

}

function chirocontact_verwerk_form(){
	if (isset($_POST['submit'])){
		$chirocontact_options = get_option('chirocontact_options');
		$data ['voornaam'] = trim($_POST['voornaam']);
		$data ['naam'] = trim($_POST['naam']);
		$data ['email'] = trim($_POST['email']);
		$data ['telefoon'] = trim($_POST['telefoon']);
		$data ['contact'] = trim($_POST['contact']);
		$data ['leiding'] = trim($_POST['leiding']);
		$data ['garage'] = trim($_POST['garage']);
		$data ['lokalen'] = trim($_POST['lokalen']);
		$data ['tenten'] = trim($_POST['tenten']);
		$data ['andere'] = trim($_POST['andere']);
		$data ['bericht'] = trim($_POST['bericht']);
		$data ['onderwerp'] = trim($_POST['onderwerp']);
		$data ['cc'] = trim($_POST['cc']);

		//error controle
		$errortekst = "<div class='error'>";
		if ($data['voornaam']==""){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\"> voornaam</span> ingevuld.<br />";
		}
		if ($data['naam']==""){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">achternaam</span> ingevuld. <br />";
		}
		if ($data['email']=="" || !is_email($data['email'])){
			$error = true;
			$errortekst .= "Je hebt geen juist <span class=\"gegeven\">e-mailadres</span> ingevuld. <br />";
		}
		if ($data['bericht']==""){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">bericht</span> ingevuld. <br />";
		}
		if ($data['contact']==""){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">bestemming</span> gekozen. <br />";
		}
		if ($data['onderwerp']==""){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">onderwerp</span> ingevuld. <br />";
		}
		if ($data['contact'] == "verhuur" && ($data['garage']!=1 && $data['tenten']!=1 && $data['lokalen']!=1 && $data['andere']!=1)) {
			$error = true;
			$errortekst = "specifieer je <span class=\"gegeven\">bestemming</span> <br />";
		}
		if ($data['contact'] == "leiding" && $data['leiding'] == 0){
			$error = true;
			$errortekst = "specifieer je <span class=\"gegeven\">bestemming</span> <br />";
		}
		$errortekst .= "</div>";





		if (!$error){


			//zoek naar waar de email moet worden gestuurd.
			switch ($data['contact']){
				case 'info':
					$to = $chirocontact_options['email_info'];
					break;
				case 'site':
					$to = $chirocontact_options['email_site'];
					break;
				case 'verhuur':
					//voeg adressen toe na initiialiseren phpmailer
				break;
				case 'leiding':
					$naar[0] = zoekemailvan($data['leiding']);
					break;
				case 'muziekkapel':
					$to = $chirocontact_options['email_muziekkapel'];
					break;
				default:
					$uid = $data['contact'];
					$user = get_userdata($uid);
					$leidingnaam = $user ->first_name . " " . $user->last_name;
					$leidingmail = $user->user_email;
					$naar[0] = $leidingmail;


			}
			if ($naar[0]==""){
				$naar = chirocontact_splits($to);
			}

			// stel het bericht op
			$bericht = "Dit bericht werd verzonden via de chirosite door ". $data['voornaam'] . " " . $data['naam'] . " (".$data['email'];
			if ($data['telefoon']!=""){
				$bericht .= ' - ' . $data['telefoon'];
			}
			$bericht .= ").
-------------------------------
Verzonden naar: ";
			switch ($data['contact']){
				case 'info':
					$bericht .= 'Algemene Info';
					break;
				case 'site':
					$bericht .= 'Webmasters';
					break;
				case 'leiding':
					$bericht .= maaknummerafdeling($data['leiding']);
					break;
				case 'verhuur':
					$i = 0;
					if ($data['lokalen']!=""){
						$bericht .= 'Verhuur lokalen';
						$i++;
					}
					if ($data['garage']!=""){
						if ($i > 0){
							$bericht .= ", ";
						}
						$bericht .= "Verhuur kookmateriaal";
						$i++;
					}
					if ($data['tenten']!=""){
						if ($i > 0){
							$bericht .= ", ";
						}
						$bericht .= "Verhuur tenten";
						$i++;
					}
					if ($data['andere']!=""){
						if ($i > 0){
							$bericht .= " en ";
						}
						$bericht .= "Verhuur 'andere'";
					}
					break;
				case 'muzekkapel':
					$bericht .= 'Muziekkapel';
					break;
				default:
					$bericht .= $leidingnaam;
			}

			$bericht .= "
-------------------------------

". $data['bericht'];

			global $phpmailer;
			if ( !is_object( $phpmailer ) || ( strtolower(get_class( $phpmailer )) != 'phpmailer' ) ) {
			if ( file_exists( ABSPATH . WPINC . '/class-phpmailer.php' ) )
				require_once ABSPATH . WPINC . '/class-phpmailer.php';
			if ( file_exists( ABSPATH . WPINC . '/class-smtp.php' ) )
				require_once ABSPATH . WPINC . '/class-smtp.php';
			if ( class_exists( 'PHPMailer') )
				$phpmailer = new PHPMailer();
		}
			// verwijder eventuele waarden
			$phpmailer->ClearAddresses();
			$phpmailer->ClearAllRecipients();
			$phpmailer->ClearAttachments();
			$phpmailer->ClearBCCs();
			$phpmailer->ClearCCs();
			$phpmailer->ClearCustomHeaders();
			$phpmailer->ClearReplyTos();

			//stuur mail
			if ($data['contact']!='verhuur'){
				foreach ($naar as $adres){
					$phpmailer->AddAddress( $adres );
				}
			}else{
				if ($data['garage'] != ""){
					$naar = chirocontact_splits($chirocontact_options['email_verhuur_garage']);
					foreach ($naar as $adres){
						$phpmailer->AddAddress($adres);
					}
				}
				if ($data['lokalen']!=""){
					$naar = chirocontact_splits($chirocontact_options['email_verhuur_lokalen']);
					foreach ($naar as $adres){
						$phpmailer->AddAddress( $adres );
					}
				}
				if ($data['tenten'] != ""){
					$naar = chirocontact_splits($chirocontact_options['email_verhuur_tenten']);
					foreach ($naar as $adres){
						$phpmailer->AddAddress( $adres);
					}
				}
				if ($data['andere']){
					$naar = chirocontact_splits($chirocontact_options['email_verhuur_andere']);
					foreach ($naar as $adres){
						$phpmailer->AddAddress($adres);
					}
				}
			}


			$phpmailer->Body = $bericht;
			$phpmailer->CharSet = apply_filters( 'wp_mail_charset', get_bloginfo('charset') );
			//$phpmailer->From = apply_filters( 'wp_mail_from', $from_email );
			$phpmailer->From = $data['email'];
			//$phpmailer->FromName = apply_filters( 'wp_mail_from_name', $from_name );
			$phpmailer->FromName = $data['voornaam'] . " " . $data['naam'];
			$phpmailer->IsMail();
			//$phpmailer->Subject = $subject;
			$phpmailer->Subject = "[ChiroSchelle.be] ".$data['onderwerp'];

			do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );

			$result = @$phpmailer->Send();
			if ($data['cc']==true){
				$phpmailer->ClearAddresses();
				$phpmailer->AddAddress($data['email']);

				do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
				$result = @$phpmailer->Send();

			}
			echo "<div class='succes'>Uw bericht is succesvol verzonden</div>";
		}else{
			echo $errortekst;
		}

	}
}

function chirocontact_toon_form(){
	chirocontact_toon_form_html();
}

function chirocontact_splits($str){
	$array = explode("\n", $str);
	return $array;

}

function zoekemailvan($id){
	$afdeling = maaknummerafdeling($id);
	$email = strtolower($afdeling . "@chiroschelle.be");
	$email = str_replace(" ", "", $email);
	return $email;
}

?>