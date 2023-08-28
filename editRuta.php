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
			case "Crear":
				//CREAR NUEVA RUTA
				try {
					$sqlNew = "INSERT INTO `ruta`(`id`, `placa`, `piloto`, `ruta`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL, ?, ?, ?, ?, ?)";

					$sentenciaNew = $mysqli->prepare($sqlNew);
					$sentenciaNew->bind_param("sssss", $_POST['placa'], $_POST['piloto'], $_POST['ruta'], $fechaActual, $fechaActual);
					$sentenciaNew->execute();

					echo json_encode(["accion" => "Creado"]);
					$sentenciaNew->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Show":
				//MOSTRAR RUTA
				try {
					$sqlMostrar = "SELECT * FROM ruta WHERE id = ?";

					$sentenciaMostrar = $mysqli->prepare($sqlMostrar);
					$sentenciaMostrar->bind_param("i", $_POST['id']);
					$sentenciaMostrar->execute();
					$result = $sentenciaMostrar->get_result();
					$mostrar = $result->fetch_assoc();

					echo json_encode([
						"id" => $mostrar['id'],
						"accion" => "Showed",
						"placa" => $mostrar['placa'],
						"piloto" => $mostrar['piloto'],
						"ruta" => $mostrar['ruta'],
						"fecha_creacion" => $mostrar['fecha_creacion'],
						"fecha_modificacion" => $mostrar['fecha_modificacion'],
					]);
					$sentenciaMostrar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Editar":
				try {
					//ACTUALIZAR DATOS DE UNA RUTA
					$sqlUpdate = "UPDATE `ruta` SET `placa`= ?,`piloto`= ?,`ruta`= ?,`fecha_modificacion`= ? WHERE `id` = ?";

					$sentenciaEditar = $mysqli->prepare($sqlUpdate);
					$sentenciaEditar->bind_param("ssssi", $_POST['placa'], $_POST['piloto'], $_POST['ruta'], $fechaActual, $_POST['id']);
					$sentenciaEditar->execute();
					echo json_encode(["accion" => "Editado"]);
					$sentenciaEditar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Eliminar":
			// ELIMINAR UNA RUTA
				try {
					$sqlDelete = "DELETE FROM `ruta` WHERE `id` = ?";

					$sentenciaEliminar = $mysqli->prepare($sqlDelete);
					$sentenciaEliminar->bind_param("i", $_POST['id']);
					$sentenciaEliminar->execute();

					echo json_encode(["accion" => "Eliminado"]);

					$sentenciaEliminar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Search":
			// BUSCA UN PILOTO
				$sqlSearch = "SELECT * FROM pilotos WHERE nombres LIKE '" . $_POST['search'] . "%'";
				$sentenciaSearch = $mysqli->prepare($sqlSearch);
				$sentenciaSearch->execute();

				$resultado = $sentenciaSearch->get_result();

				$datos = [];
				while ($mostrar = $resultado->fetch_array()) {
				    $datos[]= $mostrar['nombres'] . " " . $mostrar['apellidos'];
				}

				echo json_encode($datos);
				break;
			case "SearchPlaca":
			// BUSCA UN PILOTO
				$sqlSearchPlaca = "SELECT * FROM camiones WHERE placa LIKE '" . $_POST['search'] . "%'";
				$sentenciaSearchPlaca = $mysqli->prepare($sqlSearchPlaca);
				$sentenciaSearchPlaca->execute();

				$resultado = $sentenciaSearchPlaca->get_result();

				$datos = [];
				while ($mostrar = $resultado->fetch_array()) {
				    $datos[]= $mostrar['placa'];
				}

				echo json_encode($datos);
				break;
		}
	}
?>