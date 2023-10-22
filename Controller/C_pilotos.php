<?php
	require_once '../Model/M_pilotos.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$pilotos = new Pilotos();

	switch ($action) {
		case "Crear":
			$newPiloto = $pilotos->newPiloto($_POST['nombres'],$_POST['apellidos'],$_POST['licencia'],$_POST['estado']);

			echo json_encode($newPiloto);

			break;
		case "Show":
			$showPiloto = $pilotos->showPiloto($_POST['id']);
			$datosPiloto = $showPiloto->fetch_assoc();

			echo json_encode([
				"id" => $datosPiloto['id'],
				"accion" => "Showed",
				"nombres" => $datosPiloto['nombres'],
				"apellidos" => $datosPiloto['apellidos'],
				"licencia" => $datosPiloto['licencia'],
				"fecha_creacion" => $datosPiloto['fecha_creacion'],
				"fecha_modificacion" => $datosPiloto['fecha_modificacion'],
				"estado" => $datosPiloto['estado'],
			]);

			break;
		case "Editar":
			$updatePiloto = $pilotos->updatePiloto($_POST['nombres'],$_POST['apellidos'],$_POST['licencia'],$_POST['estado'], $_POST['id']);

			echo json_encode($updatePiloto);
			
			break;
		case "Eliminar":
			$detelePiloto = $pilotos->deletePiloto($_POST['id']);

			echo json_encode($detelePiloto);
			
			break;
		default:
			$showAllPilotos = $pilotos->showAllPilotos();

			while ($allPilotos = $showAllPilotos->fetch_array()) {
		?>
				<tr>
                    <td><?php echo htmlspecialchars($allPilotos['id']);?></td>
                    <td><?php echo htmlspecialchars($allPilotos['nombres']);?></td>
                    <td><?php echo htmlspecialchars($allPilotos['apellidos']);?></td>
                    <td><?php echo htmlspecialchars($allPilotos['licencia']);?></td>
                    <td><?php echo htmlspecialchars($allPilotos['fecha_creacion']);?></td>
                    <td><?php echo htmlspecialchars($allPilotos['fecha_modificacion']);?></td>
                    <td><?php echo $allPilotos['estado'] == 1 ? 'Activo' : 'Inactivo';?></td>
                    <td><button id="<?php echo htmlspecialchars($allPilotos['id']); ?>" class="btnEditar btnCrud" value="Show">Editar</button></td>
                    <td><button id="<?php echo htmlspecialchars($allPilotos['id']); ?>" class="btnEliminar btnCrud" value="Eliminar">Eliminar</button></td>
                </tr>
		<?php
			}
			break;
	}
?>