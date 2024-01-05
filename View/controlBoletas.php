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
	    <!-- SheetJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">

	<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

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
                    <table id="boletasTableGeneral" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>No. Manifiesto</th>
                                <th>Fecha Manifiesto</th>
                                <th>No. Boleta</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Banco</th>
                                <th>Agencia Depositó</th>
                                <th>Agencia</th>
                                <th>Fecha Boleta</th>
                                <th>Fecha Ingreso</th>
                                <th>Fecha Modificación</th>
                                <th>Usuario Ingresó</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                    <!--<div class="formAbastecimiento">
                        <button type="button" class="reports btnEditar">Generador de Reportes</button>
                    </div>-->

                    <!--<div id="reportes" class="modal form">
                        <form method="POST">
                            <h2>Selecciona el filtro deseado:</h2>
                            <div class="inputBx">
                                <div class="select">
                                    <select name="opcionesFiltros" class="opcionesFiltros">
                                        <option>---------</option>
                                        <option value="porPlaca">Por Placa</option>
                                        <option value="porFecha">Por Fecha</option>
                                        <option value="entreFechas">Entre Fechas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="inputBx filtroPorPlaca filtros" id="filtroPorPlaca">
                                <label>Placa:</label><br>
                                <input type="text" id="placaFilter" placeholder=""><br><br>
                                <button type="button" class="generar btnEditar">Generar</button>
                            </div>
                            <div class="inputBx filtroPorFecha filtros" id="filtroPorFecha">
                                <label>Fecha:</label><br>
                                <input type="date" id="fechaFilter" placeholder=""><br><br>
                                <button type="button" class="generar btnEditar">Generar</button>
                            </div>
                            <div class="inputBx filtroEntreFechas filtros" id="filtroEntreFechas">
                                <label>Entre:</label><br>
                                <input type="date" id="fechaInicial" placeholder=""><br>
                                <label>Y:</label><br>
                                <input type="date" id="fechaFinal" placeholder=""><br><br>
                                <button type="button" class="generar btnEditar">Generar</button>
                            </div>
                        </form>
                    </div>-->
                   <div id="editarUser" class="modal form">
                        <div class="cardHeader">
                            <h2>Editar Registro</h2>
                        </div>
                        <div class="formGuardarBoletas">
                            <form></form>
                        </div>
                        <div class="inputBx">
                            <button class="btn update" value="Update">Editar</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
    <!-- jQuery Modal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

	<?php require_once 'shared/footer.php';	 ?> 
	<script src="../Public/js/controlBoletas.js"></script>
</body>
</html> 