<?php
	class Login{
		private $db;
	    public function __construct(){
	        require_once 'Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function getLogin($usuario, $password){
	    	// DATOS ENVIADOS DESDE EL LOGIN
	    	$usuario = filter_var($usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	        //OBTENEMOS LOS DATOS ENVIADOS Y VALIDAMOS
	        $sql = "SELECT id, password, nombre, usuario FROM usuarios WHERE usuario = ?";

	        $sentencia_inicial = $this->db->prepare($sql);
			$sentencia_inicial->bind_param("s", $usuario);
	        $sentencia_inicial->execute();
	        $sentencia_inicial->store_result();

	        //VERIFICAR SI LOS DATOS DEVUELVEN RESULTADOS
	        $num_rows = $sentencia_inicial->num_rows;

			$sentencia_inicial->close();

			//SI HAY RESULTADOS SE VALIDA EL PASS
	        if ($num_rows > 0) {
	            $sentencia_fetch = $this->db->prepare($sql);
	        	$sentencia_fetch->bind_param("s", $usuario);
	        	$sentencia_fetch->execute();

	        	$result = $sentencia_fetch->get_result();
	        	$assoc = $result->fetch_assoc();

	        	$password_bd = $assoc['password'];

	        	$sentencia_fetch->close();

	        	if (password_verify($password, $password_bd)) {
	        		//DEVUELVO EL ID Y EL NOMBRE ASOCIADO AL USUARIO
	        		return [true, $assoc['id'], $assoc['nombre'], $assoc['usuario']];
	        	}else{
	        		return false;
	        	}
	        }
	    }
	}
?> 