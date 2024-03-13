<?php
	require_once '../Model/M_controlFacturasCombu.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$facturasCombustible = new FacturasCombustible();

	switch ($action) {
		case "Save":
			$newFactura = $facturasCombustible->newFactura($_POST['placa'], $_POST['piloto'], $_POST['ruta'], $_POST['fecha'], $_POST['fechaVale'], $_POST['serie'], $_POST['noFactura'], $_POST['monto_total'], $_POST['galones'], $_POST['tipoCombustible'], $_POST['precio_galon']);

			echo json_encode($newFactura);

			break;
		default:
			$showAllCE = $facturasCombustible->selectAllByUser();

			$datos = [];

			while ($mostrarDatos = $showAllCE->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"placa" => $mostrarDatos['placa'],
					"piloto" => $mostrarDatos['piloto'],
					"ruta" => $mostrarDatos['ruta'],
					"fecha" => $mostrarDatos['fecha'],
					"serie" => $mostrarDatos['serie'],
					"noFactura" => $mostrarDatos['noFactura'],
					"monto_total" => $mostrarDatos['monto_total'],
					"galones" => $mostrarDatos['galones'],
					"precio_galon" => $mostrarDatos['precio_galon'],
				];
			}

			echo json_encode($datos);
			break;
	}