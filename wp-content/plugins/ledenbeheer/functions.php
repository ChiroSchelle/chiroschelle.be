<?php
function ledenbeheer_verwerk_mail(){
	if (isset($_POST['submit'])){
		$data ['voornaam'] = trim($_POST['voornaam']);
		$data ['afdeling'] = trim($_POST['afdeling']);
		$data ['naam'] = trim($_POST['naam']);
		$data ['email'] = trim($_POST['email']);
		$data ['onderwerp'] = trim($_POST['onderwerp']);
		$data ['cc'] = trim($_POST['cc']);
		$data ['bericht'] = trim($_POST['bericht']);

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
		if ($data['afdeling']=="0"){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">bestemming</span> gekozen. <br />";
		}
		if ($data['onderwerp']==""){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">onderwerp</span> ingevuld. <br />";
		}

		$errortekst .= "</div>";





		if (!$error){



			//zoek naar waar de email moet worden gestuurd.


			// stel het bericht op
			$bericht = $data['bericht'] . "




--
verstuurd via www.chiroschelle.be";


			//stuur mail
			# haal emailadressen op #
			 $ids = get_user_id('afdeling', $data['afdeling']);
			 $k =0;

			 foreach ($ids as $id){
			 	$bcc[$k] =get_the_author_meta('user_email', $id);
			 	$k++;

			 }
			 global $wpdb;
			$table_name = $wpdb->prefix . 'leden';
			$order = 'naam';
			$query = "SELECT  * FROM $table_name WHERE afdeling = ". $data['afdeling'] . " AND toon != 0 order by $order";
			$result = $wpdb->get_results($query) ;
			foreach ($result as $row){
				$bcc[$k] = $row->email;

				$k++;
			}

			$to =$data['email'];



			$from = $data['email'];
			$fromname = $data['voornaam'] . " " . $data['naam'];


			$subject = "[Chiro] ".$data['onderwerp'];

			$headers = "From: '$fromname' <$from> \r\n";
			$headers .= "Reply-To: $from \r\n";
			foreach ($bcc as $b){
				$headers .= "BCC: $b \r\n";
			}

			wp_mail($to, $subject, $bericht, $headers);

			echo "<div id='message' class='updated fade'>Uw bericht is succesvol verzonden</div>";
		}else{
			echo $errortekst;
		}

	}
}

