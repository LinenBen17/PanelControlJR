<?php
	require_once '../Model/M_abastecimiento.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$abastecimiento = new Abastecimiento();

	switch ($action) {
		case "Save":
			$newAbastecimiento = $abastecimiento->newAbastecimiento($_POST['placa'], $_POST['piloto'], $_POST['ruta'], $_POST['km_inicial'], $_POST['km_final'], $_POST['monto_total'], $_POST['galones'], $_POST['precio_galon']);

			echo json_encode($newAbastecimiento);

			break;
		case "SearchPlaca":
			$searchPlaca = $abastecimiento->searchPlaca($_POST['placa']);

			$mostrar = $searchPlaca->fetch_array();
			
			echo json_encode([
				"piloto" => $mostrar["piloto"],
				"ruta" => $mostrar["ruta"],
			]);
			break;
		case "filtroPorPlaca":
			$filtroPorPlaca = $abastecimiento->filtroPorPlaca($_POST['placaFilter']);

			$mostrarDatos = $filtroPorPlaca->fetch_assoc();

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
			$filtroPorPlaca = $abastecimiento->filtroPorFecha($_POST['fechaFilter']);

			$datos = [];

			while ($mostrarDatos = $filtroPorPlaca->fetch_array()) {
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
			$filtroEntreFechas = $abastecimiento->filtroEntreFechas($_POST['fechaInicial'], $_POST['fechaFinal']);

			$datos = [];

			while ($mostrarDatos = $filtroEntreFechas->fetch_array()) {
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
		default:
			$showAllAbastecimiento = $abastecimiento->showAllAbastecimiento();

			$datos = [];

			while ($mostrarDatos = $showAllAbastecimiento->fetch_array()) {
				$datos[]= [
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
?>