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
	    public function selectAllDescuentos(){
	    	$sql = "
	    		SELECT 
				e.id AS empleadoId,
				d.id AS descuentos_id,
				e.*, d.*
				FROM empleados AS e
				INNER JOIN descuentos AS d
				ON e.id = d.empleado_id ORDER BY e.id;
	    	";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function update($datos){
			date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta de inserción
		    $sqlUpdate = "UPDATE `descuentos` SET `fecha_descuento`= ?, `tipo_descuento`= ?, `monto`= ?, `observaciones`= ?, `fecha_modifica`= ?, `usuario_modifica`= ?  WHERE `id` = ?";

		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    //datos
			$id = $datos['id'];
		    $fecha_descuento = $datos['fecha_descuento'];
		    $tipo_descuento = $datos['tipo_descuento'];
		    $monto = $datos['monto'];
		    $observaciones = $datos['observaciones'];

			// Edita el registro
            $sentenciaUpdate->bind_param("ssdsssi", $fecha_descuento, $tipo_descuento, $monto, $observaciones, $fechaActual, $_SESSION['usuario'], $id);
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
				d.id AS descuentos_id,
				e.*, d.*
				FROM empleados AS e
				INNER JOIN descuentos AS d
				ON e.id = d.empleado_id
				WHERE d.id = ?
				ORDER BY e.id;
	    	";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function deleteRegister($id){
			$sql = "DELETE FROM descuentos WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?> 