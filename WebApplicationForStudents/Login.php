<?php include('Server.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registration system PHP and MySQL</title>
		<link rel="shorcut icon" href="img/favicon-16x16.png"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="container">
			<h2>Влизане</h2>
		</div>
		<form method="post" action="login.php">
			<?php include('Errors.php'); ?>
			<div class="input">
				<label>Потребителско име</label>
				<input type="text" name="Username" >
			</div>
			<div class="input">
				<label>Парола</label>
				<input type="password" name="Password">
			</div>
			<div class="input">
				<button type="submit" class="btn" name="login_user">Влез</button>
			</div>
			<p>
				Нямате акаунт? <a href="register.php">Регистрирай се</a>
			</p>
		</form>
	</body>
</html>