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
    <title>Guías Madres | Transportes JR</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
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
                            <form action="crearMadres.php" method="POST">
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
                                <button type="submit" class="save btnEditar">Crear</button>
                            </form>  
                        </div>
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
        $(document).ready(function() {
            $('#des_codigo').focus();    
        });
        $('.clean').click(function(){
            var inputs = document.querySelectorAll('form input');
            inputs.forEach(a => a.value = "");
        });
        //OBTENER INFORMACION EN BASE AL CODIGO CON AJAX
        $("#des_codigo").blur(function() {
            var codigo = $('#des_codigo').val();

            $.ajax({
                url: 'getGuiaMadre.php',
                type: 'POST',
                dataType: 'json',
                data: {codigo: codigo},
                success: function(data){
                    if (Object.values(data).length > 1) {
                        //VARIABLES DE LOS DATOS
                        var id = [];
                        var nombre = [];
                        var direccion = [];
                        var telefono = [];
                        var contacto = [];
                        var destino = [];
                        var found;

                        //USAMOS Object.values PARA OBTENER EN ARRAY EL OBJETO E ITERAR
                        Object.values(data).forEach(datos =>{
                            //LOS DATOS LOS AÑADIMOS A SU RESPECTIVA VARIABLE
                            id.push(datos.idcliente);
                            nombre.push(datos.nombre);
                            direccion.push(datos.direccion);
                            telefono.push(datos.telefono);
                            contacto.push(datos.contacto);
                            destino.push(datos.destino);

                        });

                        //AGREGAMOS AL SELECT TODAS LAS DIRECCIONES
                        for (var i = 0; i < Object.values(data).length; i++) {
                            $('#selectModal > select').append(`
                                    <option value="${id[i]}" class="optionDir">${direccion[i]}</option>
                                `)  
                        }

                        $('#selectModal').modal();

                        //OBTENGO LA INFO. DE LA OPCIÓN SELECCIONADA
                        $('#selectModal > select').on('change', function() {
                            var value = $(this).val();

                            var optionSelected = data.find(e => e.idcliente == value);

                            try{
                                $('#des_nombre').val(optionSelected.nombre);
                                $('#des_direccion').val(optionSelected.direccion);
                                $('#des_telefono').val(optionSelected.telefono);
                                $('#des_contacto').val(optionSelected.contacto);
                                $('#des_destino').val(optionSelected.destino);
                            }catch(e){
                                $('#des_nombre').val('');
                                $('#des_direccion').val('');
                                $('#des_telefono').val('');
                                $('#des_contacto').val('');
                                $('#des_destino').val('');
                            }
                            
                        });

                        $('#selectModal').on($.modal.AFTER_CLOSE, function() {
                            $('.optionDir').remove();
                        });
                    }else{
                        var nombre;
                        var direccion;
                        var telefono;
                        var contacto;
                        var destino ;

                        Object.values(data).forEach(datos =>{
                            nombre = datos.nombre;
                            direccion = datos.direccion;
                            telefono = datos.telefono;
                            contacto = datos.contacto;
                            destino = datos.destino;
                        });
                        
                        $('#des_nombre').val(nombre);
                        $('#des_direccion').val(direccion);
                        $('#des_telefono').val(telefono);
                        $('#des_contacto').val(contacto);
                        $('#des_destino').val(destino);
                    }
                },
                error: function(xhr, status, error){
                    console.log(xhr)
                    console.log(status)
                    console.log(error)
                }
            })
        });
    </script>
    <script>
        // DATE
        var today = new Date();
        var day = today.getDate();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();
        var hour = today.getHours();
        var minutes = today.getMinutes();

        var formaPago;
        var codigo;

        $(".print").click(function () {
            formaPago = (($('#rem_codigo').val()).toUpperCase() == "XCO-6863") ? "POR COBRAR" : "CRÉDITO";
            codigo = (($('#rem_codigo').val()).toUpperCase() == "XCO-6863") ? "XCO-6863" : "V03-6862";
            /*numInicial = parseInt($('#id_numini').val());
            numFinal = parseInt($('#id_numfin').val());*/

            imprSelec('canvas');
        });

        function imprSelec(nombre) {
            var ficha = document.getElementById(nombre)
            var ventana = window.open(' ', 'popimpr');
            ventana.document.write('<html><head><title>' + document.title + '</title>');
            ventana.document.write('<link rel="stylesheet" href="css/printMadre.css">'); //Aquí agregué la hoja de estilos
            ventana.document.write('</head><body >');
            //ventana.document.write('<div class="canvas"></div>')
            ventana.document.write(
                `
                        <div class="guia">
                            <div class="formapago">
                                <p class="">${formaPago}</p>
                            </div>
              <div class="datos">
                <div class="datosRemitente">
                  <p class="remitente">FORMULARIOS STANDARD, S.A.</p>
                  <p class="dirRemitente">1 CALLE 35-39 ZONA 11 COL. TOLEDO</p>
                  <p class="telRemitente">2429-8900</p>
                  <p class="origen">CAP</p>
                </div>
                <div class="datosDestinatario">
                  <p class="destinatario">${$('#des_nombre').val()}/${$('#des_contacto').val()}</p>
                  <p class="dirDestinatario">${$('#des_direccion').val()}</p>
                  <p class="telDestinatario">${$('#des_telefono').val()}</p>
                  <p class="destino">${$('#des_destino').val()}</p>
                </div>
              </div>
                            <div class="codigoCliente">
                                <p>${codigo}</p>
                            </div>
                        </div>
                    `
                );
            ventana.document.write('</body></html>');
            ventana.document.close();
            setTimeout(()=>{
                ventana.print( );
            }, 100);
            $('.clean').click();
        }
    </script>
</body>
</html>