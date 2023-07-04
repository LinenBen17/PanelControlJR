<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    require 'validacionSesion.php';

	$correcto = false;

    if (isset($_POST['id'])) {

    	$id = $_POST['id'];

		//SQL PARA SABER SI EXISTE EL ID QUE SE ESTÁ ENVIANDO
		$sqlExisteID = "SELECT id FROM usuarios WHERE id = ?";

		$sentenciaExistencia = $mysqli->prepare($sqlExisteID);
		$sentenciaExistencia->bind_param("s", $id);
		$sentenciaExistencia->execute();
		$sentenciaExistencia->store_result();

		$resultadoExistencia = $sentenciaExistencia->num_rows;

		// SI HAY 0 REGISTROS CON ESE ID ENTONCES NO EXISTE
		if ($resultadoExistencia == 0) {
			// SQL PARA OBTENER TODOS LOS PERMISOS
			$sqlRoles = "SELECT seccion FROM permisos";
			$sentenciaRoles = $mysqli->prepare($sqlRoles);
			$sentenciaRoles->execute();

			$roles = $sentenciaRoles->get_result();

			//ARRAY DINAMICO QUE AGREGA TODOS LOS PERMISOS EN LA DB
			$secciones = array();
			foreach ($roles as $rol) {
				$secciones[strtolower(str_replace(" ", "", $rol['seccion']))] = $_POST[strtolower(str_replace(" ", "", $rol['seccion']))] ?? null;
			}

			//Usuarios datos
    		$id = $_POST['id'];
	    	$usuario = $_POST['usuario'];
	    	$nombre = $_POST['nombre'];
	    	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	    	// Filtrar las variables de permisos para obtener solo los valores no nulos
			$permisos = array_filter($secciones);

			// SENTENCIAS SQL
	    	$sqlUsuarios = "INSERT INTO usuarios (id, usuario, password, nombre) VALUES (NULL, ?, ?, ?)";
	    	$sqlPermisos = "INSERT INTO asignacion (id, id_usuario, id_permiso) VALUES (NULL, ?, ?)";

	    	$sentenciaUsuarios = $mysqli->prepare($sqlUsuarios);
	    	$sentenciaUsuarios->bind_param("sss", $usuario, $password, $nombre);
	    	$execUsuarios = $sentenciaUsuarios->execute();

			$sentenciaUsuarios->close();

	    	// Insertar los permisos en la base de datos
			foreach ($permisos as $permiso) {
	    		$sentenciaPermisos = $mysqli->prepare($sqlPermisos);
			    $sentenciaPermisos->bind_param("ii", $id, $permiso);
			    $sentenciaPermisos->execute();

			}

			$correcto = true;
			header("location:controlUsuarios.php");

			$sentenciaPermisos->close();


		}else{ //ESTE ELSE ES PARA LA SECCION DE EDITAR USUARIOS
			// SQL PARA OBTENER TODOS LOS PERMISOS
			$sqlRoles = "SELECT seccion FROM permisos";
			$sentenciaRoles = $mysqli->prepare($sqlRoles);
			$sentenciaRoles->execute();

			$roles = $sentenciaRoles->get_result();

			//ARRAY DINAMICO QUE AGREGA TODOS LOS PERMISOS EN LA DB
			$secciones = array();
			foreach ($roles as $rol) {
				$secciones[strtolower(str_replace(" ", "", $rol['seccion']))] = $_POST[strtolower(str_replace(" ", "", $rol['seccion']))] ?? null;
			}

			//Usuarios datos
    		$id = $_POST['id'];
	    	$usuario = $_POST['usuario'];
	    	$nombre = $_POST['nombre'];

	    	// SQL EDITAR NOMBRE Y USUARIO ACTUAL
			$sqlEdit = "UPDATE usuarios SET usuario = ?, nombre = ? WHERE id = ?";

			$sentenciaEdit = $mysqli->prepare($sqlEdit);
			$sentenciaEdit->bind_param("ssi", $usuario, $nombre, $id);
			$sentenciaEdit->execute();

			$sentenciaEdit->close();

	    	// Filtrar las variables de permisos para obtener solo los valores no nulos
			$permisosNuevos = array_filter($secciones);

			//SQL PARA SABER LOS PERMISOS ACTUALES DEL USUARIO
			$sqlId = "SELECT * FROM asignacion WHERE id_usuario = ?";

			$sentenciaId = $mysqli->prepare($sqlId);
			$sentenciaId->bind_param("i", $id);
			$sentenciaId->execute();

			$resultadosId = $sentenciaId->get_result();

			// ARREGLO Y LUEGO FOREACH PARA ALMACENAR LOS PERMISOS ACTUALES;
			$permisosActuales=[];

			foreach ($resultadosId as $resultado) {
				$permisosActuales[] = $resultado['id_permiso'];
			}

			// Calcula los permisos que se deben eliminar
			$permisosEliminar = array_diff($permisosActuales, $permisosNuevos);
			// Calcula los permisos que se deben agregar
			$permisosAgregar = array_diff($permisosNuevos, $permisosActuales);

			// Eliminar permisos que ya no están seleccionados
			if (!empty($permisosEliminar)) {
			    $sqlEliminarPermisos = "DELETE FROM asignacion WHERE id_usuario = ? AND id_permiso = ?";
			    $sentenciaEliminarPermisos = $mysqli->prepare($sqlEliminarPermisos);
			    foreach ($permisosEliminar as $permiso) {
			    	$sentenciaEliminarPermisos->bind_param("ii", $id, $permiso);
			        $sentenciaEliminarPermisos->execute();
			    }
			    $sentenciaEliminarPermisos->close();
			}

			// Agregar nuevos permisos seleccionados
			if (!empty($permisosAgregar)) {
			    $sqlAgregarPermisos = "INSERT INTO asignacion (id_usuario, id_permiso) VALUES (?, ?)";
			    $sentenciaAgregarPermisos = $mysqli->prepare($sqlAgregarPermisos);
			    foreach ($permisosAgregar as $permiso) {
			    	$sentenciaAgregarPermisos->bind_param("ii", $id, $permiso);
			        $sentenciaAgregarPermisos->execute();
			    }

				$sentenciaAgregarPermisos->close();
			}

		    $correcto = true;
		    header("location:controlUsuarios.php");
		}
    }
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
						<h2>Confirmación</h2>
					</div>
					<?php if ($correcto == false) { ?>
						<div class="errorGuia">
							<span class="status pending">Hubo un error al realizar la consulta. ¡Intentalo de nuevo!</span>
						</div>
					<?php } ?>
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
</body>
</html>