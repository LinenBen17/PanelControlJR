<?php
	class Conexion{
	    public static function conectar(){
	    	// CONEXION A LA DB
			try {
				$mysqli= new mysqli("localhost", "root", "", "reclamos");
				return $mysqli;
			} catch (mysqli_sql_exception $e) {
				die("Error de conexión: " . $e->getMessage());
			}
	    }
	}
?> 