<?php
	class ImpresionMadres{ 
		private $db;

	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function searchGuia($codigo){
		    $codigo = $codigo;
		    
		    // CONSULTA ENVIOS
		    $sql_datos = "SELECT * FROM bdstandar WHERE codigo = ?";
		    $datos = $this->db->prepare($sql_datos);
		    $datos->bind_param("s", $codigo);
		    $datos->execute();

		    $result_datos = $datos->get_result();

		    // Crear un array para almacenar todos los resultados obtenidos
		    $datosEncontrados = array();
		    while ($assoc_datos = $result_datos->fetch_assoc()) {
		        // Almacenar cada resultado en el array
		        $datosEncontrados[] = array(
		            'idcliente' => $assoc_datos['idcliente'],
		            'nombre' => $assoc_datos['nombre'],
		            'direccion' => $assoc_datos['direccion'],
		            'telefono' => $assoc_datos['telefono'],
		            'contacto' => $assoc_datos['contacto'],
		            'destino' => $assoc_datos['destino'],
		        );
		    }

		    $datos->close();

			return $datosEncontrados;
	    }
	    public function newGuia($codigo, $nombre, $direccion, $telefono, $destino, $contacto){
	    	$codigo = $codigo ?? null;
	    	$nombre = $nombre ?? null;
	    	$direccion = $direccion ?? null;
	    	$telefono = $telefono ?? null;
	    	$destino = $destino ?? null;
	    	$contacto = $contacto ?? null;

	    	$sqlCrearClientes = "INSERT INTO bdstandar (codigo, nombre, direccion, telefono, contacto, destino) VALUES(?,?,?,?,?,?)";

	    	$creando = $this->db->prepare($sqlCrearClientes);
	    	$creando->bind_param("ssssss", $codigo, $nombre, $direccion, $telefono, $contacto, $destino);
	    	$creando->execute();

	    	$creando->close();

	    	return true;
	    }
	}
?>