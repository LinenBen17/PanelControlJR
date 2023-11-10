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

	if ($(".formGuardarBoletas input[name='noManifiesto']").val() === $(".formGuardarBoletas.confirmacion input[name='noManifiesto']").val() && $(".formGuardarBoletas input[name='noBoleta']").val() === $(".formGuardarBoletas.confirmacion input[name='noBoleta']").val() && $(".formGuardarBoletas input[name='tipoBoleta']").val() === $(".formGuardarBoletas.confirmacion input[name='tipoBoleta']").val()) {

		let inputs = document.querySelectorAll(".formGuardarBoletas input");
		let datos = {};

		inputs.forEach((input)=>{
			let name = input.name;

			datos[name] = $(input).val()
		});

		datos["action"] = "Guardar";

		console.log(datos)

		$.ajax({
			url: '../Controller/C_controlBoletas.php',
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(data) {
				if (data) {
					location.reload();
				}else {
					Swal.fire({
					  position: 'top-end',
					  icon: 'error',
					  title: 'Este número de boleta ya ha sido ingresado anteriormente:(.',
					  background: '#071A2C',
					  color: "#FFF",
					  showConfirmButton: false,
					  timer: 1500
					})
				}
			},
			error: function(a,b,c){
				console.log(a)
				console.log(b)
				console.log(c)
			}
		})
		
	}else {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Los datos no coinciden:).',
		  background: '#071A2C',
		  color: "#FFF",
		  showConfirmButton: false,
		  timer: 2000
		})
	}
});

/////DATATABLE BOLETAS INGRESADAS////
$(document).ready(function() {
	$('#boletasTable').DataTable({
        ajax: {
            url: '../Controller/C_controlBoletas.php',
            dataSrc: ''
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        columns: [
            { data: 'id' },
            { data: 'noManifiesto' },
            { data: 'noBoleta' },
            { data: 'tipoBoleta' },
            { data: 'fechaIngreso' },
            { data: 'fechaModificacion' },
            { data: 'usuarioIngresa' },
        ]
    });
});