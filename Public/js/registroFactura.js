//FUNCIONES DE MENSAJES
function mostrarMensajeError(mensaje) {
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: mensaje,
        background: '#071A2C',
        color: "#FFF",
        showConfirmButton: false,
        timer: 1500
    });
}

function mostrarMensajeSuccess(mensaje) {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: mensaje,
        background: '#071A2C',
        color: "#FFF",
        showConfirmButton: false,
        timer: 1500
    });
}
/////FECHA ACTUAL//////
var fechaActual = new Date();
var year = fechaActual.getFullYear();
var month = fechaActual.getMonth() + 1; // Los meses van de 0 a 11, por lo que se suma 1
var day = fechaActual.getDate();
var hours = fechaActual.getHours();
var minutes = fechaActual.getMinutes();
var seconds = fechaActual.getSeconds();
var nombreReportes;

/////FUNCIONES PARA EL FORMULARIO DE ABASTECIMIENTO/////
$(document).ready(function() {
    $('#facturasTableUser').DataTable({
        ajax: {
            url: '../Controller/C_controlFacturasCombu.php',
            type: 'post',
            dataSrc:''
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        columns: [
            { data: 'id' },
            { data: 'placa' },
            { data: 'piloto' },
            { data: 'ruta' },
            { data: 'fecha' },
            { data: 'serie' },
            { data: 'noFactura' },
            { data: 'monto_total' },
            { data: 'galones' },
            { data: 'precio_galon' },
        ]
    });
});

$("#galones").blur(function() {
    let calculo = $("#monto_total").val() / $("#galones").val();
    $("#precio_galon").val(calculo.toFixed(2));
    $(".save").focus();
})

$(".save").click(function(){
    let inputs = document.querySelectorAll(".formRegistroFact input");
    let datosForm = {
        "action": "Save",
    };

    inputs.forEach((input) =>{
        let id = input.id;
        let valor = input.value;
        
        datosForm[id] = valor;
        
    })

    console.log(datosForm)

    $.ajax({
      url: '../Controller/C_controlFacturasCombu.php',
      type: 'POST',
      dataType: 'json',
      data: datosForm,
      success: function(data) {
        if (data) {
            location.reload();
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr)
        console.log(textStatus)
        console.log(errorThrown)
      }
    });
})
$(".clean").click(function(){
    let inputs = document.querySelectorAll(".formRegistroFact input");

    inputs.forEach((input) =>{
        input.value = '';
    })
})