<?php
	require_once '../Model/M_login.php';
 
	if ($_POST) {	
		$login = new Login();
		$loginExitoso = $login->getLogin($_POST['usuario'], $_POST['password']);

		if ($loginExitoso[0] == "exito") {
			//CREO UNA SESION CON EL ID Y EL NOMBRE
			session_start();

			$_SESSION['id'] = $loginExitoso[1];
	        $_SESSION['nombre'] = $loginExitoso[2];
	        $_SESSION['usuario'] = $loginExitoso[3];

		    echo json_encode(["Correcto"]);
		} else {
			echo json_encode(["Incorrecto"]);
		}
	}
?> 