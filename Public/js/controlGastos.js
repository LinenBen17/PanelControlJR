$("input[name='noManifiestoGasto']").focus();

//ABRIR MODAL DE GASTOS
$(".ingresoGastos").click(function(){
    $('#gastosModal').modal();
})

//AÑADIR NUEVAS BOLETAS
$(".newGasto").click(function(e){
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