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
						<h2>Ingreso de Depósitos Contra Entrega</h2><br><br>
					</div>
					<div>
						<div class="formGuardarDepositosCE">
							<form>
								<div class="inputBx noManifiesto">
									<label>No. Manifiesto</label><br>
									<input type="number" name="noManifiesto">
								</div>
								<div class="inputBx fechaManifiesto">
									<label>Fecha Manifiesto</label><br>
									<input type="date" name="fechaManifiesto">
								</div>
								<div class="inputBx noContraEntrega">
									<label>No. Contra Entrega</label><br>
									<input type="number" name="noContraEntrega">
								</div>
								<div class="inputBx noGuia">
									<label>No. Guía</label><br>
									<input type="number" name="noGuia">
								</div>
								<div class="inputfile-container subirCE">
							        <input type="file" name="uploadCEimage" id="inputfileCE" class="inputfileCE" accept="image/*">
							        <label for="inputfileCE" class="labelUploadCE btn"><ion-icon name="cloud-upload"></ion-icon></label>
							    </div>
								<div class="inputBx noBoleta">
									<label>No. Boleta</label><br>
									<input type="number" name="noBoleta">
								</div>
								<div class="inputBx valorBoleta">
									<label>Valor Boleta</label><br>
									<input type="number" name="valorBoleta">
								</div>
								<div class="inputBx fechaBoleta">
									<label>Fecha Boleta</label><br>
									<input type="datetime-local" name="fechaBoleta">
								</div>
								<div class="inputBx noCuenta">
									<label>No. Cuenta</label><br>
									<input type="number" name="noCuenta">
								</div>
								<div class="inputBx nombreCuenta">
									<label>Nombre de la Cuenta</label><br>
									<input type="text" name="nombreCuenta">
								</div>
								<div class="inputBx telefonoCE">
									<label>Teléfono/Whatsapp</label><br>
									<input type="number" name="telefonoCE">
								</div>
							</form>
							<div class="inputBx ">
								<input type="submit" name="guardarDepositoCE" value="Guardar" class="btn">
							</div>
						</div>
					</div>
				</div>
				<div class="recentOrders">
					<table id="ceTableUser" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>No. Manifiesto</th>
                                <th>Fecha Manifiesto</th>
                                <th>No. Contra Entrega</th>
                                <th>No. Guía</th>
                                <th>No. Boleta</th>
                                <th>Fecha Boleta</th>
                                <th>No. Cuenta</th>
                                <th>Nombre Cuenta</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
	<?php require_once 'shared/footer.php';	 ?>
	<?php echo $_SESSION['usuario'] ?>
	<script src="../Public/js/controlDepositosCE.js"></script>
	<script>
        const inputfile = document.getElementById('inputfileCE');
        const label = document.querySelector('.labelUploadCE');

        inputfile.addEventListener('change', function(e) {
            const filename = e.target.files[0].name;
            label.textContent = filename;
        });
    </script>
</body>
</html>	