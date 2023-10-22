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
                        <h2>Control Ruta</h2>
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
                                <td>Placa</td>
                                <td>Piloto</td>
                                <td>Ruta</td>
                                <td>Fecha Creación</td>
                                <td>Fecha Modif.</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                            <tbody>
                                <?php include_once '../Controller/C_ruta.php'; ?>
                            </tbody>
                    </table>
                </div>
            </div>
            <div id="newRuta" class="modal form">
                <form method="POST">
                    <h2>Nueva Ruta</h2>
                    <div class="inputBx">
                        <label for="">Placa:</label><br>
                        <input type="text" class="searchPlaca" name="placa">
                        <div class="autocompletePlaca">
                            <ul class="autocomplete-results"></ul>
                        </div>
                    </div>
                    <div class="inputBx">
                        <label for="">Piloto:</label><br>
                        <input type="text" class="searchPiloto" name="piloto">
                        <div class="autocompletePiloto">
                            <ul class="autocomplete-results"></ul>
                        </div>
                    </div>
                    <div class="inputBx">
                        <label for="">Ruta:</label><br>
                        <input type="text" name="ruta">
                    </div>
                    <input type="submit" name="action" class="btn btnCrud" value="Crear">
                </form>
            </div>
            <div id="editRuta" class="modal form">
                <form method="POST">
                    <h2>Editar Ruta</h2>
                    <input type="hidden" name="id">
                    <div class="inputBx">
                        <label for="">Placa:</label><br>
                        <input type="text" name="placa">
                    </div>
                    <div class="inputBx">
                        <label for="">Piloto:</label><br>
                        <input type="text" name="piloto">
                    </div>
                    <div class="inputBx">
                        <label for="">Ruta:</label><br>
                        <input type="text" name="ruta">
                    </div>
                    <input type="submit" name="action" class="btn btnCrud" value="Editar">
                </form>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
	<script>
        $('.actionButton').click(function() {
            $('#newRuta').modal();
        });

        $(".btnCrud").click(function(e) {
            e.preventDefault();

            let datosRuta = {};

            let divPadre = $(this).parent();
            let inputs = divPadre.find("input");
            let button = divPadre.find('button');
            
            if (button) {
                datosRuta["action"] = button.val();
                datosRuta["id"] = button.attr('id');
            }
            inputs.each(function(){
                datosRuta[this.name] = $(this).val();
            });

            console.log(datosRuta)

           $.ajax({
              url: '../Controller/C_ruta.php',
              type: 'POST',
              dataType: 'json',
              data: datosRuta,
              success: function(data) {
                console.log(data)
                if (data.accion == "Showed") {
                    $('#editRuta').modal();
                    $('#editRuta input[name="id"]').val(data.id);
                    $('#editRuta input[name="placa"]').val(data.placa);
                    $('#editRuta input[name="piloto"]').val(data.piloto);
                    $('#editRuta input[name="ruta"]').val(data.ruta);
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

        $('.searchPiloto').on('input', function() {
            let datosSearch = {
                "searchPiloto": $(this).val(),
                "action": "SearchPiloto"
            }
            $.ajax({
              url: '../Controller/C_ruta.php',
              type: 'POST',
              dataType: 'json',
              data: datosSearch,
              success: function(data) {
                $('.autocompletePiloto .autocomplete-results').empty();
                data.forEach((piloto)=>{
                    $('.autocompletePiloto .autocomplete-results').append(`
                        <li>${piloto}</li>
                    `);
                })

                $('.autocompletePiloto .autocomplete-results li').click(function() {
                    $('.searchPiloto').val($(this).text());
                    $('.autocompletePiloto .autocomplete-results').empty();
                });
              },
              error: function(xhr, textStatus, errorThrown) {
                console.log(xhr)
                console.log(textStatus)
                console.log(errorThrown)
              }
            });
        });

        $('.searchPlaca').on('input', function() {
            let datosPlaca = {
                "searchPlaca": $(this).val(),
                "action": "SearchPlaca"
            }
            $.ajax({
              url: '../Controller/C_ruta.php',
              type: 'POST',
              dataType: 'json',
              data: datosPlaca,
              success: function(data) {
                $('.autocompletePlaca .autocomplete-results').empty();
                data.forEach((placa)=>{
                    $('.autocompletePlaca .autocomplete-results').append(`
                        <li>${placa}</li>
                    `);
                })

                $('.autocompletePlaca .autocomplete-results li').click(function() {
                    $('.searchPlaca').val($(this).text());
                    $('.autocompletePlaca .autocomplete-results').empty();
                });
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