<?php
	require_once '../Model/M_controlGastos.php';
	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$controlGastos = new ControlGastos();
	switch ($action) {
		case "Save":
			if (empty($_POST['noManifiesto']) || empty($_POST['fechaManifiesto']) || empty($_POST['costoGasto']) || empty($_POST['descripcionGasto']) || empty($_POST['agenciaGasto'])) {
					echo json_encode("vacio");
			}else {
				$guardar = $controlGastos->saveGastos($_POST);

				echo json_encode($guardar);
			}
			break;
		case "ShowRegister":
			$showRegister = $controlGastos->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['id'],
				"noManifiesto" => $mostrarDatos['noManifiesto'],
				"fechaManifiesto" => $mostrarDatos['fechaManifiesto'],
				"costoGasto" => $mostrarDatos['costoGasto'],
				"descripcionGasto" => $mostrarDatos['descripcionGasto'],
				"agenciaGasto" => $mostrarDatos['agenciaGasto'],
				"rutaAgenciaGasto" => $mostrarDatos['rutaAgenciaGasto'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $controlGastos->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$update = $controlGastos->deleteRegister($_POST);

			echo json_encode($update);
			break;
		default:
			$showAllBoletas = $controlGastos->showAllGastos();

			$datos = [];

			while ($mostrarDatos = $showAllBoletas->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noManifiesto" => $mostrarDatos['noManifiesto'],
					"fechaManifiesto" => $mostrarDatos['fechaManifiesto'],
					"costoGasto" => $mostrarDatos['costoGasto'],
					"descripcionGasto" => $mostrarDatos['descripcionGasto'],
					"agenciaGasto" => $mostrarDatos['agenciaGasto'],
					"rutaAgenciaGasto" => $mostrarDatos['rutaAgenciaGasto'],
					"fechaIngreso" => $mostrarDatos['fechaIngreso'],
					"fechaModificacion" => $mostrarDatos['fechaModificacion'],
					"usuarioIngresa" => $mostrarDatos['usuarioIngresa'],
					"usuarioModifica" => $mostrarDatos['usuarioModifica'],
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			}

			echo json_encode($datos);
			break;
	}
?>