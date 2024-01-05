<?php
	class ControlUsuario{
		private $db;

	    public function __construct(){
	    	require_once 'Conexion.php';
	    	$this->db = Conexion::conectar();
	    }
	    public function getAllUsers(){
	    	//CODIGO PARA OBTENER TODOS LOS USUARIOS
	    	$sql = "SELECT id, usuario, nombre FROM usuarios";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->execute();
	    	$resultado = $sentencia->get_result();

	    	return $resultado;
	    }
	    public function getUser($id){
	    	//CODIGO PARA OBTENER TODOS LOS USUARIOS
	    	$sql = "SELECT id, usuario, nombre, password FROM usuarios WHERE id = ?";

	    	$sentencia = $this->db->prepare($sql);
	    	$sentencia->bind_param("i", $id);
	    	$sentencia->execute();
	    	$resultado = $sentencia->get_result();

	    	return $resultado;
	    }
	    public function deleteUsers($idGet){
	    	$id = $idGet;

			//SQLS PARA ELIMINAR TODO RELACIONADO AL USUARIO
			$sqlSelecccionarUser = "DELETE FROM usuarios WHERE id = ?";
			$sqlPermisoUser = "DELETE FROM asignacion WHERE id_usuario = ?";

			$sentencia = $this->db->prepare($sqlSelecccionarUser);
			$sentencia->bind_param("i", $id);
			$exec = $sentencia->execute();

			$sentenciaPermisosUser = $this->db->prepare($sqlPermisoUser);
			$sentenciaPermisosUser->bind_param("i", $id);
			$resultado = $sentenciaPermisosUser->execute();

			if ($exec && $resultado) {
				return true;
			}else{
				return false;
			}
	    }
	    public function createUser($usuario, $nombre, $password, $postData){
	    	//ARRAY DE PERMISOS
	    	$permisos = $this->permisosEnviados($postData);

			//Usuarios datos
	    	$usuario = $usuario;
	    	$nombre = $nombre;
	    	$password = password_hash($password, PASSWORD_DEFAULT);

			// SENTENCIAS SQL
	    	$sqlUsuarios = "INSERT INTO usuarios (id, usuario, password, nombre) VALUES (NULL, ?, ?, ?)";
	    	$sqlPermisos = "INSERT INTO asignacion (id, id_usuario, id_permiso) VALUES (NULL, ?, ?)";

	    	$sentenciaUsuarios = $this->db->prepare($sqlUsuarios);
	    	$sentenciaUsuarios->bind_param("sss", $usuario, $password, $nombre);
	    	$execUsuarios = $sentenciaUsuarios->execute();

			$sentenciaUsuarios->close();

	    	//OBTENER EL ID RECIEN AGREGADO
	    	$resultado = $this->getAllUsers();
	    	$resultado->data_seek($resultado->num_rows -1);

	    	$lastID = $resultado->fetch_assoc();
	    	// Insertar los permisos en la base de datos
			foreach ($permisos as $permiso) {
	    		$sentenciaPermisos = $this->db->prepare($sqlPermisos);
			    $sentenciaPermisos->bind_param("ii", $lastID['id'], $permiso);
			    $sentenciaPermisos->execute();
			}

			$sentenciaPermisos->close();

			return true;
	    }
	    public function updateUsers($id, $usuario, $nombre, $postData){
	    	//ARRAY DE PERMISOS
	    	$permisosNuevos = $this->permisosEnviados($postData);
	    	
			//Usuarios datos
			$id = $id;
	    	$usuario = $usuario;
	    	$nombre = $nombre;
	    	$newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

			// SQL EDITAR NOMBRE Y USUARIO ACTUAL
			$sqlEdit = "UPDATE usuarios SET usuario = ?, nombre = ?, password = ? WHERE id = ?";

			$sentenciaEdit = $this->db->prepare($sqlEdit);
			$sentenciaEdit->bind_param("sssi", $usuario, $nombre, $newPassword, $id);
			$sentenciaEdit->execute();

			$sentenciaEdit->close();

			//SQL PARA SABER LOS PERMISOS ACTUALES DEL USUARIO
			$sqlId = "SELECT * FROM asignacion WHERE id_usuario = ?";

			$sentenciaId = $this->db->prepare($sqlId);
			$sentenciaId->bind_param("i", $id);
			$sentenciaId->execute();

			$resultadosId = $sentenciaId->get_result();

			// ARREGLO Y LUEGO FOREACH PARA ALMACENAR LOS PERMISOS ACTUALES;
			$permisosActuales=[];

			foreach ($resultadosId as $resultado) {
				$permisosActuales[] = $resultado['id_permiso'];
			}

			// Calcula los permisos que se deben eliminar
			$permisosEliminar = array_diff($permisosActuales, $permisosNuevos);
			// Calcula los permisos que se deben agregar
			$permisosAgregar = array_diff($permisosNuevos, $permisosActuales);

			// Eliminar permisos que ya no están seleccionados
			if (!empty($permisosEliminar)) {
			    $sqlEliminarPermisos = "DELETE FROM asignacion WHERE id_usuario = ? AND id_permiso = ?";
			    $sentenciaEliminarPermisos = $this->db->prepare($sqlEliminarPermisos);
			    foreach ($permisosEliminar as $permiso) {
			    	$sentenciaEliminarPermisos->bind_param("ii", $id, $permiso);
			        $sentenciaEliminarPermisos->execute();
			    }
			    $sentenciaEliminarPermisos->close();
			}

			// Agregar nuevos permisos seleccionados
			if (!empty($permisosAgregar)) {
			    $sqlAgregarPermisos = "INSERT INTO asignacion (id_usuario, id_permiso) VALUES (?, ?)";
			    $sentenciaAgregarPermisos = $this->db->prepare($sqlAgregarPermisos);
			    foreach ($permisosAgregar as $permiso) {
			    	$sentenciaAgregarPermisos->bind_param("ii", $id, $permiso);
			        $sentenciaAgregarPermisos->execute();
			    }

				$sentenciaAgregarPermisos->close();
			}
			return true;
	    }
	    public function getPermisosEditar($id){
	    	//SQL OBTENER PERMISOS QUE TIENE EL USUARIO
		    $sqlAsignaciones = "SELECT * FROM asignacion WHERE id_usuario = ?";

		    $sentenciaAsignaciones = $this->db->prepare($sqlAsignaciones);
		    $sentenciaAsignaciones->bind_param("i", $id);
		    $sentenciaAsignaciones->execute();

		    $resultadosAsignaciones = $sentenciaAsignaciones->get_result();

		    $resultadosPermisos = $this->getPermisos();

			$sentenciaAsignaciones->close();

			return ["allPermisos" => $resultadosPermisos, "permisosUsuario" => $resultadosAsignaciones];
	    }
	    public function getPermisos(){
	    	//SQL MOSTRAR PERMISOS PARA SELECCIONAR
			$sqlOpciones = "SELECT * FROM permisos";

			$sentenciaOpciones = $this->db->prepare($sqlOpciones);
			$sentenciaOpciones->execute();

			$resultadosPermisos = $sentenciaOpciones->get_result();

			$sentenciaOpciones->close();

			return $resultadosPermisos;
	    }
	    private function permisosEnviados($postData){ 
	    	//OBTENER TODOS LOS PERMISOS
			$roles = $this->getPermisos();

			//ARRAY DINAMICO QUE AGREGA TODOS LOS PERMISOS DE LA DB
			$secciones = array();
			foreach ($roles as $rol) {
				$secciones[strtolower(str_replace(" ", "", $rol['seccion']))] = $postData[strtolower(str_replace(" ", "", $rol['seccion']))] ?? null;
			}

	    	// Filtrar las variables de permisos para obtener solo los valores no nulos
			$permisos = array_filter($secciones);

			return $permisos;

	    }
	    /*public function updateOrSave($id){
	    	//VERIFICAR SI SE EDITARÁ O GUARDARÁ
			$sql = "SELECT id FROM usuarios WHERE id = ?";

			$sentencia = $this->db->prepare($sql);
			$sentencia->bind_param("i", $id);
			$sentencia->execute();
			$sentencia->store_result();

			$resultado = $sentencia->num_rows;

			if ($resultado == 0) {
				$this->createUsers();
			}
	    }*/
	}
?>