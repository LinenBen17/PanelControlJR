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
	    public function newAbastecimiento($placa, $piloto, $ruta, $km_inicial, $km_final, $monto_total, $galones, $precio_galon){
			date_default_timezone_set('America/Guatemala');
			$fechaActual = date("d/m/Y");

	    	$sqlSave = "INSERT INTO `abastecimiento`(`id`, `placa`, `piloto`, `ruta`, `km_inicial`, `km_final`, `monto_total`, `galones`, `precio_galon`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";

			$sentenciaSave = $this->db->prepare($sqlSave);
			$sentenciaSave->bind_param("sssiiiiiss", $placa, $piloto, $ruta, $km_inicial, $km_final, $monto_total, $galones, $precio_galon, $fechaActual, $fechaActual);
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