<?php
# errors weergeven
$error_reporting = 0;

if($error_reporting == 1)
{
	ini_set('display_errors',1);
	error_reporting(E_ALL | E_STRICT);

	# sql debug (AAN - UIT)
	define('DEBUG_MODE',true);
}
else
{
	ini_set('display_errors',0);
	error_reporting(E_ALL | E_STRICT);

	# sql debug (AAN - UIT)
	define('DEBUG_MODE',false);
}

# Include config
include 'inc/config.php';
include 'inc/functies.php';

$sql_get_commercial =	"SELECT id, naam, DATE_FORMAT(van, '%H:%i') AS tijd, info
						 FROM artiesten
						 WHERE room = 'Commercial'
						";
						
if(($result_get_commercial = mysql_query($sql_get_commercial)) === false) 
{
	# weergeef foutmelding
    $commercial = showSQLError($sql_get_commercial,mysql_error(),'<div class="error">Fout bij ophalen artiesten</div>');
}
else 
{
	$commercial = '';
	while($result_commercial = mysql_fetch_assoc($result_get_commercial))
	{
		$commercial .= 	'<li>
							<span class="tijdstip">'.$result_commercial['tijd'].'</span> 
							'.$result_commercial['naam'].'<br/>
							<span class="uitleg">
								'.substr($result_commercial['info'], 0, 40).'..
								<br/><a href="artiest.php?id='.$result_commercial['id'].'">Meer info</a>
							</span>
						</li>';
	}
}						
						
$sql_get_dnb =	"SELECT id, naam, DATE_FORMAT(van, '%H:%i') AS tijd, info
				 FROM artiesten
				 WHERE room = 'DnB'
				 ORDER BY volgorde
				";
						
if(($result_get_dnb = mysql_query($sql_get_dnb)) === false) 
{
	# weergeef foutmelding
    $dnb = showSQLError($sql_get_dnb,mysql_error(),'<div class="error">Fout bij ophalen artiesten</div>');
}
else 
{
	$dnb = '';
	while($result_dnb = mysql_fetch_assoc($result_get_dnb))
	{
		$dnb .= 	'<li>
							<span class="tijdstip">'.$result_dnb['tijd'].'</span> 
							'.$result_dnb['naam'].'<br/>
							<span class="uitleg">
								'.substr($result_dnb['info'], 0, 40).'..
								<br/><a href="artiest.php?id='.$result_dnb['id'].'">Meer info</a>
							</span>
						</li>';
	}
}	
						
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Poerkwaspi</title>

		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

	</head>
	<body>
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) {return;}
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1&appId=170695056324556";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	
		<div id="wrapper">
			<div id="header">
				<img src="img/header.png" alt="poerkwaspi" />
			</div>
			
			<div id="menu">
				<ul>
					<li><a href="index.php" >Home</a></li>
					<li><a href="blog.php">Blog</a></li>
					<li><a href="artiesten.php" class="active">Artiesten</a></li>
					<li><a href="sponsors.php">Sponsors</a></li>
					<li><a href="contact.php">Contact</a></li>
				</ul>
				
				<div id="fb">
					<div class="fb-like" data-href="www.poerkwaspi.chiroschelle.be" data-send="true" data-layout="box_count" data-width="80" data-show-faces="false" data-font="arial"></div>
				</div>
			</div>
			
			<div id="content">
				<h2>Artiesten</h2>
				
				<div class="artiesten">
					<h3>Commercial</h3>
					
					<ul>	
						<?php echo $commercial; ?>
					</ul>
				</div>
				
				<div class="artiesten">
					<h3>Drum and bass</h3>
					
					<ul>	
						<?php echo $dnb; ?>
					</ul>
				</div>
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
