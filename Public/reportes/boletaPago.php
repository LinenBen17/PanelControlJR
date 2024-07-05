<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
    	*{
    		margin: 0;
    		padding: 0;
    		box-sizing: border-box;
    		font-family: sans-serif;
    		font-size: 9.5pt;
    	}
    	.container{
    		padding: 10px 20px;
    	}
    	.title h2{
    		font-size: 16pt;
    	}
    	.title p{
    		font-size: 9pt;
    		text-decoration: underline;
    		margin-bottom: 10px;
    	}
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td{
        	border: 1px solid black;
            padding: 6px;
            text-align: center;
        }
        .datosMonetarios{
        	margin-bottom: 40px;
        }
        .datosMonetarios th, .datosMonetarios td {
            text-align: left;
        }
        th.section-title{ 
            text-align: center;
        }
        .datosEmpresa, .datosEmpleado{
        	margin-bottom: 10px;
        }
        .section-title {
            background-color: #D0F2BF;
            font-weight: bold;
            text-align: center;
        }
        .no-border {
            border: none;
        }
        .totales {
            font-weight: bold;
        }
        .firma th, .firma td{
        	border: none;
        }
    </style>
</head>
<body>

	<?php
		for ($i = 0; $i <= 10; ++$i) {
	?>
    <div class="container">
	    <div class="title">
	    	<h2 style="text-align: center;">RECIBO DE PAGO</h2>
	    	<p style="text-align: center;">DEL 16/06/2024 AL 30/06/2024</p>
	    </div>
	    <table class="datosEmpresa">
	    	<thead>
		        <tr>
		            <th>NIT</th>
		            <th>NOMBRE DE LA EMPRESA</th>
		            <th>ESTADO</th>
		            <th>DIRECCIÓN</th>
		        </tr>
	    	</thead>
	        <tbody>
	        	<tr>
		            <td>17888905</td>
		            <td>TRANSPORTES JR</td>
		            <td>FUERA DE PLANILLA</td>
		            <td>20 CALLE 2-43 ZONA 3 GUATEMALA</td>
		        </tr>
	        </tbody>
	    </table>

	    <table class="datosEmpleado">
	    	<thead>
	    		<tr>
	    			<th>CODIGO</th>
	    			<th>NOMBRES</th>
	    			<th>APELLIDOS</th>
	    			<th>CTA. BANCARIA</th>
	    			<th>FECHA INGRESO</th>
	    			<th>AGENCIA</th>
	    			<th>CARGO</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		<tr>
	    			<td>1131</td>
	    			<td>AÍDA VANELLOPE MARITZA</td>
	    			<td>HERNÁNDEZ RODRIGUEZ</td>
	    			<td>4136197067</td>
	    			<td>17/06/2024</td>
	    			<td>CAP</td>
	    			<td>AUXILIAR DE RUTA</td>
	    		</tr>
	    	</tbody>
	    </table>

	    <table class="datosMonetarios">
	    	<thead>
		        <tr>
		            <th colspan="2" class="section-title">REMUNERACIONES</th>
		            <th colspan="2" class="section-title">RETENCIONES / DESCUENTOS</th>
		        </tr>
	    	</thead>
	    	<tbody>
	    		<tr>
	    			<td>Sueldo Ordinario</td>
	    			<td>1792.30</td>
	    			<td>IGSS</td>
	    			<td>0.00</td>
	    		</tr>
	    		<tr>
	    			<td>Bonificación Decreto Ley 37-2001</td>
	    			<td>125.00</td>
	    			<td>ISR</td>
	    			<td>0.00</td>
	    		</tr>
	    		<tr>
	    			<td>Bonificación Incentivo</td>
	    			<td>0.00</td>
	    			<td>Préstamos</td>
	    			<td>0.00</td>
	    		</tr>
	    		<tr>
	    			<td>Horas Extras</td>
	    			<td>0.00</td>
	    			<td>Ausencias</td>
	    			<td>0.00</td>
	    		</tr>
	    		<tr>
	    			<td>Otros Ingresos</td>
	    			<td>0.00</td>
	    			<td>Adelantos</td>
	    			<td>0.00</td>
	    		</tr>
	    		<tr>
	    			<td style="text-align: center;"><b>Total Remuneraciones</b></td>
	    			<td><b>1,917.30</b></td>
	    			<td style="text-align: center;"><b>Total Descuentos</b></td>
	    			<td><b>0.00</b></td>
	    		</tr>
	    		<tr>
	    			<td colspan="2" class="no-border"></td>
	    			<td style="text-align: center;"><b>Neto a Pagar</b></td>
	    			<td><b>1,917.30</b></td>
	    		</tr>
	    	</tbody>
	    </table>

	    <table class="firma">
	        <tr>
	            <td style="text-align: center;">___________________________________<br>EMPLEADOR</td>
	            <td style="text-align: center;">___________________________________<br>TRABAJADOR</td>
	        </tr>
	    </table>
    </div>
    <br>
    <?php	
		}
	?>
</body>
</html>