<?php
 
	include 'third-party/libraries/fpdf.php';
	
	ob_start();
	$pdf = new FPDF();
	$pdf->AddPage();

	$pdf->SetFont('times','',14);

	$pdf->Cell(190,12,"SANAL ECZANESI",1,0,'C');
	$pdf->SetFont('times','',12);	
	$pdf->Ln();  

	
	$pdf->Cell(100,12,"Siparis Icerigi",1);
	$pdf->Cell(20,12,"Toplam",1);
	$pdf->Cell(30,12,"Eczaci",1);
	$pdf->Cell(40,12,"Siparis Tarihi",1);
	$pdf->Ln(); 

	$pdf->Cell(100,12,$siparis_icerikleri,1);
	$pdf->Cell(20,12,$toplam_fiyat,1);
	$pdf->Cell(30,12,$eczaci,1); 
	$pdf->Cell(40,12,$siparis_tarihi,1); 
	$pdf->Ln(); 

	





	$pdf->Output();
	ob_end_flush(); 



?>