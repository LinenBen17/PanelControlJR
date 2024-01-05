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
            { data: 'lugarDeposito' },
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
            { data: 'lugarDeposito' },
            { data: 'agenciaBoleta' },
            { data: 'fechaBoleta' },
            { data: 'fechaIngreso' },
            { data: 'fechaModificacion' },
            { data: 'usuarioIngresa' },
            { data: 'editar' },
            { data: 'eliminar' },
        ]
    });

    $('#boletasTableGeneral').DataTable().on('draw.dt', function () {
        $('.btnEliminar').off('click');
    $('a.btnEditar').off('click');
    $('.update').off('click');
        //ELIMINAR REGISTRO
        $('.btnEliminar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_controlBoletas.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "Delete"},
                success: function(data) {
                    if(data == "deleted"){
                        mostrarMensajeSuccess("Registro eliminado con éxito.");
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                    else {
                        mostrarMensajeError("Hubo un problema al eliminar el registro.");
                    }
                },
                error: function(e, a, b) {
                    console.log(e, a, b);
                }
            })
            
        });
 
        // DATOS PARA EDITAR REGISTRO
        $('a.btnEditar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_controlBoletas.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "ShowRegister"},
                success: function(data) {
                    var campos = Object.keys(data);

                    campos.forEach((campo) => {
                    console.log(data[campo])


                        console.log(campo)
                        var inputHtml = '';

                        if (campo === 'fechaManifiesto') {
                            // Si es un campo de fecha, genera un input de tipo fecha
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="date" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === 'lugarDeposito') {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <div class="select">
                                        <select name="${campo}" id="${campo}">
                                            <option value="Jutiapa" ${data[campo] === 'Jutiapa' ? 'selected' : ''}>JUT</option>
                                            <option value="Santa Rosa" ${data[campo] === 'Santa Rosa' ? 'selected' : ''}>BAR</option>
                                            <option value="Jalapa" ${data[campo] === 'Jalapa' ? 'selected' : ''}>JAL</option>
                                            <option value="Zacapa" ${data[campo] === 'Zacapa' ? 'selected' : ''}>ZAC</option>
                                            <option value="Chiquimula" ${data[campo] === 'Chiquimula' ? 'selected' : ''}>CHI</option>
                                            <option value="Escuintla" ${data[campo] === 'Escuintla' ? 'selected' : ''}>ESC</option>
                                            <option value="Suchitepequez" ${data[campo] === 'Suchitepequez' ? 'selected' : ''}>MAZ</option>
                                            <option value="Chimaltenango" ${data[campo] === 'Chimaltenango' ? 'selected' : ''}>CHM</option>
                                            <option value="Quetzaltenango" ${data[campo] === 'Quetzaltenango' ? 'selected' : ''}>XEL</option>
                                            <option value="Quiche" ${data[campo] === 'Quiche' ? 'selected' : ''}>QCH</option>
                                            <option value="Izabal" ${data[campo] === 'Izabal' ? 'selected' : ''}>PTB</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                        }else if (campo === "fechaBoleta") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="datetime-local" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === "bancoBoleta") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <div class="select">
                                        <select name="${campo}" id="${campo}">
                                            <option value="Banrural" ${data[campo] === 'Banrural' ? 'selected' : ''}>Banrural</option>
                                            <option value="InterBanco" ${data[campo] === 'InterBanco' ? 'selected' : ''}>InterBanco</option>
                                            <option value="Banco Industrial" ${data[campo] === 'Banco Industrial' ? 'selected' : ''}>BI</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                        }else if (campo === 'tipoBoleta') {
                            // Si es el campo tipoBoleta, genera un select con opciones
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <div class="select">
                                        <select name="${campo}" id="${campo}">
                                            <option value="Por Cobrar" ${data[campo] === 'Por Cobrar' ? 'selected' : ''}>Por Cobrar</option>
                                            <option value="Contado" ${data[campo] === 'Contado' ? 'selected' : ''}>Contado</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                        } else {
                            // Para otros campos, genera un input de texto
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="text" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }

                        $('#editarUser form').append(inputHtml);
                    });

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

            let inputs = document.querySelectorAll(".formGuardarBoletas input");
            let selects = document.querySelectorAll(".formGuardarBoletas select");

            let datosForm = {
                "action": "Update",
            };

            inputs.forEach((input) =>{
                let id = input.id;
                let valorInput = input.value;
                
                datosForm[id] = valorInput;
                
            })

            selects.forEach((select) =>{
                let id = select.id;
                let valorSelect = select.value;

                datosForm[id] = valorSelect
            })

            $.ajax({
                url: '../Controller/C_controlBoletas.php',
                type: 'POST',
                dataType: 'json',
                data: datosForm,
                success:function(data) {
                    if (data == "registrado") {
                        mostrarMensajeSuccess("Modificación exitosa.");
                        setTimeout(function(){
                            location.reload();
                        }, 1500)
                    }else if(data == "repetido"){
                        mostrarMensajeError("El número de boleta ya existe.")
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

document.addEventListener('keydown', function(event) {
    // Verificar si la tecla 'Ctrl' (o 'Meta' en Mac) está presionada
    const isCtrlKey = event.ctrlKey || event.metaKey;

    // Verificar si la tecla presionada es 'G' y que 'Ctrl' está también presionado
    if (isCtrlKey && event.key === 's') {
        // Evitar el comportamiento predeterminado del navegador
        event.preventDefault();

        // Aquí puedes realizar la acción que desees al detectar la combinación de teclas Ctrl + G
        $("input[name='Guardar']").click();
    }
});

document.addEventListener('keydown', function(event) {
    // Verificar si la tecla 'Ctrl' (o 'Meta' en Mac) está presionada
    const isCtrlKey = event.ctrlKey || event.metaKey;

    // Verificar si la tecla presionada es 'G' y que 'Ctrl' está también presionado
    if (isCtrlKey && event.key === 'y') {
        // Evitar el comportamiento predeterminado del navegador
        event.preventDefault();

        // Aquí puedes realizar la acción que desees al detectar la combinación de teclas Ctrl + G
        $(".newBoleta").click();
    }
});


/////CONTROL MANIFIESTO////
 
/////OBTENER DATOS MANIFIESTO/////
$("input[name='noManifiesto']").blur(function() {
    $.ajax({
        url: '../Controller/C_controlBoletas.php',
        type: 'POST',
        dataType: 'json',
        data: {
            noManifiesto: $("input[name='noManifiesto']").val(),
            action: "getManifiesto",
        },
    })
    .done(function(data) {
        var opcion = $('#agenciaSelect option:contains(' + data["destinoManifiesto"] + ')');

        console.log(data);
        $("input[name='manifiesto']").val(data["noManifiesto"]);

        $("input[name='fecha']").val(data["fechaManifiesto"]);
        $("input[name='fechaManifiesto']").val(data["fechaManifiesto"]);

        $("input[name='origen']").val(data["origenManifiesto"]);

        $("input[name='destino']").val(data["destinoManifiesto"]);
        $("select[name='lugarDeposito']").val(opcion.val());

        $("input[name='ruta']").val(data["rutaManifiesto"]);
        $("input[name='totalContado']").val(data["totalContado"]);
        $("input[name='totalPorCobrar']").val(data["totalPorCobrar"]);
    })
    .fail(function() {
        console.log("error");
    })
    
});
