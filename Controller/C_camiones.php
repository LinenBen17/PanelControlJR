<?php
	require_once '../Model/M_camiones.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$camiones = new Camiones();

	switch ($action) {
		case "Crear":
			$newCamion = $camiones->newCamion($_POST['modelo'],$_POST['marca'],$_POST['placa']);

			echo json_encode($newCamion);

			break;
		case "Show":
			$showCamion = $camiones->showCamion($_POST['id']);
			$datosCamiones = $showCamion->fetch_assoc();

			echo json_encode([
				"id" => $datosCamiones['id'],
				"accion" => "Showed",
				"modelo" => $datosCamiones['modelo'],
				"marca" => $datosCamiones['marca'],
				"placa" => $datosCamiones['placa'],
				"fecha_creacion" => $datosCamiones['fecha_creacion'],
				"fecha_modificacion" => $datosCamiones['fecha_modificacion'],
			]);

			break;
		case "Editar":
			$updateCamion = $camiones->updateCamion($_POST['modelo'],$_POST['marca'],$_POST['placa'], $_POST['id']);

			echo json_encode($updateCamion);
			
			break;
		case "Eliminar":
			$deleteCamion = $camiones->deleteCamion($_POST['id']);

			echo json_encode($deleteCamion);
			
			break;
		default:
			$showAllCamiones = $camiones->showAllCamiones();

			while ($allCamiones = $showAllCamiones->fetch_array()) {
		?>
				<tr>
                    <td><?php echo htmlspecialchars($allCamiones['id']);?></td>
                    <td><?php echo htmlspecialchars($allCamiones['modelo']);?></td>
                    <td><?php echo htmlspecialchars($allCamiones['marca']);?></td>
                    <td><?php echo htmlspecialchars($allCamiones['placa']);?></td>
                    <td><?php echo htmlspecialchars($allCamiones['fecha_creacion']);?></td>
                    <td><?php echo htmlspecialchars($allCamiones['fecha_modificacion']);?></td>
                    <td><button id="<?php echo htmlspecialchars($allCamiones['id']); ?>" class="btnEditar btnCrud" value="Show">Editar</button></td>
                    <td><button id="<?php echo htmlspecialchars($allCamiones['id']); ?>" class="btnEliminar btnCrud" value="Eliminar">Eliminar</button></td>
                </tr>
		<?php
			}
			break;
	}
?>