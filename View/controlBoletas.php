<?php
	require_once 'shared/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="../Public/css/dashboard.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

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
						<h2>Control Boletas</h2>
					</div>
					<div class="formGuardarBoletas">
						<form>
							<div class="inputBx noManifiesto">
								<label>No. Manifiesto</label><br>
								<input type="number" name="noManifiesto">
							</div>
							<div class="inputBx noBoleta">
								<label>No. Boleta</label><br>
								<input type="number" name="noBoleta">
							</div>
							<div class="inputBx fechaBoleta">
									<label>Fecha Boleta</label><br>
									<input type="date" name="fechaBoleta">
							</div>
							<div class="inputBx valorBoleta">
									<label>Valor Boleta</label><br>
									<input type="number" name="valorBoleta">
							</div>
							<div class="inputBx tipoBoleta">
								<label>Tipo</label><br>
								<input type="text" name="tipoBoleta">
							</div>
							<div class="inputBx addBoleta">
								<br>
								<button class="btn newBoleta"><ion-icon name="add-sharp"></ion-icon></button>
							</div>
						</form>
						<div class="boletasAdicionales"></div>
						<div class="inputBx">
							<input type="submit" name="Guardar" value="Guardar" class="btn">
						</div>
					</div>
					<!--<div id="confirmarDatos" class="modal">
						<div class="cardHeader">
							<h2>Confirmación de datos</h2>
						</div>
						<form class="formGuardarBoletas confirmacion">
							<div class="inputBx">
								<label>No. Manifiesto</label><br>
								<input type="number" name="noManifiesto">
							</div>
							<div class="inputBx">
								<label>No. Boleta</label><br>
								<input type="number" name="noBoleta">
							</div>
							<div class="inputBx">
								<label>Fecha Boleta</label><br>
								<input type="date" name="fechaBoleta">
							</div>
							<div class="inputBx">
								<label>Tipo</label><br>
								<input type="text" name="tipoBoleta">
							</div>
							<div class="inputBx">
								<input type="submit" name="Guardar" value="Guardar" class="btn">
							</div>
						</form>
					</div>-->
				</div>
				<div class="recentOrders">
					<table id="boletasTable" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>No. Manifiesto</th>
                                <th>No. Boleta</th>
                                <th>Tipo Boleta</th>
                                <th>Fecha Ingreso</th>
                                <th>Fecha Modificación</th>
                                <th>Usuario Ingresó</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
	<?php require_once 'shared/footer.php';	 ?>
	<?php echo $_SESSION['usuario'] ?>
	<script src="../Public/js/controlBoletas.js"></script>
	<script>
		$(".newBoleta").click(function(e){
			e.preventDefault();
			$(".boletasAdicionales").append(
				`
					<div class="boleta">
						<div class="inputBx noBoleta">
							<label>No. Boleta</label><br>
							<input type="number" name="noBoleta">
						</div>
						<div class="inputBx fechaBoleta">
								<label>Fecha Boleta</label><br>
								<input type="date" name="fechaBoleta">
						</div>
						<div class="inputBx valorBoleta">
								<label>Valor Boleta</label><br>
								<input type="number" name="valorBoleta">
						</div>
						<div class="inputBx tipoBoleta">
							<label>Tipo</label><br>
							<input type="text" name="tipoBoleta">
						</div>
					</div>
				`
			)
		})
	</script>
</body>
</html>