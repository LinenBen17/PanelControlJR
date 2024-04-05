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
//ABRIR MODAL DE GASTOS
$(".ingresoGastos").click(function(){
    $("#gastosModal input[name='noManifiesto']").val($(".formGuardarBoletas input[name='noManifiesto']").val())
    $("#gastosModal input[name='fechaManifiesto']").val($(".formGuardarBoletas input[name='fechaManifiesto']").val())

    $('#gastosModal').modal();

})
$('#gastosModal').on($.modal.BEFORE_OPEN, function(e, a) {
    $("#gastosModal input[name='noManifiesto']").focus();
})

//AÑADIR NUEVAS BOLETAS
$(".newGasto").click(function(e){
    //Obtener el manifiesto al que se asignará el casto
    e.preventDefault();
    $(".gastosAdicionales").append(
        `
            <div class="gastos">
				<div class="inputBx costoGasto">
					<label>Costo</label><br>
					<input type="number" name="costoGasto[]">
				</div>
				<div class="inputBx descripcionGasto">
					<label>Descripción</label><br>
					<input type="text" name="descripcionGasto[]">
				</div>
				<div class="inputBx removeGasto">
					<button class="btn deleteGasto"><ion-icon name="close-outline"></ion-icon></button>
				</div>
			</div >
        `
    )
	$(".deleteGasto").click(function(){
	    $(this).parent().parent().remove();
	});
})

/////CONTROL DE GASTOS/////



$("input[name='guardarGasto']").click(function(e){
    e.preventDefault();

    var formData1 = $(".formGastos form").serializeArray();
    var formData2 = $(".gastos").find("input, select").serializeArray();

    var datos = formData1.concat(formData2);
	
	datos.push({ name: "action", value: "Save" });

    $.ajax({
        url: '../Controller/C_controlGastos.php',
        type: 'POST',
        dataType: 'json',
        data: datos,
        success:function(data) {
        	console.log(data)
            if (data == "registrado") {
                mostrarMensajeSuccess("Ingreso de gasto éxitoso.");
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
})
/////DATATABLE GASTOS INGRESADoS GENERAL////
$(document).ready(function() {
    $('#gastosTablaGeneral').DataTable({
        ajax: {
            url: '../Controller/C_controlGastos.php',
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
            { data: 'costoGasto' },
            { data: 'descripcionGasto' },
            { data: 'agenciaGasto' },
            { data: 'rutaAgenciaGasto' },
            { data: 'fechaIngreso' },
            { data: 'fechaModificacion' },
            { data: 'usuarioIngresa' },
            { data: 'usuarioModifica' },
            { data: 'editar' },
            { data: 'eliminar' },
        ]
    });

    $('#gastosTablaGeneral').DataTable().on('draw.dt', function () {
        $('.btnEliminar').off('click');
    $('a.btnEditar').off('click');
    $('.update').off('click');
        //ELIMINAR REGISTRO
        $('.btnEliminar').click(function(e) {
            e.preventDefault();
            var id = this.id;

            $.ajax({
                url: '../Controller/C_controlGastos.php',
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
                url: '../Controller/C_controlGastos.php',
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
                        }else if (campo === 'agenciaGasto') {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label>${campo.toUpperCase()}</label>
                                    <div class="select">
                                        <select name="${campo}" id="${campo}">
                                            <option value="Guatemala" ${data[campo] === 'Guatemala' ? 'selected' : ''}>Guatemala</option>
                                            <option value="Jalapa" ${data[campo] === 'Jalapa' ? 'selected' : ''}>Jalapa</option>
                                            <option value="Chiquimula" ${data[campo] === 'Chiquimula' ? 'selected' : ''}>Chiquimula</option>
                                            <option value="Zacapa" ${data[campo] === 'Zacapa' ? 'selected' : ''}>Zacapa</option>
                                            <option value="Santa Rosa" ${data[campo] === 'Santa Rosa' ? 'selected' : ''}>Santa Rosa</option>
                                            <option value="Jutiapa" ${data[campo] === 'Jutiapa' ? 'selected' : ''}>Jutiapa</option>
                                            <option value="Totonicapan" ${data[campo] === 'Totonicapan' ? 'selected' : ''}>Totonicapan</option>
                                            <option value="Chimaltenango" ${data[campo] === 'Chimaltenango' ? 'selected' : ''}>Chimaltenango</option>
                                            <option value="Escuintla" ${data[campo] === 'Escuintla' ? 'selected' : ''}>Escuintla</option>
                                            <option value="Retalhuleu" ${data[campo] === 'Retalhuleu'}>Retalhuleu</option>
                                            <option value="Quetzaltenango" ${data[campo] === 'Quetzaltenango' ? 'selected' : ''}>Quetzaltenango</option>
                                            <option value="San Marcos" ${data[campo] === 'San Marcos' ? 'selected' : ''}>San Marcos</option>
                                            <option value="Suchitepequez" ${data[campo] === 'Suchitepequez' ? 'selected' : ''}>Suchitepequez</option>
                                            <option value="Puerto Barrios" ${data[campo] === 'Puerto Barrios' ? 'selected' : ''}>Puerto Barrios</option>
                                            <option value="Quiché" ${data[campo] === 'Quiché' ? 'selected' : ''}>Quiché</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                        }else if (campo === "costoGasto") {
                            inputHtml = `
                                <div class="inputBx ${campo}">
                                    <label for="">${campo.toUpperCase()}</label><br>
                                    <input type="number" name="${campo}" id="${campo}" value="${data[campo]}">
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

                        $('#editarGasto form').append(inputHtml);
                    });

                    $("#" + campos[0]).attr({
                        'type': 'hidden',
                    });
                    $('#editarGasto').modal();

                    $('#editarGasto').on($.modal.AFTER_CLOSE, function() {
                        $('#editarGasto form > div').remove();
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

            let inputs = document.querySelectorAll(".formGastos input");
            let selects = document.querySelectorAll(".formGastos select");

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
                url: '../Controller/C_controlGastos.php',
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