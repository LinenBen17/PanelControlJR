<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

	require 'validacionSesion.php';
	require 'validacionSeccion.php';


	$sql = "SELECT * FROM reclamos";
    $sentencia = $mysqli->prepare($sql);
    $sentencia->execute();

    $resultadoSet = $sentencia->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<!-- VIEWER.JS -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.css">
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>
	<!-- Jquery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<!-- FONTAWESOME -->
	<script src="https://kit.fontawesome.com/1953eea880.js"></script>
	<!-- jQuery Modal -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
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
						<h2>Control Reclamos</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>#</td>
								<td>Cliente</td>
								<td>Telefono</td>
								<td>Correo</td>
								<td>No. Guía</td>
								<td>Foto Guia</td>
								<td>Foto Producto</td>
								<td>Carta Reclamo</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</thead>
							<tbody>
								<?php while ($resultado = $resultadoSet->fetch_array()) { ?>
									<tr>
										<td><?php echo htmlspecialchars($resultado['id']);?></td>
										<td><?php echo htmlspecialchars($resultado['nombre_cliente']);?></td>
										<td><?php echo htmlspecialchars($resultado['telefono_cliente']);?></td>
										<td><?php echo htmlspecialchars($resultado['correo_cliente']);?></td>
										<td><?php echo htmlspecialchars($resultado['numero_guia']);?></td>
								        <td><a href="#" class="ver btnEditar" data-type="image" data-class="foto_guia" id="<?php echo $resultado['id'] ?>"><ion-icon name="eye-outline"></ion-icon></a></td>
								        <td><a href="#" class="ver btnEditar" data-type="image" data-class="foto_producto" id="<?php echo $resultado['id'] ?>"><ion-icon name="eye-outline"></ion-icon></a></td>
								        <td><a href="#" class="ver btnEditar" data-type="file" id="<?php echo $resultado['id'] ?>"><ion-icon name="eye-outline"></ion-icon></a></td>
										<td>
											<!--<?php 
												if ($resultado['estado'] == 0) {
													echo 'Activo';
												}elseif ($resultado['tipo_usuario'] == 1) {
													echo "Inactivo";
												}
											?>-->
										</td>
									</tr>
								<?php } ?>
							</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="mostrarImagen">
		<div class="fotoGuia"></div>
		<div class="fotoProducto"></div>
	</div>
	<div id="mostrarDocumento"></div>
	<script>
		var foto_guia;
		var foto_producto;
		var carta_reclamo;
		var id;
		$(".ver").click(function() {
			let dataId = this.dataset.type;
			let dataClase = this.dataset.class;
			console.log(this.id + " " + dataId + " " + this.className)
			$.ajax({
				url: 'obtenerDatos.php',
				type: 'POST',
				dataType: 'json',
				data: {id: this.id},
				success: function(data){
					//DATOS
					id = data.id;
					foto_guia = data.foto_guia;
					foto_producto = data.foto_producto;
					carta_reclamo = data.carta_reclamo;

					if(dataId == "image" && dataClase == "foto_guia"){
						$('.fotoGuia img').remove();
						$('.fotoProducto img').remove();


						$('.fotoGuia').append(
							`<img src="../uploads/reclamo_${id}/${foto_guia}" alt="Foto Guia">`
						);
						
						$('#mostrarImagen').modal();

					}else if (dataId == "image" && dataClase == "foto_producto") {
						$('.fotoProducto img').remove();
						$('.fotoGuia img').remove();

						$('.fotoProducto').append(
							`<img src="../uploads/reclamo_${id}/${foto_producto}" alt="Foto Producto">`
						);
						
						$('#mostrarImagen').modal();
					}else if(dataId == "file"){
						$('#mostrarDocumento iframe').remove();
						$('#mostrarDocumento').append(
							`<iframe src="../uploads/reclamo_${id}/${carta_reclamo}" width="600" height="400" allowfullscreen webkitallowfullscreen></iframe>`
						);

						$('#mostrarDocumento').modal();

					}

				},
				error: function(xhr, status, error){
					console.log(xhr)
					console.log(status)
					console.log(error)
				}
			})
		});
	</script>
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