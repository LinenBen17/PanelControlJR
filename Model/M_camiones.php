<?php
	class Camiones{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function showAllCamiones(){
	    	$sql = "SELECT * FROM camiones";

		    $sentencia = $this->db->prepare($sql);
		    $sentencia->execute();

		    $resultadoSet = $sentencia->get_result();

		    return $resultadoSet;
	    }
	    public function newCamion($modelo, $marca, $placa){
			date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$sqlNewPiloto = "INSERT INTO `camiones`(`id`, `modelo`, `marca`, `placa`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL,?,?,?,?,?)";

			$sentenciaNewPiloto = $this->db->prepare($sqlNewPiloto);
			$sentenciaNewPiloto->bind_param("sssss", $modelo, $marca, $placa, $fechaActual, $fechaActual);
			$sentenciaNewPiloto->execute();
			$sentenciaNewPiloto->close();

			return ["accion" => "Creado"];
	    }
	    public function showCamion($id){
	    	$sqlMostrarUnCamion = "SELECT * FROM camiones WHERE id = ?";

			$sentenciaMostrar = $this->db->prepare($sqlMostrarUnCamion);
			$sentenciaMostrar->bind_param("i", $id);
			$sentenciaMostrar->execute();
			$result = $sentenciaMostrar->get_result();
			$sentenciaMostrar->close();

			return $result;
	    }
	    public function updateCamion($modelo, $marca, $placa, $id){
	    	date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$updateCamion = "UPDATE `camiones` SET `modelo`= ?,`marca`= ?,`placa`= ?,`fecha_modificacion`= ? WHERE `id` = ?";

			$sentenciaEditar = $this->db->prepare($updateCamion);
			$sentenciaEditar->bind_param("ssssi", $modelo, $marca, $placa, $fechaActual, $id);
			$sentenciaEditar->execute();
			$sentenciaEditar->close();

			return ["accion" => "Editado"];
	    }
	    public function deleteCamion($id){
	    	$deteleCamion = "DELETE FROM `camiones` WHERE `id` = ?";

			$sentenciaEliminar = $this->db->prepare($deteleCamion);
			$sentenciaEliminar->bind_param("i", $id);
			$sentenciaEliminar->execute();
			$sentenciaEliminar->close();

			return ["accion" => "Eliminado"];
	    }
	}
?>