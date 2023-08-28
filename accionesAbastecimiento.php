<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'conexion.php';

	session_start();

	require 'validacionSesion.php';

	if ($_POST) {
		date_default_timezone_set('America/Guatemala');
		$fechaActual = date("d/m/Y");
		$accion = $_POST['accion'];


		switch ($accion) {
			case "Save":
				try {
					$sqlSave = "INSERT INTO `abastecimiento`(`id`, `placa`, `piloto`, `ruta`, `km_inicial`, `km_final`, `monto_total`, `galones`, `precio_galon`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";

					$sentenciaSave = $mysqli->prepare($sqlSave);
					$sentenciaSave->bind_param("sssiiiiiss", $_POST['placa'], $_POST['piloto'], $_POST['ruta'], $_POST['km_inicial'], $_POST['km_final'], $_POST['monto_total'], $_POST['galones'], $_POST['precio_galon'], $fechaActual, $fechaActual);
					$sentenciaSave->execute();

					echo json_encode(["accion" => "Saved"]);
					$sentenciaSave->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Search":
				//BUSCAR POR PLACA
				try {
					$sqlSeach = "SELECT * FROM ruta WHERE placa = ? LIMIT 1";

					$sentenciaSearch = $mysqli->prepare($sqlSeach);
					$sentenciaSearch->bind_param("s", $_POST['placa']);
					$sentenciaSearch->execute();
					$result = $sentenciaSearch->get_result();
					$mostrarDatos = $result->fetch_assoc();

					echo json_encode([
						"piloto" => $mostrarDatos["piloto"],
						"ruta" => $mostrarDatos["ruta"],
					]);
					$sentenciaSearch->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;

		}
	}
?>