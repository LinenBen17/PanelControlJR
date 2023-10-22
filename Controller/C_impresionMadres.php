<?php
	require_once '../Model/M_impresionMadres.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$impresionMadre = new ImpresionMadres();

	switch ($action) {
		case "search":
			$searchGuia = $impresionMadre->searchGuia($_POST['codigo']);

			echo json_encode($searchGuia);

			break;
		case "save":
			$newGuia = $impresionMadre->newGuia($_POST['codigo'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['destino'], $_POST['contacto']);

			header("location: ../View/impresionMadres.php");
			break;
	}
?>