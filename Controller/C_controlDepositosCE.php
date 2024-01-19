<?php
	require_once '../Model/M_controlDepositosCE.php';
	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$controlDepositos = new ControlDepositos();
	switch ($action) {
		case "Save":
			if (empty($_POST['noManifiesto']) || empty($_POST['fechaManifiesto']) || empty($_POST['noContraEntrega']) || empty($_POST['noGuia']) || empty($_POST['noBoleta']) || empty($_POST['valorBoleta']) || empty($_POST['fechaBoleta']) || empty($_POST['noCuenta']) || empty($_POST['nombreCuenta'])) {
					echo json_encode(["vacio", $_POST]);
			}else {
				$guardar = $controlDepositos->saveDeposito($_POST);

				echo json_encode($guardar);
			}
			break;
		case "BoletasUsuario":
			$showDepositoUser = $controlDepositos->showDepositoUser();

			$datos = [];

			while ($mostrarDatos = $showDepositoUser->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noManifiesto" => $mostrarDatos['noManifiesto'],
					"fechaManifiesto" => $mostrarDatos['fechaManifiesto'],
					"noContraEntrega" => $mostrarDatos['noContraEntrega'],
					"noGuia" => $mostrarDatos['noGuia'],
					"noBoleta" => $mostrarDatos['noBoleta'],
					"fechaBoleta" => $mostrarDatos['fechaBoleta'],
					"noCuenta" => $mostrarDatos['noCuenta'],
					"nombreCuenta" => $mostrarDatos['nombreCuenta'],
				];
			}

			echo json_encode($datos);
			break;
		case "ShowRegister":
			$showRegister = $controlDepositos->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['id'],
				"noManifiesto" => $mostrarDatos['noManifiesto'],
				"fechaManifiesto" => $mostrarDatos['fechaManifiesto'],
				"noContraEntrega" => $mostrarDatos['noContraEntrega'],
				"noGuia" => $mostrarDatos['noGuia'],
				"noBoleta" => $mostrarDatos['noBoleta'],
				"valorBoleta" => $mostrarDatos['valorBoleta'],
				"fechaBoleta" => $mostrarDatos['fechaBoleta'],
				"noCuenta" => $mostrarDatos['noCuenta'],
				"nombreCuenta" => $mostrarDatos['nombreCuenta'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $controlDepositos->update($_POST);

			echo json_encode($update);
			break;
		default:
			$showAllCE = $controlDepositos->showAllCE();

			$datos = [];

			while ($mostrarDatos = $showAllCE->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noManifiesto" => $mostrarDatos['noManifiesto'],
					"fechaManifiesto" => $mostrarDatos['fechaManifiesto'],
					"noContraEntrega" => $mostrarDatos['noContraEntrega'],
					"noGuia" => $mostrarDatos['noGuia'],
					"noBoleta" => $mostrarDatos['noBoleta'],
					"valorBoleta" => $mostrarDatos['valorBoleta'],
					"fechaBoleta" => $mostrarDatos['fechaBoleta'],
					"noCuenta" => $mostrarDatos['noCuenta'],
					"nombreCuenta" => $mostrarDatos['nombreCuenta'],
					"usuarioIngresa" => $mostrarDatos['usuarioIngresa'],
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"usuarioModifica" => $mostrarDatos['usuarioModifica'],
					"fechaModificacion" => $mostrarDatos['fechaModificacion'],
					"estado" => "<input type='checkbox' value='" . $mostrarDatos['estado'] . "' " . ($mostrarDatos["estado"] == 1 ? 'checked' : ' ') . ">",
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			}

			echo json_encode($datos);
			break;
	}
?>