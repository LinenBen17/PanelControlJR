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
// CREAR USUARIO
$(".btnCrear").click(function() {
	$.ajax({
		url: '../Controller/C_controlUsuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {action: "permisos"},
		success: function(data) {
			data.forEach((seccion) => {
				$('#crearUser .roles').append(`
					<div class="checkBox">
						<p>${seccion.seccion}</p>
						<label class="switch">
							<input type="checkbox" name="${seccion['seccion'].replace(/\s+/g, '').toLowerCase()}" value="${seccion.id}">
							<span class="slider round"></span>
						</label>
					</div>
				`)
			})
			$("#crearUser").modal();
			$('#crearUser').on($.modal.AFTER_CLOSE, function() {
				$('#crearUser .roles > div').remove();
			});
		},
		error: function(a,b,c) {
			console.log(a);
			console.log(b);
			console.log(c);
		}
	})

});
// DATOS PARA EDITAR USUARIO
$('.btnEditar').click(function(e) {
	e.preventDefault();
	var id = this.id;

	$.ajax({
		url: '../Controller/C_controlUsuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {id: id, action: "obtener"},
		success: function(data) {
			console.log(data);
			var nombre = data[0].nombre;
			var usuario = data[0].usuario;
			var id = data[0].id;

			var secciones = Object.keys(data[1]);

			$('#editarUser input[name="id"]').val(id);
			$('#editarUser input[name="nombre"]').val(nombre);
			$('#editarUser input[name="usuario"]').val(usuario);

			secciones.forEach((seccion)=>{
				$('#editarUser .roles').append(`
					<div class="checkBox">
						<p>${seccion}</p>
						<label class="switch">
							<input type="checkbox" name="${seccion.replace(/\s+/g, '').toLowerCase()}" ${data[1][seccion].checked} value="${data[1][seccion].id}">
							<span class="slider round"></span>
						</label>
					</div>
				`)
			});

			$('#editarUser').modal();
			$('#editarUser').on($.modal.AFTER_CLOSE, function() {
				$('#editarUser .roles > div').remove();
			});
		},
		error: function(a, b, c) {
			console.log(a);
			console.log(b);
			console.log(c);
		}
	})
	
});
//EDITAR USUARIO
$(".updateUser").click(function(e){
	e.preventDefault();

	var datos = $(".formEditarUser").serializeArray();

	datos.push({ name: "action", value: "editar" });

	$.ajax({
        url: '../Controller/C_controlUsuarios.php',
        type: 'POST',
        dataType: 'json',
        data: datos,
        success:function(data) {
            if (true) {
            	mostrarMensajeSuccess("Usuario editado correctamente.")
            	setTimeout(function(){
            		location.reload();
            	}, 1500)
            }else{
            	mostrarMensajeError("Hubo un error al editar.")
            	setTimeout(function() {
            		location.reload();
            	})
            }
        },
        error:function(a,b,c) {
            console.log(a);
            console.log(b);
            console.log(c);
        }
    })
})
//ELIMINAR USUARIO
$('.btnEliminar').click(function(e) {
	e.preventDefault();
	var id = this.id;

	$.ajax({
		url: '../Controller/C_controlUsuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {id: id, action: "eliminar"},
		success: function(data) {
			location.reload();
		},
		error: function() {
			console.log("ERROR");
		}
	})
	
});