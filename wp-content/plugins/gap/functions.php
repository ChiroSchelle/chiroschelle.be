<?php
/*  Copyright 2010  Ben Bridts  (email : ben.bridts@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function gap_get_werkjaarID($werkjaar = false)
/**
* Zet een werkjaar om in een werkjaarID, of return de hoogste ID
*
* Als een werkjaar wordt meegegeven en er kan een bijpassend ID gevonden 
* worden (uit globael $werkjaarIDs), wordt dit gereturnd, anders wordt er 
* 0 teruggegeven (dit zou het standaardjaar in GAP moeten weergeven).
*
* @package GAP
* @author Ben Bridts
* @since 0.1
*
* @param  integer  werkjaar  Het werkjaar waarvan het ID gezocht moet worden. (vb: 2010-2011: werkjaar=2010)
* @return  integer    Het gevonden ID 
**/
{
    global $werkjaarIDs;
    
    if (!$werkjaar){ //werkjaar niet gegeven
        // neem vandaag als werkjaar. Nieuw werkjaar begint op 1 september
        if(date('n') >= 9) {//september tot en met december
            if (isset($werkjaarIDs[date('Y')])) {
                $werkjaarID = $werkjaarIDs[date('Y')];
            }
            else {
                $werkjaar_error = true;
            }
        }
        else { //januari tem augustus
            if (isset($werkjaarIDs[date('Y')-1])) {
                $werkjaarID = $werkjaarIDs[date('Y')-1];
            }
            else {
                $werkjaar_error = true;
            }
        }
    }
    else { //werkjaar is gegeven
        if (isset($werkjaarIDs[$werkjaar])) {
            $werkjaarID = $werkjaarIDs[$werkjaar];
        }
        else {
            $werkjaar_error = true;
        }
    }
    if ($werkjaar_error) {
        // zoek de hoogste key
        //$key = max(array_keys($werkjaarIDs));
        //$werkjaarID = $werkjaarIDs[$key];
				$werkjaarID=0;
    }
    return $werkjaarID;
}

function gap_get_afdelingID($afdeling=false)
/**
* Zet een afdeling om naar een ID, of return 0
*
* Zoek de gegeven ID bij de gevraagde afdeling. Deze id komt uit een globale
* variable. Als er geen ID gevonden kan worden (omdat hij niet in deze variable
* staat, of omdat er geen afdeling wordt meegegeven met deze functie), wordt
* er false gereturneerd
*
* @package GAP
* @author Ben Bridts
* @since 0.1
*
* @param  integer  $afdeling  De gevraagde afdeling zoals gebruikt op de rest van de site (1=ribbel jongens)
* @return integer   De gevonden ID
**/
{
    global $afdelingIDs;
    //bepaal de afdelingID
    if(!$afdeling)
    {
        return 0;
    }
    elseif($afdelingID = $afdelingIDs[$afdeling]) {
        return $afdelingID;
    }
    // else
    return 0;   
}

function gap_get_download_link($afdeling=false,$werkjaar=false)
/**
* Download het xlsx-bestand naar onze server, en geef een downloadlink.
*
* Haal het xlsx-bestand van de server (bepaald adhv globale variablen), en sla het
* op op onze server in de map 'wp-content/uploads/tmp'. Geef daarna een weblink naar
* dit bestand. Bestanden worden niet automatisch verwijderd. Als de afdeling of het 
* werkjaar niet gevonden kan worden, wordt respectievelijk de volledige ledenlijst 
* en de ledenlijst van het laatst gevonden jaar gedownload
* 
* @package GAP
* @author Ben Bridts
* @since 0.1
* 
* @ToDo: automatisch verwijderen van bestanden (bv. na een uur)
*
* @param  integer  $afdeling  De afdeling zoals gebruikt op onze site (1=ribbel jongens)
* @param  integer  $werkjaar  Het gezochte werkjaar (2010=2010-2011)
* @return  string    de url naar dit bestand
*
**/
{
    //haal de instellingen op
    global $protocol, $username, $password, $server, $directory, $groupID, $afdelingIDs, $werkjaarIDs;
    $werkjaarID = gap_get_werkjaarID($werkjaar);
    $afdelingID = gap_get_afdelingID($afdeling);
    
    //maak de src-url
    $src = $protocol . '://' . $username . ':' . $password . '@' . $server . '/' . $directory . '/' . $groupID . '/Leden/Download/'. $werkjaarID . '?afdelingID=' .$afdelingID . '&functieID=0&sortering=Naam&ledenLijst=Geen';

    
    //make the download on our server
    $file_name = 'gap_' . $afdeling. '.xlsx';
    $append_dir = '/uploads/tmp/';
    $dest_dir = WP_CONTENT_DIR . $append_dir;
    $dest = $dest_dir . $file_name;
    //zorg dat dest_dir bestaat (unset in wp-cron kan die verwijderen als ze leeg is)
    if( ! is_dir($dest_dir)) {
        if(! mkdir($dest_dir,0777,true)){
            return false;
        }
    }
    //download the file
    if(! file_put_contents($dest,file_get_contents($src)) ) {
        @unlink($file_name); //delete the file, but don't print errors with deleting
        return false; //no url
    }
    else {
        chmod($dest, 0777); // allow ftpuser to delete/modify
        $url =  get_bloginfo('url') . '/wp-content'. $append_dir . $file_name;
    }
    return $url;
}

