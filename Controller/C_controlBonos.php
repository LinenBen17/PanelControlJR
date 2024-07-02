<?php
	require_once '../Model/M_controlBonos.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$bonos = new Bonos();

	switch ($action) {
		case "Save":
			$newBono = $bonos->newBono($_POST['empleado_id'], $_POST['fecha_bono'], $_POST['monto'], $_POST['observaciones']);

			echo json_encode($newBono);

			break;
		case "ShowEmpleados":
			$selectAllEmpleados = $bonos->selectAllEmpleados();

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
			$showRegister = $bonos->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['bonos_id'],
				"empleado_id" => $mostrarDatos['empleadoId'],
				"fecha_bono" => $mostrarDatos['fecha_bono'],
				"monto" => $mostrarDatos['monto'],
				"observaciones" => $mostrarDatos['observaciones'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $bonos->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$delete = $bonos->deleteRegister($_POST['id']);

			echo json_encode($delete);
			break;
		default:
			$selectAllBonos = $bonos->selectAllBonos();

			$datos = [];

			while ($mostrarDatos = $selectAllBonos->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['bonos_id'],
					"empleado_id" => $mostrarDatos['empleadoId'],
					"empleado" => $mostrarDatos['nombres'] . " " . $mostrarDatos['apellidos'],
					"fecha_bono" => $mostrarDatos['fecha_bono'],
					"monto" => $mostrarDatos['monto'],
					"observaciones" => $mostrarDatos['observaciones'],
					"editar" => '<a href="#" id="' . $mostrarDatos['bonos_id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['bonos_id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			 }
			echo json_encode($datos);
			break;
	} 