<?php
	class Ruta{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function showAllRutas(){
	    	$sql = "SELECT * FROM ruta";

		    $sentencia = $this->db->prepare($sql);
		    $sentencia->execute();

		    $resultadoSet = $sentencia->get_result();

		    return $resultadoSet;
	    }
	    public function newRuta($placa, $piloto, $ruta){
			date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$sqlNewRuta = "INSERT INTO `ruta`(`id`, `placa`, `piloto`, `ruta`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL, ?, ?, ?, ?, ?)";

			$sentenciaNewRuta = $this->db->prepare($sqlNewRuta);
			$sentenciaNewRuta->bind_param("sssss", $placa, $piloto, $ruta, $fechaActual, $fechaActual);
			$sentenciaNewRuta->execute();
			$sentenciaNewRuta->close();

			return ["accion" => "Creado"];
	    }
	    public function showRuta($id){
	    	$sqlMostrarUnaRuta = "SELECT * FROM ruta WHERE id = ?";

			$sentenciaMostrar = $this->db->prepare($sqlMostrarUnaRuta);
			$sentenciaMostrar->bind_param("i", $id);
			$sentenciaMostrar->execute();
			$result = $sentenciaMostrar->get_result();
			$sentenciaMostrar->close();

			return $result;
	    }
	    public function updateRuta($placa, $piloto, $ruta, $id){
	    	date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$updateRuta = "UPDATE `ruta` SET `placa`= ?,`piloto`= ?,`ruta`= ?,`fecha_modificacion`= ? WHERE `id` = ?";

			$sentenciaEditar = $this->db->prepare($updateRuta);
			$sentenciaEditar->bind_param("ssssi", $placa, $piloto, $ruta, $fechaActual, $id);
			$sentenciaEditar->execute();
			$sentenciaEditar->close();

			return ["accion" => "Editado"];
	    }
	    public function deleteRuta($id){
	    	$deleteRuta = "DELETE FROM `ruta` WHERE `id` = ?";

			$sentenciaEliminar = $this->db->prepare($deleteRuta);
			$sentenciaEliminar->bind_param("i", $id);
			$sentenciaEliminar->execute();
			$sentenciaEliminar->close();

			return ["accion" => "Eliminado"];
	    }
	    public function searchPiloto($search){
	    	$sqlSearch = "SELECT * FROM pilotos WHERE nombres LIKE '" . $search . "%'";
			$sentenciaSearch = $this->db->prepare($sqlSearch);
			$sentenciaSearch->execute();

			$resultado = $sentenciaSearch->get_result();

			return $resultado;
	    }
	    public function searchPlaca($search){
	    	$sqlSearchPlaca = "SELECT * FROM camiones WHERE placa LIKE '" . $search . "%'";
			$sentenciaSearchPlaca = $this->db->prepare($sqlSearchPlaca);
			$sentenciaSearchPlaca->execute();

			$resultado = $sentenciaSearchPlaca->get_result();

			return $resultado;
	    }
	}
?>