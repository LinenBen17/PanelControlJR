<?php

session_start();
	class ControlBoletas{
	    private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function guardar($datos){
	    	date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");


		    // Preparar la consulta para comprobar duplicados
		    $sqlSelect = "SELECT * FROM boletas WHERE noBoleta = ?";
		    $sentenciaSelect = $this->db->prepare($sqlSelect);

		    // Preparar la consulta de inserción
		    $sqlInsert = "INSERT INTO `boletas`(`id`, `noManifiesto`, `noBoleta`, `tipoBoleta`, `fechaIngreso`, `fechaModificacion`, `usuarioIngresa`, `fechaBoleta`, `valorBoleta`, `agenciaBoleta`, `bancoBoleta`, `fechaManifiesto`, `lugarDeposito`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)";
		    $sentenciaInsert = $this->db->prepare($sqlInsert);

		    // Variable para almacenar resultados
		    $resultados = [];

		    // Iterar sobre los datos
			foreach ($datos['noBoleta'] as $key => $noBoleta) {
			    $noManifiesto = $datos['noManifiesto'];
			    $tipoBoleta = $datos['tipoBoleta'][$key];
			    $fechaBoleta = $datos['fechaBoleta'][$key];
			    $valorBoleta = $datos['valorBoleta'][$key];
			    $agenciaBoleta = $datos['agenciaBoleta'][$key];
			    $bancoBoleta = $datos['bancoBoleta'][$key];
			    $fechaManifiesto = $datos['fechaManifiesto'];
			    $lugarDeposito = $datos['lugarDeposito'];

		        // Comprobar duplicados
		        $sentenciaSelect->bind_param("i", $noBoleta);
		        $sentenciaSelect->execute();

		        $resultadoSelect = $sentenciaSelect->get_result();

		        if ($resultadoSelect->num_rows > 0) {
		            $resultados[] = ["repetido",$noBoleta];
		        } else {
		            // Insertar nuevo registro
		            $sentenciaInsert->bind_param("iisssssiisss", $noManifiesto, $noBoleta, $tipoBoleta, $fechaActual, $fechaActual, $_SESSION['usuario'], $fechaBoleta, $valorBoleta, $agenciaBoleta, $bancoBoleta, $fechaManifiesto, $lugarDeposito);
		            $sentenciaInsert->execute();

		            $resultados[] = "registrado";
		        }
		    }

		    // Cerrar las consultas y liberar recursos
		    $sentenciaSelect->close();
		    $sentenciaInsert->close();

		    return $resultados;

	    }
	    public function showAllBoletas(){
	    	$sql = "SELECT * FROM boletas";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function showBoletasByUser(){
	    	$sql = "SELECT * FROM boletas WHERE usuarioIngresa = ?";

		    $sentencia = $this->db->prepare($sql);
		    $sentencia->bind_param("s", $_SESSION['usuario']);
		    $sentencia->execute();

		    return $sentencia->get_result();
	    }
	}
?>