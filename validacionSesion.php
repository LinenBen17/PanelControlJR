<?php
    if (!isset($_SESSION['id'])) {
        header("location: index.php");
    }

    $idSesion = $_SESSION['id'];
    $nombreSesion = $_SESSION['nombre'];

    $seccionActual = basename($_SERVER['PHP_SELF']);
?>