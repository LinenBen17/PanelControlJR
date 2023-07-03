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
						<h2>Tracking Guía</h2>
					</div>
					<div class="inputBx">
						<form method="POST">
							<label>Introduce el número de guía:</label><br>
							<input type="text" name="noguia">
							<input type="submit" class="btn" value="Consultar">
						</form>
						<?php
						    if ($_POST) {
						    	$noguia = $_POST['noguia'];

						    	$sql_descarga_camiones = "SELECT escaneo, fecha, responsabl, manifiesto, rutaingres FROM descargacamiones WHERE escaneo = ?";
						    	$sql_carga_camiones = "SELECT escaneo, fecha, responsabl, manifiesto, rutadestin FROM cargacamiones WHERE escaneo = ?";
						    	$sql_envios = "SELECT no_guia, fecha, responsabl, manifiesto, destino, rutaingres, fecharecib, fechapago FROM envios WHERE no_guia = ?";

						    	if ($sentencia_rows_descarga = $mysqli->prepare($sql_descarga_camiones) and $sentencia_rows_carga = $mysqli->prepare($sql_carga_camiones) and $sentencia_rows_envios = $mysqli->prepare($sql_envios)) {
						    		$sentencia_rows_descarga->bind_param("s", $noguia);
						    		$sentencia_rows_descarga->execute();
						    		$sentencia_rows_descarga->store_result();

						    		$sentencia_rows_carga->bind_param("s", $noguia);
						    		$sentencia_rows_carga->execute();
						    		$sentencia_rows_carga->store_result();

						    		$sentencia_rows_envios->bind_param("s", $noguia);
						    		$sentencia_rows_envios->execute();
						    		$sentencia_rows_envios->store_result();

						    		$num_rows_descarga = $sentencia_rows_descarga->num_rows;
						    		$num_rows_carga = $sentencia_rows_carga->num_rows;
						    		$num_rows_envios = $sentencia_rows_envios->num_rows;

						    		if ($num_rows_descarga > 0 or $num_rows_carga > 0 or $num_rows_envios > 0) {
						    			$sentencia_rows_descarga->close();
						    			$sentencia_rows_carga->close();
						    			$sentencia_rows_envios->close();

						    			$sentencia_assoc_descarga = $mysqli->prepare($sql_descarga_camiones);
						    			$sentencia_assoc_descarga->bind_param("s", $noguia);
						    			$sentencia_assoc_descarga->execute();

						    			$result_descarga = $sentencia_assoc_descarga->get_result();
						    			$assoc_descarga = $result_descarga->fetch_assoc();

						    			$sentencia_assoc_descarga->close();

						    			$sentencia_assoc_carga = $mysqli->prepare($sql_carga_camiones);
						    			$sentencia_assoc_carga->bind_param("s", $noguia);
						    			$sentencia_assoc_carga->execute();

						    			$result_carga = $sentencia_assoc_carga->get_result();
						    			$assoc_carga = $result_carga->fetch_assoc();

						    			$sentencia_assoc_carga->close();

										$sentencia_assoc_envios = $mysqli->prepare($sql_envios);
						    			$sentencia_assoc_envios->bind_param("s", $noguia);
						    			$sentencia_assoc_envios->execute();

						    			$result_envios = $sentencia_assoc_envios->get_result();
						    			$assoc_envios = $result_envios->fetch_assoc();

						    			$sentencia_assoc_envios->close();
						?>
					</div>
					<div class="cardHeader">
						<h2>Ingreso Camiones</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>No. Guía</td>
								<td>Fecha</td>
								<td>Manifiesto</td>
								<td>Ruta Ingreso</td>
								<td>Responsable</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php if($assoc_descarga['escaneo'] != NULL){ echo htmlspecialchars($assoc_descarga['escaneo']); } ?></td>
								<td><?php if($assoc_descarga['fecha'] != NULL){ echo htmlspecialchars($assoc_descarga['fecha']); } ?></td>
								<td><?php if($assoc_descarga['manifiesto'] != NULL){ echo htmlspecialchars($assoc_descarga['manifiesto']); } ?></td>
								<td><?php if($assoc_descarga['rutaingres'] != NULL){ echo htmlspecialchars($assoc_descarga['rutaingres']); } ?></td>
								<td><?php if($assoc_descarga['responsabl'] != NULL){ echo htmlspecialchars($assoc_descarga['responsabl']); } ?></td>
							</tr>
						</tbody>
					</table>
					<div class="cardHeader">
						<h2>Salida Camiones</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>No. Guía</td>
								<td>Fecha</td>
								<td>Manifiesto</td>
								<td>Ruta Destino</td>
								<td>Responsable</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php if($assoc_carga['escaneo'] != NULL){ echo htmlspecialchars($assoc_carga['escaneo']); } ?></td>
								<td><?php if($assoc_carga['fecha'] != NULL){ echo htmlspecialchars($assoc_carga['fecha']); } ?></td>
								<td><?php if($assoc_carga['manifiesto'] != NULL){ echo htmlspecialchars($assoc_carga['manifiesto']); } ?></td>
								<td><?php if($assoc_carga['rutadestin'] != NULL){ echo htmlspecialchars($assoc_carga['rutadestin']); } ?></td>
								<td><?php if($assoc_carga['responsabl'] != NULL){ echo htmlspecialchars($assoc_carga['responsabl']); } ?></td>
							</tr>
						</tbody>
					</table>
					<div class="cardHeader">
						<h2>Envios</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>No. Guía</td>
								<td>Fecha</td>
								<td>Fecha Recibe</td>
								<td>Fecha Pago</td>
								<td>Manifiesto</td>
								<td>Ruta Destino</td>
								<td>Ruta Ingreso</td>
								<td>Responsable</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php if($assoc_envios['no_guia'] != NULL){ echo htmlspecialchars($assoc_envios['no_guia']); } ?></td>
								<td><?php if($assoc_envios['fecha'] != NULL){ echo htmlspecialchars($assoc_envios['fecha']); } ?></td>
								<td><?php if($assoc_envios['fecharecib'] != NULL){ echo htmlspecialchars($assoc_envios['fecharecib']); } ?></td>
								<td><?php if($assoc_envios['fechapago'] != NULL){ echo htmlspecialchars($assoc_envios['fechapago']); } ?></td>
								<td><?php if($assoc_envios['manifiesto'] != NULL){ echo htmlspecialchars($assoc_envios['manifiesto']); } ?></td>
								<td><?php if($assoc_envios['destino'] != NULL){ echo htmlspecialchars($assoc_envios['destino']); } ?></td>
								<td><?php if($assoc_envios['rutaingres'] != NULL){ echo htmlspecialchars($assoc_envios['rutaingres']); } ?></td>
								<td><?php if($assoc_envios['responsabl'] != NULL){ echo htmlspecialchars($assoc_envios['responsabl']); } ?></td>
							</tr>
						</tbody>
					</table>
					<?php
									}else{
					?>
										<div class="errorGuia">
											<span class="status pending">No se encontraron resultados con ese número de guía.</span>
										</div>
					<?php
							    		}
							    	}
							    }
					?>
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