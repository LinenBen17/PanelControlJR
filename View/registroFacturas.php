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
        <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">

    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

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
                        <h2>Registro de Facturas</h2>
                    </div>
                    <div class="formRegistroFact">
                        <form>
                            <div class="inputBx placa">
                                <label>Placa</label>
                                <input type="text" id="placa" placeholder="">
                            </div>
                            <div class="inputBx piloto">
                                <label>Piloto</label>
                                <input type="text" id="piloto" placeholder="">
                            </div>
                            <div class="inputBx ruta">
                                <label>Ruta</label>
                                <input type="text" id="ruta" placeholder="">
                            </div>
                            <div class="inputBx fechaVale">
                                <label>Fecha Vale</label>
                                <input type="date" id="fechaVale" placeholder="">
                            </div>
                            <div class="inputBx serie">
                                <label>Serie</label>
                                <input type="text" id="serie" placeholder="">
                            </div>
                            <div class="inputBx noFactura">
                                <label>No. Factura</label>
                                <input type="number" id="noFactura" placeholder="">
                            </div>
                            <div class="inputBx fecha">
                                <label>Fecha Factura</label>
                                <input type="date" id="fecha" placeholder="">
                            </div>
                            <div class="inputBx tipoCombustible">
                                <label>Tipo Combustible</label><br>
                                <div class="select">
                                    <select name="tipoCombustible" id="tipoCombustible">
                                        <option value="Diesel">Diesel</option>
                                        <option value="Regular">regular</option>
                                        <option value="Super">Super</option>
                                    </select>
                                </div>
                            </div>
                            <div class="inputBx monto_total">
                                <label>Monto Total</label>
                                <input type="number" id="monto_total" placeholder="">
                            </div>
                            <div class="inputBx galones">
                                <label>Galones</label>
                                <input type="number" id="galones" placeholder="">
                            </div>
                            <div class="inputBx precio_galon">
                                <label>Precio x Galón</label>
                                <input type="number" readonly id="precio_galon" placeholder="">
                            </div>
                        </form>
                        <button type="button" class="save btnEditar">Guardar</button>
                        <button type="button" class="clean btnEditar">Limpiar</button>
                    </div><br>
                <table id="facturasTableUser" class="display" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Placa</th>
                            <th>Piloto</th>
                            <th>Ruta</th>
                            <th>Fecha</th>
                            <th>Serie</th>
                            <th>No. Factura</th>
                            <th>Monto Total</th>
                            <th>Galones</th>
                            <th>Precio X Galón</th>
                        </tr>
                    </thead>
                </table>
                </div>
                <br>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
    <script src="../Public/js/registroFactura.js"></script>
</body>
</html> 