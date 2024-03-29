<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="Public/css/index.css">
	<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JQUERY -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Login | Transportes JR</title>
</head>
<body>
	<section>
		<div class="box">
			<div class="form">
				<h2>Login</h2>
				<form class="formLogin" autocomplete="off">
					<div class="inputBx">
						<input type="text" name="usuario" placeholder="Username" autocomplete="off" onfocus>
						<ion-icon name="person-circle-outline"></ion-icon>
					</div>
					<div class="inputBx">
						<input type="password" name="password" placeholder="Contraseña" autocomplete="off">
						<ion-icon name="lock-closed-outline"></ion-icon>
					</div>
					<div class="errorPassword">
						<p>¡Contraseña Incorrecta! Inténtalo de nuevo.</p>
					</div>
					<div class="errorUser">
						<p>¡Usuario invalido o inexistente! Inténtalo de nuevo.</p>
					</div>
					<div class="inputBx">
						<input type="submit" class="login" value="Login">
					</div>
				</form>
				<!--<p>Crear una nueva <a href="create.php">cuenta</a>.</p>-->
			</div>
		</div>
	</section>
	<script src="Public/js/login.js"></script>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>