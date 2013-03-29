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

# Haal artiest uit db
$sql_get_artiest =	"SELECT naam, room, van, tot, info, afbeelding
					 FROM artiesten
					 WHERE id = '".mysql_real_escape_string($_GET['id'])."'
					";
					
if(($result_get_artiest = mysql_query($sql_get_artiest)) === false) 
{
    echo showSQLError($sql_get_artiest,mysql_error(),'<div class="error">Fout bij ophalen artiest/div>');
}
elseif(mysql_num_rows($result_get_artiest) <1)
{
	$output = '<div id="info">De artiest die u zoekt bestaat niet!</div>';
}
else 
{
	$result_artiest = mysql_fetch_assoc($result_get_artiest);
	
	$naam 		= $result_artiest['naam'];
	$room 		= $result_artiest['room'];
	$van 		= $result_artiest['van'];
	$tot 		= $result_artiest['tot'];
	$info 		= $result_artiest['info'];
	$afbeelding = $result_artiest['afbeelding'];


}

#Links ophalen
$sql_get_link = "SELECT naam, url 
				 FROM links
				 WHERE userid = '".mysql_real_escape_string($_GET['id'])."'
				";
				
if(($result_get_link = mysql_query($sql_get_link)) === false) 
{
   $output = showSQLError($sql_get_link,mysql_error(),'<div class="error">Fout bij ophalen artiest/div>');
}
elseif(mysql_num_rows($result_get_link) <1)
{
	$links = '<li>Geen links</li>';
}
else 
{
	$links = '';
	while($result_link = mysql_fetch_assoc($result_get_link))
	{
		$links .= '<li><a href="'.$result_link['url'].'">'.$result_link['naam'].'</a></li>';
	}	
}				
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>

		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
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
				<?php if(!isset($output)){ ?>
				<h2><?php echo $naam; ?></h2>
				<div id="artiest">
					<p>
						<?php echo $info; ?>
					</p>
					
					<img src="img/<?php echo $afbeelding; ?>" />
					
					<h4><?php echo $naam; ?> is te vinden via</h4>
					<ul>
						<?php echo $links; ?>
					</ul>
					
				</div>
				<?php } else { echo $output; } ?>
			</div>
			<div id="footer">
				&copy; Aspiranten <a href="http://www.chiroschelle.be">Chiro Schelle</a> | <a href="http://www.jasperdesmet.be">JasperDS Webdevelopment</a> | <a href="mailto:poerkwaspi@chiroschelle.be">Contacteer ons</a>
			</div>
		</div>
	</body>

</html>
