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

$(".save").click(function(e){
    e.preventDefault();
    let inputs = document.querySelectorAll(".formRegistroFact input");
    let selects = document.querySelector("#tipoCombustible");
    let datosForm = {
        "action": "Save",
    };

    inputs.forEach((input) =>{
        let id = input.id;
        let valor = input.value;
        
        datosForm[id] = valor;
        
    })

    datosForm[selects.id] = selects.value;

    console.log(datosForm)

    $.ajax({
      url: '../Controller/C_controlFacturasCombu.php',
      type: 'POST',
      dataType: 'json',
      data: datosForm,
      success: function(data) {
        if (data) {
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

/////DATATABLE BOLETAS INGRESADAS GENERAL////
$(document).ready(function() {
    $('#formRegistroFact').DataTable({
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
            'excel', 'print'
        ],
        columns: [
            { data: '#' },
            { data: 'fecha' },
            { data: 'placa' },
            { data: 'piloto' },
            { data: 'ruta' },
            { data: 'serie' },
            { data: 'noFactura' },
            { data: 'galones' },
            { data: 'tipoCombustible' },
            { data: 'precio_galon' },
            { data: 'monto_total' },
            { data: 'fecha_creacion' },
            { data: 'usuario_ingresa' },
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

            console.log(id)

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