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
    <!-- SheetJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

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
                        <button type="button" class="reports btnEditar">Generador de Reportes</button>
                    </div>

                    <div id="reportes" class="modal form">
                        <form method="POST">
                            <h2>Selecciona el filtro deseado:</h2>
                            <div class="inputBx">
                                <div class="select">
                                    <select name="opcionesFiltros" class="opcionesFiltros">
                                        <option>---------</option>
                                        <option value="porPlaca">Por Placa</option>
                                        <option value="porFecha">Por Fecha</option>
                                        <option value="entreFechas">Entre Fechas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="inputBx filtroPorPlaca filtros" id="filtroPorPlaca">
                                <label>Placa:</label><br>
                                <input type="text" id="placaFilter" placeholder=""><br><br>
                                <button type="button" class="generar btnEditar">Generar</button>
                            </div>
                            <div class="inputBx filtroPorFecha filtros" id="filtroPorFecha">
                                <label>Fecha:</label><br>
                                <input type="date" id="fechaFilter" placeholder=""><br><br>
                                <button type="button" class="generar btnEditar">Generar</button>
                            </div>
                            <div class="inputBx filtroEntreFechas filtros" id="filtroEntreFechas">
                                <label>Entre:</label><br>
                                <input type="date" id="fechaInicial" placeholder=""><br>
                                <label>Y:</label><br>
                                <input type="date" id="fechaFinal" placeholder=""><br><br>
                                <button type="button" class="generar btnEditar">Generar</button>
                            </div>
                        </form>
                    </div>
                </div><br>

                <div class="recentOrders">
                    <table id="abastecimientoTable" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Piloto</th>
                                <th>Ruta</th>
                                <th>Km. Inicial</th>
                                <th>Km. Final</th>
                                <th>Monto Total</th>
                                <th>Galones</th>
                                <th>Precio x Galón</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
    <script>
        var fechaActual = new Date();
        var year = fechaActual.getFullYear();
        var month = fechaActual.getMonth() + 1; // Los meses van de 0 a 11, por lo que se suma 1
        var day = fechaActual.getDate();
        var hours = fechaActual.getHours();
        var minutes = fechaActual.getMinutes();
        var seconds = fechaActual.getSeconds();
        var nombreReportes;

        $(document).ready(function(){

            $('#abastecimientoTable').DataTable({
                ajax: {
                    url: '../Controller/C_abastecimiento.php',
                    dataSrc: ''
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                columns: [
                    { data: 'placa' },
                    { data: 'piloto' },
                    { data: 'ruta' },
                    { data: 'km_inicial' },
                    { data: 'km_final' },
                    { data: 'monto_total' },
                    { data: 'galones' },
                    { data: 'precio_galon' },
                ]
            });
        });

        $('#placa').blur(function() {
            let datosSearch = {
                "placa": $(this).val(),
                "action": "SearchPlaca"
            }

            $.ajax({
              url: '../Controller/C_abastecimiento.php',
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
            let calculo = $("#monto_total").val() / $("#galones").val();
            $("#precio_galon").val(calculo.toFixed(2));
            $(".save").focus();
        })

        $(".save").click(function(){
            let inputs = document.querySelectorAll(".formAbastecimiento input");
            let datosForm = {
                "action": "Save",
            };

            inputs.forEach((input) =>{
                let id = input.id;
                let valor = input.value;
                
                datosForm[id] = valor;
                
            })

            $.ajax({
              url: '../Controller/C_abastecimiento.php',
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
        $(".reports").click(function(){
            $('#reportes').modal();
        })
        $(".opcionesFiltros").change(function() {
            let opcionSeleccionada = $(".opcionesFiltros option:selected").val();
            
            switch (opcionSeleccionada) {
                case "porPlaca":
                    $('.filtros').css('display', 'none');
                    $(".filtroPorPlaca").css('display', 'block');
                    break;
                case "porFecha":
                    $('.filtros').css('display', 'none');
                    $(".filtroPorFecha").css('display', 'block');
                    break;
                case "entreFechas":
                    $('.filtros').css('display', 'none');
                    $(".filtroEntreFechas").css('display', 'block');
                    break;
                default:
                    $('.filtros').css('display', 'none');
                    break;
            }
        });

        $('#fechaInicial').change(function () {
            $("#fechaFinal").attr('min', $('#fechaInicial').val());
        })
        $('#fechaFilter').change(function () {
            console.log($(this).val())
        })

        $('.generar').click(function() {
            let divPadre = $(this).parent();
            let inputs = divPadre.find("input");
            let datosParaReporte={};
            
            inputs.each(function(){
                datosParaReporte[this.id] = $(this).val();
            });

            datosParaReporte["action"] = divPadre.attr("id");

            console.log(datosParaReporte);

            $.ajax({
              url: '../Controller/C_abastecimiento.php',
              type: 'POST',
              dataType: 'json',
              data: datosParaReporte,
              success: function(datos) {
                let data = Array.isArray(datos) ? datos : [datos];
                nombreReportes = "REPORT_" + year + "/" + month + "/" + day + "_" + hours + ":" + minutes + ":" + seconds;

                const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
                const EXCEL_EXTENSION = '.xlsx';

                downloadAsExcel();

                function downloadAsExcel(){
                    const worksheet = XLSX.utils.json_to_sheet(data);
                    const workbook = {
                        Sheets: {
                            'data' : worksheet
                        },
                        SheetNames: ['data']
                    };
                    const excelBuffer = XLSX.write(workbook, {bookType: 'xlsx', type: 'array'});
                    console.log(excelBuffer);
                    saveAsExcel(excelBuffer, nombreReportes);
                }

                function saveAsExcel(buffer, filename){
                    const data = new Blob([buffer], {type: EXCEL_TYPE});
                    saveAs(data, filename+EXCEL_EXTENSION);
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