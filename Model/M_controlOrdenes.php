<?php

	session_start();
	class OrdenesCompra{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function newOrder($datos){
	    	//VARIABLES OBTENIDAS DEL PARAMETRO
	    	$noOrden = $datos["noOrden"];
	    	$noFactura = $datos["noFactura"];
	    	$fecha = $datos["fecha"];
	    	$proveedor = $datos["proveedor"];
	    	$placa = $datos["placa"];
	    	$cantidad = $datos["cantidad"];
	    	$descripcion = $datos["descripcion"];
	    	$precioUnitario = $datos["precioUnitario"];
	    	$total = $datos["total"];
	    	$observacion = $datos["observacion"];

	    	$sqlSave = "INSERT INTO `ordenesdecompra`(`noOrden`, `noFactura`, `fecha`, `proveedor`, `placa`, `cantidad`, `descripcion`, `precioUnitario`, `total`, `observacion`, `usuario_ingresa`, `usuario_modifica`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("issssisddsss", $noOrden, $noFactura, $fecha, $proveedor, $placa, $cantidad, $descripcion, $precioUnitario, $total, $observacion, $_SESSION['usuario'], $_SESSION['usuario']);
			$sentenciaSave->execute();

			return ["accion" => "Saved"];
	    }
	    public function selectAllByUser(){
	    	$sql = "SELECT * FROM ordenesdecompra WHERE usuario_ingresa = ?";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("s", $_SESSION['usuario']);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function selectAll(){
	    	$sql = "SELECT * FROM ordenesdecompra";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function update($datos){
			date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta de inserción
		    $sqlUpdate = "UPDATE `ordenesdecompra` SET `noOrden`=?, `noFactura`=?, `fecha`=?, `proveedor`=?, `placa`=?, `cantidad`=?, `descripcion`=?, `precioUnitario`=?, `total`=?, `observacion`=?, `usuario_modifica`=?, `fecha_modificacion`=? WHERE `id`= ?";

		    $sentenciaUpdate = $this->db->prepare($sqlUpdate);

		    // Variable para almacenar resultados
		    $resultados = [];
 
		    // Iterar sobre los datos
		    $id = $datos["id"];
			$noOrden = $datos['noOrden'];
			$noFactura = $datos['noFactura'];
		    $fecha = $datos['fecha'];

		    $proveedor = $datos['proveedor'];
		    $placa = $datos['placa'];
		    $cantidad = $datos['cantidad'];
		    $descripcion = $datos['descripcion'];
		    $precioUnitario = $datos['precioUnitario'];
		    $total = $datos['total'];
		    $observacion = $datos['observacion'];

			// Edita el registro
            $sentenciaUpdate->bind_param("issssisddsssi", $noOrden, $noFactura, $fecha, $proveedor, $placa, $cantidad, $descripcion, $precioUnitario, $total, $observacion, $_SESSION['usuario'], $fechaActual,$id);
            $sentenciaUpdate->execute();

            $resultados[] = "registrado";

	        //Cerrar conexiones
	        $sentenciaUpdate->close();

		    return $resultados;
		}
	    public function showRegister($id){
	    	$sql = "SELECT * FROM ordenesdecompra WHERE id = ?";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function deleteRegister($id){
			$sql = "DELETE FROM ordenesdecompra WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?> 