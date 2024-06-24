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
        <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
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
                        <h2>Ingreso Detalle de Pago a Empleados</h2>
                    </div>
                    <div class="formIngresoDetallePago">
                        <form>
                            <div class="inputBx empleado">
                                <label>Empleado</label>
                                <div class="search">
                                    <input type="text" id="empleado_id" placeholder="" value="">
                                    <button type="button" class="btn searchEmpleado"><ion-icon name="search"></ion-icon></button>
                                </div>
                            </div>
                            <div class="inputBx sueldo_ordinario">
                                <label>Sueldo Ordinario</label>
                                <input type="number" id="sueldo_ordinario" placeholder="">
                            </div>
                            <div class="inputBx bonificacion_ley">
                                <label>Bonificación de Ley</label>
                                <input type="number" id="bonificacion_ley" placeholder="">
                            </div>
                            <div class="inputBx bonificacion_incentivo">
                                <label>Bonificación Incentiva</label>
                                <input type="number" id="bonificacion_incentivo" placeholder="">
                            </div>
                            <div class="inputBx igss">
                                <label>IGSS</label>
                                <input type="number" id="igss" placeholder="">
                            </div>
                            <div class="inputBx isr">
                                <label>ISR</label>
                                <input type="number" id="isr" placeholder="">
                            </div>
                        </form>
                        <button type="button" class="save btnEditar">Guardar</button>
                        <button type="button" class="clean btnEditar">Limpiar</button>
                    </div><br>
                    <div id="seleccionarEmpleado" class="modal form">
                        <div class="cardHeader">
                            <h2>Seleccionar Empleado</h2>
                        </div>
                        <div class="details">
                            <div class="recentOrders">
                            <table id="tableSelectEmpleado" class="display" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Cargo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                            </table>
                            </div>
                        </div>
                        <div class="inputBx">
                            <button class="btn update" value="Update">Editar</button>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <!-- jQuery Modal -->
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

	<?php require_once 'shared/footer.php';	 ?>
    <script src="../Public/js/controlDetallePago.js"></script>
</body>
</html> 