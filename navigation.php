		<div class="navigation">  
			<ul>
				<li>
					<a href="#">
						<span class="icon"><ion-icon name="car-outline"></ion-icon></span>
						<span class="title">TRANSPORTES JR</span>
					</a>
				</li>
				<li>
					<a href="principal.php">
						<span class="icon"><ion-icon name="home-outline"></ion-icon></span>
						<span class="title">Inicio</span>
					</a>
				</li>
				<?php
					// Definir los permisos y los enlaces correspondientes
					require 'seccionesUrls.php';

					// Uso de la función para verificar los permisos y generar enlaces
					foreach ($permisos as $permiso => $enlace) {
					    if (verificarPermiso($idSesion, $permiso)) {
							$icono = isset($iconos[$permiso]) ? $iconos[$permiso] : "default-icon"; // Obtener el nombre del icono correspondiente
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
				<li>
					<a href="logout.php">
						<span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
						<span class="title">Cerrar Sesión</span>
					</a>
				</li>
			</ul>
		</div>