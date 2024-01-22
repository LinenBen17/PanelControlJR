<?php 
	require_once '../Model/M_controlDepositosCE.php';
	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$controlDepositos = new ControlDepositos();
	switch ($action) {
		case "Save":
			if (empty($_POST['noManifiesto']) || empty($_POST['fechaManifiesto']) || empty($_POST['noContraEntrega']) || empty($_POST['noGuia']) || empty($_POST['noBoleta']) || empty($_POST['valorBoleta']) || empty($_POST['fechaBoleta']) || empty($_POST['noCuenta']) || empty($_POST['nombreCuenta']) || empty($_POST['telefonoCE']) || empty($_FILES['file']['name'])) {
					echo json_encode(["vacio"]);
			}else {
				$guardar = $controlDepositos->saveDeposito($_POST, $_FILES);

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
		case "changeStatus":
			$changeStatus = $controlDepositos->changeStatus($_POST);

			echo json_encode($changeStatus);
			break;
		case "Delete":
			$delete = $controlDepositos->deleteRegister($_POST["id"]);

			echo json_encode($delete);
			break;
		default:
			$showAllCE = $controlDepositos->showAllCE();

			$datos = [];

			function find_file($dir, $pattern){
			    $dirs = glob($dir . '/*', GLOB_ONLYDIR);
			    $files = glob($dir . '/' . $pattern);
			    
			    foreach($dirs as $subdir){
			        $files = array_merge($files, find_file($subdir, $pattern));
			    }
			    
			    return $files;
			}

			while ($mostrarDatos = $showAllCE->fetch_array()) {
				$dir =  dirname(__DIR__) . "/uploads/images/"; // Establecer el directorio inicial
				$pattern = $mostrarDatos['imagenBoleta']; // Establecer el patrón del archivo que desea buscar

				$results = find_file($dir, $pattern);

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
					"telefonoCE" => $mostrarDatos['telefonoCE'],
					"usuarioIngresa" => $mostrarDatos['usuarioIngresa'],
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"usuarioModifica" => $mostrarDatos['usuarioModifica'],
					"fechaModificacion" => $mostrarDatos['fechaModificacion'],
					"estado" => "<label class='switch'><input type='checkbox' class='statusCheck' value='" . $mostrarDatos['estado'] . "' " . ($mostrarDatos["estado"] == 1 ? 'checked' : ' ') . " id='" . $mostrarDatos['id'] ."'><span class='slider round'></span></label>",
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			}

			echo json_encode($datos);
			break;
	}
?>