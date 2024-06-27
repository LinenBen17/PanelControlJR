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
	        "Ingreso Boletas" => "ingresoBoletas.php",
	        "Control Boletas" => "controlBoletas.php",
	        "Control Gastos" => "controlGastos.php",
	        "Depositos CE" => "ingresoDepositosCE.php",
	        "Control CE" => "controlDepositosCE.php",
	        "Registro Fact" => "registroFacturas.php",
	        "Control Fact" => "controlFacturas.php",
	        "Registro Ordenes" => "registroOrdenes.php",
	        "Control Ordenes" => "controlOrdenes.php",
	        "Ingreso Empleados" => "ingresoEmpleados.php",
	        "Control Empleados" => "controlEmpleados.php",
	        "Detalle Pago" => "ingresoDetallePago.php",
	        "Control Detalle Pago" => "controlDetallePago.php",
	        "Ingreso Descuentos" => "ingresoDescuentos.php",
	        "Control Descuentos" => "controlDescuentos.php",
	        "Ingreso Bonos" => "ingresoBonos.php",
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
	        "Ingreso Boletas" => "create-outline",
	        "Control Boletas" => "receipt-outline",
	        "Control Gastos" => "cash-outline",
	        "Depositos CE" => "wallet-outline",
	        "Control CE" => "folder-open-outline",
	        "Registro Fact" => "save-outline",
	        "Control Fact" => "build-outline",
	        "Registro Ordenes" => "newspaper-outline",
	        "Control Ordenes" => "book-outline",
	        "Ingreso Empleados" => "accessibility-outline",
	        "Control Empleados" => "calendar-outline",
	        "Detalle Pago" => "cash",
	        "Control Detalle Pago" => "wallet",
	        "Ingreso Descuentos" => "wallet",
	        "Control Descuentos" => "wallet",
	        "Ingreso Bonos" => "wallet",
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