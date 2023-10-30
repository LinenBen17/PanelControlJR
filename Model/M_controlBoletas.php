<?php
session_start();
	class ControlBoletas{
	    private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function guardar($noManifiesto, $noBoleta, $tipoBoleta){
	    	date_default_timezone_set('America/Guatemala');
			$fechaActual = date("Y-m-d H:i:s");

	    	$sqlSelect = "SELECT * FROM boletas WHERE noBoleta = ?";
	    	$sql = "INSERT INTO `boletas`(`id`, `noManifiesto`, `noBoleta`, `tipoBoleta`, `fechaIngreso`, `fechaModificacion`, `usuarioIngresa`) VALUES(NULL, ?,?,?,?,?,?)";

	    	$sentenciaSelect = $this->db->prepare($sqlSelect);
	    	$sentenciaSelect->bind_param("i", $noBoleta);
	    	$sentenciaSelect->execute();

	    	$resultadoSelect = $sentenciaSelect->get_result();

	    	if ($resultadoSelect->num_rows > 0) {
	    		return false;
	    	}else {		
		    	$sentencia = $this->db->prepare($sql);
		    	$sentencia->bind_param("iissss", $noManifiesto, $noBoleta, $tipoBoleta, $fechaActual, $fechaActual, $_SESSION['usuario']);
		    	$sentencia->execute();

		    	return true;
	    	}

	    }
	    public function showAllBoletas(){
	    	$sql = "SELECT * FROM boletas";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();;
	    }
	}
?>