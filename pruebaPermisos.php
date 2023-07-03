<?php 
	ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php'; 

    session_start();

    require 'validacionSesion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Permisos PRUEBA</title>
</head>
<body>
	<?php
		// Función para verificar los permisos de un usuario
		function verificarPermiso($usuarioId, $permisoRequerido) {
    		require 'conexion.php';

		    // Realizar la consulta para obtener los permisos del usuario
		    $query = "SELECT COUNT(*) AS count FROM asignacion AS a
		              JOIN permisos AS p ON a.id_permiso = p.id
		              WHERE a.id_usuario = ? AND p.seccion = ?";

		    // Ejecutar la consulta y obtener el resultado
		    // Aquí asumimos que estás utilizando una conexión a la base de datos llamada $conexion
		    $sentencia = $mysqli->prepare($query);
		    $sentencia->bind_param("is", $usuarioId, $permisoRequerido);
		    $sentencia->execute();

		    $resultado = $sentencia->get_result();

		    // Obtener el número de filas del resultado
		    $assoc = $resultado->fetch_assoc();
		    $count = $assoc['count'];

		    return $count > 0; // Devolver true si el usuario tiene el permiso requerido, false en caso contrario
		}
		// Definir los permisos y los enlaces correspondientes
		$permisos = array(
		    "Leer" => "leer.html",
		    "Eliminar" => "eliminar.html",
		    "Crear" => "crear.html"
		);

		// Uso de la función para verificar los permisos y generar enlaces
		foreach ($permisos as $permiso => $enlace) {
		    if (verificarPermiso($id, $permiso)) {
		        echo "<a href=\"$enlace\">$permiso</a><br>";
		    }
		}
	?>
</body>
</html>