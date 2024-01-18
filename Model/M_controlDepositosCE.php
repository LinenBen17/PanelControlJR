<?php
	session_start();
	class ControlDepositos{
	    private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function saveDeposito($datos){
		    date_default_timezone_set('America/Guatemala');
		    $fechaActual = date("Y-m-d H:i:s");

		    // Preparar la consulta para comprobar duplicados
		    $sqlSelectBoleta = "SELECT * FROM depositoscontraentregas WHERE noBoleta = ?";
		    $sentenciaSelectBoleta = $this->db->prepare($sqlSelectBoleta);

		    // Preparar la consulta para comprobar duplicados
		    $sqlSelectCE = "SELECT * FROM depositoscontraentregas WHERE noContraEntrega = ?";
		    $sentenciaSelectCE = $this->db->prepare($sqlSelectCE);

		    // Preparar la consulta para comprobar duplicados
		    $sqlSelectGuia = "SELECT * FROM depositoscontraentregas WHERE noGuia = ?";
		    $sentenciaSelectGuia = $this->db->prepare($sqlSelectGuia);

		    // Preparar la consulta de inserción
		    $sqlInsert = "INSERT INTO `depositoscontraentregas`(`id`, `noManifiesto`, `fechaManifiesto`, `noContraEntrega`, `noGuia`, `noBoleta`, `valorBoleta`, `fechaBoleta`, `noCuenta`, `nombreCuenta`, `usuarioIngresa`, `fechaIngreso`, `usuarioModifica`, `fechaModificacion`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		    $sentenciaInsert = $this->db->prepare($sqlInsert);

		    // Variable para almacenar resultados
		    $resultados = [];

		    // Iterar sobre los datos
		    $noBoleta = $datos['noBoleta'];  
		    $fechaManifiesto = $datos['fechaManifiesto'];
		    $noContraEntrega = $datos['noContraEntrega'];
		    $noGuia = $datos['noGuia'];
		    $noManifiesto = $datos['noManifiesto'];
		    $valorBoleta = $datos['valorBoleta'];
		    $fechaBoleta = $datos['fechaBoleta'];
		    $noCuenta = $datos['noCuenta'];
		    $nombreCuenta = $datos['nombreCuenta'];

		    // Comprobar duplicados
		    $sentenciaSelectBoleta->bind_param("i", $noBoleta);
		    $sentenciaSelectBoleta->execute();
		    $resultadoSelectBoleta = $sentenciaSelectBoleta->get_result();

		    // Comprobar duplicados
		    $sentenciaSelectCE->bind_param("i", $noContraEntrega);
		    $sentenciaSelectCE->execute();
		    $resultadoSelectCE = $sentenciaSelectCE->get_result();

		    // Comprobar duplicados
		    $sentenciaSelectGuia->bind_param("i", $noGuia);
		    $sentenciaSelectGuia->execute();
		    $resultadoSelectGuia = $sentenciaSelectGuia->get_result();

		    if ($resultadoSelectBoleta->num_rows > 0) {
		        $resultados[] = "repetidoBoleta";
		    } elseif ($resultadoSelectCE->num_rows > 0) {
		        $resultados[] = "repetidoCE";
		    } elseif ($resultadoSelectGuia->num_rows > 0) {
		        $resultados[] = "repetidoGuia";
		    } else {
		        // Insertar nuevo registro
		        $sentenciaInsert->bind_param("isiiidsisssss", $noManifiesto, $fechaManifiesto, $noContraEntrega, $noGuia, $noBoleta, $valorBoleta, $fechaBoleta, $noCuenta, $nombreCuenta, $_SESSION['usuario'], $fechaActual, $_SESSION['usuario'], $fechaActual);
		        $sentenciaInsert->execute();
		        $resultados[] = "registrado";
		    }

		    // Cerrar las consultas y liberar recursos
		    $sentenciaSelectBoleta->close();
		    $sentenciaSelectCE->close();
		    $sentenciaSelectGuia->close();
		    $sentenciaInsert->close();

		    return $resultados;
		}
	    public function showDepositoUser(){
	    	$sql = "SELECT * FROM depositoscontraentregas WHERE usuarioIngresa = ?";

		    $sentencia = $this->db->prepare($sql);
		    $sentencia->bind_param("s", $_SESSION['usuario']);
		    $sentencia->execute();

		    return $sentencia->get_result();
	    }
	    public function showAllCE(){
	    	$sql = "SELECT * FROM depositoscontraentregas";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	    public function showRegister($id){
			$sql = "SELECT * FROM depositoscontraentregas WHERE id = ?";

			$sentencia = $this->db->prepare($sql);
			$sentencia->bind_param("i", $id);
			$sentencia->execute();
			$resultadoSet = $sentencia->get_result();

			return $resultadoSet;
		}
		//SE DEBE REALIZAR LA FUNCION PARA EDITAR


		public function deleteRegister($id){
			$sql = "DELETE FROM gastos WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$exec = $sentencia->execute();

	    	return ["deleted"];

		}
	}
?>