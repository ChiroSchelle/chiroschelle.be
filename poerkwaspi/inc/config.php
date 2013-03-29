<?php
# config
header("Content-Type:text/html;charset=utf-8");

# Gegevens database (MYSQL)
$mysql['host'] 				= "localhost"; 			
$mysql['gebruikersnaam'] 	= "c7070chi_poerkw";				
$mysql['wachtwoord'] 		= "chrsell882";				
$mysql['database'] 			= "c7070chi_poerkwaspi";

# Gegevens mail
$mail['adres']		 	= '';
$mail['wachtwoord'] 	= '';
$mail['noreply']		= '';
$mail['smtp'] 			= '';
$mail['naam']			= '';

# Juiste tijdzone
date_default_timezone_set('Europe/Berlin');

# Check verbinding met database
if(mysql_connect($mysql['host'],$mysql['gebruikersnaam'],$mysql['wachtwoord']) == false)
{
	echo '<div class="error">Error: fout bij verbinden database.</div>';
}
else
{
	# Check of de database bestaat 
	if(mysql_select_db($mysql['database']) == false)
	{
		echo '<div class="error">Error: fout met selecteren database.</div>';
	}
	else
	{
		$charset = "SET NAMES 'UTF8'";
		if(mysql_query($charset) === false)
		{
			echo '<div class="error">Error: fout met kiezen van charset.</div>';
		}
	}
}

# Juiste taal
$sql_set_time = "SET lc_time_names = 'nl_NL'";

//  Check query		
if (($result_set_time = mysql_query($sql_set_time)) === false) 
{
    # als de query fout is -> foutafhandeling
    echo 'Fout met instellen datum.';
}

?>
