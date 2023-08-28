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
				//CREAR NUEVO CAMION
				try {
					$sqlNew = "INSERT INTO `camiones`(`id`, `modelo`, `marca`, `placa`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL,?,?,?,?,?)";

					$sentenciaNew = $mysqli->prepare($sqlNew);
					$sentenciaNew->bind_param("sssss", $_POST['modelo'], $_POST['marca'], $_POST['placa'], $fechaActual, $fechaActual);
					$sentenciaNew->execute();

					echo json_encode(["accion" => "Creado"]);
					$sentenciaNew->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Show":
				//MOSTRAR UN CAMION
				try {
					$sqlMostrar = "SELECT * FROM camiones WHERE id = ?";

					$sentenciaMostrar = $mysqli->prepare($sqlMostrar);
					$sentenciaMostrar->bind_param("i", $_POST['id']);
					$sentenciaMostrar->execute();
					$result = $sentenciaMostrar->get_result();
					$mostrar = $result->fetch_assoc();

					echo json_encode([
						"id" => $mostrar['id'],
						"accion" => "Showed",
						"modelo" => $mostrar['modelo'],
						"marca" => $mostrar['marca'],
						"placa" => $mostrar['placa'],
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
					//ACTUALIZAR DATOS DE UN CAMION
					$sqlUpdate = "UPDATE `camiones` SET `modelo`= ?,`marca`= ?,`placa`= ?,`fecha_modificacion`= ? WHERE `id` = ?";

					$sentenciaEditar = $mysqli->prepare($sqlUpdate);
					$sentenciaEditar->bind_param("ssssi", $_POST['modelo'], $_POST['marca'], $_POST['placa'], $fechaActual, $_POST['id']);
					$sentenciaEditar->execute();
					echo json_encode(["accion" => "Editado"]);
					$sentenciaEditar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Eliminar":
			// ELIMINAR UN CAMION
				try {
					$sqlDelete = "DELETE FROM `camiones` WHERE `id` = ?";

					$sentenciaEliminar = $mysqli->prepare($sqlDelete);
					$sentenciaEliminar->bind_param("i", $_POST['id']);
					$sentenciaEliminar->execute();

					echo json_encode(["accion" => "Eliminado"]);

					$sentenciaEliminar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
		}
	}
?>