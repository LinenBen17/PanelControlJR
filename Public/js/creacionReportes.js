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

$(".clean").click(function(){
    let inputs = document.querySelectorAll(".formCreacionReportes input");

    inputs.forEach((input) =>{
        input.value = '';
    })
})

//DATEPICKER
let fechaInicial;
let fechaFinal;

$(function() {
    $('input[name="daterange"]').daterangepicker({
        ranges: {
           'Primera Quincena': [moment().startOf('month'), moment().date(15).endOf('day')],
           'Segunda Quincena': [moment().date(16).startOf('day'), moment().endOf('month')]
        },
        maxSpan: {
            days: 15 // Establece aquí el máximo de días permitidos en el rango
        }
    }, function(start, end, label) {
        fechaInicial = start.format('YYYY-MM-DD');
        fechaFinal = end.format('YYYY-MM-DD');
    });
});
    
$(".print").click(function(e){
    e.preventDefault();
    let inputs = document.querySelectorAll(".formCreacionReportes input");
    let selects = document.querySelectorAll(".formCreacionReportes select");

    let datosForm = {
        "action": "Print",
        "tipo_reporte": selects[0].value,
        "fechaInicial": fechaInicial,
        "fechaFinal": fechaFinal,
    };

    let camposLlenos = true; // Suponemos que todos los campos están llenos inicialmente

    for (let input in datosForm) {

        if (datosForm[input] == undefined) {
            mostrarMensajeError("Rango de fecha inválido.");
            camposLlenos = false; // Cambiamos la variable a false si encontramos un campo vacío
        }
    }

    if (camposLlenos) {
    let form = $('<form>', {
        action: '../Controller/C_controlReportes.php',
        method: 'POST',
        target: '_blank'
    });

    $.each(datosForm, function(key, value) {
        form.append($('<input>', {
            type: 'hidden',
            name: key,
            value: value
        }));
    });

    form.appendTo('body').submit().remove();
}

})