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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
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
                        <h2>Impresión Guías Madres</h2>
                    </div>
                    <div class="actionButton">
                        <button class="btn">
                            <span class="icon">
                                <a href="#newRegister" rel="modal:open"><ion-icon name="add-outline"></ion-icon></a>
                            </span>
                        </button>
                    </div>
                    <div class="canvas" id="canvas"></div>
                    <div class="formGuiaMadre">
                        <form>
                            <div class="inputBx rCodigo">
                                <label>Código</label>
                                <input type="text" id="rem_codigo" placeholder="V03-6862">
                            </div>
                            <div class="inputBx rNombre">
                                <label>Nombre Remitente</label>
                                <input readonly type="text" id="rem_nombre" placeholder="FORMULARIOS STANDARD, S.A.">
                            </div>
                            <div class="inputBx rDireccion">
                                <label>Dirección</label>
                                <input readonly type="text" id="rem_direccion" placeholder="1 CALLE 35-39 ZONA 11 COL. TOLEDO">
                            </div>
                            <div class="inputBx rTelefono">
                                <label>Teléfono</label>
                                <input readonly type="text" id="rem_telefono" placeholder="2429-8900">
                            </div>
                            <div class="inputBx rOrigen">
                                <label>Origen</label>
                                <input readonly type="text" id="rem_origen" placeholder="CAP">
                            </div>
                            <div class="inputBx dCodigo">
                                <label>Código</label>
                                <input type="text" id="des_codigo">
                            </div>
                            <div class="inputBx dNombre">
                                <label>Nombre Destinatario</label>
                                <input type="text" id="des_nombre">
                            </div>
                            <div class="inputBx dDireccion">
                                <label>Dirección</label>
                                <input type="text" id="des_direccion">  
                            </div>
                            <div class="inputBx dTelefono">
                                <label>Teléfono</label>
                                <input type="text" id="des_telefono">
                            </div>
                            <div class="inputBx dDestino">
                                <label>Destino</label>
                                <input type="text" id="des_destino">  
                            </div>
                            <div class="inputBx dContacto">
                                <label>Contacto</label>
                                <input type="text" id="des_contacto">
                            </div>
                        </form>
                        <button type="button" class="print btnEditar">Imprimir</button>
                        <button type="button" class="clean btnEditar">Limpiar</button>

                        <div class="modal" id="selectModal">
                            <select name="selectDir" id="">
                                <option value="0" selected>--SELECCIONA LA DIRECCIÓN--</option>
                            </select>
                        </div>
                        <div class="modal formNewMadre" id="newRegister">
                            <form action="../Controller/C_impresionMadres.php" method="POST">
                                <div class="inputBx dCodigo">
                                    <label>Código</label>
                                    <input type="text" id="des_codigo" name="codigo">
                                </div>
                                <div class="inputBx dNombre">
                                    <label>Nombre Destinatario</label>
                                    <input type="text" id="des_nombre" name="nombre">
                                </div>
                                <div class="inputBx dContacto">
                                    <label>Contacto</label>
                                    <input type="text" id="des_contacto" name="contacto">
                                </div>
                                <div class="inputBx dDireccion">
                                    <label>Dirección</label>
                                    <input type="text" id="des_direccion" name="direccion">  
                                </div>
                                <div class="inputBx dTelefono">
                                    <label>Teléfono</label>
                                    <input type="text" id="des_telefono" name="telefono">
                                </div>
                                <div class="inputBx dDestino">
                                    <label>Destino</label>
                                    <input type="text" id="des_destino" name="destino">  
                                </div>
                                <button type="submit" name="action" class="save btnEditar" value="save">Crear</button>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
	<script src="../Public/js/impresionMadres.js"></script>
</body>
</html>