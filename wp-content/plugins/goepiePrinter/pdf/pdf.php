<?php
    #HEADING
    require_once('fpdf.php');
	//include_once('conf.php');
	include_once('functions.php');
    //phpinfo();
	
	class PDF extends FPDF{
	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(0,10,'Programma Goepie');
		}
	
	function GoepieTable($datum, $data){
		//Const
		$afdeling[1] = "Ribbel-jongens";
		$afdeling[2] = "Ribbel-meisjes";
		$afdeling[3] = "Speelclub-jongens";
		$afdeling[4] = "Speelclub-meisjes";
		$afdeling[5] = "Rakkers";
		$afdeling[6] = "Kwiks";
		$afdeling[7] = "Toppers";
		$afdeling[8] = "Tippers";
		$afdeling[9] = "Kerels";
		$afdeling[10] = "Tip-tiens";
		$afdeling[11] = "Aspi-jongens";
		$afdeling[12] = "Aspi-meisjes";
		$afdeling[13] = "Iedereen";	
		$afdeling[14] = "Leiding";
		$afdeling[15] = "Muziekkapel";
		$afdeling[16] = "Tikeas";
		$afdeling[17] = "Activiteiten";
		$afdeling[18] = "Oud-leiding";
		$afdeling[19] = "VeeBee";
		$afdeling[20] = "Sympathisanten";
		$afdeling[21] = "Ribbel-Speelclub";
		$afdeling[22] = "Rakwi";		
			
		
		//Column widths	
		$w = array(35, 0);
		
		//Header
		$this->SetFontSize(13);
		$this->Cell(0,8, $datum, 1, 0, 'C');

		//DATA
		$this->Ln();
		foreach($data as $key => $value){
			if($key == 14 or !$afdeling[$key]){
				continue;
			}
			$this->SetFontSize(10);
			if($key != 17 && $key != 13){
				$this->Cell($w[0], 6, $afdeling[$key], 'LTR');
			}
			$this->MultiCell($w[1], 6, $value, 1);
		}
	}
	}
	
	function getProgram($date){
		$return;
		global $wpdb;
		$table_name = $wpdb->prefix . 'programma';
		$stop = "WHERE datum = '" . $date . "'";
		$str = "SELECT * FROM $table_name $stop";
		$result = $wpdb->get_results($str);
		foreach ($result as $row) {
			//$return[$row->afdeling] = utf8_decode(str_replace("\\", "", $row->programma));
			$return[$row->afdeling] = iconv('UTF-8', 'windows-1252', str_replace("\\", "", $row->programma));
		}
		if(sizeof($return) > 0){
			ksort($return);
		}
		return $return;
	}
	
	function getProgramBetween($year1, $month1, $day1, $year2, $month2, $day2){
		$nrDay = array('Zondag ', 'Maandag ', 'Dinsdag ', 'Woensdag ', 'Donderdag ', 'Vrijdag ', 'Zaterdag ');
		$nrMonth = array('Verkeeder invoer', ' Januari ', ' Februari ', ' Maart ', ' April ', ' Mei ', ' Juni ',
		 ' Juli ', ' Augustus ', ' September ', ' Oktober ', ' November ', ' December ');
		$return;	
		$date1 = new DateTime($year1 . "-" . $month1 . "-" . $day1);
		$date2 = new DateTime($year2 . "-" . $month2 . "-" . $day2);
		$count = 0;
		while($date1 < $date2){
			$Day = $nrDay[$date1->format("w")];
			$Month = $nrMonth[$date1->format("n")];
			$date = $Day . $date1->format("j") . $Month . $date1->format("Y");
			$program = getProgram($date1->format("Y-m-d"));
			if(count($program) > 0){
				$return[$count] = array($date, $program);
				$count++;
			}
			$day1++;
			date_fix_date($month1, $day1, $year1);
			$date1 = new DateTime($year1 . "-" . $month1 . "-" . $day1);
		}
		return $return;
	}
	
	function makeGoepiePDF($program, $download){
		$pdf = new PDF;	
		$pdf->SetMargins(30, 20);
		$pdf->SetFont("Arial", '', 10);
		$pdf->SetLineWidth(0.1);
		//$pdf->SetAutoPageBreak(True, 20);
		$first = true;
		foreach($program as $row){
			$yLast = $pdf->GetY();
			if($yLast + getYs($row) < 270 && !$first){
				$pdf->SetY($yLast+5);
			}
			else {
				$pdf->AddPage();
				$first = false;
			}
			//echo $row[0] . " ->" . $yLast . "->" . (getYs($row)) . "<br>";
			$yFirst = $pdf->getY();
			//$pdf->AcceptPageBreak();
			$pdf->GoepieTable($row[0], $row[1]);
			$yLast = $pdf->GetY();
			$pdf->Line(30,$yFirst, 30, $yLast);
			$pdf->Line(30, $yLast, 65, $yLast);
		}
		//$downStr = "I";
		//if($download){
			$downStr = "F";
		//}
		echo $pdf->Output("pdf/programma.pdf", $downStr);
		echo "Download <a href='pdf/programma.pdf'>hier</a> het programma";
	}	
	
?>