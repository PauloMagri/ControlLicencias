<?php
//Se llama a la libreria de tcpdf
require_once ('../../js/pdf/TCPDF-master/tcpdf_import.php');
require_once '../controladoresEspecificos/ControladorDiasCtaLicencia.php';

//Se crea el documento
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//Se establece el contenido de la cabecera
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CONTROL LICENCIAS');
$pdf->SetTitle('SOLICITUD LICENCIA ANUAL');
$pdf->SetSubject('');
$pdf->SetKeywords('Reporte pedido vacaciones');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('times', 'BI', 9);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 16);
$logo = K_PATH_IMAGES.'logo_example.png';
$pdf->Image($logo, 10, 10, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false, false, false);
$pdf->Cell(0, 9, 'CONTROL LICENCIAS', 0, false, 'C', false, '', 0, false, 'M', 'M');
$pdf->Ln(15);

if($_POST['formulariodiasctalicencia'] == "pedido"){

	$pdf->SetFont('helvetica', 'BU', 14);
	$pdf->Cell(0, 15, 'DIAS A CUENTA DE LICENCIA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->Cell(0, 15, 'Form. Nº ' . $_POST['iddc'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'PERIODO: ' . $_POST['a'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Apellido y nombres:  ' . '                                                                       Legajo: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, '                           ' . $_POST['ap'] . ', ' . $_POST['nom'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15,'                                                                                                  ' . $_POST['leg'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Fecha de ingreso:   ' . $_POST['ing'] . '      Sección: ............................................................... ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'Solicita  _____  Días.	Desde el:  ____/____/____  hasta el dìa:  ____/____/____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(15);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Firma del empleado                 ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);

	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'INFORME DE LA OFICINA DE PERSONAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Dìas a cuenta de licencia anteriores:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', '', 8);

	//Se realiza la busqueda de los pedido de vacaciones anteriores del empleado
	$parametros = array("iddiasctalicencia" => $_POST['iddc'], "legajo" => $_POST['leg']);
	$controlador = new ControladorDiasCtaLicencia($parametros);
	$arrayDCL = $controlador->buscar($parametros);
	$contador = 0;

	foreach ($arrayDCL as $clave) {
		if($contador < 2 && $clave['desde'] != null && $clave['hasta'] != null){
			//Se imprimiran hasta dos pedidos de vacaciones anteriores
			$pdf->Cell(0, 15, 'Desde el día: ' . date("d/m/Y", strtotime($clave[8])) . '     hasta el día: ' . date("d/m/Y", strtotime($clave[9])) . '    Licencia: ' . $clave[7], 0, false, 'L', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(6);
		}
		$contador++;
	}

	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(0, 15, '* * * ARCHIVESE EN EL LEGAJO PERSONAL * * *', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Notificado:_______________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Jefe de personal                    ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->Cell(0, 15, '        Mendoza: ____ / ____ / ____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);

	$pdf->writeHTML('<hr/>', true, false, true, false, '');
	$pdf->Ln(2);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'RESOLUCIÓN DE ENCARGADO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'SI - NO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, '                , se acuerda la licencia solicitada, previa notificación del solicitante, del informe que antecede.-', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(0, 15, '* * * ARCHÍVESE EN EL LEGAJO PERSONAL * * *', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(15);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15, '        Mendoza: ____ / ____ / ____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Encargado                      ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->writeHTML('<hr/>', true, false, true, false, '');
}//Fin formulario pedido

if($_POST['formulariodiasctalicencia'] == "completo"){

	$pdf->SetFont('helvetica', 'BU', 14);
	$pdf->Cell(0, 15, 'DIAS A CUENTA DE LICENCIA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->Cell(0, 15, 'Form. Nº ' . $_POST['iddc'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'PERIODO: ' . $_POST['a'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Apellido y nombres:  ' . '                                                                       Legajo: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, '                           ' . $_POST['ap'] . ', ' . $_POST['nom'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15,'                                                                                                  ' . $_POST['leg'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Fecha de ingreso:   ' . $_POST['ing'] . '      Sección: ............................................................... ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'Solicita  '. $_POST['cd'] .'  Días.	Desde el:  ' . $_POST['des'] . '  hasta el dia:  ' . $_POST['has'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(15);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Firma del empleado                 ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);

	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'INFORME DE LA OFICINA DE PERSONAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Dìas a cuenta de licencia anteriores:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', '', 8);

	//Se realiza la busqueda de los pedido de vacaciones anteriores del empleado
	$parametros = array("iddiasctalicencia" => $_POST['iddc'], "legajo" => $_POST['leg']);
	$controlador = new ControladorDiasCtaLicencia($parametros);
	$arrayDCL = $controlador->buscar($parametros);
	$contador = 0;

	foreach ($arrayDCL as $clave) {
		if($contador < 2 && $clave['desde'] != null && $clave['hasta'] != null){
			//Se imprimiran hasta dos pedidos de vacaciones anteriores
			$pdf->Cell(0, 15, 'Desde el día: ' . date("d/m/Y", strtotime($clave[8])) . '     hasta el día: ' . date("d/m/Y", strtotime($clave[9])) . '    Licencia: ' . $clave[7], 0, false, 'L', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(6);
		}
		$contador++;
	}

	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(0, 15, '* * * ARCHIVESE EN EL LEGAJO PERSONAL * * *', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Notificado:_______________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Jefe de personal                    ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->Cell(0, 15, '        Mendoza: ____ / ____ / ____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);

	$pdf->writeHTML('<hr/>', true, false, true, false, '');
	$pdf->Ln(2);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'RESOLUCIÓN DE ENCARGADO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'SI - NO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, '                , se acuerda la licencia solicitada, previa notificación del solicitante, del informe que antecede.-', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(0, 15, '* * * ARCHÍVESE EN EL LEGAJO PERSONAL * * *', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(15);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15, '        Mendoza: ____ / ____ / ____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Encargado                      ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->writeHTML('<hr/>', true, false, true, false, '');
}//Fin formulario pedido
//Se cierra y se exporta el archivo PDF
$pdf->Output('SolicitudLicenciaAnual' . $_POST['ap'] . $_POST['nom'] . '.pdf', 'I');