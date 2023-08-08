<?php
  require 'conexion.php';
  if ($_POST['codigo']) {
    $codigo = $_POST['codigo'];
    
    // CONSULTA ENVIOS
    $sql_datos = "SELECT * FROM bdstandar WHERE codigo = ?";
    $datos = $mysqli->prepare($sql_datos);
    $datos->bind_param("s", $codigo);
    $datos->execute();

    $result_datos = $datos->get_result();

    // Crear un array para almacenar todos los resultados obtenidos
    $datosEncontrados = array();
    while ($assoc_datos = $result_datos->fetch_assoc()) {
        // Almacenar cada resultado en el array
        $datosEncontrados[] = array(
            'idcliente' => $assoc_datos['idcliente'],
            'nombre' => $assoc_datos['nombre'],
            'direccion' => $assoc_datos['direccion'],
            'telefono' => $assoc_datos['telefono'],
            'contacto' => $assoc_datos['contacto'],
            'destino' => $assoc_datos['destino'],
        );
    }

    $datos->close();

    echo json_encode($datosEncontrados);
  }
?>