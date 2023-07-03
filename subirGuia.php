<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    require 'validacionSesion.php';
	require 'validacionSeccion.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<div class="container">
		<!-- NAVIGATION -->
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
						<h2>Subir Guía</h2>
					</div>
					<form method="POST" class="form">
					    <div class='file'>
							<label for='input-file'><ion-icon name="cloud-upload"></ion-icon>&nbsp; Selecciona un archivo</label>
					      	<input id='input-file' type='file' name="image" class="image">
					    </div>
        			</form>
        			<div class="popup">
        				<div class="modal" id="editorCropper">
        				<h2>Recortar Imagen</h2>	
	        				<div class="body">    					
		        				<div class="editarImage">
		        					<image id="image"></image>
		        				</div>
		        				<div class="previewSection">
		        					<div class="preview"></div>
		        					<div class="buttonsPreview">
		        						<span class="rotate45 buttonConf"><ion-icon name="refresh-outline"></ion-icon></span>
		        						<span class="moveCenter buttonConf"><ion-icon name="move-outline"></ion-icon></span>
		        					</div>
					        		<div class="inputBx boxEditor">
										<label>No. Guía:</label><br>
										<input type="text" name="no_guia" maxlength="10" id="no_guia">
									</div>
		        				</div>
	        				</div>
	        				<div class="buttons">
	        					<a href="#" rel="modal:close" class="btnEliminar">Cancelar</a>
	        					<a type="button" id="crop" class="btnEditar">Guardar</a>
	        				</div>
        				</div>
        			</div>

				</div>
			</div>
		</div>
	</div>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<script src="js/index.js"></script>
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