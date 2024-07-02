	<?php

	session_start();
	class Bonos{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function newBono($empleado_id, $fecha_bono, $monto, $observaciones){
	    	$sqlSave = "INSERT INTO `bonos`(`empleado_id`, `fecha_bono`, `monto`, `observaciones`, `usuario_ingresa`, `usuario_modifica`) VALUES (?, ?, ?, ?, ?, ?) ";

	    	$mensaje = "";
	    	
			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("isdsss", $empleado_id, $fecha_bono, $monto, $observaciones, $_SESSION['usuario'], $_SESSION['usuario']);
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
	    public function selectAllBonos(){
	    	$sql = "
	    		SELECT 
				e.id AS empleadoId,
				b.id AS bonos_id,
				e.*, b.*
				FROM empleados AS e
				INNER JOIN bonos AS b
				ON e.id = b.empleado_id ORDER BY e.id;
	    	";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function update($datos){
			date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta de inserción
		    $sqlUpdate = "UPDATE `bonos` SET `fecha_bono`= ?, `monto`= ?, `observaciones`= ?, `fecha_modificacion`= ?, `usuario_modifica`= ?  WHERE `id` = ?";

		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    //datos
			$id = $datos['id'];
		    $fecha_bono = $datos['fecha_bono'];
		    $monto = $datos['monto'];
		    $observaciones = $datos['observaciones'];

			// Edita el registro
            $sentenciaUpdate->bind_param("sdsssi", $fecha_bono, $monto, $observaciones, $fechaActual, $_SESSION['usuario'], $id);
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
				b.id AS bonos_id,
				e.*, b.*
				FROM empleados AS e
				INNER JOIN bonos AS b
				ON e.id = b.empleado_id
				WHERE b.id = ?
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