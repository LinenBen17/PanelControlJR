<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    require 'validacionSesion.php';

    if ($_POST) {
    	$codigo = $_POST['codigo'] ?? null;
    	$nombre = $_POST['nombre'] ?? null;
    	$direccion = $_POST['direccion'] ?? null;
    	$telefono = $_POST['telefono'] ?? null;
    	$destino = $_POST['destino'] ?? null;
    	$contacto = $_POST['contacto'] ?? null;

    	$sqlCrearClientes = "INSERT INTO bdstandar (codigo, nombre, direccion, telefono, contacto, destino) VALUES(?,?,?,?,?,?)";


    	try {
	    	$creando = $mysqli->prepare($sqlCrearClientes);
	    	$creando->bind_param("ssssss", $codigo, $nombre, $direccion, $telefono, $contacto, $destino);
	    	$creando->execute();

	    	header("location: impresionMadres.php");
	    	die();
    	} catch (Exception $e) {
    		echo "Error:<br>" . $e->getMessage();
    		die("HUBO UN ERROR AL CREAR EL REGISTRO");
    	}
    	$creando->close();
    }
?>