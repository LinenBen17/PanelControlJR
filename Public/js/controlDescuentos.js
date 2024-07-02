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

$(".searchEmpleado").click(function(){
    $('#seleccionarEmpleado').modal();

    // Destruye el DataTable si ya ha sido inicializado
    if ($.fn.DataTable.isDataTable('#tableSelectEmpleado')) {
        $('#tableSelectEmpleado').DataTable().destroy();
    }
    
    $('#tableSelectEmpleado').DataTable({
        ajax: {
            url: '../Controller/C_controlDescuentos.php',
            type: 'post',
            data: {"action" : "ShowEmpleados"},
            dataSrc:''
        },
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
        },
        columns: [
            { data: 'id' },
            { data: 'nombres' },
            { data: 'apellidos' },
            { data: 'cargo' },
            { data: 'estado_planilla' },
        ],
        rowId: function(a) {
            return a.id;
        },
    });
})

$('#tableSelectEmpleado').on('click', 'tr', function () {
    //SELECCIONA EL ID EN EL CAMPO EMPLEADO Y CIERRA EL MODAL
    $("#empleado_id").val(this.id);
    $.modal.close();

    //ESTABLECE EL FOCO EN EL CAMPO EMPLEADO Y CREA UNA FUNCION AJAX PARA OBTENER LOS DATOS DE ESE EMPLEADO (En caso tuviera datos ya asignados, si no quedará vacío)
    $("#empleado_id").focus();

});

$(".save").click(function(e){
        e.preventDefault();
        let inputs = document.querySelectorAll(".formIngresoDescuentos input");
        let selects = document.querySelectorAll(".formIngresoDescuentos select");

        let datosForm = {
            "action": "Save",
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

        datosForm[selects.id] = selects.value;

        let camposLlenos = true; // Suponemos que todos los campos están llenos inicialmente

        console.log(datosForm);

        inputs.forEach(function(input) {
            if (input.value == "") {
                mostrarMensajeError("Todos los campos deben estar llenos.");
                camposLlenos = false; // Cambiamos la variable a false si encontramos un campo vacío
            }
        });

        if (camposLlenos) {
            $.ajax({
                url: '../Controller/C_controlDescuentos.php',
                type: 'POST',
                dataType: 'json',
                data: datosForm,
                success: function(data) {
                    if (data == "Saved") {
                        mostrarMensajeSuccess("Registro guardado con éxito.");
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }else if (data == "Repeated"){
                        mostrarMensajeError("Error al guardar el descuento.")
                        $(".clean").click();
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
    let inputs = document.querySelectorAll(".formIngresoDetallePago input");

    inputs.forEach((input) =>{
        input.value = '';
    })
})
/////DATATABLE BOLETAS INGRESADAS GENERAL////
$(document).ready(function() {
    $('#tableDescuentosGeneral').DataTable({
        ajax: {
            url: '../Controller/C_controlDescuentos.php',
            type: 'post',
            dataSrc:''
        },
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
        },
        columns: [
            { data: 'id' },
            { 
                data: 'empleado',
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('id', rowData.empleado_id); // Asigna el id de la fila a la celda
                }
            },
            { data: 'fecha_descuento' },
            { data: 'tipo_descuento' },
            { data: 'monto' },
            { data: 'observaciones' },
            { data: 'editar' },
            { data: 'eliminar' },
        ],
    });

    $('#tableDescuentosGeneral').DataTable().on('draw.dt', function () {
    $('.btnEliminar').off('click');
    $('a.btnEditar').off('click');
    $('.update').off('click');
        //ELIMINAR REGISTRO
        $('.btnEliminar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_controlDescuentos.php',
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
                url: '../Controller/C_controlDescuentos.php',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: "ShowRegister"},
                success: function(data) {
                    var campos = Object.keys(data);

                    campos.forEach((campo) => {
                        console.log(campo)
                        var inputHtml = '';

                        if (campo === "monto") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="number" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === "empleado_id") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="text" name="${campo}" id="${campo}" value="${data[campo]}" readonly>
                                </div>
                            `;
                        }else if (campo === "fecha_descuento") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="date" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }else if (campo === "tipo_descuento") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label>${campo.toUpperCase()}</label><br>
                                    <div class="select">
                                        <select name="${campo}" id="${campo}">
                                            <option value="Ausencia" ${data[campo] === 'Ausencia' ? 'selected' : ''}>Ausencia</option>
                                            <option value="Anticipo" ${data[campo] === 'Anticipo' ? 'selected' : ''}>Anticipo</option>
                                            <option value="Otros" ${data[campo] === 'Otros' ? 'selected' : ''}>Otros</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                        }else{
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="text" name="${campo}" id="${campo}" value="${data[campo]}">
                                </div>
                            `;
                        }

                        $('#editarDescuento form').append(inputHtml);
                    });

                    $("#" + campos[0]).attr({
                        'type': 'hidden',
                    });
                    $('#editarDescuento').modal();

                    $('#editarDescuento').on($.modal.AFTER_CLOSE, function() {
                        $('#editarDescuento form > div').remove();
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

            let inputs = document.querySelectorAll(".formIngresoDescuentos input");
            let selects = document.querySelectorAll(".formIngresoDescuentos select");

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
                url: '../Controller/C_controlDescuentos.php',
                type: 'POST',
                dataType: 'json',
                data: datosForm,
                success:function(data) {
                    if (data == "registrado") {
                        mostrarMensajeSuccess("Modificación exitosa.");
                        setTimeout(function(){
                            location.reload();
                        }, 1500)
                    }else{
                        mostrarMensajeError("Hubo un error en la modificación.")
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