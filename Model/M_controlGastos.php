<?php
	session_start();
	class ControlGastos{
	    private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function saveGastos($datos){
	    	date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    $sqlInsert = "INSERT INTO `gastos`(`id`, `noManifiesto`, `fechaManifiesto`, `costoGasto`, `descripcionGasto`, `fechaIngreso`, `fechaModificacion`, `usuarioIngresa`, `usuarioModifica`, `agenciaGasto`, `rutaAgenciaGasto`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";

		    $sentenciaInsert = $this->db->prepare($sqlInsert);

		    // Variable para almacenar resultados
		    $resultados = [];
		    // Iterar sobre los datos
			foreach ($datos['descripcionGasto'] as $key => $descripcionGasto) {
			    $noManifiesto = $datos['noManifiesto'];
			    $fechaManifiesto = $datos['fechaManifiesto'];
			    $agenciaGasto = $datos['agenciaGasto'];
			    $rutaAgenciaGasto = $datos['rutaAgenciaGasto'];
			    $costoGasto = $datos['costoGasto'][$key];

	            // Insertar nuevo registro
	            $sentenciaInsert->bind_param("isdsssssss", $noManifiesto, $fechaManifiesto, $costoGasto, $descripcionGasto, $fechaActual, $fechaActual, $_SESSION['usuario'], $_SESSION['usuario'], $agenciaGasto, $rutaAgenciaGasto);
	            $sentenciaInsert->execute();

	            $resultados[] = "registrado";
		    }

		    // Cerrar las consultas y liberar recursos
		    $sentenciaInsert->close();

		    return $resultados;
	    }
	}
?>