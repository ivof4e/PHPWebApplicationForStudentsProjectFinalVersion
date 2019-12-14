<?php include('Server.php') ?>
<?php
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: Login.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: Login.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<link rel="shorcut icon" href="img/favicon-16x16.png"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="container2">
			<h2>Начална страница</h2>
		</div>
		<div class="container">
			<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
			<?php endif ?>
			<?php  if (isset($_SESSION['username'])) : ?>
			<p>Добре дошъл <strong><?php echo $_SESSION['username']; ?></strong></p>
			<p> <a href="index.php?logout='1'" style="color: red;">Излез</a> </p>
		</div>
		<?php endif ?>
		<div>
			<div class="row">
				<form action="index.php" method="post" enctype="multipart/form-data" >
						<?php include('errors.php'); ?>
					<div class="input">
						<h4>Заглавие</h4>
						<input type="text" name="Title" placeholder="Заглавие" value="<?php echo $Title; ?>">
					</div>
					<div class="input">
						<h4>Качи файл</h4>
						<input type="file" name="myfile"> 
					</div>
					<div>
						<ul>	
							<li><button type="submit" class="btn" name="save">Добавяне</button></li>
							<li><button type="submit" class="btn" <a href="index.php">Назад</button></li>
						</ul>
					</div>
				</form>
			</div>
		</div>
		
		<table class="table">
			<thead>
				<th>Заглавие</th>
				<th>Дата на публикуване</th>
				<th>Изтегли</th>
			</thead>
			<tbody>
			<?php foreach ($files as $file): ?>
				<tr>
					<td><?php echo $file['Title']; ?></td>
					<td><?php echo $file['UploadDate']; ?></td>
					<td><a href="index.php?file_id=<?php echo $file['id'] ?>">Изтегли</a></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		
	</body>
</html>