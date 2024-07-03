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


$(document).ready(function() {
    $('#des_codigo').focus();    
});
$('.clean').click(function(){
    var inputs = document.querySelectorAll('form input');
    inputs.forEach(a => a.value = "");
});

var munQuiche = [
        "Canillá",
        "Chajul",
        "Chicamán",
        "Chiché",
        "Chichicastenango",
        "Chinique",
        "Cunén",
        "Ixcán",
        "Joyabaj",
        "Nebaj",
        "Pachalum",
        "Patzité",
        "Sacapulas",
        "San Andrés Sajcabajá",
        "San Antonio Ilotenango",
        "San Bartolomé Jocotenango",
        "San Juan Cotzal",
        "San Pedro Jocopilas",
        "Santa Cruz del Quiché",
        "Uspantán",
        "Zacualpa"
    ]

console.log(munQuiche)
//OBTENER INFORMACION EN BASE AL CODIGO CON AJAX
$("#des_codigo").blur(function() {
    var codigo = $('#des_codigo').val();

    $.ajax({
        url: '../Controller/C_impresionMadres.php',
        type: 'POST',
        dataType: 'json',
        data: {action: "search", codigo: codigo},
        success: function(data){
        	console.log(data)
            if (Object.values(data).length > 1) {
                //VARIABLES DE LOS DATOS
                var id = [];
                var nombre = [];
                var direccion = [];
                var telefono = [];
                var contacto = [];
                var destino = [];
                var found;

                //USAMOS Object.values PARA OBTENER EN ARRAY EL OBJETO E ITERAR
                Object.values(data).forEach(datos =>{
                    //LOS DATOS LOS AÑADIMOS A SU RESPECTIVA VARIABLE
                    id.push(datos.idcliente);
                    nombre.push(datos.nombre);
                    direccion.push(datos.direccion);
                    telefono.push(datos.telefono);
                    contacto.push(datos.contacto);
                    destino.push(datos.destino);

                });

                //AGREGAMOS AL SELECT TODAS LAS DIRECCIONES
                for (var i = 0; i < Object.values(data).length; i++) {
                    $('#selectModal > select').append(`
                            <option value="${id[i]}" class="optionDir">${direccion[i]}</option>
                        `)  
                }

                $('#selectModal').modal();

                //OBTENGO LA INFO. DE LA OPCIÓN SELECCIONADA
                $('#selectModal > select').on('change', function() {
                    var value = $(this).val();

                    var optionSelected = data.find(e => e.idcliente == value);

                    try{
                        $('#des_nombre').val(optionSelected.nombre);
                        $('#des_direccion').val(optionSelected.direccion);
                        $('#des_telefono').val(optionSelected.telefono);
                        $('#des_contacto').val(optionSelected.contacto);
                        $('#des_destino').val(optionSelected.destino);
                    }catch(e){
                        $('#des_nombre').val('');
                        $('#des_direccion').val('');
                        $('#des_telefono').val('');
                        $('#des_contacto').val('');
                        $('#des_destino').val('');
                    }
                    
                });

                $('#selectModal').on($.modal.AFTER_CLOSE, function() {
                    $('.optionDir').remove();
                });
            }else{
                var nombre;
                var direccion;
                var telefono;
                var contacto;
                var destino ;

                Object.values(data).forEach(datos =>{
                    nombre = datos.nombre;
                    direccion = datos.direccion;
                    telefono = datos.telefono;
                    contacto = datos.contacto;
                    destino = datos.destino;
                });
                
                $('#des_nombre').val(nombre);
                $('#des_direccion').val(direccion);
                $('#des_telefono').val(telefono);
                $('#des_contacto').val(contacto);
                $('#des_destino').val(destino);
            }

            if ($('#des_destino').val() == "QCH"){
                mostrarMensajeError("Área seleccionada sin cobertura.");
            }
        },
        error: function(xhr, status, error){
            console.log(xhr)
            console.log(status)
            console.log(error)
        }
    })
});

//IMPRIMIR GUIA
// DATE
var today = new Date();
var day = today.getDate();
var month = today.getMonth() + 1;
var year = today.getFullYear();
var hour = today.getHours();
var minutes = today.getMinutes();

var formaPago;
var codigo;

$(".print").click(function () {
    formaPago = (($('#rem_codigo').val()).toUpperCase() == "XCO-6863") ? "POR COBRAR" : "CRÉDITO";
    codigo = (($('#rem_codigo').val()).toUpperCase() == "XCO-6863") ? "XCO-6863" : "V03-6862";
    /*numInicial = parseInt($('#id_numini').val());
    numFinal = parseInt($('#id_numfin').val());*/

   if ($('#des_destino').val() == "QCH"){
        mostrarMensajeError("Área seleccionada sin cobertura.");
   }else{
        imprSelec('canvas');
   }

});

function imprSelec(nombre) {
    var ficha = document.getElementById(nombre)
    var ventana = window.open(' ', 'popimpr');
    ventana.document.write('<html><head><title>' + document.title + '</title>');
    ventana.document.write('<link rel="stylesheet" href="../Public/css/printMadre.css">'); //Aquí agregué la hoja de estilos
    ventana.document.write('</head><body >');
    //ventana.document.write('<div class="canvas"></div>')
    ventana.document.write(
        `
                <div class="guia">
                    <div class="formapago">
                        <p class="">${formaPago}</p>
                    </div>
      <div class="datos">
        <div class="datosRemitente">
          <p class="remitente">FORMULARIOS STANDARD, S.A.</p>
          <p class="dirRemitente">1 CALLE 35-39 ZONA 11 COL. TOLEDO</p>
          <p class="telRemitente">2429-8900</p>
          <p class="origen">CAP</p>
        </div>
        <div class="datosDestinatario">
          <p class="destinatario">${$('#des_nombre').val()}/${$('#des_contacto').val()}</p>
          <p class="dirDestinatario">${$('#des_direccion').val()}</p>
          <p class="telDestinatario">${$('#des_telefono').val()}</p>
          <p class="destino">${$('#des_destino').val()}</p>
        </div>
      </div>
                    <div class="codigoCliente">
                        <p>${codigo}</p>
                    </div>
                </div>
            `
        );
    ventana.document.write('</body></html>');
    ventana.document.close();
    setTimeout(()=>{
        ventana.print( );
        ventana.close( );
    }, 100);
    $('.clean').click();
}