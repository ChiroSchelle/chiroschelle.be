<?php

#1 functie voor sql debug
function showSQLError($sql,$error,$text='Error')
{
    if (DEBUG_MODE)
    {
        return  '<pre>Error: ' . $error . '<br />' . $sql . '</pre>';
    }
    else
    {
        return $text;
    }
} 

#2 Blog berichten ophalen
function blogBerichten($start, $limiet)
{
	$sql_get_blog =	"SELECT id, titel, auteur, DATE_FORMAT(datum, '%d %M %Y om %H uur') AS datum, bericht
					 FROM blog
					 ORDER BY id DESC LIMIT ".mysql_real_escape_string($start).", ".mysql_real_escape_string($limiet)."
					";
					
	if(($result_get_blog = mysql_query($sql_get_blog)) === false)
	{
		return showSQLError($sql_get_blog,mysql_error(),'<div id="error">Er liep iets mis bij het ophalen van het blog bericht.</div>');
	}
	else
	{
		$output = '';
		while($result_blog = mysql_fetch_assoc($result_get_blog))
		{
			$output .= '
			<div class="blogberichtje">
				<h3>'.$result_blog['titel'].'</h3>
				<div class="info">
					Geschreven door '.$result_blog['auteur'].' op '.$result_blog['datum'].'
				</div>
				<p>
					'.substr(nl2br(strip_tags($result_blog['bericht'])), 0, 250).'...
					<br/><br/>
					<a href="lees_blog.php?id='.$result_blog['id'].'" class="leesverder">Lees meer</a>
				</p>	
			</div>';
		}
		
		return $output;
	}
}

#3 Tel aantal blog berichten
function tel_blogberichten()
{
	# tel de reacties 
	$sql_tel_blogberichten = 	"SELECT COUNT(id) as num 
								 FROM blog
								";
							
	if(($result_tel_blogberichten = mysql_query($sql_tel_blogberichten)) === false)
	{
		return false;
	}
	else
	{
		$tel = mysql_fetch_assoc($result_tel_blogberichten);
		return $tel['num'];
	}
}


#4 Paginate 
function paginate($limiet, $pagina, $total_pages)
{					
	// Initial page num setup
	if($pagina == 0)
	{
		$pagina = 1;
	}
						
	$prev = $pagina - 1;
	$next = $pagina + 1;
						
	$lastpage = ceil($total_pages/$limiet);
	$LastPagem1 = $lastpage - 1;					

	$paginate = '';
	
	if($lastpage > 1)
	{	

		$paginate .= '<div class="paginate">';
							
		// Previous
		if ($pagina > 1)
		{
			$paginate .= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$prev.'"> Vorige</a>';
		}
		else
		{
			$paginate.= '<span class="disabled"> Vorige </span>';	
		}
		
		$stages = "";
	
		// Pages
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $pagina)
				{
					$paginate .= '<span class="current">'.$counter.'</span>';
				}
				else
				{
					$paginate .= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$counter.'"> '.$counter .'</a>';
				}
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($pagina < 1 + ($stages * 2))
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $pagina)
					{
						$paginate.= '<span class="current"> '.$counter.' </span>';
					}
					else
					{
						$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$counter.'"> '.$counter.' </a>';
					}
				}
					
				$paginate.= '...';
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$LastPagem1.'"> '.$LastPagem1.' </a>';
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$LastPagem1.'"> '.$lastpage.' </a>';
			}
			elseif($lastpage - ($stages * 2) > $pagina && $pagina > ($stages * 2))
			{
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page=1"> 1 </a>';
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page=2"> 2 </a>';
									
				$paginate.= '...';
				for ($counter = $pagina - $stages; $counter <= $pagina + $stages; $counter++)
				{
					if ($counter == $pagina)
					{
						$paginate.= '<span class="current"> '.$counter.' </span>';
					}
					else
					{
						$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$counter.'"> '.$counter .'</a>';
					}
				}
									
				$paginate.= '...';
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$LastPagem1.'"> '.$LastPagem1.' </a>';
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$lastpage.'"> '.$lastpage.' </a>';
			}
			else
			{
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page=1"> 1</a>';
				$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page=2"> 2</a>';
				$paginate.= '...';
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $pagina)
					{
						$paginate.= '<span class="current"> '.$counter.' </span>';
					}
					else
					{
						$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$counter.'"> '.$counter.' </a>';
					}
				}
			}
		}

		// Next
		if ($pagina < $counter - 1)
		{
			$paginate.= '<a href="blog.php?id='.$_GET['id'].'&amp;page='.$next.'"> Volgende</a>';
		}
		else
		{
			$paginate.= '<span class="disabled"> Volgende</span>';
		}

		$paginate.= '</div>';		

	}
	
	return $paginate;
}

