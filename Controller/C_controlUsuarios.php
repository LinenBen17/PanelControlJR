<?php
	require_once '../Model/M_controlUsuario.php';

	$action = isset($_POST['action']) ? $_POST['action'] : '';

	$controlUsuario = new ControlUsuario();


	switch ($action) {
		case 'permisos':
			$getPermisos = $controlUsuario->getPermisos();

			$permisos = [];
 
			foreach ($getPermisos as $permiso) {
				$permisos[] = [
					"id" => $permiso['id'],
					"seccion" => $permiso['seccion'],
				];
			}

			echo json_encode($permisos);
			break;
		case 'obtener':
			$getUser = $controlUsuario->getUser($_POST['id']);
			$getPermisosEditar = $controlUsuario->getPermisosEditar($_POST['id']);

			$seccionPermiso = [];
			$user = $getUser->fetch_assoc();

			foreach ($getPermisosEditar["allPermisos"] as $resultadoPermiso) {
				$idPermiso = $resultadoPermiso['id'];

				$seccionPermiso[$resultadoPermiso['seccion']] = [
					"id" => $idPermiso,
				];

				$asignaciones = $getPermisosEditar["permisosUsuario"];

				foreach ($asignaciones as $asignacion) {
			    	if ($asignacion['id_permiso'] == $idPermiso) {
			    		$seccionPermiso[$resultadoPermiso['seccion']] = [
			    			"id" => $idPermiso,
			    			"checked" => "checked",
			    		];
			    	}
			    }
			}

			echo json_encode([$user, $seccionPermiso]);
			break;
		case 'crear':
			$createUser = $controlUsuario->createUser($_POST['usuario'], $_POST['nombre'], $_POST['password'], $_POST);
			
			header("location: ../View/controlUsuarios.php");
			break;
		case 'editar':
			try {
				$updateUsers = $controlUsuario->updateUsers($_POST['id'], $_POST['usuario'], $_POST['nombre'], $_POST);
				
				header("location: ../View/controlUsuarios.php");
			} catch (Exception $e) {
				echo json_encode([$e]);
			}
			break;

		case 'eliminar':
			try {
				$idPost = isset($_POST['id']) ? $_POST['id'] : '';

				if($controlUsuario->deleteUsers($idPost)){
					echo json_encode([$controlUsuario->deleteUsers($idPost)]);
				}

			} catch (Exception $e) {
				echo json_encode([$e]);
			}
			break;

		default:
			$resultado = $controlUsuario->getAllUsers();

			while ($allUsers = $resultado->fetch_array()) {
		?>
				<tr>
					<td><?php echo htmlspecialchars($allUsers['id']);?></td>
					<td><?php echo htmlspecialchars($allUsers['usuario']);?></td>
					<td><?php echo htmlspecialchars($allUsers['nombre']);?></td>
					<td><a href="#" id="<?php echo htmlspecialchars($allUsers['id']);?>" class="btnEditar">Editar</a></td>
					<td><a href="" id="<?php echo htmlspecialchars($allUsers['id']);?>" class="btnEliminar">Eliminar</a></td>
				</tr>
		<?php
			}
			break;
	}

?>