<?php 
	require_once '../Model/M_abastecimiento.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$abastecimiento = new Abastecimiento();

	switch ($action) {
		case "Save":
			$newAbastecimiento = $abastecimiento->newAbastecimiento($_POST['placa'], $_POST['piloto'], $_POST['ruta'], $_POST['km_inicial'], $_POST['km_final'], $_POST['monto_total'], $_POST['galones'], $_POST['precio_galon'], $_POST['fecha'], $_POST['rendimiento']);

			echo json_encode($newAbastecimiento);

			break;
		case "Delete":
			$delete = $abastecimiento->delete($_POST['id']);

			echo json_encode($delete);
			break;
		case "ShowRegister":
			$showRegister = $abastecimiento->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();

			$datos = [
				"id" => $mostrarDatos["id"],
				"placa" => $mostrarDatos["placa"],
				"piloto" => $mostrarDatos["piloto"],
				"ruta" => $mostrarDatos["ruta"],
				"km_inicial" => $mostrarDatos["km_inicial"],
				"km_final" => $mostrarDatos["km_final"],
				"monto_total" => $mostrarDatos["monto_total"],
				"galones" => $mostrarDatos["galones"],
				"precio_galon" => $mostrarDatos["precio_galon"],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $abastecimiento->update($_POST['placa'], $_POST['piloto'], $_POST['ruta'], $_POST['km_inicial'], $_POST['km_final'], $_POST['monto_total'], $_POST['galones'], $_POST['precio_galon'], $_POST['id']);

			echo json_encode($update);
			break;
		case "SearchPlaca":
			$searchPlaca = $abastecimiento->searchPlaca($_POST['placa']);
			$searchLastPlaca = $abastecimiento->searchLastPlaca($_POST['placa']);

			$mostrar = $searchPlaca->fetch_array();
			$mostrarLast = $searchLastPlaca->fetch_array();
			
			echo json_encode([
				"piloto" => $mostrar["piloto"],
				"ruta" => $mostrar["ruta"],
				"km_final" => $mostrarLast["km_final"],
			]);
			break;
		case "filtroPorPlaca":
			$filtroPorPlaca = $abastecimiento->filtroPorPlaca($_POST['placaFilter']);

			$datos = [];

			while ($mostrarDatos = $filtroPorPlaca->fetch_array()) {
				$datos[]= [
					"fecha_creacion" => $mostrarDatos["fecha_creacionM"],
					"fecha_modificacion" => $mostrarDatos["fecha_modificacionM"],
					"fecha_combustible" => $mostrarDatos["fecha_combustible"],
					"placa" => $mostrarDatos["placa"],
					"piloto" => $mostrarDatos["piloto"],
					"ruta" => $mostrarDatos["ruta"],
					"km_inicial" => $mostrarDatos["km_inicial"],
					"km_final" => $mostrarDatos["km_final"],
					"rendimiento" => $mostrarDatos["rendimiento"],
					"monto_total" => $mostrarDatos["monto_total"],
					"galones" => $mostrarDatos["galones"],
					"precio_galon" => $mostrarDatos["precio_galon"],
				];
			}
			echo json_encode($datos);
			break;
		case "filtroPorFecha":
			$filtroPorPlaca = $abastecimiento->filtroPorFecha($_POST['fechaFilter']);

			$datos = [];

			while ($mostrarDatos = $filtroPorPlaca->fetch_array()) {
				$datos[]= [
					"fecha_creacion" => $mostrarDatos["fecha_creacionM"],
					"fecha_modificacion" => $mostrarDatos["fecha_modificacionM"],
					"fecha_combustible" => $mostrarDatos["fecha_combustible"],
					"placa" => $mostrarDatos["placa"],
					"piloto" => $mostrarDatos["piloto"],
					"ruta" => $mostrarDatos["ruta"],
					"km_inicial" => $mostrarDatos["km_inicial"],
					"km_final" => $mostrarDatos["km_final"],
					"rendimiento" => $mostrarDatos["rendimiento"],
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
					"fecha_combustible" => $mostrarDatos["fecha_combustible"],
					"placa" => $mostrarDatos["placa"],
					"piloto" => $mostrarDatos["piloto"],
					"ruta" => $mostrarDatos["ruta"],
					"km_inicial" => $mostrarDatos["km_inicial"],
					"km_final" => $mostrarDatos["km_final"],
					"rendimiento" => $mostrarDatos["rendimiento"],
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
					"id" => $mostrarDatos["id"],
					"placa" => $mostrarDatos["placa"],
					"piloto" => $mostrarDatos["piloto"],
					"ruta" => $mostrarDatos["ruta"],
					"km_inicial" => $mostrarDatos["km_inicial"],
					"km_final" => $mostrarDatos["km_final"],
					"monto_total" => $mostrarDatos["monto_total"],
					"galones" => $mostrarDatos["galones"],
					"precio_galon" => $mostrarDatos["precio_galon"],
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>',
				];
			}

			echo json_encode($datos);
			break;
	}
?>