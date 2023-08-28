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
				//CREAR NUEVO PILOTO
				try {
					$sqlNewPiloto = "INSERT INTO `pilotos`(`id`, `nombres`, `apellidos`, `licencia`, `fecha_creacion`, `fecha_modificacion`, `estado`) VALUES (NULL,?,?,?,?,?,?)";

					$sentenciaNewPiloto = $mysqli->prepare($sqlNewPiloto);
					$sentenciaNewPiloto->bind_param("sssssi", $_POST['nombres'], $_POST['apellidos'], $_POST['licencia'], $fechaActual, $fechaActual, $_POST['estado']);
					$sentenciaNewPiloto->execute();

					echo json_encode(["accion" => "Creado"]);
					$sentenciaNewPiloto->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Show":
				//MOSTRAR UN PILOTO
				try {
					$sqlMostrarUnPiloto = "SELECT * FROM pilotos WHERE id = ?";

					$sentenciaMostrar = $mysqli->prepare($sqlMostrarUnPiloto);
					$sentenciaMostrar->bind_param("i", $_POST['id']);
					$sentenciaMostrar->execute();
					$result = $sentenciaMostrar->get_result();
					$mostrarPiloto = $result->fetch_assoc();

					echo json_encode([
						"id" => $mostrarPiloto['id'],
						"accion" => "Showed",
						"nombres" => $mostrarPiloto['nombres'],
						"apellidos" => $mostrarPiloto['apellidos'],
						"licencia" => $mostrarPiloto['licencia'],
						"fecha_creacion" => $mostrarPiloto['fecha_creacion'],
						"fecha_modificacion" => $mostrarPiloto['fecha_modificacion'],
						"estado" => $mostrarPiloto['estado'],
					]);
					$sentenciaMostrar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Editar":
				try {
					//ACTUALIZAR DATOS DE UN PILOTO
					$updatePiloto = "UPDATE `pilotos` SET `nombres`= ?,`apellidos`= ?,`licencia`= ?,`fecha_modificacion`= ?,`estado`= ? WHERE `id` = ?";

					$sentenciaEditar = $mysqli->prepare($updatePiloto);
					$sentenciaEditar->bind_param("ssssii", $_POST['nombres'], $_POST['apellidos'], $_POST['licencia'], $fechaActual, $_POST['estado'], $_POST['id']);
					$sentenciaEditar->execute();
					echo json_encode(["accion" => "Editado"]);
					$sentenciaEditar->close();
				} catch (Exception $e) {
					echo json_encode($e->getMessage());
				}
				break;
			case "Eliminar":
				try {
					$detelPiloto = "DELETE FROM `pilotos` WHERE `id` = ?";

					$sentenciaEliminar = $mysqli->prepare($detelPiloto);
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