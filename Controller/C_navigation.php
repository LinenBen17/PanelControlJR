<?php
	require_once '../Model/M_permisos.php';

	$permisos = new Permisos();

	foreach ($permisos->permisosUrl as $permiso => $enlace) {
	    if ($permisos->verificarPermiso($_SESSION['id'], $permiso)) {
			$icono = isset($permisos->iconos[$permiso]) ? $permisos->iconos[$permiso] : "default-icon"; // Obtener el nombre del icono correspondiente
?>
			<li>
        		<a href="<?php echo $enlace; ?>">
        			<span class="icon"><ion-icon name="<?php echo $icono; ?>"></ion-icon></span>
        			<span class="title"><?php echo $permiso; ?></span>
        		</a>
        	</li>
<?php
	    }
	}
?>