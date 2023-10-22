<?php
	class Pilotos{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function showAllPilotos(){
	    	$sql = "SELECT * FROM pilotos";

		    $sentencia = $this->db->prepare($sql);
		    $sentencia->execute();

		    $resultadoSet = $sentencia->get_result();

		    return $resultadoSet;
	    }
	    public function newPiloto($nombres, $apellidos, $licencia, $estado){
			date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$sqlNewPiloto = "INSERT INTO `pilotos`(`id`, `nombres`, `apellidos`, `licencia`, `fecha_creacion`, `fecha_modificacion`, `estado`) VALUES (NULL,?,?,?,?,?,?)";

			$sentenciaNewPiloto = $this->db->prepare($sqlNewPiloto);
			$sentenciaNewPiloto->bind_param("sssssi", $nombres, $apellidos, $licencia, $fechaActual, $fechaActual, $estado);
			$sentenciaNewPiloto->execute();
			$sentenciaNewPiloto->close();

			return ["accion" => "Creado"];
	    }
	    public function showPiloto($id){
	    	$sqlMostrarUnPiloto = "SELECT * FROM pilotos WHERE id = ?";

			$sentenciaMostrar = $this->db->prepare($sqlMostrarUnPiloto);
			$sentenciaMostrar->bind_param("i", $id);
			$sentenciaMostrar->execute();
			$result = $sentenciaMostrar->get_result();
			$sentenciaMostrar->close();

			return $result;
	    }
	    public function updatePiloto($nombres, $apellidos, $licencia, $estado, $id){
	    	date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$updatePiloto = "UPDATE `pilotos` SET `nombres`= ?,`apellidos`= ?,`licencia`= ?,`fecha_modificacion`= ?,`estado`= ? WHERE `id` = ?";

			$sentenciaEditar = $this->db->prepare($updatePiloto);
			$sentenciaEditar->bind_param("ssssii", $nombres, $apellidos, $licencia, $fechaActual, $estado, $id);
			$sentenciaEditar->execute();
			$sentenciaEditar->close();

			return ["accion" => "Editado"];
	    }
	    public function deletePiloto($id){
	    	$detelePiloto = "DELETE FROM `pilotos` WHERE `id` = ?";

			$sentenciaEliminar = $this->db->prepare($detelePiloto);
			$sentenciaEliminar->bind_param("i", $id);
			$sentenciaEliminar->execute();
			$sentenciaEliminar->close();

			return ["accion" => "Eliminado"];
	    }
	}
?>