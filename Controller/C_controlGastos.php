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
	}
?>