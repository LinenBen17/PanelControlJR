<?php
  require 'conexion.php';
  if ($_POST['id']) {
    $id = $_POST['id'];
    
    // CONSULTA ENVIOS
    $sql_datos = "SELECT * FROM reclamos WHERE id = ?";
    $datos = $mysqli->prepare($sql_datos);
    $datos->bind_param("s", $id);
    $datos->execute();

    $result_datos = $datos->get_result();
    $assoc_datos = $result_datos->fetch_assoc();

    $datos->close();

    $datosEnviar = [
        'foto_guia' => $assoc_datos['foto_guia'],
        'foto_producto' => $assoc_datos['foto_producto'],
        'carta_reclamo' => $assoc_datos['carta_reclamo'],
        'id' => $assoc_datos['id'],
    ];
    echo json_encode($datosEnviar);
  }
?>