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
						<h2>Ingreso de Boletas</h2><br><br>
					</div>
					<div class="herramientas">
						<div class="ingresoGastos">
							<button class="btn"><ion-icon name="construct-outline"></ion-icon></button>
						</div>
						<div class="subirManifiestos">
							<button class="btn uploadManifiestos"><ion-icon name="file-tray-stacked-outline"></ion-icon></button>
						</div>
					</div>
					<div class="control">
						<div class="formGuardarBoletas">
							<form>
								<div class="inputBx noManifiesto">
									<label>No. Manifiesto</label><br>
									<input type="number" name="noManifiesto">
								</div>
								<div class="inputBx lugarDeposito">
									<label>Agencia</label><br>
									<div class="select">
										<select name="lugarDeposito">
											<option value="Jutiapa">JUT</option>
											<option value="Capital">CAP</option>
											<option value="Santa Rosa">BAR</option>
											<option value="Jalapa">JAL</option>
											<option value="Zacapa">ZAC</option>
											<option value="Chiquimula">CHI</option>
											<option value="Escuintla">ESC</option>
											<option value="Suchitepequez">MAZ</option>
											<option value="Chimaltenango">CHM</option>
											<option value="Quetzaltenango">XEL</option>
											<option value="Quiche">QCH</option>
											<option value="Izabal">PTB</option>
										</select>
									</div>
								</div>
								<div class="inputBx fechaManifiesto fechaActual">
									<label>Fecha Manifiesto</label><br>
									<input type="date" name="fechaManifiesto">
								</div>
								<div class="inputBx noBoleta">
									<label>No. Boleta</label><br>
									<input type="number" name="noBoleta[]">
								</div>
								<div class="inputBx valorBoleta">
									<label>Valor Boleta</label><br>
									<input type="number" name="valorBoleta[]">
								</div>
								<div class="inputBx fechaBoleta">
									<label>Fecha Boleta</label><br>
									<input type="datetime-local" name="fechaBoleta[]">
								</div>
								<div class="inputBx tipoBoleta">
									<label>Tipo</label><br>
									<div class="select">
										<select name="tipoBoleta[]" id="">
											<option value="Por Cobrar">Por Cobrar</option>
											<option value="Contado">Contado</option>
										</select>
									</div>
								</div>
								<div class="inputBx agenciaBoleta">
									<label>Agencia</label><br>
									<input type="text" name="agenciaBoleta[]">
								</div>
								<div class="inputBx bancoBoleta">
									<label>Banco</label><br>
									<div class="select">
										<select name="bancoBoleta[]" id="">
											<option value="Banrural">Banrural</option>
											<option value="InterBanco">InterBanco</option>
											<option value="Banco Industrial">BI</option>
										</select>
									</div>
								</div>
								<div class="inputBx addBoleta">
									<button class="btn newBoleta"><ion-icon name="add-sharp"></ion-icon></button>
								</div>
								<input type="hidden" name="action" value="Guardar">
							</form>
							<div class="boletasAdicionales"></div>
							<div class="inputBx">
								<input type="submit" name="Guardar" value="Guardar" class="btn">
							</div>
						</div>
						<div class="formManifiesto">
							<form>
								<div class="inputBx manifiesto">
									<label>No. Manifiesto</label><br>
									<input type="text" readonly name="manifiesto" >
								</div>
								<div class="inputBx fecha">
									<label>Fecha Manifiesto</label><br>
									<input type="text" readonly name="fecha" >
								</div>
								<div class="inputBx origen">
									<label>Origen</label><br>
									<input type="text" readonly name="origen" >
								</div>
								<div class="inputBx destino">
									<label>Destino</label><br>
									<input type="text" readonly name="destino" >
								</div>
								<div class="inputBx ruta">
									<label>Ruta</label><br>
									<input type="text" readonly name="ruta" >
								</div>
								<div class="inputBx totalContado">
									<label>Total Contado</label><br>
									<input type="text" readonly name="totalContado" >
								</div>
								<div class="inputBx totalPorCobrar">
									<label>Total Por Cobrar</label><br>
									<input type="text" readonly name="totalPorCobrar" >
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="recentOrders">
					<table id="boletasTable" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>No. Manifiesto</th>
                                <th>No. Boleta</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Banco</th>
                                <th>Agencia Depositó</th>
                                <th>Fecha Boleta</th>
                                <th>Fecha Ingreso</th>
                                <th>Usuario Ingresó</th>
                            </tr>
                        </thead>
                    </table>
				</div>
				<div id="gastosModal" class="modal">
                    <div class="cardHeader">
                        <h2>Ingreso de gastos al manifiesto</h2>
                    </div>
                    <div class="formGastos">
                    	<form>
							<div class="inputBx noManifiesto">
								<label>No. Manifiesto</label><br>
								<input type="number" name="noManifiesto">
							</div>
							<div class="inputBx fechaManifiesto">
								<label>Fecha Manifiesto</label><br>
								<input type="date" name="fechaManifiesto">
							</div>
							<div class="inputBx agenciaGasto">
								<label>Agencia</label>
								<div class="select">
									<select name="agenciaGasto">
										<option value="Guatemala">Guatemala</option>
										<option value="Jalapa">Jalapa</option>
										<option value="Chiquimula">Chiquimula</option>
										<option value="Zacapa">Zacapa</option>
										<option value="Santa Rosa">Santa Rosa</option>
										<option value="Jutiapa">Jutiapa</option>
										<option value="Totonicapan">Totonicapan</option>
										<option value="Chimaltenango">Chimaltenango</option>
										<option value="Escuintla">Escuintla</option>
										<option value="Retalhuleu">Retalhuleu</option>
										<option value="Quetzaltenango">Quetzaltenango</option>
										<option value="San Marcos">San Marcos</option>
										<option value="Suchitepequez">Suchitepequez</option>
										<option value="Puerto Barrios">Puerto Barrios</option>
										<option value="Quiché">Quiché</option>
									</select>
								</div>
							</div>
							<div class="inputBx rutaAgenciaGasto">
								<label>Ruta</label><br>
								<input type="text" name="rutaAgenciaGasto">
							</div>
							<div class="inputBx costoGasto">
								<label>Costo</label><br>
								<input type="number" name="costoGasto[]">
							</div>
							<div class="inputBx descripcionGasto">
								<label>Descripción</label><br>
								<input type="text" name="descripcionGasto[]">
							</div>
							<div class="inputBx addGasto">
								<button class="btn newGasto"><ion-icon name="add-sharp"></ion-icon></button>
							</div>
						</form>
						<div class="gastosAdicionales"></div>
						<div class="inputBx">
							<input type="submit" name="guardarGasto" value="Ingresar" class="btn">
						</div>
                    </div>	
                </div>
			</div>
		</div>
	</div>
	<?php require_once 'shared/footer.php';	 ?>
	<?php echo $_SESSION['usuario'] ?>
	<script src="../Public/js/controlBoletas.js"></script>
	<script src="../Public/js/controlGastos.js"></script>
</body>
</html>