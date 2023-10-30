<?php
	class Permisos{
	    private $db;

		// Definir los permisos y los enlaces correspondientes
	    public $permisosUrl = array(
	        "Control Usuarios" => "controlUsuarios.php",
	        //"Subir Guia" => "subirGuia.php",
	        //"Control Reclamos" => "controlReclamos.php",
	        "Impr Guias Hijas" => "impresionHijas.php",
	        "Impr Guias Madres" => "impresionMadres.php",
	        "Tracking" => "tracking.php",
	        "Pilotos" => "pilotos.php",
	        "Camiones" => "camiones.php",
	        "Ruta" => "ruta.php",
	        "Abastecimiento" => "abastecimiento.php",
	        "Control Abaste" => "controlAbastecimiento.php",
	        "Control Boletas" => "controlBoletas.php",
	    );

	    // Definir las asociaciones entre secciones e iconos 
	    public $iconos = array(
	        "Control Usuarios" => "people-outline",
	        "Subir Guia" => "cloud-upload-outline",
	        "Control Reclamos" => "alert-outline",
	        "Impr Guias Hijas" => "print-outline",
	        "Impr Guias Madres" => "print",
	        "Tracking" => "layers-outline",
	        "Pilotos" => "body",
	        "Camiones" => "bus-outline",
	        "Ruta" => "map-outline",
	        "Abastecimiento" => "clipboard-outline",
	        "Control Abaste" => "reader-outline",
	        "Control Boletas" => "receipt-outline",
	    );
	    
	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function verificarPermiso($usuarioId, $permisoRequerido){
			// Realizar la consulta para obtener los permisos del usuario
	        $query = "SELECT COUNT(*) AS count FROM asignacion AS a
	                  JOIN permisos AS p ON a.id_permiso = p.id
	                  WHERE a.id_usuario = ? AND p.seccion = ?";

	        // Ejecutar la consulta y obtener el resultado
	        // Aquí asumimos que estás utilizando una conexión a la base de datos llamada $mysqli
	        $sentencia = $this->db->prepare($query);
	        $sentencia->bind_param("is", $usuarioId, $permisoRequerido);
	        $sentencia->execute();

	        $resultado = $sentencia->get_result();

	        // Obtener el número de filas del resultado
	        $assoc = $resultado->fetch_assoc();
	        $count = $assoc['count'];

	        return $count > 0; // Devolver true si el usuario tiene el permiso requerido, false en caso contrario
	    }
	} 
?>