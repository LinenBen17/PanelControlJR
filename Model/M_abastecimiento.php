<?php
	class Abastecimiento{
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function showAllAbastecimiento(){
	    	$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento";

		    $sentencia = $this->db->prepare($sql);
		    $sentencia->execute();

		    $resultadoSet = $sentencia->get_result();

		    return $resultadoSet;
	    }
	    public function delete($id){
	    	$sql = "DELETE FROM abastecimiento WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	if ($exec) {
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }
	    public function update($placa, $piloto, $ruta, $km_inicial, $km_final, $monto_total, $galones, $precio_galon, $id){
			$sqlEdit = "UPDATE abastecimiento SET placa = ?, piloto = ?, ruta = ?, km_inicial = ?, km_final = ?, monto_total = ?, galones = ?, precio_galon = ? WHERE id = ?";

			$sentencia = $this->db->prepare($sqlEdit);
			$sentencia->bind_param("sssiidddi", $placa, $piloto, $ruta, $km_inicial, $km_final, $monto_total, $galones, $precio_galon, $id);
			$sentencia->execute();

			return true;
	    }
		public function showRegister($id){
			$sql = "SELECT * FROM abastecimiento WHERE id = ?";

			$sentencia = $this->db->prepare($sql);
			$sentencia->bind_param("i", $id);
			$sentencia->execute();
			$resultadoSet = $sentencia->get_result();

			return $resultadoSet;
		}
	    public function newAbastecimiento($placa, $piloto, $ruta, $km_inicial, $km_final, $monto_total, $galones, $precio_galon, $fecha, $rendimiento){
			date_default_timezone_set('America/Guatemala');
			$fechaActual = date("Y-m-d H:i:s");

	    	$sqlSave = "INSERT INTO `abastecimiento`(`id`, `placa`, `piloto`, `ruta`, `km_inicial`, `km_final`, `monto_total`, `galones`, `precio_galon`, `fecha_creacion`, `fecha_modificacion`, `fecha_combustible`, `rendimiento`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)";

			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("sssiiiiisssi", $placa, $piloto, $ruta, $km_inicial, $km_final, $monto_total, $galones, $precio_galon, $fechaActual, $fechaActual, $fecha, $rendimiento);
			$sentenciaSave->execute();

			return ["accion" => "Saved"];
	    }
	    public function searchPlaca($search){
	    	$sqlSearch = "SELECT * FROM ruta WHERE placa = ? LIMIT 1";

			$sentenciaSearch = $this->db->prepare($sqlSearch);
			$sentenciaSearch->bind_param("s", $search);
			$sentenciaSearch->execute();
			$result = $sentenciaSearch->get_result();
			
			return $result;
	    }
	    public function searchLastPlaca($search){
	    	$sqlSearch = "SELECT * FROM abastecimiento WHERE placa = ? ORDER BY id DESC LIMIT 1";

			$sentenciaSearch = $this->db->prepare($sqlSearch);
			$sentenciaSearch->bind_param("s", $search);
			$sentenciaSearch->execute();
			$result = $sentenciaSearch->get_result();
			
			return $result;
	    }
	    public function filtroPorPlaca($placaFilter){
	    	$sqlFiltroPlaca = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento WHERE placa = ?";

			$sentenciaFiltroPlaca = $this->db->prepare($sqlFiltroPlaca);
			$sentenciaFiltroPlaca->bind_param("s", $placaFilter);
			$sentenciaFiltroPlaca->execute();
			$result = $sentenciaFiltroPlaca->get_result();

			return $result;
	    }
	    public function filtroPorFecha($fechaFilter){
			$fechaFormateada = date("d/m/Y", strtotime($fechaFilter));

			$sqlFiltroFecha = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento WHERE DATE_FORMAT(fecha_creacion, '%d/%m/%Y') = ?";

			$sentenciaFiltroFecha = $this->db->prepare($sqlFiltroFecha);
			$sentenciaFiltroFecha->bind_param("s", $fechaFormateada);
			$sentenciaFiltroFecha->execute(); 
			$result = $sentenciaFiltroFecha->get_result();

			return $result;
	    }
	    public function filtroEntreFechas($fechaI, $fechaF){
			$fechaInicial = date("d/m/Y", strtotime($fechaI));
			$fechaFinal = date("d/m/Y", strtotime($fechaF));

			$sqlFiltroFecha = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacionM, DATE_FORMAT(fecha_modificacion, '%d/%m/%Y') AS fecha_modificacionM FROM abastecimiento WHERE DATE_FORMAT(fecha_creacion, '%d/%m/%Y') >= ? AND DATE_FORMAT(fecha_creacion, '%d/%m/%Y') <= ?";

			$sentenciaFiltroFecha = $this->db->prepare($sqlFiltroFecha);
			$sentenciaFiltroFecha->bind_param("ss", $fechaInicial, $fechaFinal);
			$sentenciaFiltroFecha->execute(); 
			$result = $sentenciaFiltroFecha->get_result();

			return $result;
	    }
	}
?>