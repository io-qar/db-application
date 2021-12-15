<html>
	<head>
		<title><?php echo $title_name; ?></title>
		<link rel="stylesheet" href="/styles/main.css">
		<meta charset="utf-8">
		<?php
			session_start();
			// echo $_SESSION;
		?>
	</head>
	<body>
		<header class="header">
			<div class="header__content">
				<nav class="navbar">
					<?php
						echo '<a href="/views/index.php" class="nav__item">Главная</a>';
						if (isset($_SESSION['name'])) {	
							echo '<a href="/views/view_archive.php" class="nav__item">Архив</a>';
							// echo '<a href="/views/view_user-page.php" class="nav__item">Ваш профиль</a>';
							// echo '<a href="/views/view_upload.php" class="nav__item">Загрузить пост</a>';
							echo '<a href="/controllers/logout.php" class="nav__item">Выйти из аккаунта</a>';
							echo 'Вы зашли на сайт под именем '.$_SESSION["name"].' с типом доступа <b>'.$_SESSION['prv'].'</b>';
						} else {
							echo '<a href="/views/view_reg.php" class="nav__item">Зарегистрироваться</a>';
							echo '<a href="/views/view_login.php" class="nav__item">Войти</a>';
						}
					?>
				</nav>
			</div>
		</header>