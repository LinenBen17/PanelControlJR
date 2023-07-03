<?php
    $seccionActual = basename($_SERVER['PHP_SELF']);

    require 'seccionesUrls.php';

    // Función para verificar los permisos de un usuario
    function verificarPermiso($usuarioId, $permisoRequerido) {
        require 'conexion.php';

        // Realizar la consulta para obtener los permisos del usuario
        $query = "SELECT COUNT(*) AS count FROM asignacion AS a
                  JOIN permisos AS p ON a.id_permiso = p.id
                  WHERE a.id_usuario = ? AND p.seccion = ?";

        // Ejecutar la consulta y obtener el resultado
        // Aquí asumimos que estás utilizando una conexión a la base de datos llamada $mysqli
        $sentencia = $mysqli->prepare($query);
        $sentencia->bind_param("is", $usuarioId, $permisoRequerido);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        // Obtener el número de filas del resultado
        $assoc = $resultado->fetch_assoc();
        $count = $assoc['count'];

        return $count > 0; // Devolver true si el usuario tiene el permiso requerido, false en caso contrario
    }

    $permisoEncontrado = false; //Variable para verificar si se encontró un permiso válido
    // Uso de la función para verificar los permisos
    foreach ($permisos as $permiso => $enlace) {
        if (verificarPermiso($idSesion, $permiso)) {
            if ($enlace == $seccionActual) {
                $permisoEncontrado = true; // Se encontró un permiso válido que coincide con la sección actual
                break; // Salir del bucle
            }
        }
    }

    if (!$permisoEncontrado) {
        header("location: principal.php");
        exit();
    }
?>