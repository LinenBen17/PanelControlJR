<?php
require_once '../Public/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
		case "Print":
		    // Realiza la validación
			function validarFechasQuincenales($fechaInicio, $fechaFin) {
			    $primerDiaMes = date('Y-m-01', strtotime($fechaInicio)); // Primer día del mes de la fecha inicio
			    $ultimoDiaMes = date('Y-m-t', strtotime($fechaInicio)); // Último día del mes de la fecha inicio
			    
			    // Validar quincena del 1 al 15
			    $esQuincena1 = ($fechaInicio == $primerDiaMes && $fechaFin == date('Y-m-15', strtotime($fechaInicio)));
			    
			    // Validar quincena del 16 al fin de mes
			    $esQuincena2 = ($fechaInicio == date('Y-m-16', strtotime($fechaInicio)) && $fechaFin == $ultimoDiaMes);
			    
			    return $esQuincena1 || $esQuincena2;
			}

		    $valid = validarFechasQuincenales($_POST['fechaInicial'], $_POST['fechaFinal']); // Cambia esto a tu lógica de validación
		    $errorMessage = "La validación falló."; // Mensaje de error personalizado

		    if (!$valid) {
		        // Si la validación falla, envía una respuesta JSON con el error
		        header('Content-Type: application/json');
		        echo json_encode([
		            'success' => false,
		        ]);
		        exit;
		    }

		    if ($_POST['tipo_reporte'] == 'Planilla') {
		    	// Si la validación pasa, continúa con la generación del PDF
			    $params = http_build_query($_POST);
			    $url = "http://localhost/PanelControlJR/Public/reportes/planilla.php?" . $params;

			    $html = file_get_contents($url);

			    $options = $dompdf->getOptions();
			    $options->set(array('isRemoteEnabled' => true));
			    $dompdf->setOptions($options);

			    $dompdf->loadHTML($html);

			    $dompdf->setPaper('legal', 'landscape');

			    $dompdf->render();

			    header('Content-Type: application/pdf');
			    header('Content-Disposition: inline; filename="planilla.pdf"');

			    echo $dompdf->output();
		    }else if ($_POST['tipo_reporte'] == 'BolPago') {
		    	// Si la validación pasa, continúa con la generación del PDF
			    $params = http_build_query($_POST);
			    $url = "http://localhost/PanelControlJR/Public/reportes/boletaPago.php?" . $params;

			    $html = file_get_contents($url);

			    $options = $dompdf->getOptions();
			    $options->set(array('isRemoteEnabled' => true));
			    $dompdf->setOptions($options);

			    $dompdf->loadHTML($html);

			    $dompdf->setPaper('A4', 'portrait');

			    $dompdf->render();

			    header('Content-Type: application/pdf');
			    header('Content-Disposition: inline; filename="boletaPago.pdf"');

			    echo $dompdf->output();
		    }
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