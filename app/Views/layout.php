<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?= $this->e($title) ?></title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
	</head>

	<body>
		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?= $this->url('default_home'); ?>"><?= $w_site_name; ?></a>
				</div>

				<!-- Right menu -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<?php if ($w_user): ?>
						<!-- Membre -->
						<li>
							<a href="<?= $this->url('security_profil'); ?>">
								<?= $w_user['firstname']." ".$w_user['lastname'] ?>
							</a>
						</li>
						<li>
							<a href="<?= $this->url('security_logout'); ?>">Déconnexion</a>
						</li>

						<?php else: ?>
						<!-- Visiteur -->
						<li class="<?= $w_current_route == "security_login" ? "active" : ""; ?>">
							<a href="<?= $this->url('security_login'); ?>">Connexion</a>
						</li>
						<li class="<?= $w_current_route == "security_register" ? "active" : ""; ?>">
							<a href="<?= $this->url('security_register'); ?>">Inscription</a>
						</li>
						<?php endif; ?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>

		<div class="container">
			<header>
				<h1><?= $this->e($title) ?></h1>
			</header>

			<section>
				<?= $this->section('main_content') ?>
			</section>

			<footer>
				<?php var_dump($_SESSION) ?>
			</footer>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="<?= $this->assetUrl('js/app.js'); ?>"></script>
	</body>
</html>
