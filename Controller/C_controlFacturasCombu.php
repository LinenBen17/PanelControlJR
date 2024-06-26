<?php
	require_once '../Model/M_controlFacturasCombu.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$facturasCombustible = new FacturasCombustible();

	switch ($action) {
		case "Save":
			$newFactura = $facturasCombustible->newFactura($_POST['placa'], $_POST['piloto'], $_POST['ruta'], $_POST['fecha'], $_POST['fechaVale'], $_POST['serie'], $_POST['noFactura'], $_POST['monto_total'], $_POST['galones'], $_POST['tipoCombustible'], $_POST['precio_galon']);

			echo json_encode($newFactura);

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
		case "SelectAllUser":
			$selectAllByUser = $facturasCombustible->selectAllByUser();

			$datos = [];

			while ($mostrarDatos = $selectAllByUser->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"fecha" => $mostrarDatos['fecha'],
					"fechaVale" => $mostrarDatos['fechaVale'],
					"placa" => $mostrarDatos['placa'],
					"piloto" => $mostrarDatos['piloto'],
					"ruta" => $mostrarDatos['ruta'],
					"serie" => $mostrarDatos['serie'],
					"noFactura" => $mostrarDatos['noFactura'],
					"galones" => $mostrarDatos['galones'],
					"tipoCombustible" => $mostrarDatos['tipoCombustible'],
					"precio_galon" => $mostrarDatos['precio_galon'],
					"monto_total" => $mostrarDatos['monto_total'],
				];
			}

			echo json_encode($datos);
			break;
		default:
			$showAllCE = $facturasCombustible->selectAll();

			$datos = [];

			while ($mostrarDatos = $showAllCE->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"fecha" => $mostrarDatos['fecha'],
					"fechaVale" => $mostrarDatos['fechaVale'],
					"placa" => $mostrarDatos['placa'],
					"piloto" => $mostrarDatos['piloto'],
					"ruta" => $mostrarDatos['ruta'],
					"serie" => $mostrarDatos['serie'],
					"noFactura" => $mostrarDatos['noFactura'],
					"galones" => $mostrarDatos['galones'],
					"tipoCombustible" => $mostrarDatos['tipoCombustible'],
					"precio_galon" => $mostrarDatos['precio_galon'],
					"monto_total" => $mostrarDatos['monto_total'],
					"fecha_creacion" => $mostrarDatos['fecha_creacion'],
					"usuario_ingresa" => $mostrarDatos['usuario_ingresa'],
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			}

			echo json_encode($datos);
			break;
	}