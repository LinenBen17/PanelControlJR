<?php
	require_once 'shared/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="../Public/css/dashboard.css">
</head>
<body>
	<div class="container">
		<?php require 'shared/navigation.php' ?>
		<!-- Main -->
		<div class="main">
			<div class="topbar">
				<div class="toggle">
					<ion-icon name="menu-outline"></ion-icon>
				</div>
				<!-- search -->
				<div class="search">
					<label>
						<input type="text" placeholder="Search here">
						<ion-icon name="search-outline"></ion-icon>
					</label>
				</div>
				<!-- userImg -->
				<?php require 'shared/view.php'; ?>
			</div>
			<div class="details">
				<div class="recentOrders">

			</div>
		</div>
	</div>
	<?php require_once 'shared/footer.php';	 ?>
</body>
</html>