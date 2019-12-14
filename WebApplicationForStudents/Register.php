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
			<h2>Регистрация</h2>
		</div>
		<form method="post" action="Register.php">
			<?php include('errors.php'); ?>
			<div class="input">
				<h5>Потребителско име</h5>
				<input type="text" name="Username" value="<?php echo $Username; ?>">
			</div>
			<div class="input">
				<h5>Факултетен номер</h5>
				<input type="text" name="FacultyNumber" value="<?php echo $FacultyNumber; ?>">
			</div>
			<div class="input">
				<h5>Име</h5>
				<input type="text" name="FirstName" value="<?php echo $FirstName; ?>">
			</div>
			<div class="input">
				<h5>Презиме</h5>
				<input type="text" name="SecondName" value="">
			</div>
			<div class="input">
				<h5>Фамилия</h5>
				<input type="text" name="LastName" value="<?php echo $LastName; ?>">
			</div>
			<div class="input">
				<h5>Парола</h5>
				<input type="password" name="Password_1">
			</div>
			<div class="input">
				<h5>Потвърди паролата</h5>
				<input type="password" name="Password_2">
			</div>
			<div class="input">
				<h5>Специалност</h5>
				<input type="text" name="Speciality" value="<?php echo $Speciality; ?>">
			</div>
			<div class="input">
				<h5>Курс</h5>
				<select  name="Course" value="<?php echo $Course; ?>">                      
					<option value="Null">--Изберете курс--</option>
					<option value="1-st course">Първи курс</option>
					<option value="2-nd course">Втори курс</option>
					<option value="3-rd course">Трети курс</option>
					<option value="4-th course">Четвърти курс</option>
				</select>
			</div>
			<div class="input">
				<h5>Тип образование</h5>
				<select  name="EducationType" value="<?php echo $EducationType; ?>">                      
					<option value="Null">--Изберете тип образование--</option>
					<option value="regularly">Редовно</option>
					<option value="external">Задочно</option>
				</select>
			</div>
			<div >
				<ul>	
					<li><button type="submit" class="btn" name="reg_user">Регистрация</button></li>
					<li><a href="index.php" class="btn"> Назад </a></li>
				</ul>
			</div>
			<p>
				Ако вече имате акаунт? <a href="index.php">Влезте</a>
			</p>
		</form>
	</body>
</html>