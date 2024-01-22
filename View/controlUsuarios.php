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
	<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
				<form class="formEditarUser">
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
					<div class="inputBx">
						<label for="">Contraseña:</label><br>
						<input type="text" name="password">
					</div>
					<label>Permisos Usuarios:</label><br><br>
					<div class="roles"></div><br><br>
					<div class="inputBx">
						<input type="submit" name="action" class="btn updateUser" value="editar">
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
	<script src="../Public/js/controlUsuarios.js"></script>
</body>
</html>