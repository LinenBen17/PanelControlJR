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
	    public function showAllGastos(){
	    	$sql = "SELECT * FROM gastos";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function showRegister($id){
			$sql = "SELECT * FROM gastos WHERE id = ?";

			$sentencia = $this->db->prepare($sql);
			$sentencia->bind_param("i", $id);
			$sentencia->execute();
			$resultadoSet = $sentencia->get_result();

			return $resultadoSet;
		}
		public function update($datos){
			date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta de inserción
		    $sqlUpdate = "UPDATE `gastos` SET `id`= ?, `noManifiesto`= ?, `fechaManifiesto`= ?, `costoGasto`= ?, `descripcionGasto`= ?, `agenciaGasto`= ?, `rutaAgenciaGasto`= ?, `fechaModificacion`= ?,  `usuarioModifica`= ? WHERE `id` = ?";
		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    // Iterar sobre los datos
			$id = $datos['id'];
		    $noManifiesto = $datos['noManifiesto'];

		    $fechaManifiesto = $datos['fechaManifiesto'];
		    $costoGasto = $datos['costoGasto'];
		    $descripcionGasto = $datos['descripcionGasto'];
		    $agenciaGasto = $datos['agenciaGasto'];
		    $rutaAgenciaGasto = $datos['rutaAgenciaGasto'];

			// Edita el registro
            $sentenciaUpdate->bind_param("iisdsssssi", $id, $noManifiesto, $fechaManifiesto, $costoGasto, $descripcionGasto, $agenciaGasto, $rutaAgenciaGasto, $fechaActual, $_SESSION['usuario'], $id);
            $sentenciaUpdate->execute();

            $resultados[] = "registrado";

	        //Cerrar conexiones
	        $sentenciaUpdate->close();

		    return $resultados;
		}
		public function deleteRegister($id){
			$sql = "DELETE FROM gastos WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?>