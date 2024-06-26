<?php
	require_once '../Model/M_controlEmpleados.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$empleados = new Empleados();

	switch ($action) {
		case "Save":
			$newEmpleado = $empleados->newEmpleado($_POST['nombres'], $_POST['apellidos'], $_POST['ctaBancaria'], $_POST['fecha_ingreso_empleado'], $_POST['agencia'], $_POST['cargo'], $_POST['estado_planilla'], $_POST['observaciones']);

			echo json_encode($newEmpleado);

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