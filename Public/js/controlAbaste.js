/////FECHA ACTUAL//////
var fechaActual = new Date();
var year = fechaActual.getFullYear();
var month = fechaActual.getMonth() + 1; // Los meses van de 0 a 11, por lo que se suma 1
var day = fechaActual.getDate();
var hours = fechaActual.getHours();
var minutes = fechaActual.getMinutes();
var seconds = fechaActual.getSeconds();
var nombreReportes;
 
////MUESTRA LA TABLA DE ABASTECIMIENTO////
$(document).ready(function(){

    $('#abastecimientoTable').DataTable({
        ajax: {
            url: '../Controller/C_abastecimiento.php',
            dataSrc: ''
        },
        "sDefaultContent": '<a href="">Edit</a> / <a href="" onclick="removeRow();">Delete</a>',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        columns: [
            { data: 'id' },
            { data: 'placa' },
            { data: 'piloto' },
            { data: 'ruta' },
            { data: 'km_inicial' },
            { data: 'km_final' },
            { data: 'monto_total' },
            { data: 'galones' },
            { data: 'precio_galon' },
            { data: 'editar' },
            { data: 'eliminar' },
        ]
    });

    $('#abastecimientoTable').DataTable().on('init.dt', function () {
        //ELIMINAR REGISTRO
        $('.btnEliminar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_abastecimiento.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "Delete"},
                success: function(data) {
                    if(data){
                        location.reload();
                    }
                    else {
                        alert(":(((")
                    }
                },
                error: function() {
                    console.log("ERROR");
                }
            })
            
        });

        // DATOS PARA EDITAR USUARIO
        $('a.btnEditar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_abastecimiento.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "ShowRegister"},
                success: function(data) {
                    var campos = Object.keys(data);

                    campos.forEach((campo)=>{
                        $('#editarUser form').append(`
                            <div class="inputBx ${campo}">
                                <label for="">${campo.toUpperCase()}</label><br>
                                <input type="text" name="${campo}" id="${campo}" value="${data[campo]}">
                            </div>
                        `)
                    })

                    $("#" + campos[0]).attr({
                        'type': 'hidden',
                    });
                    $('#editarUser').modal();

                    $('#editarUser').on($.modal.AFTER_CLOSE, function() {
                        $('#editarUser form > div').remove();
                    });
                },
                error: function(a, b, c) {
                    console.log(a);
                    console.log(b);
                    console.log(c);
                }
            })
            
        });
        $('.update').click(function(e) {
            e.preventDefault();

            let inputs = document.querySelectorAll(".formAbastecimiento input");
            let datosForm = {
                "action": "Update",
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
                success:function(data) {
                    if (data) {
                        location.reload();
                    }else{
                        alert(":((");
                    }
                },
                error:function(a,b,c) {
                    console.log(a);
                    console.log(b);
                    console.log(c);
                }
            })
            
        });
    });
});

//// CREACION Y ESPECIFICACION DE REPORTES////
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