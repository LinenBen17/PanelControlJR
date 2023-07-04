<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

	require 'validacionSesion.php';
	require 'validacionSeccion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
                            </tr>
                        </thead>
                            <tbody>
                                <td>1</td>
                                <td>Aaron Benjamín</td>
                                <td>Esquite Castillo</td>
                                <td>A11</td>
                                <td>3/07/2023</td>
                                <td>3/07/2023</td>
                                <td>Activo</td>
                            </tbody>
                    </table>
                </div>
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
</body>
</html>