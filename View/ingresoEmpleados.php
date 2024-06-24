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
                        <h2>Ingreso de Empleados</h2>
                    </div>
                    <div class="formIngresoEmpleados">
                        <form>
                            <div class="inputBx nombres">
                                <label>Nombres</label>
                                <input type="text" id="nombres" placeholder="">
                            </div>
                            <div class="inputBx apellidos">
                                <label>Apellidos</label>
                                <input type="text" id="apellidos" placeholder="">
                            </div>
                            <div class="inputBx ctaBancaria">
                                <label>Cuenta Bancaria</label>
                                <input type="number" id="ctaBancaria" placeholder="">
                            </div>
                            <div class="inputBx fechaIngreso">
                                <label>Fecha Ingreso</label>
                                <input type="date" id="fecha_ingreso_empleado" placeholder="">
                            </div>
                            <div class="inputBx agencia">
                                <label>Agencia</label><br>
                                <div class="select">
                                    <select name="agencia" id="agencia">
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
                            <div class="inputBx cargo">
                                <label>Cargo</label>
                                <input type="text" id="cargo" placeholder="">
                            </div>
                            <div class="inputBx estado_planilla">
                                <label>Estado Planilla</label><br>
                                <div class="select">
                                    <select name="estado_planilla" id="estado_planilla">
                                        <option value="1">En Planilla</option>
                                        <option value="0">Fuera de Planilla</option>
                                    </select>
                                </div>
                            </div>
                            <div class="inputBx observaciones">
                                <label>Observaciónes</label>
                                <input type="text" id="observaciones" placeholder="">
                            </div>
                        </form>
                        <button type="button" class="save btnEditar">Guardar</button>
                        <button type="button" class="clean btnEditar">Limpiar</button>
                    </div><br>
                </div>
                <br>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
    <script src="../Public/js/controlEmpleados.js"></script>
</body>
</html> 