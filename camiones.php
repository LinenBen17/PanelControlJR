<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

	require 'validacionSesion.php';
	require 'validacionSeccion.php';

    $sql = "SELECT * FROM camiones";
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
                                <?php while ($resultado = $resultadoSet->fetch_array()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($resultado['id']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['modelo']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['marca']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['placa']);?></td>
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
                    <div class="inputBx">
                        <input type="submit" name="action" class="btn btnCrud" value="Crear">
                    </div>
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
            $('#newCamion').modal();
        });

        $(".btnCrud").click(function(e) {
            e.preventDefault();
            console.log($(this).val());

            let datosCamion;

            if($(this).val() == "Crear"){
                datosCamion = {
                    "modelo": $('#newCamion input[name="modelo"]').val(),
                    "marca": $('#newCamion input[name="marca"]').val(),
                    "placa": $('#newCamion input[name="placa"]').val(),
                    "accion": "Crear",
                }
            }else if ($(this).val() == "Editar") {
                datosCamion = {
                    "id": $('#editCamion input[name="id"]').val(),
                    "modelo": $('#editCamion input[name="modelo"]').val(),
                    "marca": $('#editCamion input[name="marca"]').val(),
                    "placa": $('#editCamion input[name="placa"]').val(),
                    "accion": "Editar",
                }
            }else if ($(this).val() == "Show") {
                datosCamion = {
                    "accion": "Show",
                    "id": this.id,
                }
            }else if ($(this).val() == "Eliminar") {
                datosCamion = {
                    "accion": "Eliminar",
                    "id": this.id,
                }
            }
           $.ajax({
              url: 'editCamion.php',
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