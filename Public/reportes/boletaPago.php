<?php
// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
// Desactivar toda notificación de error
error_reporting(0);
	$fechaInicial = $_GET['fechaInicial'];
	$fechaFinal = $_GET['fechaFinal'];

	$newFechaInicial = date("d/m/Y", strtotime($fechaInicial));
	$newFechaFinal = date("d/m/Y", strtotime($fechaFinal));


	class BolPago{
		private $db;

	    public function __construct(){
	        require_once '../../Model/Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function selectAllBolPago(){
	    	$sql = "
				SELECT
			    /* EMPLEADOS */
			    e.id AS empleadoID,
			    e.nombres AS empleado_nombres,
			    e.apellidos AS empleado_apellidos,
			    e.ctaBancaria AS empleado_ctaBancaria,
			    e.fecha_ingreso_empleado AS empleado_fechaIngreso,
			    e.agencia AS empleado_agencia,
			    e.cargo AS empleado_cargo,
			    /* DETALLE PAGO EMPLEADO */
			    dpe.id AS detalle_id,
			    dpe.sueldo_ordinario AS detalle_sueldo,
			    dpe.bonificacion_ley AS detalle_bonoLey,
			    dpe.bonificacion_incentivo AS detalle_bonoIncentivo,
			    dpe.igss AS detalle_igss,
			    /* BONO */
			    b.id AS bono_id,
			    b.fecha_bono AS bono_fecha,
			    b.monto AS bono_monto,
			    /* DESCUENTO */
			    d.id AS descuento_id,
			    d.fecha_descuento AS descuento_fecha,
			    d.tipo_descuento AS descuento_tipo,
			    d.monto AS descuento_monto
			/* SELECCION */
			FROM empleados AS e
			LEFT JOIN detalle_pago_empleado AS dpe ON e.id = dpe.empleado_id
			LEFT JOIN bonos AS b ON e.id = b.empleado_id AND b.fecha_bono BETWEEN ? AND ?
			LEFT JOIN descuentos AS d ON e.id = d.empleado_id AND d.fecha_descuento BETWEEN ? AND ?
			WHERE e.fecha_ingreso_empleado <= ?
			ORDER BY e.id
	    	";

	    	$sentencia =  $this->db->prepare($sql);
	    	$sentencia->bind_param("sssss", $_GET['fechaInicial'], $_GET['fechaFinal'], $_GET['fechaInicial'], $_GET['fechaFinal'], $_GET['fechaFinal']);
	    	$sentencia->execute();

	    	return $sentencia->get_result();
	    }
	}
?> 
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
        .break{
        	page-break-after:always;
        }
    </style>
