<?php
//Se llama a la libreria de tcpdf
require_once ('../../js/pdf/TCPDF-master/tcpdf_import.php');
require_once '../controladoresEspecificos/ControladorPedidoVacaciones.php';
require_once '../controladoresEspecificos/ControladorLicenciaVacaciones.php';
require_once '../controladoresEspecificos/ControladorSeccion.php';
require_once '../controladoresEspecificos/ControladorEmpleado.php';
require_once '../controladoresEspecificos/ControladorSesion.php';

$sesion = new ControladorSesion();

if ($sesion->verificar()){



$parametros = array("idseccion" => $_POST['seccion']);
$cSeccion = new ControladorSeccion($parametros);
$seccion = $cSeccion->buscar($parametros);

$parametros = array("tabla" => "empleado", "criterio" => "idseccion", "idseccion" => $_POST['seccion'], "anio" => $_POST['licencia']);
$clv = new ControladorLicenciaVacaciones($parametros);
$arrayLicencias = $clv->buscarLicencias($parametros);

$cpv = new ControladorPedidoVacaciones($parametros);
$arrayPV = array();
foreach ($arrayLicencias as $licencia) {
	$licencia['fecha'] = $_POST['fecha'];
	$parametros = array("legajo" => $licencia['legajo'], "licencia" => $licencia['anio'], "fecha" => $licencia['fecha']);
	$resultado = $cpv->agregar($parametros);
	array_push($arrayPV, $resultado);
}

//Se crea el documento
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//Se establece el contenido de la cabecera
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CONTROL LICENCIA');
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

foreach ($arrayPV as $fila) {
 
	$pdf->AddPage();
	$pdf->SetFont('helvetica', 'B', 16);
	$logo = K_PATH_IMAGES.'logo_example.png';
	$pdf->Image($logo, 10, 10, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false, false, false);
	$pdf->Cell(0, 9, 'CONTROL LICENCIA', 0, false, 'C', false, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->SetFont('helvetica', 'BU', 14);
	$pdf->Cell(0, 15, 'LICENCIA ANUAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(5);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->Cell(0, 15, 'Form. Nº ' . $fila[0]['idpedidovacaciones'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(5);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, 'PERIODO: ' . $fila[0]['anio'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Apellido y nombres: ' . '                                                                      		 Legajo: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->Cell(0, 15, '                           ' . $fila[0]['apellido'] . ', ' . $fila[0]['nombre'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(0);
	$pdf->Cell(0, 15,'		                                                                                                  ' . $fila[0]['legajo'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Fecha de ingreso:   ' . date("d/m/Y", strtotime($fila[0]['ingreso'])) . '      Por antigüedad corresponden  ' . $fila[0]['dias'] . '  días corridos. Tiene  ' . $fila[0]['pendientes'] . '  días pendientes.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->Cell(0, 15, 'A tomar:  7 / 14 / 21 / 28 / 35  dias.	Desde el día:  ____/____/____  hasta el día:  ____/____/____', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(3);
	$pdf->SetFont('helvetica', 'B', 6);
	$pdf->Cell(0, 15, '                        (tachar lo que no corresponda)', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 15, 'Deja  ______  días pendientes, a tomar en fecha a confirmar.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(10);
	$pdf->Cell(0, 15, '____________________________', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(4);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'Firma del empleado                 ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->writeHTML('<hr/>', true, false, true, false, '');
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(0, 15, 'INFORME DE LA OFICINA DE PERSONAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(0, 15, 'La licencia anterior, fue tomada:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
	$pdf->Ln(8);
	$pdf->SetFont('helvetica', '', 8);

	//Se realiza la busqueda de los pedido de vacaciones anteriores del empleado
	$parametros = array("idpedidovacaciones" => $fila[0]['idpedidovacaciones'], "legajo" => $fila[0]['legajo']);
	//print_r($parametros);
	$controlador = new ControladorPedidoVacaciones($parametros);
	$arrayPedidos = $controlador->buscar($parametros);
	$contador = 0;
	//print_r($arrayPedidos);

	foreach ($arrayPedidos as $clave) {
		if($contador < 2 && $clave['desde'] != null && $clave['hasta'] != null){
			//Se imprimiran hasta dos pedidos de vacaciones anteriores
			$pdf->Cell(0, 15, 'Desde el día: ' . date("d/m/Y", strtotime($clave['desde'])) . '     hasta el día: ' . date("d/m/Y", strtotime($clave['hasta'])) . '    Licencia: ' . $clave[7], 0, false, 'L', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(8);
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
	$parametros = array("legajo" => $fila[0]['legajo']);
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
			<tr border="left">
				<td>
					<p align="left">PARA PERCIBIR EL PLUS DE VACACIONES ANUALES, DEBERA PRESENTAR EN TIEMPO Y FORMA LA NOTIFICACION A TAL FIN.</p>
				</td>
			</tr>
		</table>
		', true, false, true, false, '');
}

//Se cierra y se exporta el archivo PDF
$pdf->Output('SolicitudLicenciaAnual_' . $seccion['nombre'] . '_' . $_POST['licencia'] . '.pdf', 'D');

} else {
	echo '<form action="../ruteador/CerrarSesion.php" method="POST">
			  <h3>Debe iniciar sesion</h3><button type="submit" class="btn btn-primary">Ir a inicio</button>
          </form>';
}