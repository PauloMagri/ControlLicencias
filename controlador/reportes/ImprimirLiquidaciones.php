<?php
//Se llama a la libreria de tcpdf
require_once ('../../js/pdf/TCPDF-master/tcpdf_import.php');

//Se crea el documento
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//Se establece el contenido de la cabecera
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CONTROL LICENCIAS');
$pdf->SetTitle('LIQUIDACION VACACIONES');
$pdf->SetSubject('');
$pdf->SetKeywords('Reporte liquidacion de vacaciones');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('times', 'BI', 9);
$pdf->SetLeftMargin(15);

$arrayLiquidaciones = json_decode($_POST['liquidaciones'], true);
//print_r($arrayLiquidaciones);
$pdf->AddPage('L');
$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 15, 'Liquidacion de vacaciones', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(6);
//Formato cabecera tabla
$pdf->SetFillColor(0, 0, 250);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->SetFont('helvetica', 'B', 12);
//Titulos cabecera tabla
$pdf->Cell(20, 7, 'Legajo', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Apellido', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Nombre', 1, 0, 'C', 1);
$pdf->Cell(30, 7, 'Mes', 1, 0, 'C', 1);
$pdf->Cell(20, 7, 'Dias', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Tipo Formulario', 1, 0, 'C', 1);
$pdf->Cell(35, 7, 'N° Formulario', 1, 0, 'C', 1);

$pdf->Ln();
//Formato cuerpo tabla
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('helvetica', '', 10);
//Data cuerpo tabla
$arrayMeses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
$fill = 0;
foreach ($arrayLiquidaciones as $liquidacion) {
	$pdf->Cell(20, 6, $liquidacion['legajo'], 'LR', 0, 'C', $fill);
	$pdf->Cell(40, 6, $liquidacion['apellido'], 'LR', 0, 'C', $fill);
	$pdf->Cell(40, 6, $liquidacion['nombre'], 'LR', 0, 'C', $fill);
	$pdf->Cell(30, 6, $arrayMeses[$liquidacion['mes']], 'LR', 0, 'C', $fill);
	$pdf->Cell(20, 6, $liquidacion['dias'], 'LR', 0, 'C', $fill);
	$pdf->Cell(40, 6, $liquidacion['tipo'], 'LR', 0, 'L', $fill);
	$pdf->Cell(35, 6, $liquidacion['idpedido'], 'LR', 0, 'C', $fill);
	$pdf->Ln();
	$fill=!$fill;
}

//Se cierra y se exporta el archivo PDF
$pdf->Output('LiquidacionDeVacaciones.pdf', 'I');
