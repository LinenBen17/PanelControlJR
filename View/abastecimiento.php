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
                        <h2>Abastecimiento</h2>
                    </div>
                    <div class="formAbastecimiento">
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
                            <div class="inputBx km_inicial">
                                <label>Km. Inicial</label>
                                <input type="number" id="km_inicial" placeholder="">
                            </div>
                            <div class="inputBx km_final">
                                <label>Km. Final</label>
                                <input type="number" id="km_final" placeholder="">
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
                    </div>
                </div><br>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
    <script src="../Public/js/abastecimiento.js"></script>
</body>
</html>