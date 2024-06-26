<?php
	require_once '../Model/M_controlDescuentos.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$descuentos = new Descuentos();

	switch ($action) {
		case "Save":
			$newDescuento = $descuentos->newDescuento($_POST['empleado_id'], $_POST['fecha_descuento'], $_POST['tipo_descuento'], $_POST['monto'], $_POST['observaciones']);

			echo json_encode($newDescuento);

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