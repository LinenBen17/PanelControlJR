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
                        <h2>Control Pilotos</h2>
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
                                <td>Nombres</td>
                                <td>Apellidos</td>
                                <td>Licencia</td>
                                <td>Fecha Creación</td>
                                <td>Fecha Modif.</td>
                                <td>Estado</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                            <tbody>
                                <?php include_once("../Controller/C_pilotos.php") ?>
                            </tbody>
                    </table>
                </div>
                <div id="newPiloto" class="modal form">
                    <form method="POST">
                        <h2>Nuevo Piloto</h2>
                        <div class="inputBx">
                            <label for="">Nombres:</label><br>
                            <input type="text" name="nombres">
                        </div>
                        <div class="inputBx">
                            <label for="">Apellidos:</label><br>
                            <input type="text" name="apellidos">
                        </div>
                        <div class="inputBx">
                            <label for="">Licencia:</label><br>
                            <input type="text" name="licencia">
                        </div>
                        <div class="inputBx">
                            <label for="">Estado:</label><br>
                            <div class="select">
                                <select name="estado">
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="action" class="btn btnCrud" value="Crear">
                    </form>
                </div>
                <div id="editPiloto" class="modal form">
                    <form method="POST">
                        <h2>Editar Piloto</h2>
                        <input type="hidden" name="id">
                        <div class="inputBx">
                            <label for="">Nombres:</label><br>
                            <input type="text" name="nombres">
                        </div>
                        <div class="inputBx">
                            <label for="">Apellidos:</label><br>
                            <input type="text" name="apellidos">
                        </div>
                        <div class="inputBx">
                            <label for="">Licencia:</label><br>
                            <input type="text" name="licencia">
                        </div>
                        <div class="inputBx">
                            <label for="">Estado:</label><br>
                            <div class="select">
                                <select name="estado">
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="action" class="btn btnCrud" value="Editar">
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
	<script>
        $('.actionButton').click(function() {
            $('#newPiloto').modal();
        });

        $(".btnCrud").click(function(e) {
            e.preventDefault();

            let datosPiloto = {};

            let divPadre = $(this).parent();
            let inputs = divPadre.find("input");
            let button = divPadre.find('button');
            let select = divPadre.find('select');
            
            if (button) {
                datosPiloto["action"] = button.val();
                datosPiloto["id"] = button.attr('id');
            }
            if (select) {
                datosPiloto["estado"] = select.val();
            }
            inputs.each(function(){
                datosPiloto[this.name] = $(this).val();
            });

           $.ajax({
              url: '../Controller/C_pilotos.php',
              type: 'POST',
              dataType: 'json',
              data: datosPiloto,
              success: function(data) {
                if (data.accion == "Showed") {
                    $('#editPiloto').modal();
                    $('#editPiloto input[name="id"]').val(data.id);
                    $('#editPiloto input[name="nombres"]').val(data.nombres);
                    $('#editPiloto input[name="apellidos"]').val(data.apellidos);
                    $('#editPiloto input[name="licencia"]').val(data.licencia);
                    $('#editPiloto select[name="estado"]').val(data.estado);
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