</head>
<body>
	<?php
		$bolPago = new BolPago();
		$selectAllBolPago = $bolPago->selectAllBolPago();

		$datosAgrupados = [];
		
		while ($mostrarDatos = $selectAllBolPago->fetch_array()) {
		    $id = $mostrarDatos['empleadoID'];

		    // Inicializar el array si no existe
		    if (!isset($datosAgrupados[$id])) {
		        $datosAgrupados[$id] = [
		            "id" => $id,
		            "ctaBancaria" => $mostrarDatos['empleado_ctaBancaria'],
		            "empleadoNombres" => $mostrarDatos['empleado_nombres'],
		            "empleadoApellidos" => $mostrarDatos['empleado_apellidos'],
		            "empleadoIngreso" => $mostrarDatos['empleado_fechaIngreso'],
		            "cargo" => $mostrarDatos['empleado_cargo'],
		            "agencia" => $mostrarDatos['empleado_agencia'],
		            "sueldo" => round($mostrarDatos['detalle_sueldo'] / 2, 2),
		            "bonoLey" => round($mostrarDatos['detalle_bonoLey'] / 2, 2),
		            "bonoIncentivo" => round($mostrarDatos['detalle_bonoIncentivo'] / 2, 2),
		            "igss" => $mostrarDatos['detalle_igss'],
		            "bonoMonto" => 0,
		            "ausencias" => 0,
		            "anticipos" => 0,
		            "otros" => 0,
		        ];
		    }

		    // Sumar bonos, excluyendo bonoLey y bonoIncentivo
		    if (!is_null($mostrarDatos['bono_id'])) {
		        $bonoId = $mostrarDatos['bono_id'];
		        if (!isset($datosAgrupados[$id]['bonos'][$bonoId])) {
		            $datosAgrupados[$id]['bonoMonto'] += floatval($mostrarDatos['bono_monto']);
		            $datosAgrupados[$id]['bonos'][$bonoId] = true;
		        }
		    }

		    // Sumar descuentos según el tipo
		    if (!is_null($mostrarDatos['descuento_id'])) {
		        $descuentoId = $mostrarDatos['descuento_id'];
		        if (!isset($datosAgrupados[$id]['descuentos'][$descuentoId])) {
		            $descuentoTipo = $mostrarDatos['descuento_tipo'];
		            $descuentoMonto = floatval($mostrarDatos['descuento_monto']);
		            if ($descuentoTipo == 'Ausencia') {
		                $datosAgrupados[$id]['ausencias'] += $descuentoMonto;
		            } elseif ($descuentoTipo == 'Anticipo') {
		                $datosAgrupados[$id]['anticipos'] += $descuentoMonto;
		            } else {
		                $datosAgrupados[$id]['otros'] += $descuentoMonto;
		            }
		            $datosAgrupados[$id]['descuentos'][$descuentoId] = true;
		        }
		    }
		}

		// Convertir los datos agrupados a una lista de arrays, quitando los arrays temporales de bonos y descuentos
		$datos = [];
		foreach ($datosAgrupados as $empleado) {
		    unset($empleado['bonos']);
		    unset($empleado['descuentos']);
		    $datos[] = $empleado;
		}
	?>

	<?php

		for ($i = 0; $i < count($datos); ++$i) {

			for ($e = 0; $e < 2; ++$e) {
	?>
			    <div class="container">
				    <div class="title">
				    	<h2 style="text-align: center;">RECIBO DE PAGO</h2>
				    	<p style="text-align: center;">DEL <?php echo $newFechaInicial; ?> AL <?php echo $newFechaFinal; ?></p>
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
				    			<td><?php echo $datos[$i]['id']; ?></td>
				    			<td><?php echo $datos[$i]['empleadoNombres']; ?></td>
				    			<td><?php echo $datos[$i]['empleadoApellidos']; ?></td>
				    			<td><?php echo $datos[$i]['ctaBancaria']; ?></td>
				    			<td><?php echo date("d/m/Y", strtotime($datos[$i]['empleadoIngreso'])) ?></td>
				    			<td><?php echo $datos[$i]['agencia']; ?></td>
				    			<td><?php echo $datos[$i]['cargo']; ?></td>
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
				    			<td><?php echo number_format($datos[$i]['sueldo'], 2); ?></td>
				    			<td>IGSS</td>
				    			<td><?php
				    					$igss = number_format($datos[$i]['igss'] / 100 * $datos[$i]['sueldo'], 2);
										echo $igss; 
				    				?></td>
				    		</tr>
				    		<tr>
				    			<td>&nbsp;</td>
				    			<td></td>
				    			<td></td>
				    			<td></td>
				    		</tr>
				    		<tr>
				    			<td>Bonificación Decreto Ley 37-2001</td>
				    			<td><?php echo number_format($datos[$i]['bonoLey'], 2); ?></td>
				    			<td>Adelantos</td>
				    			<td><?php echo number_format($datos[$i]['anticipos'], 2); ?></td>
				    		</tr>
				    		<tr>
				    			<td>Bonificación Incentivo</td>
				    			<td><?php echo number_format($datos[$i]['bonoIncentivo'], 2); ?></td>
				    			<td>Ausencias</td>
				    			<td><?php echo number_format($datos[$i]['ausencias'], 2); ?></td>
				    		</tr>
				    		<tr>
				    			<td>Otros Ingresos</td>
				    			<td><?php echo number_format($datos[$i]['bonoMonto'], 2); ?></td>
				    			<td>Otros</td>
				    			<td><?php echo number_format($datos[$i]['otros'], 2); ?></td>
				    		</tr>
				    		<tr>
				    			<td style="text-align: center;"><b>Total Remuneraciones</b></td>
				    			<td><b><?php
				    				$totalDevengado = $datos[$i]['sueldo'] + $datos[$i]['bonoLey'] + $datos[$i]['bonoIncentivo'] + $datos[$i]['bonoMonto'];
									 echo number_format($totalDevengado, 2);
			    				?></b></td>
				    			<td style="text-align: center;"><b>Total Descuentos</b></td>
				    			<td><b><?php
				    				$totalDescuentos = $datos[$i]['anticipos'] + $datos[$i]['ausencias'] + $datos[$i]['otros'];
									echo number_format($totalDescuentos,2);
				    			?></b></td>
				    		</tr>
				    		<tr>
				    			<td colspan="2" class="no-border"></td>
				    			<td style="text-align: center;"><b>Neto a Pagar</b></td>
				    			<td><b><?php echo number_format($totalDevengado - $totalDescuentos - $igss, 2); ?></b></td>
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
	<?php
			}
	?>
				<div class="break"></div>
	<?php
		}
	?>
    <br>
</body>
</html>