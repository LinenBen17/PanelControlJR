<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'conexion.php';

	session_start();

	require 'validacionSesion.php';

	if ($_POST) {
		date_default_timezone_set('America/Guatemala');
		$fechaActual = date("Y-m-d");
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
					$sqlSearch = "SELECT * FROM ruta WHERE placa = ? LIMIT 1";

					$sentenciaSearch = $mysqli->prepare($sqlSearch);
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
			case "filtroPorPlaca":
				$sqlFiltroPlaca = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento WHERE placa = ?";

				$sentenciaFiltroPlaca = $mysqli->prepare($sqlFiltroPlaca);
				$sentenciaFiltroPlaca->bind_param("s", $_POST['placaFilter']);
				$sentenciaFiltroPlaca->execute();
				$result = $sentenciaFiltroPlaca->get_result();
				$mostrarDatos = $result->fetch_assoc();

				echo json_encode([
					"fecha_creacion" => $mostrarDatos["fecha_creacionM"],
					"fecha_modificacion" => $mostrarDatos["fecha_modificacionM"],
					"placa" => $mostrarDatos["placa"],
					"piloto" => $mostrarDatos["piloto"],
					"ruta" => $mostrarDatos["ruta"],
					"km_inicial" => $mostrarDatos["km_inicial"],
					"km_final" => $mostrarDatos["km_final"],
					"monto_total" => $mostrarDatos["monto_total"],
					"galones" => $mostrarDatos["galones"],
					"precio_galon" => $mostrarDatos["precio_galon"],
				]);
				break;
			case "filtroPorFecha":
				$fechaInput = $_POST['fechaFilter'];
				$fechaFormateada = date("d/m/Y", strtotime($fechaInput));

				$sqlFiltroFecha = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento WHERE DATE_FORMAT(fecha_creacion, '%d/%m/%Y') = ?";

				$sentenciaFiltroFecha = $mysqli->prepare($sqlFiltroFecha);
				$sentenciaFiltroFecha->bind_param("s", $fechaFormateada);
				$sentenciaFiltroFecha->execute(); 
				$result = $sentenciaFiltroFecha->get_result();

				$datos = [];

				while ($mostrarDatos = $result->fetch_array()) {
					$datos[]= [
						"fecha_creacion" => $mostrarDatos["fecha_creacionM"],
						"fecha_modificacion" => $mostrarDatos["fecha_modificacionM"],
						"placa" => $mostrarDatos["placa"],
						"piloto" => $mostrarDatos["piloto"],
						"ruta" => $mostrarDatos["ruta"],
						"km_inicial" => $mostrarDatos["km_inicial"],
						"km_final" => $mostrarDatos["km_final"],
						"monto_total" => $mostrarDatos["monto_total"],
						"galones" => $mostrarDatos["galones"],
						"precio_galon" => $mostrarDatos["precio_galon"],
					];
				}
				echo json_encode($datos);
				break;
			case "filtroEntreFechas":
				$fechaInicial = date("d/m/Y", strtotime($_POST['fechaInicial']));
				$fechaFinal = date("d/m/Y", strtotime($_POST['fechaFinal']));

				$sqlFiltroFecha = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento WHERE DATE_FORMAT(fecha_creacion, '%d/%m/%Y') >= ? AND DATE_FORMAT(fecha_creacion, '%d/%m/%Y') <= ?";

				$sentenciaFiltroFecha = $mysqli->prepare($sqlFiltroFecha);
				$sentenciaFiltroFecha->bind_param("ss", $fechaInicial, $fechaFinal);
				$sentenciaFiltroFecha->execute(); 
				$result = $sentenciaFiltroFecha->get_result();

				$datos = [];

				while ($mostrarDatos = $result->fetch_array()) {
					$datos[]= [
						"fecha_creacion" => $mostrarDatos["fecha_creacionM"],
						"fecha_modificacion" => $mostrarDatos["fecha_modificacionM"],
						"placa" => $mostrarDatos["placa"],
						"piloto" => $mostrarDatos["piloto"],
						"ruta" => $mostrarDatos["ruta"],
						"km_inicial" => $mostrarDatos["km_inicial"],
						"km_final" => $mostrarDatos["km_final"],
						"monto_total" => $mostrarDatos["monto_total"],
						"galones" => $mostrarDatos["galones"],
						"precio_galon" => $mostrarDatos["precio_galon"],
					];
				}
				echo json_encode($datos);
				break;
		}
	}
?>