<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    if ($_POST) {
        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sql = "SELECT id, password, nombre FROM usuarios WHERE usuario = ?";

        if ($sentencia_inicial = $mysqli->prepare($sql)) {

	        $sentencia_inicial->bind_param("s", $usuario);
	        $sentencia_inicial->execute();
	        $sentencia_inicial->store_result();

	        $num_rows = $sentencia_inicial->num_rows;

			if ($num_rows > 0) {
	            $sentencia_inicial->close();

	            $sentencia_fetch = $mysqli->prepare($sql);
	        	$sentencia_fetch->bind_param("s", $usuario);
	        	$sentencia_fetch->execute();

	        	$result = $sentencia_fetch->get_result();
	        	$assoc = $result->fetch_assoc();

	        	$password_bd = $assoc['password'];
	        	$pass_c = password_hash("ass", PASSWORD_DEFAULT);

	        	$sentencia_fetch->close();

	        	if (password_verify($password, $password_bd)) {
	        		$_SESSION['id'] = $assoc['id'];
	        		$_SESSION['nombre'] = $assoc['nombre'];

	        		header("location: principal.php");
	        	}else{
?>
					<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	        		<script type="text/javascript">
	        			$(document).ready(function(){
							var contenedorErrorPass = document.querySelector(".errorPassword");
	        				contenedorErrorPass.style.display = "block";
	        			})
	        		</script>
<?php
	        	}
	        }else{
?>
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						var contenedorErrorUser = document.querySelector(".errorUser");
	        			contenedorErrorUser.style.display = "block";
	        		})
				</script>
<?php
	        }
        }	
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/index.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Login | Transportes JR</title>
</head>
<body>
	<section>
		<div class="box">
			<div class="form">
				<h2>Login</h2>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="nope" method="POST">
					<div class="inputBx">
						<input type="text" name="usuario" placeholder="Username" autocomplete="nope">
						<ion-icon name="person-circle-outline"></ion-icon>
					</div>
					<div class="inputBx">
						<input type="password" name="password" placeholder="Contraseña" autocomplete="nope">
						<ion-icon name="lock-closed-outline"></ion-icon>
					</div>
					<div class="errorPassword">
						<p>¡Contraseña Incorrecta! Inténtalo de nuevo.</p>
					</div>
					<div class="errorUser">
						<p>¡Usuario invalido o inexistente! Inténtalo de nuevo.</p>
					</div>
					<div class="inputBx">
						<input type="submit" value="Login">
					</div>
				</form>
				<!--<p>Crear una nueva <a href="create.php">cuenta</a>.</p>-->
			</div>
		</div>
	</section>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>