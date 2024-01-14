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
$(".login").click(function(e){
	e.preventDefault();
	let datos = {
		"usuario": $(".formLogin input[name='usuario']").val(),
		"password": $(".formLogin input[name='password']").val(),
	};
	console.log(datos)
	$.ajax({
		url: 'Controller/C_login.php',
        type: 'POST',
        dataType: 'json',
        data: datos,
        success: function(data) {
            console.log(data)
            if (data == "Correcto") {
            	location.href = "View/principal.php";
            }else{
            	mostrarMensajeError("El usuario o contraseña son incorrectos.")
            }
        },
        error: function(a, b, c) {
            console.log(a);
            console.log(b);
            console.log(c);
        }
	})
}) 