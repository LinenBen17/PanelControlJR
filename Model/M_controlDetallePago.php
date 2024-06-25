<?php

	session_start();
	class DetallePago{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function newDetalle($empleado_id, $sueldo_ordinario, $bonificacion_ley, $bonificacion_incentivo, $igss, $isr){
	    	$sqlSave = "INSERT INTO `detalle_pago_empleado`(`empleado_id`, `sueldo_ordinario`, `bonificacion_ley`, `bonificacion_incentivo`, `igss`, `isr`, `usuario_ingresa`, `usuario_modifica`) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";

	    	$sqlSelect = "SELECT * FROM detalle_pago_empleado WHERE empleado_id = ?";

	    	$sentenciaSelect = $this->db->prepare($sqlSelect);
	    	$sentenciaSelect->bind_param("i", $empleado_id);
	    	$sentenciaSelect->execute();

	    	$resultado = $sentenciaSelect->get_result();

	    	$mensaje = "";
	    	
	    	if ($resultado->num_rows > 0) {
	    		$mensaje = "Repeated";
	    	}else{
				$sentenciaSave = $this->db->prepare($sqlSave);
				$sentenciaSave->bind_param("idddddss", $empleado_id, $sueldo_ordinario, $bonificacion_ley, $bonificacion_incentivo, $igss, $isr, $_SESSION['usuario'], $_SESSION['usuario']);
				$sentenciaSave->execute();

				$mensaje = "Saved";
			}

			return $mensaje;
	    }
	    public function selectAllEmpleados(){
	    	$sql = "SELECT * FROM empleados";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function selectAllDetalle(){
	    	$sql = "
	    		SELECT 
				e.id AS empleadoId,
				dpe.id AS detalle_pago_empleado_id,
				e.*, dpe.*
				FROM empleados AS e
				INNER JOIN detalle_pago_empleado AS dpe
				ON e.id = dpe.empleado_id ORDER BY e.id;
	    	";

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
			$sql = "DELETE FROM detalle_pago_empleado WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?> 