function ledenbeheer_verwerk_lid($type='nieuw', $db='chiro'){
	$chiroleden_options = get_option('chiroleden_options');
	if (isset($_POST['submit'])){

		$data ['voornaam'] = trim($_POST['voornaam']);
		$data ['afdeling'] = trim($_POST['afdeling']);
		$data ['naam'] = trim($_POST['naam']);
		$data ['email'] = trim($_POST['email']);
		if ($_POST['adres'] !=""){
			$data ['adres'] = trim($_POST['adres']);
		}else{
			$data ['adres'] = trim($_POST['straat']);
		}
		$data['straat'] = trim($_POST['straat']);
		$data['nr'] = trim($_POST['nr']);
		$data ['postcode'] = trim($_POST['postcode']);
		$data ['gemeente'] = trim($_POST['gemeente']);
		$data ['telefoon'] = trim($_POST['telefoon']);
		$data ['geboorte'] = trim($_POST['geboorte']);
		$data ['geslacht'] = trim($_POST['geslacht']);
		$data ['lidgeld'] = trim($_POST['lidgeld']);
		$data['invoerder'] = trim($_POST['invoerder']);
		$data ['id'] = trim($_POST['id']);

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

		if ($data['afdeling']=="0"){
			$error = true;
			$errortekst .= "Je hebt geen <span class=\"gegeven\">afdeling</span> gekozen. <br />";
		}


		$errortekst .= "</div>";





		if (!$error){

			global $wpdb;
			foreach ($data as $veld){
				if ($veld == ''){
					$veld = 'NULL';
				}
			}
			$table_name = $wpdb->prefix . 'leden';
			if ($type=='nieuw'){
				$query =  "INSERT INTO $table_name (`afdeling` ,`naam` ,`voornaam` ,`adres` ,`postcode` ,`gemeente` ,`telefoon` ,`geboorte` ,`geslacht` ,`email` ,`lidgeld`)
VALUES ('{$data['afdeling']}', '{$data['naam']}', '{$data['voornaam']}', '{$data['adres']}', '{$data['postcode']}', '{$data['gemeente']}', '{$data['telefoon']}', '{$data['geboorte']}', '{$data['geslacht']}', '{$data['email']}', '{$data['lidgeld']}')";
				$tekst = 'toegevoegd';
			}elseif ($type=='update'){
				$query = "UPDATE `$table_name` SET `afdeling` = '{$data['afdeling']}', `naam` = '{$data['naam']}', `voornaam` = '{$data['voornaam']}', `adres` = '{$data['adres']}', `postcode` = '{$data['postcode']}', `gemeente` = '{$data['gemeente']}', `telefoon` = '{$data['telefoon']}', `geboorte` = '{$data['geboorte']}',  `email` = '{$data['email']}', `lidgeld` = '{$data['lidgeld']}' WHERE `id` = {$data['id']} LIMIT 1 ";
				$tekst ='aangepast';
			}
			if ($db == 'chiro'){
	 			$wpdb->query($query);
			}elseif ($db == 'wp'){
				update_usermeta($data['id'],'afdeling',$data['afdeling']);
				update_usermeta($data['id'],'first_name',$data['voornaam']);
				update_usermeta($data['id'],'last_name',$data['naam']);
				update_usermeta($data['id'],'straat',$data['straat']);
				update_usermeta($data['id'],'nr',$data['nr']);
				update_usermeta($data['id'],'postcode',$data['gemeente']);
				update_usermeta($data['id'],'telefoon',$data['telefoon']);
				update_usermeta($data['id'],'gemeente',$data['gemeente']);
				update_usermeta($data['id'],'geboorte',$data['geboorte']);
				update_usermeta($data['id'],'user_email',$data['email']);
				update_usermeta($data['id'],'lidgeld',$data['lidgeld']);


			}
 			//stuur mail naar VB's
 			$bericht =
 "Volgend lid werd $tekst door ". $data['invoerder'] ."
 --------

 Afdeling: ". maaknummerafdeling($data['afdeling']) . "
 Voornaam: {$data['voornaam']}
 Naam: {$data['naam']}
 Adres: {$data['adres']}
 Gemeente: {$data['postcode']} {$data['gemeente']}
 Telefoon: {$data['telefoon']}
 Geboortedatum: {$data['geboorte']}
 Geslacht: {$data['geslacht']}
 E-mail: {$data['email']}
 Lidgeld betaald?: {$data['lidgeld']}


 --
 verzonden via www.chiroschelle.be"
 ;



			//stuur mail
			$naar = chiroleden_splits($chiroleden_options['email_updates']);
			$to = "";
			foreach ($naar as $email){
				$to .= "$email ,";
			}





			$from = 'no-reply@chiroschelle.be';
			$fromname = 'ChiroSchelle.be';


			$subject = "[ChiroSchelle.be] lid $tekst";

			$headers = "From: '$fromname' <$from> \r\n";
			$headers .= "Reply-To: $from \r\n";
			wp_mail($to, $subject, $bericht, $headers);

			echo "<div id='message' class='updated fade'>Succesvol $tekst!</div>";
		}else{
			echo $errortekst;
		}

	}
}

function chiroleden_update_options($chiroleden_options){
	$ok = false;
	update_option('chiroleden_options',$chiroleden_options);
	$ok = true;

	if ($ok){
		?><div id="message" class="updated fade"><p>Opties opgeslagen</p></div> <?php
	}else {
		?><div id="message" class="error fade"><p>Opties niet opgeslagen</p></div> <?php
	}

}
function chiroleden_splits($str){
	$array = explode("\n", $str);
	return $array;

}

function chiroleden_get_data($id){
	global $wpdb;
	$table_name = $wpdb->prefix . 'leden';
	$query = "SELECT * FROM `$table_name` WHERE `id`=$id ";
	$result = $wpdb->get_results($query) ;
	foreach ($result as $row){
		$user = new chiroLid();
		$user->ID = $row->id;
		$user->first_name = $row->voornaam;
		$user->last_name = $row->naam;
		$user->straat = $row -> adres;
		$user->nr = "";
		$user->postcode = $row->postcode;
		$user->gemeente = $row->gemeente;
		$user->user_email = $row->email;
		$user->telefoon = $row->telefoon;
		$user->geboorte = $row->geboorte;
		$user->afdeling = $row->afdeling;
		switch ($row->lidgeld){
			case 'Ja':
				$user->lidgeld = 1;
				break;
			case 'Nee':
				$user->lidgeld = 0;
				break;
		}
		$user->actief = $row->actief;
	}
	return $user;
}

