<?php

	session_start();
	class Empleados{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function newEmpleado($nombres, $apellidos, $ctaBancaria, $fecha_ingreso_empleado, $agencia, $cargo, $estado_planilla, $observaciones){
	    	$sqlSave = "INSERT INTO `empleados`(`nombres`, `apellidos`, `ctaBancaria`, `fecha_ingreso_empleado`, `agencia`, `cargo`, `estado_planilla`, `observaciones`, `usuario_ingresa`, `usuario_modifica`) VALUES (?,?,?,?,?,?,?,?,?,?)";

			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("ssisssssss", $nombres, $apellidos, $ctaBancaria, $fecha_ingreso_empleado, $agencia, $cargo, $estado_planilla, $observaciones, $_SESSION['usuario'], $_SESSION['usuario']);
			$sentenciaSave->execute();

			return ["accion" => "Saved"];
	    }
	    public function selectAll(){
	    	$sql = "SELECT * FROM empleados";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function update($datos){
			date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta de inserción
		    $sqlUpdate = "UPDATE `empleados` SET `nombres`= ?, `apellidos`= ?, `ctaBancaria`= ?, `fecha_ingreso_empleado`= ?, `agencia`= ?, `cargo`= ?, `estado_planilla`= ?, `observaciones`= ?, `fecha_modificacion`= ?, `usuario_modifica`= ? WHERE `id` = ?";

		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    //datos
			$id = $datos['id'];
			$nombres = $datos['nombres'];
		    $apellidos = $datos['apellidos'];
		    $ctaBancaria = $datos['ctaBancaria'];
		    $fecha_ingreso_empleado = $datos['fecha_ingreso_empleado'];
		    $agencia = $datos['agencia'];
		    $cargo = $datos['cargo'];
		    $estado_planilla = $datos['estado_planilla'];
		    $observaciones = $datos['observaciones'];

			// Edita el registro
            $sentenciaUpdate->bind_param("ssisssisssi", $nombres, $apellidos, $ctaBancaria, $fecha_ingreso_empleado, $agencia, $cargo, $estado_planilla, $observaciones, $fechaActual, $_SESSION['usuario'], $id);
            $sentenciaUpdate->execute();

            $resultados[] = "registrado";

	        //Cerrar conexiones
	        $sentenciaUpdate->close();

		    return $resultados;
		}
	    public function showRegister($id){
	    	$sql = "SELECT * FROM empleados WHERE id = ?";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function deleteRegister($id){
			$sql = "DELETE FROM empleados WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?> 