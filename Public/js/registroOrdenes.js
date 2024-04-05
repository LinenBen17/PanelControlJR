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

/////SELECCIONA REGISTROS POR USUARIO/////
$(document).ready(function() {
    $('#ordenesCompraTable').DataTable({
        ajax: {
            url: '../Controller/C_controlOrdenes.php',
            type: 'post',
            data: {"action" : "SelectAllUser"},
            dataSrc:''
        },
        "language": {
            url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
        },
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        columns: [
            { data: 'id' },
            { data: 'noOrden' },
            { data: 'noFactura' },
            { data: 'fecha' },
            { data: 'proveedor' },
            { data: 'placa' },
            { data: 'cantidad' },
            { data: 'descripcion' },
            { data: 'precioUnitario' },
            { data: 'total' },
            { data: 'observacion' },
        ]
    });
});

$(document).on('blur', '#precioUnitario', function() {
    let calculo = $("#cantidad").val() * $(this).val();
    $("#total").val(calculo.toFixed(2));
    $("#observacion").focus();
});

$(".save").click(function(e){
    e.preventDefault();
    let inputs = document.querySelectorAll(".formRegistroOrdenes input");
    let textarea = document.querySelector("#observacion");
    let datosForm = {
        "action": "Save",
    };

    inputs.forEach((input) =>{
        let id = input.id;
        let valor = input.value;
        
        datosForm[id] = valor;
        
    })

    datosForm[textarea.id] = textarea.value;

    let camposLlenos = true; // Suponemos que todos los campos están llenos inicialmente

    inputs.forEach(function(input) {
        if (input.value == "") {
            mostrarMensajeError("Todos los campos deben estar llenos.");
            camposLlenos = false; // Cambiamos la variable a false si encontramos un campo vacío
        }
    });

    if (camposLlenos) {
        $.ajax({
            url: '../Controller/C_controlOrdenes.php',
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
    }

})
$(".clean").click(function(){
    let inputs = document.querySelectorAll(".ordenesCompraTable input");

    inputs.forEach((input) =>{
        input.value = '';
    })
})

/////DATATABLE BOLETAS INGRESADAS GENERAL////
$(document).ready(function() {
    $('#ordenesTableGeneral').DataTable({
        ajax: {
            url: '../Controller/C_controlOrdenes.php',
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
                    columns: ':lt(-2)', // Índices de las columnas que quieres exportar
                },
            },
        ],
        columns: [
            { data: 'id' },
            { data: 'noOrden' },
            { data: 'noFactura' },
            { data: 'fecha' },
            { data: 'proveedor' },
            { data: 'placa' },
            { data: 'cantidad' },
            { data: 'descripcion' },
            { data: 'precioUnitario' },
            { data: 'total' },
            { data: 'observacion' },
            { data: 'fecha_ingreso' },
            { data: 'fecha_modificacion' },
            { data: 'usuario_ingresa' },
            { data: 'usuario_modifica' },
            { data: 'editar' },
            { data: 'eliminar' },
        ]
    });

    $('#ordenesTableGeneral').DataTable().on('draw.dt', function () {
        $('.btnEliminar').off('click');
    $('a.btnEditar').off('click');
    $('.update').off('click');
        //ELIMINAR REGISTRO
        $('.btnEliminar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_controlOrdenes.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "Delete"},
                success: function(data) {
                    console.log(data)
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

            console.log(id)

            $.ajax({
                url: '../Controller/C_controlOrdenes.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "ShowRegister"},
                success: function(data) {
                    var campos = Object.keys(data);

                    campos.forEach((campo) => {
                    console.log(data[campo])


                        console.log(campo)
                        var inputHtml = '';

                        if (campo === 'fecha') {
                            // Si es un campo de fecha, genera un input de tipo fecha
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="date" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === "noOrden" || campo === "cantidad" || campo === "precioUnitario" || campo === "total") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="number" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === "observacion") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <textarea type="text" name="${campo}" id="${campo}">${data[campo]}</textarea>
                                </div>
                            `;
                        }else {
                            // Para otros campos, genera un input de texto
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="text" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }

                        $('#editarOrden form').append(inputHtml);
                    });

                    $("#" + campos[0]).attr({
                        'type': 'hidden',
                    });
                    $('#editarOrden').modal();

                    $('#editarOrden').on($.modal.AFTER_CLOSE, function() {
                        $('#editarOrden form > div').remove();
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

            let inputs = document.querySelectorAll(".formRegistroOrdenes input");
            let textarea = document.querySelector(".formRegistroOrdenes textarea");

            let datosForm = {
                "action": "Update",
            };

            inputs.forEach((input) =>{
                let id = input.id;
                let valorInput = input.value;
                
                datosForm[id] = valorInput;
                
            })

            datosForm[textarea.id] = textarea.value;

            $.ajax({
                url: '../Controller/C_controlOrdenes.php',
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