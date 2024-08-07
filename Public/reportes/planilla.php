<?php
// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
// Desactivar toda notificación de error
error_reporting(0);
	$fechaInicial = $_GET['fechaInicial'];
	$fechaFinal = $_GET['fechaFinal'];

	$newFechaInicial = date("d/m/Y", strtotime($fechaInicial));
	$newFechaFinal = date("d/m/Y", strtotime($fechaFinal));


	class Planilla{
		private $db;

	    public function __construct(){
	        require_once '../../Model/Conexion.php';
	        $this->db = Conexion::conectar();
	    }
	    public function selectAllPlanilla(){
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
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Planilla De Saldos</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: sans-serif;
			font-size: 9pt;
		}

		.header {
			background: none;
			border: none;
		}

		.header h2 {
			font-size: 12pt;
			font-style: italic;
			padding: 20px 0;
		}

		.hLeft {
			text-align: right; /* Align text to the right */
			position: fixed;
			left: calc(1180px + 10px);
			margin-top: 25px;
		}

		.hLeft .page {
			font-weight: bold;
			font-size: 12pt;
			font-style: italic;
		}

		.page:after {
			content: counter(page);
			font-size: 12pt;
			color: #000;
		}

		.title {
			border-bottom: 1px solid #000;
			position: relative;
		}

		.title h1 {
			text-align: center;
			font-size: 18pt;
			padding: 15px 15px 0px 15px;
			position: relative;
			top: 10px;
		}

		.title img {
			width: 200px;
			margin: -30px 10px 10px 10px;
		}

		table, .title, .footer {
			margin-left: 100px;
			width: 1182px;
		}

		table, th, td {
			border: 0px solid black;
			border-collapse: collapse;
		}

		th, td {
			text-align: center;
			box-sizing: border-box; /* Añadido para incluir el padding en el width */
		}
		td{
			padding: 10px;
		}
		th{
			padding: 12px 8px;
		}
		thead {
			background: #C0C0C0;
			border: 1px solid #000;
			border-radius: 50%;
		}

		tbody tr {
			border-bottom: 1px solid #000;
		}

		table tr > td:nth-child(n+1):nth-child(-n+5) {
			font-size: 8pt;
		}
		tr.totales td{
			font-size: 10pt !important;
			font-weight: bold;
		}
		tr.totales td h1{
			font-size: 12pt;
		}
	</style>
</head>
<body>
	<div class="title">
		<h1>PLANILLA DE SUELDOS</h1>
		<img src="https://i.ibb.co/yfBVM6C/Logo-7-7.png" alt="">
	</div>
	<div class="hLeft">
		<span class="page">Página: </span>
	</div>
	<?php
		$planilla = new Planilla();
		$selectAllPlanilla = $planilla->selectAllPlanilla();

		$datosAgrupados = [];

		$totales = [
			"sueldo" => 0,
			"bonoLey" => 0,
			"bonoIncentivo" => 0,
			"otrosIngresos" => 0,
			"totalDevengado" => 0,
			"igss" => 0,
			"anticipo" => 0,
			"ausencias" => 0,
			"otrosDescuentos" => 0,
			"totalDescuento" => 0,
			"liquido" => 0,
		];
		
		while ($mostrarDatos = $selectAllPlanilla->fetch_array()) {
		    $id = $mostrarDatos['empleadoID'];

		    // Inicializar el array si no existe
		    if (!isset($datosAgrupados[$id])) {
		        $datosAgrupados[$id] = [
		            "id" => $id,
		            "ctaBancaria" => $mostrarDatos['empleado_ctaBancaria'],
		            "empleado" => $mostrarDatos['empleado_nombres'] . " " . $mostrarDatos['empleado_apellidos'],
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
	<table>
			<thead class="header">
				<tr>
					<th colspan="14">
							<h2 style="text-align: left;">Período planilla: Del <?php echo $newFechaInicial; ?> Al <?php echo $newFechaFinal; ?></h2>
					</th>
					<th colspan="2">
						
					</th>
				</tr>
			</thead>
		<thead>
			<tr>
				<th>No.</th>
				<th>Cta. Bancaria</th>
				<th>Nombre Empleado</th>
				<th>Puesto</th>
				<th>Agencia</th>
				<th>Sueldo</th>
				<th>Bonific. Ley</th>
				<th>Bono Incentivo</th>
				<th>Otros Ingresos</th>
				<th>Total Devengado</th>
				<th>IGSS</th>
				<th>Anticipo</th>
				<th>Ausencias</th>
				<th>Otros Descuentos</th>
				<th>Total Descuento</th>
				<th>Liquido a Recibir</th>
			</tr>
		</thead>
		<tbody>
				<?php
					for ($i = 0; $i < count($datos); ++$i) {
				?>
						<tr>	
							<td><?php echo $datos[$i]['id']; ?></td>
							<td><?php echo $datos[$i]['ctaBancaria']; ?></td>
							<td><?php echo $datos[$i]['empleado']; ?></td>
							<td><?php echo $datos[$i]['cargo']; ?></td>
							<td><?php echo $datos[$i]['agencia']; ?></td>
							<td><?php echo number_format($datos[$i]['sueldo'], 2); ?></td>
							<td><?php echo number_format($datos[$i]['bonoLey'], 2); ?></td>
							<td><?php echo number_format($datos[$i]['bonoIncentivo'], 2); ?></td>
							<td><?php echo number_format($datos[$i]['bonoMonto'], 2); ?></td>
							<td><?php
									 $totalDevengado = $datos[$i]['sueldo'] + $datos[$i]['bonoLey'] + $datos[$i]['bonoIncentivo'] + $datos[$i]['bonoMonto'];
									 echo number_format($totalDevengado, 2);
								?></td>
							<td><?php
								$igss = number_format($datos[$i]['igss'] / 100 * $datos[$i]['sueldo'], 2);
								echo $igss; 
							?></td>
							<td><?php echo number_format($datos[$i]['anticipos'], 2); ?></td>
							<td><?php echo number_format($datos[$i]['ausencias'], 2); ?></td>
							<td><?php echo number_format($datos[$i]['otros'], 2); ?></td>
							<td><?php

									$totalDescuentos = $datos[$i]['anticipos'] + $datos[$i]['ausencias'] + $datos[$i]['otros'];
									echo number_format($totalDescuentos,2);
								?></td>
							<td><?php
									$liquido = $totalDevengado - $totalDescuentos - $igss;
									echo number_format($liquido, 2);
							?></td>
						</tr>
				<?php
						$totales["sueldo"] += $datos[$i]['sueldo'];
						$totales["bonoLey"] += $datos[$i]['bonoLey'];
						$totales["bonoIncentivo"] += $datos[$i]['bonoIncentivo'];
						$totales["otrosIngresos"] += $datos[$i]['bonoMonto'];
						$totales["totalDevengado"] += $totalDevengado;
						$totales["igss"] += $igss;
						$totales["anticipo"] += $datos[$i]['anticipos'];
						$totales["ausencias"] += $datos[$i]['ausencias'];
						$totales["otrosDescuentos"] += $datos[$i]['otros'];
						$totales["totalDescuento"] += $totalDescuentos;
						$totales["liquido"] += $liquido;
					} 
				?>
				<tr class="totales">
					<td colspan="3"></td>
					<td colspan="2"><h1>TOTALES</h1></td>
					<td><<?php echo number_format($totales['sueldo'], 2); ?></td>
					<td><<?php echo number_format($totales['bonoLey'], 2); ?></td>
					<td><<?php echo number_format($totales['bonoIncentivo'], 2); ?></td>
					<td><<?php echo number_format($totales['otrosIngresos'], 2); ?></td>
					<td><<?php echo number_format($totales['totalDevengado'], 2); ?></td>
					<td><<?php echo number_format($totales['igss'], 2); ?></td>
					<td><<?php echo number_format($totales['anticipo'], 2); ?></td>
					<td><<?php echo number_format($totales['ausencias'], 2); ?></td>
					<td><<?php echo number_format($totales['otrosDescuentos'], 2); ?></td>
					<td><<?php echo number_format($totales['totalDescuento'], 2); ?></td>
					<td><<?php echo number_format($totales['liquido'], 2); ?></td>
				</tr>
		</tbody>
	</table>
</body>
</html>