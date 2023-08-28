<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

	require 'validacionSesion.php';
	require 'validacionSeccion.php';

    $sql = "SELECT * FROM pilotos";
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
                                <?php while ($resultado = $resultadoSet->fetch_array()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($resultado['id']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['nombres']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['apellidos']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['licencia']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['fecha_creacion']);?></td>
                                        <td><?php echo htmlspecialchars($resultado['fecha_modificacion']);?></td>
                                        <td><?php echo $resultado['estado'] == 1 ? 'Activo' : 'Inactivo';?></td>
                                        <td><button id="<?php echo htmlspecialchars($resultado['id']); ?>" class="btnEditar btnCrud" value="Show">Editar</button></td>
                                        <td><button id="<?php echo htmlspecialchars($resultado['id']); ?>" class="btnEliminar btnCrud" value="Eliminar">Eliminar</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                </div>
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
                    <div class="inputBx">
                        <input type="submit" name="action" class="btn btnCrud" value="Crear">
                    </div>
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
            $('#newPiloto').modal();
        });

        $(".btnCrud").click(function(e) {
            e.preventDefault();
            console.log($(this).val());

            let datosPiloto;

            if($(this).val() == "Crear"){
                datosPiloto = {
                    "nombres": $('#newPiloto input[name="nombres"]').val(),
                    "apellidos": $('#newPiloto input[name="apellidos"]').val(),
                    "licencia": $('#newPiloto input[name="licencia"]').val(),
                    "estado": $('#newPiloto select[name="estado"]').val(),
                    "accion": "Crear",
                }
            }else if ($(this).val() == "Editar") {
                datosPiloto = {
                    "id": $('#editPiloto input[name="id"]').val(),
                    "nombres": $('#editPiloto input[name="nombres"]').val(),
                    "apellidos": $('#editPiloto input[name="apellidos"]').val(),
                    "licencia": $('#editPiloto input[name="licencia"]').val(),
                    "estado": $('#editPiloto select[name="estado"]').val(),
                    "accion": "Editar",
                }
            }else if ($(this).val() == "Show") {
                datosPiloto = {
                    "accion": "Show",
                    "id": this.id,
                }
            }else if ($(this).val() == "Eliminar") {
                datosPiloto = {
                    "accion": "Eliminar",
                    "id": this.id,
                }
            }
           $.ajax({
              url: 'editPiloto.php',
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