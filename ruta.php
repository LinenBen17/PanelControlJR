<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

	require 'validacionSesion.php';
	require 'validacionSeccion.php';

    $sql = "SELECT * FROM ruta";
    $sentencia = $mysqli->prepare($sql);
    $sentencia->execute();

    $resultadoSet = $sentencia->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <title>Pilotos | Transportes JR</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <?php require 'navigation.php'; ?>
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
                <?php require 'userImg.php'; ?>
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
                                <?php while ($resultado = $resultadoSet->fetch_array()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($resultado['id']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['placa']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['piloto']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['ruta']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['fecha_creacion']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['fecha_modificacion']);?></td>
                                        <td><button id="<?php echo htmlspecialchars($resultado['id']); ?>" class="btnEditar btnCrud" value="Show">Editar</button></td>
                                        <td><button id="<?php echo htmlspecialchars($resultado['id']); ?>" class="btnEliminar btnCrud" value="Eliminar">Eliminar</button></td>
                                    </tr>
                                <?php } ?>
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
                    <div class="inputBx">
                        <input type="submit" name="action" class="btn btnCrud" value="Crear">
                    </div>
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
                    <div class="inputBx">
                        <input type="submit" name="action" class="btn btnCrud" value="Editar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        //MenuToggle
        let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        let main = document.querySelector('.main');

        toggle.onclick = function(){
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
        //add hovered class in selected list item
        let list = document.querySelectorAll('.navigation li');
        function activeLink() {
            list.forEach((item)=>{
                item.classList.remove('hovered');
            });
            this.classList.add('hovered');
        }
        list.forEach((item)=>{
            item.addEventListener('mouseover', activeLink)
        })
    </script>
    <script>
        $('.actionButton').click(function() {
            $('#newRuta').modal();
        });

        $('.searchPiloto').on('input', function() {
            let datosSearch = {
                "search": $(this).val(),
                "accion": "Search"
            }
            $.ajax({
              url: 'editRuta.php',
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
                "search": $(this).val(),
                "accion": "SearchPlaca"
            }
            $.ajax({
              url: 'editRuta.php',
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

        $(".btnCrud").click(function(e) {
            e.preventDefault();
            console.log($(this).val());

            let datosRuta;

            if($(this).val() == "Crear"){
                datosRuta = {
                    "placa": $('#newRuta input[name="placa"]').val(),
                    "piloto": $('#newRuta input[name="piloto"]').val(),
                    "ruta": $('#newRuta input[name="ruta"]').val(),
                    "accion": "Crear",
                }
            }else if ($(this).val() == "Editar") {
                datosRuta = {
                    "id": $('#editRuta input[name="id"]').val(),
                    "placa": $('#editRuta input[name="placa"]').val(),
                    "piloto": $('#editRuta input[name="piloto"]').val(),
                    "ruta": $('#editRuta input[name="ruta"]').val(),
                    "accion": "Editar",
                }
            }else if ($(this).val() == "Show") {
                datosRuta = {
                    "accion": "Show",
                    "id": this.id,
                }
            }else if ($(this).val() == "Eliminar") {
                datosRuta = {
                    "accion": "Eliminar",
                    "id": this.id,
                }
            }
           $.ajax({
              url: 'editRuta.php',
              type: 'POST',
              dataType: 'json',
              data: datosRuta,
              success: function(data) {
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
    </script>
</body>
</html>