function ledenbeheer_zoek_leden($meta,$value){
	$value = '%'.$value.'%';
	$ids = get_user_id($meta, $value);
	return $ids;
}

function ledenbeheer_convert_meta($meta){
	switch ($meta){
		case 'ID':
			return 'id';
			break;
		case 'first_name':
			return 'voornaam';
			break;
		case 'last_name':
			return 'naam';
			break;
		case 'straat':
			return 'adres';
			break;
		case 'user_email':
			return 'email';
			break;
		default:
			return $meta;
			break;
	}
}

function chiroleden_wijzig_eigenschappen(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'leden';
	if (isset($_POST['submit_lijst'])){

	switch ($_POST['actie']){
		case 'betaal_lidgeld':
			$meta = 'lidgeld';
			$value = 1;
			$value_2 = 'Ja';
			break;
		case 'verwijder_lidgeld':
			$meta = 'lidgeld';
			$value = 0;
			$value_2 = 'Nee';
			break;
		case 'inactief':
			$meta = 'actief';
			$value = 'inactief';
			$value_2 = 'inactief';
			break;
		case 'actief':
			$meta = 'actief';
			$value= 'actief';
			$value_2 = 'actief';
			break;
		case 'register':
			$meta = 'toon';
			$value_2 = '0';
			break;
		case 'verhoog_afdeling':
			$meta = false;
			$verander_afd = '+';
			break;
		case 'verlaag_afdeling' :
			$meta = false;
			$verander_afd = '-';
			break;
		default:
			$meta = false;
			break;
	}


	if ($meta != false && $_POST['user'][0]!=""){
		foreach ($_POST['user'] as $u){
			update_usermeta($u, $meta, $value);
		}
	}

	if ($meta != false && $_POST['user_niet_reg'][0]!=""){
		foreach ($_POST['user_niet_reg'] as $u){
			$query = "UPDATE `$table_name` SET `$meta` = '$value_2' WHERE `id`= '$u' LIMIT 1 ";
			$wpdb->query($query);
		}
	}
	if ($verander_afd == '+' && $_POST['user'][0]!=""){
		foreach ($_POST['user'] as $u){
		$afd = get_the_author_meta('afdeling', $u) + 2;
		if ($afd > 12){
			if ($afd % 2 == 0){
				$afd = 12;
			}else {
				$afd = 11;
			}
		}
		update_usermeta($u, 'afdeling', $afd);
		}
	}
	if ($verander_afd == '-' && $_POST['user'][0]!=""){
		foreach ($_POST['user'] as $u){
		$afd = get_the_author_meta('afdeling', $u) - 2;
		if ($afd < 1){
			if ($afd % 2 == 0){
				$afd = 2;
			}else {
				$afd = 1;
			}
		update_usermeta($u, 'afdeling', $afd);
		}
	}
	}
	if ($verander_afd == '+' && $_POST['user_niet_reg'][0]!=""){
		foreach ($_POST['user_niet_reg'] as $u){
		$afd = get_the_author_meta('afdeling', $u) + 2;
		if ($afd > 12){
			if ($afd % 2 == 0){
				$afd = 12;
			}else {
				$afd = 11;
			}
		update_usermeta($u, 'afdeling', $afd);
		}
	}
	}
	if ($verander_afd == '-' && $_POST['user_niet_reg'][0]!=""){
		foreach ($_POST['user_niet_reg'] as $u){
		$afd = get_the_author_meta('afdeling', $u) - 2;
		if ($afd < 1){
			if ($afd % 2 == 0){
				$afd = 2;
			}else {
				$afd = 1;
			}
		update_usermeta($u, 'afdeling', $afd);
		}
	}
	}
}
}

