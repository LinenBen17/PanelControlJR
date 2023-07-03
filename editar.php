<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    require 'validacionSesion.php';

        // Función para verificar los permisos de un usuario
    function verificarPermiso($usuarioId, $permisoRequerido) {
        require 'conexion.php';

        // Realizar la consulta para obtener los permisos del usuario
        $query = "SELECT COUNT(*) AS count FROM asignacion AS a
                  JOIN permisos AS p ON a.id_permiso = p.id
                  WHERE a.id_usuario = ? AND p.seccion = ?";

        // Ejecutar la consulta y obtener el resultado
        // Aquí asumimos que estás utilizando una conexión a la base de datos llamada $mysqli
        $sentencia = $mysqli->prepare($query);
        $sentencia->bind_param("is", $usuarioId, $permisoRequerido);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        // Obtener el número de filas del resultado
        $assoc = $resultado->fetch_assoc();
        $count = $assoc['count'];

        return $count > 0; // Devolver true si el usuario tiene el permiso requerido, false en caso contrario
    }

    $idGet = $_GET['id'];

    //SQL OBTENER DATOS USUARIO
    $sqlUsuarios = "SELECT usuario, nombre FROM usuarios WHERE id = ?";

    $sentenciaUsuarios = $mysqli->prepare($sqlUsuarios);
    $sentenciaUsuarios->bind_param("i", $idGet);
    $sentenciaUsuarios->execute();

    $resultadoUsuarios = $sentenciaUsuarios->get_result();
    $assocUsuarios = $resultadoUsuarios->fetch_assoc();

    $sentenciaUsuarios->close();

    //SQL OBTENER PERMISOS
    $sqlAsignaciones = "SELECT * FROM asignacion WHERE id_usuario = ?";

    $sentenciaAsignaciones = $mysqli->prepare($sqlAsignaciones);
    $sentenciaAsignaciones->bind_param("i", $idGet);
    $sentenciaAsignaciones->execute();

    $resultadosAsignaciones = $sentenciaAsignaciones->get_result();

    $sentenciaAsignaciones->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>
	<div class="container">
		<?php require 'navigation.php'; ?>
		<!-- Main -->
		<div class="main">
			<div class="topbar">
				<div class="toggle">
					<ion-icon name="menu-outline"></ion-icon>
				</div>
				<!-- search -->
				<div class="search">
					<label>
						<input type="text" placeholder="Search here">
						<ion-icon name="search-outline"></ion-icon>
					</label>
				</div>
				<!-- userImg -->
				<?php require 'userImg.php'; ?>
			</div>
			<div class="details"> 
				<div class="recentOrders">
					<div class="cardHeader">
						<h2>Editar Usuario</h2>
					</div>
					<div class="formBx">
						<form method="POST" class="form" action="guarda.php">
							<div class="inputBx">
								<input type="hidden" name="id" value="<?php echo $idGet; ?>">
							</div>
							<div class="inputBx">
								<label>Usuario:</label><br>
								<input type="text" name="usuario" value="<?php echo htmlspecialchars($assocUsuarios['usuario']); ?>">
							</div>
							<div class="inputBx">
								<label>Nombre del Usuario:</label><br>
								<input type="text" name="nombre" value="<?php echo htmlspecialchars($assocUsuarios['nombre']); ?>">
							</div>
							<label>Permisos del usuario:</label><br><br>
							<div class="roles">
								<?php
									//SQL MOSTRAR PERMISOS PARA SELECCIONAR
									$sqlOpciones = "SELECT * FROM permisos";

									$sentenciaOpciones = $mysqli->prepare($sqlOpciones);
									$sentenciaOpciones->execute();

									$resultadosPermisos = $sentenciaOpciones->get_result();

    								$sentenciaOpciones->close();

									foreach ($resultadosPermisos as $resultadoPermiso) {
										$seccionPermiso = $resultadoPermiso['seccion'];
										$idPermiso = $resultadoPermiso['id'];

										$asignaciones = $resultadosAsignaciones;
										$checked = "";

										foreach ($asignaciones as $asignacion) {
									    	if ($asignacion['id_permiso'] == $idPermiso) {
									    		$checked = "checked";
									    	}
									    }
								?>
										<div class="checkBox">
											<p><?php echo $resultadoPermiso['seccion']; ?></p>
											<label class="switch">
												<input type="checkbox" name="<?php echo strtolower(str_replace(" ", "", $seccionPermiso)); ?>" value="<?php echo $idPermiso; ?>" <?php echo $checked; ?>>
												<span class="slider round"></span>
											</label>
										</div>
								<?php		
									}

								?>
							</div>
							<div class="inputBx">
								<a href="principal.php" class="btn">Regresar</a>
								<input type="submit" name="submit" class="btn" value="Editar">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<script>
		//MenuToggle
		let toggle = document.querySelector('.toggle');
		let navigation = document.querySelector('.navigation');
		let main = document.querySelector('.main');

		toggle.onclick = function(){
			navigation.classList.toggle('active');
			main.classList.toggle('active');
		}
		//add hovered class in selected list item
		let list = document.querySelectorAll('.navigation li');
		function activeLink() {
			list.forEach((item)=>{
				item.classList.remove('hovered');
			});
			this.classList.add('hovered');
		}
		list.forEach((item)=>{
			item.addEventListener('mouseover', activeLink)
		})
	</script>
	<script>
		var checkboxs = document.querySelectorAll('input[type="checkbox"]');
		checkboxs.forEach(input => {
			var name = input.name;
			console.log(name + " " + input.checked);
		});
	</script>
</body>
</html>