function gap_get_array($afdeling=false,$werkjaar=false)
/**
* maak een array met daarin de ledenlijst
*
* Een array wordt gemaakt, met daarin de ledenlijst van de gevraagde afdeling
* in het gevraagde jaar. Als afdeling of jaar niet gevonden kan worden, wordt er
* respectievelijk van alle afdelingen en van het laatst gevonde jaar een tabel
* gemaakt.
*
* @package GAP
* @author Ben Bridts
* @since 0.1
*
* @param  integer  $afdeling  de afdeling zoals gebruikt op onze site (1=ribbel jongens)
* @param  integer  $werkjaar  het gezochte werkjaar (2010=2010-2011)
* @return array een multidimensie array met daarin alle leden.
**/
{ 
    //array om terug te geven
    $leden = array();
    //haal de instellingen op
    global $protocol, $username, $password, $server, $directory, $groupID, $afdelingIDs, $werkjaarIDs;
    $werkjaarID = gap_get_werkjaarID($werkjaar);
    $afdelingID = gap_get_afdelingID($afdeling);
    //maak de url
    // volgende url laat GAP zelf het werkjaar kiezen, en toont alle leden
    $url = $protocol . '://' . $username . ':' . $password . '@' . $server . '/' . $directory . '/' . $groupID . '/Leden/';
    if($werkjaar || $afdeling) { //
        $url .= 'Lijst/' . $werkjaarID . '?afdelingID=' . $afdelingID . '&sortering=Naam&functieID=0&ledenLijst=Geen';
    }
    //als zowel $werkjaar als $afdeling false zijn, laat GAP dan kiezen
    
    //now get the html
		$dom = new domDocument;
    //$dom->loadHTMLfile($url);
    $html = file_get_contents($url);
    libxml_use_internal_errors(true); // no errors to stderr/stdout, see http://www.php.net/manual/en/domdocument.loadhtml.php#95463
    $dom->loadHTML($html);
    $dom ->preserveWhiteSpace = false;
    $table = $dom->getElementsByTagName('table');
		$rows = $table->item(0)->getElementsByTagName('tr');

    // loop over the table rows    '
    foreach ($rows as $row) 
    { 
    	$lid = array();
        //get each column by tag name
        $cols = $row->getElementsByTagName('td');
        
        // opbouw van htmlpagina:
	    $kolomnrs = array (
		      // array ( 'index' =>  0, 'name' => 'select'),
		      // array ( 'index' =>  1, 'name' => 'volg-nr'),
		         array ( 'index' =>  2, 'name' => 'type' ) //(Lid/Leiding)
		        ,array ( 'index' =>  3, 'name' => 'naam' )
		        ,array ( 'index' =>  4, 'name' => 'geboortedatum')
		      //,array ( 'index' =>  5, 'name' => 'geslacht' )
		      //,array ( 'index' =>  6, 'name' => 'betaald' )
		        ,array ( 'index' =>  7, 'name' => 'afdeling' )
		      //,array ( 'index' =>  8, 'name' => 'functie' )
		      //,array ( 'index' =>  9, 'name' => 'instapeinde' )
		        ,array ( 'index' => 10, 'name' => 'telefoon' )
		        ,array ( 'index' => 11, 'name' => 'e-mail' )
		      );
		    $naam_kolom=3;
		    $afdeling_kolom=7;

        // hebben we een data rij?
        if ($cols->item($naam_kolom)->nodeValue){
 		    //haal data op      
		    foreach ($kolomnrs as $nr) {
		    	$lid[$nr['name']] = trim($cols->item($nr['index'])->nodeValue);
		    } //foreach kolomnrs
		    if ($cols->item($naam_kolom)->hasChildNodes()) { //i can has link?
		    	$links = $cols->item($naam_kolom)->getElementsByTagName('a');
		    	$link = $links->item(0)->getAttribute('href');
		    	$link_parts= explode('/',$link);
		    	$lid['gap_id'] = '!';//trim(end($link_parts));
		    } //if link
		    else {
		    	$lid['gap_id'] = '?'; //no id found
		    } // else link
		    if ($cols->item($afdeling_kolom)->hasChildNodes()) { //i can has link?
		    	$links = $cols->item($afdeling_kolom)->getElementsByTagName('a');
		    	$link = $links->item(0)->getAttribute('href');
		    	$link_parts= explode('/',$link);
		    	$tmp = explode('?',trim(end($link_parts)));
		    	$lid['afdeling_id'] = '!';//$tmp[0];
		    } //if link
		    else {
		    	$lid['afdeling_id'] = '?'; //no id found
		    } // else link
		    //lowercase type
		    $lid['type'] = strtolower($lid['type']);
		   	//append to array
		   	$leden[] = $lid;
        } // if data-row
    } //foreach rows
    return $leden;
}

