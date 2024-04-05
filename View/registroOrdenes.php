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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <!-- userImg -->
                <?php require 'shared/view.php'; ?>
            </div>
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Registro de Órdenes</h2>
                    </div>
                    <div class="formRegistroOrdenes">
                        <form>
                            <div class="inputBx noOrden">
                                <label>No. Orden</label>
                                <input type="number" id="noOrden" placeholder="">
                            </div>
                            <div class="inputBx noFactura">
                                <label>No. Factura</label>
                                <input type="text" id="noFactura" placeholder="">
                            </div>
                            <div class="inputBx fecha">
                                <label>Fecha</label>
                                <input type="date" id="fecha" placeholder="">
                            </div>
                            <div class="inputBx proveedor">
                                <label>Proveedor</label>
                                <input type="text" id="proveedor" placeholder="">
                            </div>
                            <div class="inputBx placa">
                                <label>Placa</label>
                                <input type="text" id="placa" placeholder="">
                            </div>
                            <div class="inputBx cantidad">
                                <label>Cantidad</label>
                                <input type="number" id="cantidad" placeholder="">
                            </div>
                            <div class="inputBx descripcion">
                                <label>Descripción</label>
                                <input type="text" id="descripcion" placeholder="">
                            </div>
                            <div class="inputBx precioUnitario">
                                <label>Precio Unitario</label>
                                <input type="number" id="precioUnitario" placeholder="">
                            </div>
                            <div class="inputBx total">
                                <label>Total</label>
                                <input type="number" id="total" placeholder="">
                            </div>
                            <div class="inputBx observacion">
                                <label>Observación</label>
                                <textarea type="text" id="observacion" placeholder=""></textarea>
                            </div>
                        </form>
                        <button type="button" class="save btnEditar">Guardar</button>
                        <button type="button" class="clean btnEditar">Limpiar</button>
                    </div><br>
                <table id="ordenesCompraTable" class="display" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Orden</th>
                            <th>No. Factura</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Placa</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                </table>
                </div>
                <br>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
    <script src="../Public/js/registroOrdenes.js"></script>
</body>
</html> 