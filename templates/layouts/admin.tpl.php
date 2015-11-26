
<!-- ADMIN LAYOUT -->

<!doctype html>
<html>
	<head>
		<title>EnviroMon Control Panel</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<h1> EnviroMon Control Panel 
		<?php if($page_title) echo "- " . "$page_title"; ?>
		</h1>
	</head>
	<body>
		<div class="container">
			<?php if ( isset($_SESSION['message']) ): ?>
				<div class='alert alert-warning'><?= $_SESSION['message'] ?></div>
				<?php unset($_SESSION['message']); ?>
			<?php endif; ?>
			
			<?= $page_content ?>
		</div>
	</body>
</html>