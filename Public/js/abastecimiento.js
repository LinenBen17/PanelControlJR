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
    $.ajax({
      url: '../Controller/C_abastecimiento.php',
      type: 'POST',
      dataType: 'json',
      success: function(data) {
        //$("input#km_inicial").val(data.at(-1).km_final);
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr)
        console.log(textStatus)
        console.log(errorThrown)
      }
    });
});
$('#placa').blur(function() {
    let datosSearch = {
        "placa": $(this).val(),
        "action": "SearchPlaca"
    }

    $.ajax({
      url: '../Controller/C_abastecimiento.php',
      type: 'POST',
      dataType: 'json',
      data: datosSearch,
      success: function(data) {
        $('#piloto').val(data["piloto"]);
        $('#ruta').val(data["ruta"]);
        $('#km_inicial').val(data['km_final']);
        $('#km_inicial').focus();
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr)
        console.log(textStatus)
        console.log(errorThrown)
      }
    });
});

$("#galones").blur(function() {
    let calculo = $("#monto_total").val() / $("#galones").val();
    $("#precio_galon").val(calculo.toFixed(2));
    $(".save").focus();
})

$(".save").click(function(){
    let inputs = document.querySelectorAll(".formAbastecimiento input");
    let datosForm = {
        "action": "Save",
    };

    inputs.forEach((input) =>{
        let id = input.id;
        let valor = input.value;
        
        datosForm[id] = valor;
        
    })

    $.ajax({
      url: '../Controller/C_abastecimiento.php',
      type: 'POST',
      dataType: 'json',
      data: datosForm,
      success: function(data) {
        location.reload();
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr)
        console.log(textStatus)
        console.log(errorThrown)
      }
    });
})
$(".clean").click(function(){
    let inputs = document.querySelectorAll(".formAbastecimiento input");

    inputs.forEach((input) =>{
        input.value = '';
    })
})

$('#fechaInicial').change(function () {
    $("#fechaFinal").attr('min', $('#fechaInicial').val());
})
$('#fechaFilter').change(function () {
    console.log($(this).val())
})
