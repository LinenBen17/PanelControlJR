<?php

	session_start();
	class Descuentos{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function newDescuento($empleado_id, $fecha_descuento, $tipo_descuento, $monto, $observaciones){
	    	$sqlSave = "INSERT INTO `descuentos`(`empleado_id`, `fecha_descuento`, `tipo_descuento`, `monto`, `observaciones`, `usuario_ingresa`, `usuario_modifica`) VALUES (?, ?, ?, ?, ?, ?, ?)";

	    	$mensaje = "";
	    	
			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("issdsss", $empleado_id, $fecha_descuento, $tipo_descuento, $monto, $observaciones, $_SESSION['usuario'], $_SESSION['usuario']);
			$sentenciaSave->execute();

			$mensaje = "Saved";

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
		    $sqlUpdate = "UPDATE `detalle_pago_empleado` SET `sueldo_ordinario`= ?, `bonificacion_incentivo`= ?, `igss`= ?, `isr`= ?, `usuario_modifica`= ?, `fecha_modificacion`= ?  WHERE `id` = ?";

		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    //datos
			$id = $datos['id'];
			$empleado_id = $datos['empleado_id'];
		    $sueldo_ordinario = $datos['sueldo_ordinario'];
		    $bonificacion_ley = $datos['bonificacion_ley'];
		    $bonificacion_incentivo = $datos['bonificacion_incentivo'];
		    $igss = $datos['igss'];
		    $isr = $datos['isr'];

			// Edita el registro
            $sentenciaUpdate->bind_param("ddddssi", $sueldo_ordinario, $bonificacion_incentivo, $igss, $isr, $_SESSION['usuario'], $fechaActual, $id);
            $sentenciaUpdate->execute();

            $resultados[] = "registrado";

	        //Cerrar conexiones
	        $sentenciaUpdate->close();

		    return $resultados;
		}
	    public function showRegister($id){
	    	$sql = "
	    		SELECT 
				e.id AS empleadoId,
				dpe.id AS detalle_pago_empleado_id,
				e.*, dpe.*
				FROM empleados AS e
				INNER JOIN detalle_pago_empleado AS dpe
				ON e.id = dpe.empleado_id
				WHERE dpe.id = ?
				ORDER BY e.id;
	    	";

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