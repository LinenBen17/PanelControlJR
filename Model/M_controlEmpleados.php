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
	    public function selectAllByUser(){
	    	$sql = "SELECT * FROM facturascombustibles WHERE usuario_ingresa = ?";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("s", $_SESSION['usuario']);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function selectAll(){
	    	$sql = "SELECT * FROM facturascombustibles";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function update($datos){
			date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta de inserción
		    $sqlUpdate = "UPDATE `facturascombustibles` SET `fecha`= ?, `fechaVale`= ?, `placa`= ?, `piloto`= ?, `ruta`= ?, `serie`= ?, `noFactura`= ?, `galones`= ?, `tipoCombustible`= ?, `precio_galon`= ?, `monto_total`= ?, `fecha_modificacion`= ?, `usuario_modifica`= ? WHERE id = ?";
		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    // Iterar sobre los datos
			$id = $datos['id'];
			$fecha = $datos['fecha'];
		    $fechaVale = $datos['fechaVale'];

		    $placa = $datos['placa'];
		    $piloto = $datos['piloto'];
		    $ruta = $datos['ruta'];
		    $serie = $datos['serie'];
		    $noFactura = $datos['noFactura'];
		    $galones = $datos['galones'];
		    $tipoCombustible = $datos['tipoCombustible'];
		    $precio_galon = $datos['precio_galon'];
		    $monto_total = $datos['monto_total'];

			// Edita el registro
            $sentenciaUpdate->bind_param("ssssssidsddssi", $fecha, $fechaVale, $placa, $piloto, $ruta, $serie, $noFactura, $galones, $tipoCombustible, $precio_galon, $monto_total, $fechaActual, $_SESSION['usuario'], $id);
            $sentenciaUpdate->execute();

            $resultados[] = "registrado";

	        //Cerrar conexiones
	        $sentenciaUpdate->close();

		    return $resultados;
		}
	    public function showRegister($id){
	    	$sql = "SELECT * FROM facturascombustibles WHERE id = ?";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function deleteRegister($id){
			$sql = "DELETE FROM facturascombustibles WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?> 