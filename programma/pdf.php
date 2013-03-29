<?php
require('../fpdf/fpdf.php');


//create a FPDF object
/*$pdf=new FPDF();

//set document properties
$pdf->SetAuthor('Lana Kovacevic');
$pdf->SetTitle('FPDF tutorial');

//set font for the entire document
$pdf->SetFont('Helvetica','B',20);
$pdf->SetTextColor(50,60,100);

//set up a page
$pdf->AddPage('P');
$pdf->SetDisplayMode(real,'default');

//insert an image and make it a link
//$pdf->Image('logo.png',10,20,33,0,' ','http://www.fpdf.org/');

//display the title with a border around it
$pdf->SetXY(50,20);
$pdf->SetDrawColor(50,60,100);
$pdf->Cell(100,10,'FPDF Tutorial',1,0,'C',0);

//Set x and y position for the main text, reduce font size and write content
$pdf->SetXY (10,50);
$pdf->SetFontSize(10);
$pdf->Write(5,'Congratulations! You have generated a PDF.');

//Output the document
$pdf->Output('example1.pdf','I');
*/

class PDF extends FPDF
{
  function Header()
    {
      //$this->Image('logo.png',10,8,33);
      $this->SetFont('Helvetica','B',15);
      $this->SetXY(50, 10);
      $this->Cell(0,10,'This is a header',1,0,'C');
     }

  function Footer()
    {
      $time = time();
      $this->SetXY(0,-15);
      $this->SetFont('Helvetica','I',10);
      $this->Write (0,'Afgedrukt op '.date('l j F Y',$time));
      $this->Write (5,'(c) 2008 ChiroSchelle.be');
      
    }
}

$pdf=new PDF();
$pdf->AddPage();
//display the title with a border around it
$pdf->SetXY(50,20);
$pdf->SetDrawColor(50,60,100);
$pdf->Cell(100,10,'FPDF Tutorial',1,0,'C',0);

//Set x and y position for the main text, reduce font size and write content
$pdf->SetXY (10,50);
$pdf->SetFontSize(10);
$pdf->Write(5,'Congratulations! You have generated a PDF.');
$pdf->Output('example2.pdf','I');


?>