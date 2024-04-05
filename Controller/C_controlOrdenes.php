<?php
	require_once '../Model/M_controlOrdenes.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$ordenesCompra = new OrdenesCompra();

	switch ($action) {
		case "Save":
			$newOrden = $ordenesCompra->newOrder($_POST);

			echo json_encode($newOrden);

			break;
		case "ShowRegister":
			$showRegister = $ordenesCompra->showRegister($_POST['id']);

			$mostrarDatos = $showRegister->fetch_assoc();
 
			$datos = [
				"id" => $mostrarDatos['id'],
				"noOrden" => $mostrarDatos['noOrden'],
				"noFactura" => $mostrarDatos['noFactura'],
				"fecha" => $mostrarDatos['fecha'],
				"proveedor" => $mostrarDatos['proveedor'],
				"placa" => $mostrarDatos['placa'],
				"cantidad" => $mostrarDatos['cantidad'],
				"descripcion" => $mostrarDatos['descripcion'],
				"precioUnitario" => $mostrarDatos['precioUnitario'],
				"total" => $mostrarDatos['total'],
				"observacion" => $mostrarDatos['observacion'],
			];

			echo json_encode($datos);
			break;
		case "Update":
			$update = $ordenesCompra->update($_POST);

			echo json_encode($update);
			break;
		case "Delete":
			$delete = $ordenesCompra->deleteRegister($_POST['id']);

			echo json_encode($delete);
			break;
		case "SelectAllUser":
			$selectAllByUser = $ordenesCompra->selectAllByUser();

			$datos = [];

			while ($mostrarDatos = $selectAllByUser->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noOrden" => $mostrarDatos['noOrden'],
					"noFactura" => $mostrarDatos['noFactura'],
					"fecha" => $mostrarDatos['fecha'],
					"proveedor" => $mostrarDatos['proveedor'],
					"placa" => $mostrarDatos['placa'],
					"cantidad" => $mostrarDatos['cantidad'],
					"descripcion" => $mostrarDatos['descripcion'],
					"precioUnitario" => $mostrarDatos['precioUnitario'],
					"total" => $mostrarDatos['total'],
					"observacion" => $mostrarDatos['observacion'],
				];
			}

			echo json_encode($datos);
			break;
		default:
			$showAllCE = $ordenesCompra->selectAll();

			$datos = [];

			while ($mostrarDatos = $showAllCE->fetch_array()) {
				$datos[]= [
					"id" => $mostrarDatos['id'],
					"noOrden" => $mostrarDatos['noOrden'],
					"noFactura" => $mostrarDatos['noFactura'],
					"fecha" => $mostrarDatos['fecha'],
					"proveedor" => $mostrarDatos['proveedor'],
					"placa" => $mostrarDatos['placa'],
					"cantidad" => $mostrarDatos['cantidad'],
					"descripcion" => $mostrarDatos['descripcion'],
					"precioUnitario" => $mostrarDatos['precioUnitario'],
					"total" => $mostrarDatos['total'],
					"observacion" => $mostrarDatos['observacion'],
					"fecha_ingreso" => $mostrarDatos['fecha_ingreso'],
					"fecha_modificacion" => $mostrarDatos['fecha_modificacion'],
					"usuario_ingresa" => $mostrarDatos['usuario_ingresa'],
					"usuario_modifica" => $mostrarDatos['usuario_modifica'],
					"editar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEditar">Editar</a>',
					"eliminar" => '<a href="#" id="' . $mostrarDatos['id'] . '" class="btnEliminar">Eliminar</a>', 
				];
			}

			echo json_encode($datos);
			break;
	}