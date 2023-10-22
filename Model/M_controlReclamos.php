<?php
	class ControlReclamos{
		private $db;
	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function getReclamos(){
	    	$sql = "SELECT * FROM reclamos";
		    $sentencia = $this->db->prepare($sql);
		    $sentencia->execute();

		    $resultadoSet = $sentencia->get_result();

		    return $resultadoSet;
	    }
	}

	$controlreclamos = new ControlReclamos();
?>