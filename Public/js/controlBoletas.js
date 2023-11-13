$("input[name='noManifiesto']").focus();

/*$("input[name='confirmar']").click(function(e) {
	e.preventDefault();

	$("#confirmarDatos input[name='tipoBoleta']").val($(".formGuardarBoletas input[name='tipoBoleta']").val());
	$("#confirmarDatos input[name='fechaBoleta']").val($(".formGuardarBoletas input[name='fechaBoleta']").val());
	$("#confirmarDatos input[name='valorBoleta']").val($(".formGuardarBoletas input[name='valorBoleta']").val());

    $('#confirmarDatos').modal();
})*/

/*$('#confirmarDatos').on($.modal.AFTER_OPEN, function() {
    $("#confirmarDatos input[name='noManifiesto']").focus();
    console.log("A")
});*/

$("input[name='Guardar']").click(function(e) {
    e.preventDefault();

    var formData1 = $(".formGuardarBoletas form").serializeArray();
    var formData2 = $(".boleta").find("input, select").serializeArray();
    var datos = formData1.concat(formData2);

    // Validar campos vacíos
    var campos = $(".boleta").find("input, select, textarea");
    var hayCamposVacios = campos.filter(function () {
        return $(this).val() === "";
    }).length > 0;

    if (hayCamposVacios) {
        mostrarMensajeError('Los campos agregados deben estar completos.');
        return;
    }

    $.ajax({
        url: '../Controller/C_controlBoletas.php',
        type: 'POST',
        dataType: 'json',
        data: datos,
        success: function(data) {
            if (data.includes("vacio")) {
                mostrarMensajeError('Todos los campos deben estar llenos.');
            }

            Object.values(data).forEach((estado) => {
                console.log(estado);
                if (estado.includes("repetido")) {
                    mostrarMensajeError(`La Boleta ${estado[1]}, ya fue ingresada anteriormente.`);
                }
            });

            if (Object.values(data).every(elemento => elemento === "registrado")) {
                location.reload();
            }
        },
        error: function(a, b, c) {
            console.log(a);
            console.log(b);
            console.log(c);
        }
    });
});

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

/////DATATABLE BOLETAS INGRESADAS POR USUARIO////
$(document).ready(function() {
	$('#boletasTable').DataTable({
        ajax: {
            url: '../Controller/C_controlBoletas.php',
            type: 'post',
            data: {"action" : "BoletasUsuario"},
            dataSrc:''
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        columns: [
            { data: 'id' },
            { data: 'noManifiesto' },
            { data: 'noBoleta' },
            { data: 'tipoBoleta' },
            { data: 'valorBoleta' },
            { data: 'bancoBoleta' },
            { data: 'fechaBoleta' },
            { data: 'fechaIngreso' },
            { data: 'usuarioIngresa' },
        ]
    });
});

/////DATATABLE BOLETAS INGRESADAS GENERAL////
$(document).ready(function() {
	$('#boletasTableGeneral').DataTable({
        ajax: {
            url: '../Controller/C_controlBoletas.php',
            type: 'post',
            dataSrc:''
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ],
        columns: [
            { data: 'id' },
            { data: 'noManifiesto' },
            { data: 'fechaManifiesto' },
            { data: 'noBoleta' },
            { data: 'tipoBoleta' },
            { data: 'valorBoleta' },
            { data: 'bancoBoleta' },
            { data: 'agenciaBoleta' },
            { data: 'fechaBoleta' },
            { data: 'fechaIngreso' },
            { data: 'fechaModificacion' },
            { data: 'usuarioIngresa' },
        ]
    });
});