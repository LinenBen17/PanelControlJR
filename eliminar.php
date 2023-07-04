<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'conexion.php';

	session_start();

    require 'validacionSesion.php';

	$id = $_GET['id'];
	//SQLS PARA ELIMINAR TODO RELACIONADO AL USUARIO
	$sqlSelecccionarUser = "DELETE FROM usuarios WHERE id = ?";
	$sqlPermisoUser = "DELETE FROM asignacion WHERE id_usuario = ?";

	$sentencia = $mysqli->prepare($sqlSelecccionarUser);
	$sentencia->bind_param("i", $id);
	$exec = $sentencia->execute();

	$sentenciaPermisosUser = $mysqli->prepare($sqlPermisoUser);
	$sentenciaPermisosUser->bind_param("i", $id);
	$resultado = $sentenciaPermisosUser->execute();

	if ($exec && $resultado) {
		header ("Location: controlUsuarios.php");
		die();
	}else{
		echo "ERROR AL ELIMINAR USUARIO";
	}
?>