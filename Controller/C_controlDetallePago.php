<?php
	require_once '../Model/M_controlDetallePago.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$detallePago = new DetallePago();

	switch ($action) {
		case "Save":
			$newDetalle = $detallePago->newDetalle($_POST['empleado_id'], $_POST['sueldo_ordinario'], $_POST['bonificacion_ley'], $_POST['bonificacion_incentivo'], $_POST['igss'], $_POST['isr']);

			echo json_encode($newDetalle);

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
			$showRegister = $empleados->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['id'],
				"nombres" => $mostrarDatos['nombres'],
				"apellidos" => $mostrarDatos['apellidos'],
				"ctaBancaria" => $mostrarDatos['ctaBancaria'],
				"fecha_ingreso_empleado" => $mostrarDatos['fecha_ingreso_empleado'],
				"agencia" => $mostrarDatos['agencia'],
				"cargo" => $mostrarDatos['cargo'],
				"estado_planilla" => $mostrarDatos['estado_planilla'],
				"observaciones" => $mostrarDatos['observaciones'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $empleados->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$delete = $empleados->deleteRegister($_POST['id']);

			echo json_encode($delete);
			break;
		default:
			$showAll = $empleados->selectAll();

			$datos = [];

			while ($mostrarDatos = $showAll->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"nombres" => $mostrarDatos['nombres'],
					"apellidos" => $mostrarDatos['apellidos'],
					"ctaBancaria" => $mostrarDatos['ctaBancaria'],
					"fecha_ingreso_empleado" => $mostrarDatos['fecha_ingreso_empleado'],
					"agencia" => $mostrarDatos['agencia'],
					"cargo" => $mostrarDatos['cargo'],
					"estado_planilla" => $mostrarDatos['estado_planilla'],
					"observaciones" => $mostrarDatos['observaciones'],
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			 }
			echo json_encode($datos);
			break;
	} 