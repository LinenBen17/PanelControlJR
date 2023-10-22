<?php
	require_once '../Model/M_ruta.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$ruta = new Ruta();

	switch ($action) {
		case "Crear":
			$newRuta = $ruta->newRuta($_POST['placa'],$_POST['piloto'],$_POST['ruta']);

			echo json_encode($newRuta);

			break;
		case "Show":
			$showRuta = $ruta->showRuta($_POST['id']);
			$datosRuta = $showRuta->fetch_assoc();

			echo json_encode([
				"id" => $datosRuta['id'],
				"accion" => "Showed",
				"placa" => $datosRuta['placa'],
				"piloto" => $datosRuta['piloto'],
				"ruta" => $datosRuta['ruta'],
				"fecha_creacion" => $datosRuta['fecha_creacion'],
				"fecha_modificacion" => $datosRuta['fecha_modificacion'],
			]);

			break;
		case "Editar":
			$updateRuta = $ruta->updateRuta($_POST['placa'],$_POST['piloto'],$_POST['ruta'], $_POST['id']);

			echo json_encode($updateRuta);
			
			break;
		case "Eliminar":
			$deleteRuta = $ruta->deleteRuta($_POST['id']);

			echo json_encode($deleteRuta);
			
			break;
		case "SearchPiloto":
			$searchPiloto = $ruta->searchPiloto($_POST['searchPiloto']);

			$datos = [];
			while ($mostrar = $searchPiloto->fetch_array()) {
			    $datos[]= $mostrar['nombres'] . " " . $mostrar['apellidos'];
			}

			echo json_encode($datos);
			break;
		case "SearchPlaca":
			$searchPlaca = $ruta->searchPlaca($_POST['searchPlaca']);

			$datos = [];
			while ($mostrar = $searchPlaca->fetch_array()) {
			    $datos[]= $mostrar['placa'];
			}

			echo json_encode($datos);
			break;
		default:
			$showAllRutas = $ruta->showAllRutas();

			while ($allRutas = $showAllRutas->fetch_array()) {
		?>
				<tr>
                    <td><?php echo htmlspecialchars($allRutas['id']);?></td>
                    <td><?php echo htmlspecialchars($allRutas['placa']);?></td>
                    <td><?php echo htmlspecialchars($allRutas['piloto']);?></td>
                    <td><?php echo htmlspecialchars($allRutas['ruta']);?></td>
                    <td><?php echo htmlspecialchars($allRutas['fecha_creacion']);?></td>
                    <td><?php echo htmlspecialchars($allRutas['fecha_modificacion']);?></td>
                    <td><button id="<?php echo htmlspecialchars($allRutas['id']); ?>" class="btnEditar btnCrud" value="Show">Editar</button></td>
                    <td><button id="<?php echo htmlspecialchars($allRutas['id']); ?>" class="btnEliminar btnCrud" value="Eliminar">Eliminar</button></td>
                </tr>
		<?php
			}
			break;
	}
?>