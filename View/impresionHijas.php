<?php
	require_once 'shared/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<link rel="stylesheet" type="text/css" href="../Public/css/dashboard.css">
</head>
<body>
	<div class="container">
        <?php require 'shared/navigation.php' ?>
        <!-- Main -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!-- search -->
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <!-- userImg -->
                <?php require 'shared/view.php'; ?>
            </div>
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Impresión Guías Hijas</h2>
                    </div>
                    <div class="canvas" id="canvas"></div>
                    <div class="inputBx formGuia">
                        <div class="form">
                            <form>
                                <div class="inputBox guiaMadre">
                                    <input type="text" id="guiaMadre" placeholder="Guia Madre:">
                                </div>
                                <div class="inputBox piezas">
                                    <input readonly="readonly" id="piezas" value="2" placeholder="Piezas:">
                                </div>
                                <div class="inputBox de">
                                    <input type="number" id="de" placeholder="De:">
                                </div>
                                <div class="inputBox origen">
                                    <input type="text" id="origen" placeholder="Origen:">
                                </div>
                                <div class="inputBox destino">
                                    <input type="text" id="destino" placeholder="Destino:">
                                </div>
                                <br>
                            </form>
                            <button type="button" class="print btnEditar">Imprimir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php require_once 'shared/footer.php';	 ?>
	<script>
		// DATE
	    var today = new Date();
	    var day = today.getDate();
	    var month = today.getMonth() + 1;
	    var year = today.getFullYear();
	    var fecha = `${month}/${day}/${year}`;

	    $('.fecha').text(fecha);

	    let contadorDe;
	    let piezas;
	    let print = $('.print');
	    let datos = [$('#guiaMadre'), $('#piezas'), $('#de'), $('#origen'), $('#destino')]
	    let etiquetas = [$('.guiaMadre'), $('.piezas'), $('.de'), $('.origen'), $('.destino')]

	    print.click(()=>{
	        piezas = parseInt(datos[1].val());
	        contadorDe = parseInt(datos[2].val());
	        console.log(contadorDe, piezas);
	        imprSelec('canvas');
	    })

	    function imprSelec(nombre) {
	        var ficha = document.getElementById(nombre)
	        var ventana = window.open(' ', 'popimpr');
	        ventana.document.write('<html><head><title>' + document.title + '</title>');
	        ventana.document.write('<link rel="stylesheet" href="../Public/css/printHijas.css">'); //Aquí agregué la hoja de estilos
	        ventana.document.write('</head><body >');
	        //ventana.document.write('<div class="canvas"></div>')
	        for(var i = piezas; i <= contadorDe; i++){
	            ventana.document.write(
	                ficha.innerHTML = `
	                    <div class="guia">
	                        <p class="guiaMadre">${datos[0].val()}</p>
	                        <p class="fecha">${fecha}</p>
	                        <p class="piezas">${i}</p>
	                        <p class="de">${datos[2].val()}</p>
	                        <p class="origen">${datos[3].val()}</p>
	                        <p class="destino">${datos[4].val()}</p>
	                    </div>
	                    <div class="break"></div>
	                `
	            );
	        }
	        ventana.document.write('</body></html>');
	        ventana.document.close();
	        setTimeout(()=>{
	            ventana.print( );
	            ventana.close( );
	            ficha.innerHTML = '';
	        }, 100)
	    }
	</script>
</body>
</html>