<?php
require_once '../Public/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
	    case "Print":

	        // Construir la URL con los parámetros de datosForm
	        $params = http_build_query($_POST);
	        $url = "http://localhost/PanelControlJR/Public/reportes/planilla.php?" . $params;

	        // Cargar el contenido HTML
	        $html = file_get_contents($url);

	        // Configurar las opciones de Dompdf
	        $options = $dompdf->getOptions();
	        $options->set(array('isRemoteEnabled' => true));
	        $dompdf->setOptions($options);

	        // Cargar el HTML en Dompdf
	        $dompdf->loadHTML($html);

	        // Configurar el tamaño y la orientación del papel
	        $dompdf->setPaper('legal', 'landscape');

	        // Renderizar el PDF
	        $dompdf->render();

	        // Enviar los encabezados HTTP adecuados para la respuesta PDF
	        header('Content-Type: application/pdf');
	        header('Content-Disposition: inline; filename="a.pdf"');

	        // Enviar el PDF al navegador
	        echo $dompdf->output();
	    break;
		case "ShowEmpleados":
			$selectAllEmpleados = $descuentos->selectAllEmpleados();

			$datos = [];

			while ($mostrarDatos = $selectAllEmpleados->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"nombres" => $mostrarDatos['nombres'],
					"apellidos" => $mostrarDatos['apellidos'],
					"cargo" => $mostrarDatos['cargo'],
					"estado_planilla" => $mostrarDatos['estado_planilla'] == 1 ? "En Planilla" : "Fuera de Planilla",
				];
			 }
			echo json_encode($datos);
			break;
		case "ShowRegister":
			$showRegister = $descuentos->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['descuentos_id'],
				"empleado_id" => $mostrarDatos['empleadoId'],
				"fecha_descuento" => $mostrarDatos['fecha_descuento'],
				"tipo_descuento" => $mostrarDatos['tipo_descuento'],
				"monto" => $mostrarDatos['monto'],
				"observaciones" => $mostrarDatos['observaciones'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $descuentos->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$delete = $descuentos->deleteRegister($_POST['id']);

			echo json_encode($delete);
			break;
		default:
			$selectAllDescuentos = $descuentos->selectAllDescuentos();

			$datos = [];

			while ($mostrarDatos = $selectAllDescuentos->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['descuentos_id'],
					"empleado_id" => $mostrarDatos['empleadoId'],
					"empleado" => $mostrarDatos['nombres'] . " " . $mostrarDatos['apellidos'],
					"fecha_descuento" => $mostrarDatos['fecha_descuento'],
					"tipo_descuento" => $mostrarDatos['tipo_descuento'],
					"monto" => $mostrarDatos['monto'],
					"observaciones" => $mostrarDatos['observaciones'],
					"editar" => '<a href="#" id="' . $mostrarDatos['descuentos_id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['descuentos_id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			 }
			echo json_encode($datos);
			break;
	} 