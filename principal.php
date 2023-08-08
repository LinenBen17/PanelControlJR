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

    $sqlDestinos = "SELECT DISTINCT destino FROM bdstandar";

    $destinos = $mysqli->prepare($sqlDestinos);
    $destinos->execute();
    $destinos->store_result();

    $cantidadDestinos = $destinos->num_rows;

    $destinos->close();

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
						<h2>¡BIENVENIDO AL DASHBOARD DE TRANS. JR!</h2>
					</div>
					<div class="cards">
	                    <div class="card-single">
	                        <div>
	                            <h1><?php echo $cantidadDestinos; ?></h1>
	                            <span>Destinos en Standar</span>
	                        </div>
	                        <div>
	                            <span class="las la-users"><ion-icon name="map-outline"></ion-icon></span>
	                        </div>
	                    </div>
	                </div>
	                <div class="projects">
                        <div class="card">
                            <div class="card-header">
                                <h3>Tus Permisos Actuales</h3>
                                <button>See All
                                    <span class="las la-arrow-right"></span>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Sección</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
													// Definir los permisos y los enlaces correspondientes
													require 'seccionesUrls.php';
													$con = 0;
													// Uso de la función para verificar los permisos y generar enlaces
													foreach ($permisos as $permiso => $enlace) {
													    if (verificarPermiso($idSesion, $permiso)) {
													    	$con++;
												?>
	                                            			<tr>	
																<td><?php echo $con; ?></td>
																<td><?php echo $permiso; ?></td>
																<td></td>
	                                            			</tr>
												<?php
													    }
													}
												?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
</body>
</html>