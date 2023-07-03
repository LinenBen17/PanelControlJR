<?php 
    ini_set('display_errors', 0);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    require 'validacionSesion.php';
	require 'validacionSeccion.php';

	// SELECCIONA EL ULTIMO SQL
	$sqlSelectId = "SELECT id FROM usuarios ORDER BY id DESC LIMIT 1";

	$selectLastId=$mysqli->prepare($sqlSelectId);
	$selectLastId->execute();

	$result = $selectLastId->get_result();
	$assoc = $result->fetch_assoc();

	$selectLastId->close();

	$lastID = $assoc['id'] + 1;
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
						<h2>Crear Usuario</h2>
					</div>
					<div class="formBx">
						<form method="POST" class="form" action="guarda.php">
							<div class="inputBx">
								<label>Usuario:</label><br>
								<input type="text" name="usuario">
							</div>
							<div class="inputBx">
								<label>Contraseña del usuario:</label><br>
								<input type="text" name="password">
							</div>
							<div class="inputBx">
								<label>Nombre del usuario:</label><br>
								<input type="text" name="nombre">
							</div>
							<input style="display: none; visibility: hidden; opacity: 0;" type="hidden" name="id" value="<?php  echo $lastID; ?>">
							<label>Permisos del usuario:</label><br><br>
							<div class="roles">
								<?php
									//SQL MOSTRAR PERMISOS PARA SELECCIONAR
									$sqlOpciones = "SELECT * FROM permisos";

									$sentenciaOpciones = $mysqli->prepare($sqlOpciones);
									$sentenciaOpciones->execute();

									$resultadosPermisos = $sentenciaOpciones->get_result();

									foreach ($resultadosPermisos as $resultadoPermiso) {
										$seccionPermiso = $resultadoPermiso['seccion'];
										$idPermiso = $resultadoPermiso['id'];
								?>
										<div class="checkBox">
											<p><?php echo $resultadoPermiso['seccion']; ?></p>
											<label class="switch">
												<input type="checkbox" name="<?php echo strtolower(str_replace(" ", "", $seccionPermiso)); ?>" value="<?php echo $idPermiso; ?>">
												<span class="slider round"></span>
											</label>
										</div>
								<?php		
									}
								?>
							</div>
							<div class="inputBx">
								<a href="principal.php" class="btn">Regresar</a>
								<input type="submit" name="submit" class="btn" value="Crear">
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
</body>
</html>