##STuur een mail als een user zijn profiel updated:##
//add_action('profile_update', ledenbeheer_profile_update());
add_action('personal_options_update', ledenbeheer_profile_update());
## voeg de 'oude data' toe als hidden fields ##
add_action('show_user_profile', ledenbeheer_hidden_fields);
add_action('edit_user_profile', ledenbeheer_hidden_fields);

function ledenbeheer_profile_update(){
	if (isset($_POST['submit'])&& $_POST['email']!=""){
	//wp_mail('jobridts@gmail.com', 'AFDELING: ' . $_POST['afdeling'] ) or die ('error!');
	global $phpmailer;
			$uid = $_POST['user_id'];
			//$user = get_userdata($id);
			if (ledenbeheer_check_wijzigingen($_POST,$user)== true){
				$geboorte = $_POST['geb_dag'] . '/' . $_POST['geb_maand'] . '/' . $_POST['geb_jaar'];
				 			$bericht =
 "Volgend lid werd gewijzigd door ". $_POST['invoerder'] ."
 --------

 Afdeling: ". ledenbeheer_maaknummerafdeling($_POST['afdeling']) . "
 Voornaam: {$_POST['first_name']}
 Naam: {$_POST['last_name']}
 Adres: {$_POST['straat']} {$_POST['nr']}
 Gemeente: {$_POST['postcode']} {$_POST['gemeente']}
 Telefoon: {$_POST['telefoon']}
 Geboortedatum: $geboorte
 E-mail: {$_POST['email']}


 --
 verzonden via www.chiroschelle.be"
 ;

$chiroleden_options = get_option('chiroleden_options');
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
				$naar = chiroleden_splits($chiroleden_options['email_updates']);

				foreach ($naar as $email){
					$phpmailer->AddAddress( $email );
				}


				$phpmailer->Body = $bericht;
				$phpmailer->CharSet = apply_filters( 'wp_mail_charset', get_bloginfo('charset') );
				//$phpmailer->From = apply_filters( 'wp_mail_from', $from_email );
				$phpmailer->From = 'no-reply@chiroschelle.be';
				//$phpmailer->FromName = apply_filters( 'wp_mail_from_name', $from_name );
				$phpmailer->FromName = 'ChiroSchelle.be';
				$phpmailer->IsMail();
				//$phpmailer->Subject = $subject;
				$phpmailer->Subject = "[ChiroSchelle.be] lid aangepast";

				do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );

				$result = @$phpmailer->Send();
		}
	}

}

function ledenbeheer_check_wijzigingen($post, $user){
	//te controleren velden:
	$velden = array('first_name', 'last_name', 'email', 'afdeling', 'straat', 'nr', 'postcode', 'gemeente', 'telefoon' );
	foreach ($velden as $v){
		if ($post[$v .'_old'] != $post[$v]){
			$gewijzigd = true;
		}
	}

	//geboorte <-> geb_dag,maand, jaar
	$geboorte = $post['geb_jaar'] . '-' . $post['geb_maand'] . '-' . $post['geb_dag'];
	if ($geboorte != $post['geboorte_old']){
		$gewijzigd = true;
	}
	if ($gewijzigd == true){
		return true;
	}else {
		return false;
	}

}

function ledenbeheer_hidden_fields($user){
	$velden = array('first_name', 'last_name', 'email', 'afdeling', 'straat', 'nr', 'postcode', 'gemeente', 'telefoon', 'geboorte' );
	foreach ($velden as $v){
		?>
		<input type="hidden" name="<?php echo $v; ?>_old" value="<?php echo get_the_author_meta( $v, $user->ID); ?>" />
		<?php
	}
	global $current_user;
	get_currentuserinfo();
	?>
	<input type="hidden" name="invoerder" value="<?php echo $current_user->first_name . ' '. $current_user->last_name; ?>" />
	<?php
}

function ledenbeheer_maaknummerafdeling($afdeling) {
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
		break;
	case 18:
		$afdeling = "Oud-leiding";
		break;
	case 19:
		$afdeling = "VeeBee";
		break;
	case 20:
		$afdeling = "Sympathisant";
		break;
	case 21:
		$afdeling = 'Ribbel-Speelcub';
		break;
	case 22:
		$afdeling = 'Rakwi';
		break;
	}
		return $afdeling;
}
?>
