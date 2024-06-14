<?php
	require_once '../Model/M_controlEmpleados.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$empleados = new Empleados();

	switch ($action) {
		case "Save":
			$newEmpleado = $empleados->newEmpleado($_POST['nombres'], $_POST['apellidos'], $_POST['ctaBancaria'], $_POST['fechaIngreso'], $_POST['agencia'], $_POST['cargo'], $_POST['estadoPlanilla'], $_POST['observaciones']);

			echo json_encode($newEmpleado);

			break;
		case "ShowRegister":
			$showRegister = $facturasCombustible->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['id'],
				"placa" => $mostrarDatos['placa'],
				"piloto" => $mostrarDatos['piloto'],
				"ruta" => $mostrarDatos['ruta'],
				"fechaVale" => $mostrarDatos['fechaVale'],
				"serie" => $mostrarDatos['serie'],
				"noFactura" => $mostrarDatos['noFactura'],
				"fecha" => $mostrarDatos['fecha'],
				"tipoCombustible" => $mostrarDatos['tipoCombustible'],
				"monto_total" => $mostrarDatos['monto_total'],
				"galones" => $mostrarDatos['galones'],
				"precio_galon" => $mostrarDatos['precio_galon'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $facturasCombustible->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$delete = $facturasCombustible->deleteRegister($_POST['id']);

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
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"agencia" => $mostrarDatos['agencia'],
					"cargo" => $mostrarDatos['cargo'],
					"estadoPlanilla" => $mostrarDatos['estadoPlanilla'],
					"observaciones" => $mostrarDatos['observaciones'],
					"fecha_ingreso" => $mostrarDatos['fecha_ingreso'],
					"fecha_modificacion" => $mostrarDatos['fecha_modificacion'],
					"usuario_ingresa" => $mostrarDatos['usuario_ingresa'],
					"usuario_modifica" => $mostrarDatos['usuario_modifica'],
				];
			 }

			echo json_encode($datos);
			break;
	}