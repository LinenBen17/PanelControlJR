<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'conexion.php';

	session_start();

    require 'validacionSesion.php';

	$id = $_GET['id'];
	$sql = "DELETE FROM usuarios WHERE id = ?";

	$sentencia = $mysqli->prepare($sql);
	$sentencia->bind_param("i", $id);
	$exec = $sentencia->execute();

	if ($exec) {
		header ("Location: controlUsuarios.php");
		die();
	}else{
		echo "ERROR AL ELIMINAR USUARIO";
	}
?>