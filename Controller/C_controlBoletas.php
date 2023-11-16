<?php
	require_once '../Model/M_controlBoletas.php';
	$action = isset($_POST['action']) ? $_POST['action'] : ''; 

	$controlBoletas = new ControlBoletas();
	switch ($action) {
		case "Guardar":
			if (empty($_POST['noManifiesto']) || empty($_POST['noBoleta']) || empty($_POST['tipoBoleta']) || empty($_POST['fechaBoleta']) || empty($_POST['valorBoleta']) || empty($_POST['agenciaBoleta']) || empty($_POST['bancoBoleta']) || empty($_POST['fechaManifiesto'])) {
					echo json_encode("vacio");
			}else {
				$guardar = $controlBoletas->guardar($_POST);

				echo json_encode($guardar);
			}
			break;
		case "BoletasUsuario":
			$showAllBoletas = $controlBoletas->showBoletasByUser();

			$datos = [];

			while ($mostrarDatos = $showAllBoletas->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noManifiesto" => $mostrarDatos['noManifiesto'],
					"noBoleta" => $mostrarDatos['noBoleta'],
					"tipoBoleta" => $mostrarDatos['tipoBoleta'],
					"valorBoleta" => $mostrarDatos['valorBoleta'],
					"bancoBoleta" => $mostrarDatos['bancoBoleta'],
					"fechaBoleta" => $mostrarDatos['fechaBoleta'],
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"usuarioIngresa" => $mostrarDatos['usuarioIngresa'],
					"lugarDeposito" => $mostrarDatos['lugarDeposito'],
				];
			}

			echo json_encode($datos);
			break;
		default:
			$showAllBoletas = $controlBoletas->showAllBoletas();

			$datos = [];

			while ($mostrarDatos = $showAllBoletas->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noManifiesto" => $mostrarDatos['noManifiesto'],
					"fechaManifiesto" => $mostrarDatos['fechaManifiesto'],
					"noBoleta" => $mostrarDatos['noBoleta'],
					"tipoBoleta" => $mostrarDatos['tipoBoleta'],
					"valorBoleta" => $mostrarDatos['valorBoleta'],
					"bancoBoleta" => $mostrarDatos['bancoBoleta'],
					"agenciaBoleta" => $mostrarDatos['agenciaBoleta'],
					"fechaBoleta" => $mostrarDatos['fechaBoleta'],
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"fechaModificacion" => $mostrarDatos['fechaModificacion'],
					"usuarioIngresa" => $mostrarDatos['usuarioIngresa'],
					"lugarDeposito" => $mostrarDatos['lugarDeposito'],
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			}

			echo json_encode($datos);
			break;
	}
?>