<?php
   	require_once 'parser.php';
	try{
		$parser = new Parser;
		$result;
		if(isset($_GET["afdeling"]) && isset($_GET["startDate"]) && isset($_GET["endDate"])){
			$result = $parser->getProgrammaBetweenDate($_GET["afdeling"], $_GET["startDate"], $_GET["endDate"]);
		}else if(isset($_GET["afdeling"]) && isset($_GET["date"])){
			$result = $parser->getProgrammaByStartDate($_GET["afdeling"], $_GET["date"]);
		}else if(isset($_GET['afdeling'])){
			$result = $parser->getProgrammaByAfdeling($_GET["afdeling"]);
		}else{
			throw new Exception("Kon geen gegevens parsen");
		}
		$xml = "<?xml version=\"1.0\"?>\n";
		$xml .= "<PROGRAMMA>";
		foreach ($result as $programma) {
			$xml .= $programma->makeXML();
		}
		$xml .= "</PROGRAMMA>";
		$simpleXML = new SimpleXMLElement($xml);
		header('Content-Type: text/xml'); 
		echo $simpleXML->asXML();
	}catch(Exception $e){
		echo "Error: " . $e->getMessage() . "\n";
	}
?>