<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php /* if a $page_title variable is set, include it it the title tag */ ?>
			<?php if ( isset($page_title) ): ?>
				<?php echo $page_title . ' | '; ?>
			<?php endif; ?>
			EnviroMon- Environment Monitoring
		</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style type="text/css">
		img {
			max-width: 100%;
		}

		.col-sm-4 {
			text-align: center;
		}

		.col-sm-4 img {
			height: 300px;
		}
		</style>
	</head>
	<body>
		<!-- Bootstrap navigation header -->
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">EnviroMon</a>
				</div>
				<div class="navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="about.php">About</a>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container">
			<div class="page-header">
				<h1 class="page-title">
					<?php /* If a $page_title is available, use that in the header */ ?>
					<?php if ( isset($page_title) ): ?>
						<?php echo $page_title; ?>
					<?php /* Otherwise, print the default title */ ?>
					<?php else: ?>
						EnviroMon- Environment Monitor
					<?php endif; ?>
				</h1>
			</div>