function gap_echo_table($afdeling=false,$werkjaar=false)
/**
* Schrijf een tabel met daarin de ledenlijst
*
* Een table wordt geschreven, met daarin de ledenlijst van de gevraagde afdeling
* in het gevraagde jaar. Als afdeling of jaar niet gevonden kan worden, wordt er
* respectievelijk van alle afdelingen en van het laatst gevonde jaar een tabel
* gemaakt.
*
* @package GAP
* @author Ben Bridts
* @since 0.1
*
* @param  integer  $afdeling  de afdeling zoals gebruikt op onze site (1=ribbel jongens)
* @param  integer  $werkjaar  het gezochte werkjaar (2010=2010-2011)
**/
{ 
    //haal de leden op
    $leden = gap_get_array($afdeling,$werkjaar);
    //counter
    $aantal_personen = 0;
    $aantal_leiding = 0;
    
    // start output  
?>    
    <form id="change_leden" method="post">
    <table class="gap">
	<thead>
	  <tr>
	    <th scope="col">&nbsp;</th>
	    <th scope="col">Naam</th>
	    <th scope="col">Geboortedatum</th>
	    <th scope="col">Afd.</th>
	    <th scope="col">Telefoon</th>
	    <th scope="col">E-mail</th>
	  </tr>
	</thead>
	<tbody>
<?php
    // loop over the leden
    foreach ($leden as $lid) 
    { 
	    if ($lid['type'] == 'leiding') {
            $aantal_leiding++;
        }
        else {
        	$aantal_leden++;
        }
        
        // opmaak wisselt per rij
        if($aantal_leden & 1) { // 0 = even, 1 = odd 
            $even = 'oneven';
        }
        else {
            $even = 'even';
        }
        $type = $lid['type'];
      	//display row
        echo("<tr class='$even $type'>") ;
    	echo "<td><input type='checkbox' name='gap_ids[]' value='". base64_encode(serialize($lid)) ."' </td>";
    	echo "<td>" . $lid['naam'] ."</td>";
    	echo "<td>" . $lid['geboortedatum'] ."</td>";
    	echo "<td>" . $lid['afdeling'] ."</td>";
    	echo "<td>" . $lid['telefoon'] ."</td>";
    	echo "<td>" . $lid['e-mail'] ."</td>";
        echo('</tr>'); 
    }
    
    echo '</tbody></table>';
    
    // return total number of rows
    $aantal_personen = $aantal_leden + $aantal_leiding;

    echo "<p>Totaal: $aantal_personen ($aantal_leden leden + $aantal_leiding leiding)</p>";
?>
    <p class="submit">
      <input type="submit" name="submit" value="wijzig leden (werkt nog niet)" class="button-primary">
    </p>
    </form>
<?php
}

