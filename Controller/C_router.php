<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
	class Router {
		public function route($url) {
			if ($url === '/principal') {
				$path = __DIR__ . '/../View/principal.php';
				include $path;
			}
		}
	}
?>