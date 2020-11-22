<?php
//Se llama a la libreria de tcpdf
require_once ('../../js/pdf/TCPDF-master/tcpdf_import.php');
require_once '../controladoresEspecificos/ControladorPedidoVacaciones.php';
require_once '../controladoresEspecificos/ControladorLicenciaVacaciones.php';
require_once '../controladoresEspecificos/ControladorEmpleado.php';
require_once '../controladoresEspecificos/ControladorSesion.php';

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

$pdf->Ln(10);

//Se evalua el tipo de formulario para generar su respectivo pdf
if($_POST['formulariopedidovacaciones'] == 'pedido'){

	$pdf->SetFont('helvetica', 'BU', 14);
	$pdf->Cell(0, 15, 'LICENCIA ANUAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(5);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->Cell(0, 15, 'Form. Nº ' . $_POST['idpv'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(5);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'PERIODO: ' . $_POST['a'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Apellido y nombres: ' . '                                                                       Legajo: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, '                           ' . $_POST['ap'] . ', ' . $_POST['nom'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15,'                                                                                                  ' . $_POST['leg'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);

	//Se buscara la licencia de vacaciones correspondiente, para informar los dias pendientes de la misma
	$parametros = array("legajo" => $_POST['leg'], "anio" => $_POST['a']);
	$controladorLV = new ControladorLicenciaVacaciones($parametros);
	$licencia = $controladorLV->buscar($parametros);

	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Fecha de ingreso:   ' . $_POST['ing'] . '      Por antigüedad corresponden  ' . $_POST['d'] . '  días corridos. Tiene ' . $licencia['pendientes'] . ' días pendientes.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'A tomar:  7 / 14 / 21 / 28 / 35  días.	Desde el día:  ____/____/____  hasta el día:  ____/____/____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(3);
	$pdf->SetFont('helvetica', 'B', 6);
	$pdf->Cell(0, 15, '                        (tachar lo que no corresponda)', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Deja  ______  días pendientes, a tomar en fecha a confirmar.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(12);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Firma del empleado                 ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'INFORME DE LA OFICINA DE PERSONAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'La licencia anterior, fue tomada:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(6);
	$pdf->SetFont('helvetica', '', 8);

	//Se realiza la busqueda de los pedido de vacaciones anteriores del empleado
	$parametros = array("idpedidovacaciones" => $_POST['idpv'], "legajo" => $_POST['leg']);
	$controlador = new ControladorPedidoVacaciones($parametros);
	$arrayPV = $controlador->buscar($parametros);
	$contador = 0;

	foreach ($arrayPV as $clave) {
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

	//Se busca la seccion a la que pertenece el empleado, para agregar al titulo del encargado del area
	$parametros = array("legajo" => $_POST['leg']);
	$controlador = new ControladorEmpleado($parametros);
	$empleado = $controlador->buscar($parametros);

	$pdf->Cell(0, 15, 'RESOLUCIÓN DE ENCARGADO DEL AREA DE ' . $empleado['seccion'], 0, false, 'L', 0, '', 0, false, 'M', 'M');

	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'SI - NO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, '                , se acuerda la licencia solicitada, previa notificación del solicitante.-', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Encargado                   ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->writeHTML('<hr/>', true, false, true, false, '');
	$pdf->Ln(2);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'ACTUALIZACIÓN DE DATOS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, '(obligatorio, aunque no se hayan producido cambios)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Domicilio:____________________________________________________________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'Localidad:____________________________________  Código postal:____________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'Teléfono fijo:__________________________________  Teléfono celular:_______________________', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	
	$pdf->writeHTML('
		<table cellpadding="10" border="1">
			<tr border="hidden">
				<td>
					<p align="left">PARA PERCIBIR EL PLUS DE VACACIONES ANUALES, DEBERA PRESENTAR EN TIEMPO Y FORMA LA NOTIFICACION A TAL FIN.</p>
				</td>
			</tr>
		</table>
		', true, false, true, false, '');

}//Fin formulario licencia anual

//Si tiene el rango de fechas se imprime el formulario completo 
if($_POST['formulariopedidovacaciones'] == "completo") {
	$pdf->SetFont('helvetica', 'BU', 14);
	$pdf->Cell(0, 15, 'LICENCIA ANUAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(5);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->Cell(0, 15, 'Form. Nº ' . $_POST['idpv'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(5);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'PERIODO: ' . $_POST['a'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Apellido y nombres: ' . '                                                                       Legajo: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, '                           ' . $_POST['ap'] . ', ' . $_POST['nom'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15,'                                                                                                  ' . $_POST['leg'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Fecha de ingreso:   ' . $_POST['ing'] . '      Por antigüedad corresponden  ' . $_POST['d'] . '  días corridos. Tiene  ' . $_POST['p'] . '  días pendientes', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'A tomar  '. $_POST['cd'] .'  días.	Desde el:  '. $_POST['des'] .'  hasta el dia:  ' . $_POST['has'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	
	$pdf->Cell(0, 15, 'Deja '. $_POST['p'] .' días pendientes, a tomar en fecha a confirmar.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Firma del empleado                 ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'INFORME DE LA OFICINA DE PERSONAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'La licencia anterior, fue tomada:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 8);

	//Se realiza la busqueda de los pedido de vacaciones anteriores del empleado
	$parametros = array("idpedidovacaciones" => $_POST['idpv'], "legajo" => $_POST['leg']);
	$controlador = new ControladorPedidoVacaciones($parametros);
	$arrayPV = $controlador->buscar($parametros);
	$contador = 0;

	foreach ($arrayPV as $clave) {
		if($contador < 2 && $clave['desde'] != null && $clave['hasta'] != null){
			//Se imprimiran hasta dos pedidos de vacaciones anteriores
			$pdf->Cell(0, 15, 'Desde el día: ' . date("d/m/Y", strtotime($clave[8])) . '     hasta el día: ' . date("d/m/Y", strtotime($clave[9])) . '    Licencia: ' . $clave[7], 0, false, 'L', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(8);
		}
		$contador++;
	}

	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(0, 15, '* * * ARCHÍVESE EN EL LEGAJO PERSONAL * * *', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(15);
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
	
	//Se busca la seccion a la que pertenece el empleado, para agregar al titulo del encargado del area
	$parametros = array("legajo" => $_POST['leg']);
	$controlador = new ControladorEmpleado($parametros);
	$empleado = $controlador->buscar($parametros);
	//print_r($empleado);

	$pdf->Cell(0, 15, 'RESOLUCIÓN DE ENCARGADO DEL AREA DE ' . $empleado['seccion'], 0, false, 'L', 0, '', 0, false, 'M', 'M');

	$pdf->Ln(8);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'SI - NO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, '                , se acuerda la licencia solicitada, previa notificación del solicitante.-', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Encargado                   ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 10);
	
	$pdf->writeHTML('
		<table cellpadding="10" border="1">
			<tr border="hidden">
				<td>
					<p align="left">PARA PERCIBIR EL PLUS DE VACACIONES ANUALES, DEBERA PRESENTAR EN TIEMPO Y FORMA LA NOTIFICACION A TAL FIN.</p>
				</td>
			</tr>
		</table>
		', true, false, true, false, '');
}

//Se cierra y se exporta el archivo PDF
$pdf->Output('SolicitudLicenciaAnual' . $_POST['ap'] . $_POST['nom'] . '.pdf', 'I');