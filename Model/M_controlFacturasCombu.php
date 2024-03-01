<?php 

	session_start();
	class FacturasCombustible{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function newFactura($placa, $piloto, $ruta, $fecha, $serie, $noFactura, $monto_total, $galones, $precio_galon){
			date_default_timezone_set('America/Guatemala');
			$fechaActual = date("Y-m-d H:i:s");

	    	$sqlSave = "INSERT INTO `facturascombustibles`(`id`, `fecha`, `placa`, `piloto`, `ruta`, `serie`, `noFactura`, `galones`, `precio_galon`, `monto_total`, `fecha_creacion`, `fecha_modificacion`, `usuario_ingresa`, `usuario_modifica`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("sssssidddssss", $fecha, $placa, $piloto, $ruta, $serie, $noFactura, $galones, $precio_galon, $monto_total, $fechaActual, $fechaActual, $_SESSION['usuario'], $_SESSION['usuario']);
			$sentenciaSave->execute();

			return ["accion" => "Saved"];
	    }
	    public function selectAllByUser(){
	    	$sql = "SELECT * FROM facturascombustibles WHERE usuario_ingresa = ?";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("s", $_SESSION['usuario']);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	}
?>