<?php
	class Conexion{
	    public static function conectar(){
	    	// CONEXION A LA DB
			try {
				$mysqli= new mysqli("localhost", "root", "", "u969496133_sistemjr");
				
				// Establecer el conjunto de caracteres a UTF-8
		        if (!$mysqli->set_charset('utf8mb4')) {
		            die('Error cargando el conjunto de caracteres utf8mb4: ' . $mysqli->error);
		        }
				return $mysqli;
			} catch (mysqli_sql_exception $e) {
				die("Error de conexión: " . $e->getMessage());
			}
	    }
	}
?> 