function gap_edit_leden()
{
	if (isset($_POST['gap_ids'])) {
		$gap_ids = $_POST['gap_ids'];
?>
    <form id="change_leden" method="post">
    <input type="hidden" name="original_ids" value="<?php echo $gap_ids;?>" />
    <table class="gap">
	<thead>
	  <tr>
	    <th scope="col">Naam</th>
	    <th scope="col">Geboortedatum</th>
	    <th scope="col">Afd.</th>
	    <th scope="col">Telefoon</th>
	    <th scope="col">E-mail</th>
	    <th scope="col">Extra</th>
	  </tr>
	</thead>
	<tbody>
<?php
		foreach ( $gap_ids as $slid ) {
			$lid = unserialize(base64_decode($slid));
			echo "<tr>";
			echo "<td>" . $lid['naam'] . "</td>";
			echo "<td>" . $lid['geboortedatum'] . "</td>";
			echo "<td>" . $lid['afdeling'] . "</td>";
			echo "<td>" . $lid['telefoon'] . "</td>";
			echo "<td>" . $lid['e-mail'] . "</td>";
			echo "<td><input type='checkbox' name='" . $lid['gap_id'] ."_stop' /> schrijf uit</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td><input type='text' name='" . $lid['gap_id'] ."_naam' /></td>";
			echo "<td><input type='text' name='" . $lid['gap_id'] ."_geboortedatum' size='11' /></td>";
			echo "<td><input type='text' name='" . $lid['gap_id'] ."_afdeling' size='5' /></td>";
			echo "<td><input type='text' name='" . $lid['gap_id'] ."_telefoon' size='14' /></td>";
			echo "<td><input type='text' name='" . $lid['gap_id'] ."_e-mail' size= '25' /></td>";
			echo "<td><input type='checkbox' name='" . $lid['gap_id'] ."_voegtoe' />voeg toe</td>";
			echo "</tr>";
		}
?>
	</tbody>
	</table>
	<p>
	  <label for="opmerkingen">Opmerkingen</label>
	  <input type="text" name="opmerkingen" id="opmerkingen" />
	<p class="submit">
      <input type="submit" name="submit" value="stuur mail" class="button-primary">
    </p>
    </form>
<?php
	} //if isset
}
function gap_server_offline()
/**
* Kijk of de server nog online is
*
* Kijk of de server nog online is, door gebruik te maken van de globale variabelen
* Er wordt enkel gekeken naar online/offline, niet naar rechten. 
*
* @Package GAP
* @Since 0.1
*
* @ToDo Ook checken op de juiste rechten
* 
* @return   bool    true als de server online is, false als de server offline is.
*
**/
{   
    global $protocol, $username, $password, $server, $directory, $groupID;
    //make the url
    $url = $protocol . '://' . $server . '/' . $directory . '/' . $groupID .'/';
   
    //set up curl
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10); //timeout in 10s
    curl_setopt($ch,CURLOPT_HEADER,true);
    curl_setopt($ch,CURLOPT_NOBODY,true);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); //return output ipv naar stdout
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //het kan ons (momenteel) nog niet echt schelen of het cert. ok is

    //check
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    if ($response && $http_status == 200 ){
        return false;
    }
    else {
        return $http_status;
    } 
}

function gap_get_options()
/**
* Haal alle opties op.
*
* Haal zowel de opties uit wp-db als de hardcoded opties uit options.php
*
* @package GAP
* @author Ben Bridts
* @since 0.1
*
* @ToDo: ipv hardcoded ophalen van nationaal
*
* @return  array  een array met all opties array( naam => optie)
**/
{
    //opties die nog niet in wp-db staan
    $afdelingIDs = array(
         1 => 2705, //ribbel jongens
         2 => 5355, //ribbel meisjes
         3 => 5356, //speelclub jongens
         4 => 2706, //speelclub meisjes
         5 => 2707, //rakkers
         6 => 5358, //kwiks
         7 => 5357, //toppers
         8 => 2708, //tippers
         9 => 2709, //kerels
        10 => 5359, //tiptiens
        11 => 2710, //aspi jongens
        12 => 5360  //aspi meisjes
    );
    $werkjaarIDs = array( //index = jaar van september
        2009 => 1483,
        2010 => 2000,
        2011 => 4047
    );
    $gap_options = get_option('gap_options');  
    $gap_options['afdelingIDs'] = $afdelingIDs;
    $gap_options['werkjaarIDs'] = $werkjaarIDs;
    return $gap_options;
}

function set_global_options()
/**
* Zet alle opties in globale variablen
*
* Alle opties worden in globale variablen gezet. Zo moet gap_get_options niet elke keer
* uitgevoerd worden, en het bespaart ook een pak typwerk.
*
* @package GAP
* @author Ben Bridts
* @since 0.1
*
**/
{
    global $protocol, $username, $password, $server, $directory, $groupID, $afdelingIDs, $werkjaarIDs;
    
    $gap_options = gap_get_options();
    
    $protocol    = $gap_options['protocol']   ; 
    $username    = $gap_options['username']   ; 
    $password    = $gap_options['password']   ; 
    $server      = $gap_options['server']     ; 
    $directory   = $gap_options['directory']  ; 
    $groupID     = $gap_options['groupID']    ; 
    $afdelingIDs = $gap_options['afdelingIDs']; 
    $werkjaarIDs = $gap_options['werkjaarIDs']; 
}

function gap_delete_directory($dir)
/**
* Verwijder een map, inclusief alle bestanden en mappen in die map
*
* Verwijder de map, gegeven als een volledig pad inclusief trailing slash.
* Dit gebeurt door alle submappen en bestanden te verwijderen (door deze 
* functie recursief op te roepen)
*
* @package GAP
* @since 0.1
*
* @param    string  $dir    De map die verwijderd moet worden
**/
{
    if ($handle = opendir($dir)) {
        $array = array();
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if(is_dir($dir.$file)) {
                    if(!@rmdir($dir.$file)) { // Empty directory? Remove it
                        delete_directory($dir.$file.'/'); // Not empty? Delete the files inside it
                    }
                }
                else {
                    @unlink($dir.$file);
                }
            }
        }
        closedir($handle);
        @rmdir($dir);
    }
}
?>
