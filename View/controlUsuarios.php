<?php
	require_once 'shared/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<link rel="stylesheet" type="text/css" href="../Public/css/dashboard.css">
</head>
<body>
	<div class="container">
		<?php require 'shared/navigation.php' ?>
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
				<?php require 'shared/view.php'; ?>
			</div>
			<div class="details">
				<div class="recentOrders">
					<div class="cardHeader">
						<h2>Control Usuarios</h2>
					</div>
					<div class="actionButton" bis_skin_checked="1">
                        <button class="btn btnCrear">
                            <span class="icon">
                                <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                            </span>
                        </button>
                    </div>
					<table>
						<thead>
							<tr>
								<td>#</td>
								<td>Usuario</td>
								<td>Nombre</td>
								<td></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<?php include_once '../Controller/C_controlUsuarios.php'; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="editarUser" class="modal form">
				<form action="../Controller/C_controlUsuarios.php" method="POST">
					<h2>Editar Usuario</h2>
					<input type="hidden" name="id">
					<div class="inputBx">
						<label for="">Nombre:</label><br>
						<input type="text" name="nombre">
					</div>
					<div class="inputBx">
						<label for="">Usuario:</label><br>
						<input type="text" name="usuario">
					</div>
					<label>Permisos Usuarios:</label><br><br>
					<div class="roles"></div><br><br>
					<div class="inputBx">
						<input type="submit" name="action" class="btn" value="editar">
					</div>
				</form>
			</div>
			<div id="crearUser" class="modal form">
				<form action="../Controller/C_controlUsuarios.php" method="POST">
					<h2>Crear Usuario</h2>
					<div class="inputBx">
						<label for="">Nombre del usuario:</label><br>
						<input type="text" name="nombre">
					</div>
					<div class="inputBx">
						<label for="">Usuario:</label><br>
						<input type="text" name="usuario">
					</div>
					<div class="inputBx">
						<label for="">Contraseña:</label><br>
						<input type="text" name="password">
					</div>
					<label>Permisos Usuarios:</label><br><br>
					<div class="roles"></div><br><br>
					<div class="inputBx">
						<input type="submit" name="action" class="btn" value="crear">
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php require_once 'shared/footer.php';	 ?>
	<script>
		// CREAR USUARIO
		$(".btnCrear").click(function() {
			$.ajax({
				url: '../Controller/C_controlUsuarios.php',
				type: 'POST',
				dataType: 'json',
				data: {action: "permisos"},
				success: function(data) {
					data.forEach((seccion) => {
						$('#crearUser .roles').append(`
							<div class="checkBox">
								<p>${seccion.seccion}</p>
								<label class="switch">
									<input type="checkbox" name="${seccion['seccion'].replace(/\s+/g, '').toLowerCase()}" value="${seccion.id}">
									<span class="slider round"></span>
								</label>
							</div>
						`)
					})
					$("#crearUser").modal();
					$('#crearUser').on($.modal.AFTER_CLOSE, function() {
						$('#crearUser .roles > div').remove();
					});
				},
				error: function(a,b,c) {
					console.log(a);
					console.log(b);
					console.log(c);
				}
			})

		});
		// DATOS PARA EDITAR USUARIO
		$('.btnEditar').click(function(e) {
			e.preventDefault();
			var id = this.id;

			$.ajax({
				url: '../Controller/C_controlUsuarios.php',
				type: 'POST',
				dataType: 'json',
				data: {id: id, action: "obtener"},
				success: function(data) {
					var nombre = data[0].nombre;
					var usuario = data[0].usuario;
					var id = data[0].id;

					var secciones = Object.keys(data[1]);

					$('#editarUser input[name="id"]').val(id);
					$('#editarUser input[name="nombre"]').val(nombre);
					$('#editarUser input[name="usuario"]').val(usuario);

					secciones.forEach((seccion)=>{
						$('#editarUser .roles').append(`
							<div class="checkBox">
								<p>${seccion}</p>
								<label class="switch">
									<input type="checkbox" name="${seccion.replace(/\s+/g, '').toLowerCase()}" ${data[1][seccion].checked} value="${data[1][seccion].id}">
									<span class="slider round"></span>
								</label>
							</div>
						`)
					});

					$('#editarUser').modal();
					$('#editarUser').on($.modal.AFTER_CLOSE, function() {
						$('#editarUser .roles > div').remove();
					});
				},
				error: function(a, b, c) {
					console.log(a);
					console.log(b);
					console.log(c);
				}
			})
			
		});

		//ELIMINAR USUARIO
		$('.btnEliminar').click(function(e) {
			e.preventDefault();
			var id = this.id;

			$.ajax({
				url: '../Controller/C_controlUsuarios.php',
				type: 'POST',
				dataType: 'json',
				data: {id: id, action: "eliminar"},
				success: function(data) {
					location.reload();
				},
				error: function() {
					console.log("ERROR");
				}
			})
			
		});
	</script>
</body>
</html>