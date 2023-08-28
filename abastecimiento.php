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
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <title>Abastecimiento | Transportes JR</title>
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
    <script>
    	$('#placa').blur(function() {
    		let datosSearch = {
                "placa": $(this).val(),
                "accion": "Search"
            }
            $.ajax({
              url: 'accionesAbastecimiento.php',
              type: 'POST',
              dataType: 'json',
              data: datosSearch,
              success: function(data) {
                $('#piloto').val(data["piloto"]);
                $('#ruta').val(data["ruta"]);
                $('#km_inicial').focus();
              },
              error: function(xhr, textStatus, errorThrown) {
                console.log(xhr)
                console.log(textStatus)
                console.log(errorThrown)
              }
            });
    	});

    	$("#galones").blur(function() {
    		let calculo = parseInt($("#monto_total").val()) / parseInt($("#galones").val());
    		$("#precio_galon").val(calculo.toFixed(3));
    		$(".save").focus();
    	})

    	$(".save").click(function(){
    		let inputs = document.querySelectorAll(".formAbastecimiento input");
    		let datosForm = {
    			"accion": "Save",
    		};

    		inputs.forEach((input) =>{
    			let id = input.id;
    			let valor = input.value;
    			
    			datosForm[id] = valor;
    			
    		})

            $.ajax({
              url: 'accionesAbastecimiento.php',
              type: 'POST',
              dataType: 'json',
              data: datosForm,
              success: function(data) {
              	location.reload();
              },
              error: function(xhr, textStatus, errorThrown) {
                console.log(xhr)
                console.log(textStatus)
                console.log(errorThrown)
              }
            });
    	})
    	$(".clean").click(function(){
    		let inputs = document.querySelectorAll(".formAbastecimiento input");

    		inputs.forEach((input) =>{
    			input.value = '';
    		})
    	})
    </script>
</body>
</html>