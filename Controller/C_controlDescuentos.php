<?php
	require_once '../Model/M_controlDescuentos.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$detallePago = new Descuentos();

	switch ($action) {
		case "Save":
			$newDescuento = $detallePago->newDescuento($_POST['empleado_id'], $_POST['fecha_descuento'], $_POST['tipo_descuento'], $_POST['monto'], $_POST['observaciones']);

			echo json_encode($newDescuento);

			break;
		case "ShowEmpleados":
			$selectAllEmpleados = $detallePago->selectAllEmpleados();

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
			$showRegister = $detallePago->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['detalle_pago_empleado_id'],
				"empleado_id" => $mostrarDatos['empleadoId'],
				"sueldo_ordinario" => $mostrarDatos['sueldo_ordinario'],
				"bonificacion_ley" => $mostrarDatos['bonificacion_ley'],
				"bonificacion_incentivo" => $mostrarDatos['bonificacion_incentivo'],
				"igss" => $mostrarDatos['igss'],
				"isr" => $mostrarDatos['isr'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $detallePago->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$delete = $detallePago->deleteRegister($_POST['id']);

			echo json_encode($delete);
			break;
		default:
			$selectAllDetalle = $detallePago->selectAllDetalle();

			$datos = [];

			while ($mostrarDatos = $selectAllDetalle->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['detalle_pago_empleado_id'],
					"empleado_id" => $mostrarDatos['empleadoId'],
					"empleado" => $mostrarDatos['nombres'] . " " . $mostrarDatos['apellidos'],
					"sueldo_ordinario" => $mostrarDatos['sueldo_ordinario'],
					"bonificacion_ley" => $mostrarDatos['bonificacion_ley'],
					"bonificacion_incentivo" => $mostrarDatos['bonificacion_incentivo'],
					"igss" => $mostrarDatos['igss'],
					"isr" => $mostrarDatos['isr'],
					"editar" => '<a href="#" id="' . $mostrarDatos['detalle_pago_empleado_id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['detalle_pago_empleado_id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			 }
			echo json_encode($datos);
			break;
	} 