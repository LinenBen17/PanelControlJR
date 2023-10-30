<?php
	require_once '../Model/M_controlBoletas.php';
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$controlBoletas = new ControlBoletas();

	switch ($action) {
		case "Guardar":
			$guardar = $controlBoletas->guardar($_POST['noManifiesto'], $_POST['noBoleta'], $_POST['tipoBoleta']);

			echo json_encode($guardar);
			break;
		
		default:
			$showAllBoletas = $controlBoletas->showAllBoletas();

			$datos = [];

			while ($mostrarDatos = $showAllBoletas->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noManifiesto" => $mostrarDatos['noManifiesto'],
					"noBoleta" => $mostrarDatos['noBoleta'],
					"tipoBoleta" => $mostrarDatos['tipoBoleta'],
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"fechaModificacion" => $mostrarDatos['fechaModificacion'],
					"usuarioIngresa" => $mostrarDatos['usuarioIngresa'],
				];
			}

			echo json_encode($datos);
			break;
	}
?>