#5 volledige blog ophalen
function leesBlogbericht($id)
{
	$sql_get_blog =	"SELECT titel, auteur, DATE_FORMAT(datum, '%d %M %Y om %H uur') AS datum, bericht
					 FROM blog
					 WHERE id = '".mysql_real_escape_string($id)."'
					";
	if(($result_get_blog = mysql_query($sql_get_blog)) === false)
	{
		return showSQLError($sql_get_blog,mysql_error(),'<div id="error">Er liep iets mis bij het ophalen van het blog bericht.</div>');
	}
	elseif(mysql_num_rows($result_get_blog) <1)
	{
		return 'bestaat niet';
	}
	else
	{
		$result_blog = mysql_fetch_assoc($result_get_blog);
		
		$output = '
			<h2>'.$result_blog['titel'].'</h2>
			<div class="blogberichtje">
				<div class="info">
					Geschreven door '.$result_blog['auteur'].' op '.$result_blog['datum'].'
				</div>
				<p>
					'.nl2br($result_blog['bericht']).'		
				</p>
			</div>	
		';	
		
		return $output;
	}
}

#6 Reacties opahalen
function getReacties($id)
{	
	$sql_get_reacties 	=	"SELECT naam, bericht, DATE_FORMAT(datum, '%d %M om %H.%i') AS datum
							 FROM reacties
							 WHERE blog = '".mysql_real_escape_string($id)."'
							";
			
	if(($qry_get_reacties = mysql_query($sql_get_reacties)) === false) 
	{
		return showSQLError($sql_get_reacties,mysql_error(),'<div class="error">Ophalen reacties mislukt</div>');
	}
	elseif(mysql_num_rows($qry_get_reacties) < 1)
	{
		return '<div class="info">Nog geen reacties, schrijf als eerste een reactie!</div>';
	}	
	else
	{
		$reacties = '';
	
		while($result_reacties = mysql_fetch_assoc($qry_get_reacties))
		{
			$reacties .= '
				<div class="blogberichtje">
					<div class="info">
						Geschreven door '.$result_reacties['naam'].' op  '.$result_reacties['datum'].'
					</div>
					<p>
						'.nl2br(htmlspecialchars($result_reacties['bericht'])).'
					</p>
				</div>';
		}
		
		return $reacties;
	}
}

#7 Valideer
function validate($gegevens)
{
	$error = array();
		
	if(strlen($gegevens['naam']) < 3)
	{
		$error[] = 'Uw naam moet minstens 3 tekens bevatten';
	}
	
	if(strlen($gegevens['mail']) < 5)
	{
		$error[] = 'Uw email adres is niet geldig';
	}
	
	if(strlen($gegevens['bericht']) < 5)
	{
		$error[] = 'Uw bericht moet minstens 5 tekens bevatten';
	}
			
	# Tel de fouten en weergeef ze indien nodig
	$fouten = count($error); // aantal errors tellen
	if($fouten != 0) 
	{ 
		$validatie  = '<div class="error">';
		$validatie .= 'Uw reactie kon niet worden toegevoegd omwille van de volgende reden(en):';
		$validatie .= '<ul>';
				
		for($i = 0; $i < $fouten; $i++) 
		{
			$validatie .=  '<li>'.$error[$i].'</li>';
		}
				
		$validatie .= '</ul>';
		$validatie .= '</div>';
		
		return $validatie;
	}
	else
	{
		return 'valid';
	}
}

#8 bericht toevoegen
function addBericht($naam, $email, $bericht, $ip, $blog)
{
	 $sql_add_bericht =	"INSERT INTO reacties
						 VALUES	('',
								 '".mysql_real_escape_string($naam)."',
								 NOW(),
								 '".mysql_real_escape_string($email)."',
								 '".mysql_real_escape_string($ip)."',
								 '".mysql_real_escape_string($bericht)."',
								 '".mysql_real_escape_string($blog)."'
								) 
						";
			
	if(($qry_add_bericht = mysql_query($sql_add_bericht)) === false) 
	{
		return showSQLError($sql_add_bericht,mysql_error(),'<div id="error">Fout met invoegen reactie, probeer nogmaals</div>.');
	}
	else 
	{
		return '<div class="success">Bericht is toegevoegd!</div>';
	}
}	
?>