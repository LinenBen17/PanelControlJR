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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">

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
                    <table id="abastecimientoTable" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Placa</th>
                                <th>Piloto</th>
                                <th>Ruta</th>
                                <th>Km. Inicial</th>
                                <th>Km. Final</th>
                                <th>Monto Total</th>
                                <th>Galones</th>
                                <th>Precio x Galón</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                    <div class="formAbastecimiento">
                        <button type="button" class="reports btnEditar">Generador de Reportes</button>
                    </div>

                    <div id="reportes" class="modal form">
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
                    </div>
                    <div id="editarUser" class="modal form">
                        <div class="cardHeader">
                            <h2>Editar Registro</h2>
                        </div>
                        <div class="formAbastecimiento">
                            <form></form>
                        </div>
                        <div class="inputBx">
                            <input type="submit" class="btn update" value="editar">
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<?php require_once 'shared/footer.php';	 ?>
	<script src="../Public/js/controlAbaste.js"></script>
</body>
</html>