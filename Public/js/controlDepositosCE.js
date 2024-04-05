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

//INGRESO DE DEPOSITOS
$("input[name='guardarDepositoCE']").click(function(e){
    e.preventDefault();

    var formData1 = $(".formGuardarDepositosCE form").serializeArray();

    var formData2 = new FormData();
    formData2.append('file', document.getElementById("inputfileCE").files[0]);

    // Agregar los campos del formulario a formData2
    for (var i = 0; i < formData1.length; i++) {
        formData2.append(formData1[i].name, formData1[i].value);
    }

    formData2.append('action', 'Save');

    console.log(formData2);

    $.ajax({
        url: '../Controller/C_controlDepositosCE.php',
        type: 'POST',
        dataType: 'json',
        data: formData2,
        processData: false,
        contentType: false,
        success:function(data) {
            console.log(data)
            if (data == "registrado") {
                mostrarMensajeSuccess("Ingreso de gasto éxitoso.");
                setTimeout(function(){
                    location.reload();
                }, 1500)
            }else if(data == "repetidoBoleta"){
                mostrarMensajeError("El número de boleta ya existe.")
            }else if(data == "repetidoCE"){
                mostrarMensajeError("El número de contra entrega ya fue ingresado.")
            }else if(data == "repetidoGuia"){
                mostrarMensajeError("El número de guía ya fue ingresado.")
            }else if (data == "vacio") {
                mostrarMensajeError("Ningún campo debe estar vacío.")
            }
        },
        error:function(a,b,c) {
            console.log(a);
            console.log(b);
            console.log(c);
        }
    })
})

/////DATATABLE BOLETAS INGRESADAS POR USUARIO////
$(document).ready(function() {
    $('#ceTableUser').DataTable({
        ajax: {
            url: '../Controller/C_controlDepositosCE.php',
            type: 'post',
            data: {"action" : "BoletasUsuario"},
            dataSrc:''
        },
        "language": {
            url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
        },
        columns: [
            { data: 'id' },
            { data: 'noManifiesto' },
            { data: 'fechaManifiesto' },
            { data: 'noContraEntrega' },
            { data: 'noGuia' },
            { data: 'noBoleta' },
            { data: 'fechaBoleta' },
            { data: 'noCuenta' },
            { data: 'nombreCuenta' },
        ]
    });
});

/////DATATABLE GASTOS INGRESADoS GENERAL////
$(document).ready(function() {
    $('#ceTablaGeneral').DataTable({
        ajax: {
            url: '../Controller/C_controlDepositosCE.php',
            type: 'post',
            dataSrc:''
        },
        "language": {
            url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Exportar a Excel',
                exportOptions: {
                    columns: ':lt(-2)' // Índices de las columnas que quieres exportar
                }
            },
        ],
        columns: [
            { data: 'id' },
            { data: 'noManifiesto' },
            { data: 'fechaManifiesto' },
            { data: 'noContraEntrega' },
            { data: 'noGuia' },
            { data: 'noBoleta' },
            { data: 'valorBoleta' },
            { data: 'fechaBoleta' },
            { data: 'noCuenta' },
            { data: 'nombreCuenta' },
            { data: 'telefonoCE' },
            { data: 'usuarioIngresa' },
            { data: 'fechaIngreso' },
            { data: 'usuarioModifica' },
            { data: 'fechaModificacion' },
            { data: 'estado' },
            { data: 'imagenBoleta' },
            { data: 'editar' },
            { data: 'eliminar' },
        ]
    });

    $('#ceTablaGeneral').DataTable().on('draw.dt', function () {
        $('.btnEliminar').off('click');
    $('a.btnEditar').off('click');
    $('.update').off('click');
        //ELIMINAR REGISTRO
        $('.btnEliminar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_controlDepositosCE.php',
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
        //ESTABLECER ESTATUS
        $('.statusCheck').on('change', function() {
            var datos = {
                "id": this.id,
                "estadoCheck": $(this).is(':checked'),
                "action": "changeStatus"
            };

            $.ajax({
                url: '../Controller/C_controlDepositosCE.php',
                type: 'POST',
                dataType: 'json',
                data: datos,
                success: function(data) {
                    if (data == "Actualizado") {
                        mostrarMensajeSuccess("El estado ha sido actualizado correctamente.");
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
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
            console.log(id)

            $.ajax({
                url: '../Controller/C_controlDepositosCE.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "ShowRegister"},
                success: function(data) {
                    console.log(data)
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
                        }else if (campo === 'fechaBoleta') {
                            // Si es un campo de fecha, genera un input de tipo fecha
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="datetime-local" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === 'nombreCuenta') {
                            // Si es un campo de fecha, genera un input de tipo fecha
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="text" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else {
                            // Para otros campos, genera un input de texto
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="number" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }

                        $('#editarDepositoCE form').append(inputHtml);
                    });

                    $("#" + campos[0]).attr({
                        'type': 'hidden',
                    });
                    $('#editarDepositoCE').modal();

                    $('#editarDepositoCE').on($.modal.AFTER_CLOSE, function() {
                        $('#editarDepositoCE form > div').remove();
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

            let inputs = document.querySelectorAll(".formGuardarDepositosCE input");
            let selects = document.querySelectorAll(".formGuardarDepositosCE select");

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
                url: '../Controller/C_controlDepositosCE.php',
                type: 'POST',
                dataType: 'json',
                data: datosForm,
                success:function(data) {
                    console.log(data)
                    if (data == "registrado") {
                        mostrarMensajeSuccess("Modificación exitosa.");
                        setTimeout(function(){
                            location.reload();
                        }, 1500)
                    }else if(data == "repetidoGuia"){
                        mostrarMensajeError("El número de guía ya fue ingresado.")
                    }else if(data == "repetidoBoleta"){
                        mostrarMensajeError("El número de boleta ya fue ingresado.")
                    }else if(data == "repetidoCE"){
                        mostrarMensajeError("El número de contra entrega ya fue ingresado.")
                    }
                    else if(data == "repetido"){
                        mostrarMensajeError("Hubo un error al guardar.")
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