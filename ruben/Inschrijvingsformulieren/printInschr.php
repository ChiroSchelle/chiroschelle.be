<?php
	include_once("fpdf.php");
	include_once("classes.php");
	
	function addPage(&$pdf){
		$pdf->AddPage("L", "A4");
		$pdf->Cell(10, 6, "ID", 1, 0, "C", false);
		$pdf->Cell(50, 6, "Naam", 1, 0, "C", false);
		$pdf->Cell(50, 6, "Voornaam", 1, 0, "C", false);
		$pdf->Cell(30, 6, "Aantal", 1, 0, "C", false);
		$pdf->Cell(30, 6, "Te Betalen", 1, 0, "C", false);
		$pdf->Cell(80, 6, "Opmerkingen", 1, 1, "C", false);
	}
	
	function addInsch(&$pdf, &$insch){
		$tebet = $insch->teBetalen() . " euro";
		$pdf->Cell(10, 6, $insch->getID(), 1, 0, "L", false);
		$pdf->Cell(50, 6, $insch->getNaam(), 1, 0, "L", false);
		$pdf->Cell(50, 6, $insch->getVoornaam(), 1, 0, "L", false);
		$pdf->Cell(30, 6, $insch->getAantal(), 1, 0, "L", false);
		$pdf->Cell(30, 6, $tebet, 1, 0, "L", false);
		$pdf->MultiCell(80, 6, $insch->getOpmerkingen(), 1, "L", false);
	}
	
	function printPDF(){
		$inschrijvingen = new inschrijvingen;
		$inschrijvingen->loadDB();
		
		$pdf = new FPDF("L", "mm", "A4");
		$pdf->SetMargins(30, 20);
		$pdf->SetFont("Arial", '', 10);
		addPage($pdf);
		$countInsch = 0;	
		$countPers = 0;
		foreach ($inschrijvingen->inschrijvingen as $inschrijving) {
			addInsch($pdf, $inschrijving);
			$countInsch++;		
			$countPers += $inschrijving->getAantal();
		}
	
		$pdf->Cell(1, 6, "", 0,1);
		$pdf->Cell(50, 6, "Totaal aantal inschrijvingen", 0, 0, "L", false);
		$pdf->Cell(10, 6, $countInsch, 0, 1, "R", false);
		$pdf->Cell(50, 6, "Totaal aantal personen", 0, 0, "L");
		$pdf->Cell(10, 6, $countPers, 0, 1, "R", false);
		$pdf->output("Inchrijvingsavond.pdf", "I");
	}
	
	function tshirtAddpage(&$pdf){
		$array = array("6jaar", "8jaar", "10jaar", "12jaar", "DamesS", "DamesM", "DamesL", "HerenS", "HerenM", "HerenL", "HerenXL", "HerenXXL");
		
		$pdf->AddPage("L", "A4");
		$pdf->Cell(5, 6, "ID", 1, 0, "C", false);
		$pdf->Cell(30, 6, "Naam", 1, 0, "C", false);
		$pdf->Cell(30, 6, "Voornaam", 1, 0, "C", false);
		
		foreach ($array as $maat) {
			$pdf->Cell(15, 6, $maat, 1, 0, "C", false);
		}
		
		$pdf->Cell(20, 6, "Aantal", 1, 0, "C", false);
		$pdf->Cell(20, 6, "Te Betalen", 1, 1, "C", false);
	}
	
	function addBestelling(&$pdf, &$bestelling){
		$array = array("f6jaar", "f8jaar", "f10jaar", "f12jaar", "fDamesS", "fDamesM", "fDamesL", "fHerenS", "fHerenM", "fHerenL", "fHerenXL", "fHerenXXL");
		
		$pdf->Cell(5, 6, $bestelling->fID, 1, 0, "L", false);
		$pdf->Cell(30, 6, $bestelling->fNaam, 1, 0, "L", false);
		$pdf->Cell(30, 6, $bestelling->fVoornaam, 1, 0, "L", false);
		
		foreach ($array as $maat) {
			$pdf->Cell(15, 6, $bestelling->$maat, 1, 0, "L", false);
		}
		
		$pdf->Cell(20, 6, $bestelling->Aantal(), 1, 0, "L", false);
		$pdf->Cell(20, 6, $bestelling->teBetalen(), 1, 1, "L", false);
		
	}
	
	function printTotaal(&$pdf, &$bestellingen, $totaal = "XX"){
		$pdf->Cell(30, 6, "", 0, 1);
		$pdf->Cell(5, 6, "XX", 1, 0, "L", false);
		$pdf->Cell(30, 6, "Totaal", 1, 0, "C", false);
		$pdf->Cell(30, 6, $totaal . " bestellingen", 1, "C", false);
		
		
		for ($i=0; $i <12 ; $i++) { 
			$pdf->Cell(15, 6, $bestellingen->getMaat($i), 1, 0, "L", false);
		}
		
		$totaal = $bestellingen->totaal();
		$pdf->Cell(20, 6, $totaal, 1, 0, "L", false);
		$temp = $totaal * 10;
		$pdf->Cell(20, 6, $temp, 1, 1, "L", false);
		
	}
	
	function tshirtPrintPDF(){
		$bestellingen = new bestellingen;
		$bestellingen->loadFromDB();
		
		$pdf = new FPDF("L", "mm", "A4");
		$pdf->SetMargins(10, 20);
		$pdf->SetFont("Arial", '', 8);
		tshirtAddpage($pdf);
		$count = 0;
		$count2 = 0;
		foreach ($bestellingen->bestellingen as $bestelling) {
			$count2++;
			addBestelling($pdf, $bestelling);
			$count++;
			if($count == 27){
				tshirtAddpage($pdf);
				$count = 0;
			}
		}
		
		printTotaal($pdf, $bestellingen, $count2);
		
		$pdf->output("Tshirts.pdf", "I");
		
	}
?>