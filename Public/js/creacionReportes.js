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
        //Mostrar la pantalla de carga
        document.querySelector('.load').style.display = 'block';

        // Crear un objeto FormData con los datos del formulario
        let formData = new FormData();
        $.each(datosForm, function(key, value) {
            formData.append(key, value);
        });

        // Enviar los datos al servidor usando fetch
        fetch('../Controller/C_controlReportes.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            //Ocultar la pantalla de carga
            document.querySelector('.load').style.display = 'none';

            if (response.headers.get('Content-Type').includes('application/json')) {
                return response.json().then(data => {
                    if (data.success) {
                        // Si la validación pasa, abrir el PDF en una nueva pestaña
                        let params = new URLSearchParams(datosForm).toString();
                        let url = `http://localhost/PanelControlJR/Public/reportes/planilla.php?${params}`;
                        window.open(url, '_blank');
                    } else {
                        // Si la validación falla, mostrar el mensaje en la consola
                        mostrarMensajeError("El rango de fecha que ingresó no es válido.");
                    }
                });
            } else if (response.headers.get('Content-Type').includes('application/pdf')) {
                // Si la respuesta es un PDF, abrirlo en una nueva pestaña
                return response.blob().then(blob => {
                    let url = URL.createObjectURL(blob);
                    window.open(url, '_blank');
                });
            }
        })
        .catch(error => {
            //Ocultar la pantalla de carga en caso de error
            document.querySelector('.load').style.display = 'none';

            console.error('Error:', error);
        });
    }

})