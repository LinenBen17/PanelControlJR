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
                        <h2>Control Camiones</h2>
                    </div>
                    <div class="actionButton">
                        <button class="btn">
                            <span class="icon">
                                <ion-icon name="add-outline"></ion-icon>
                            </span>
                        </button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Modelo</td>
                                <td>Marca</td>
                                <td>Placa</td>
                                <td>Fecha Creación</td>
                                <td>Fecha Modif.</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                            <tbody> 
                                <?php include_once("../Controller/C_camiones.php") ?>
                            </tbody>
                    </table>
                </div>
            </div>
            <div id="newCamion" class="modal form">
                <form method="POST">
                    <h2>Nuevo Camión</h2>
                    <div class="inputBx">
                        <label for="">Modelo:</label><br>
                        <input type="text" name="modelo">
                    </div>
                    <div class="inputBx">
                        <label for="">Marca:</label><br>
                        <input type="text" name="marca">
                    </div>
                    <div class="inputBx">
                        <label for="">Placa:</label><br>
                        <input type="text" name="placa">
                    </div>
                    <input type="submit" name="action" class="btn btnCrud" value="Crear">
                </form>
            </div>
            <div id="editCamion" class="modal form">
                <form method="POST">
                    <h2>Editar Camión</h2>
                    <input type="hidden" name="id">
                    <div class="inputBx">
                        <label for="">Modelo:</label><br>
                        <input type="text" name="modelo">
                    </div>
                    <div class="inputBx">
                        <label for="">Marca:</label><br>
                        <input type="text" name="marca">
                    </div>
                    <div class="inputBx">
                        <label for="">Placa:</label><br>
                        <input type="text" name="placa">
                    </div>
                    <input type="submit" name="action" class="btn btnCrud" value="Editar">
                </form>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
	<script>
        $('.actionButton').click(function() {
            $('#newCamion').modal();
        });

        $(".btnCrud").click(function(e) {
            e.preventDefault();

            let datosCamion = {};

            let divPadre = $(this).parent();
            let inputs = divPadre.find("input");
            let button = divPadre.find('button');
            
            if (button) {
                datosCamion["action"] = button.val();
                datosCamion["id"] = button.attr('id');
            }
            inputs.each(function(){
                datosCamion[this.name] = $(this).val();
            });

           $.ajax({
              url: '../Controller/C_camiones.php',
              type: 'POST',
              dataType: 'json',
              data: datosCamion,
              success: function(data) {
                if (data.accion == "Showed") {
                    $('#editCamion').modal();
                    $('#editCamion input[name="id"]').val(data.id);
                    $('#editCamion input[name="modelo"]').val(data.modelo);
                    $('#editCamion input[name="marca"]').val(data.marca);
                    $('#editCamion input[name="placa"]').val(data.placa);
                }else if (data.accion == "Eliminado" || data.accion == "Editado" || data.accion == "Creado"){
                    location.reload();
                }
              },
              error: function(xhr, textStatus, errorThrown) {
                console.log(xhr)
                console.log(textStatus)
                console.log(errorThrown)
              }
            });
                                    
        });   
    </script>
</body>
</html>