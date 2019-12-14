<?php
	session_start();
	require_once('validation.php');
		$Username = "";
		$FacultyNumber   = "";
		$FirstName  = "";
		$LastName  = "";
		$Speciality   = "";
		$FileName = "";
		$errors = array(); 
		$Title = "";
		
		// Свързване с база данни
		$db = mysqli_connect('localhost', 'root', '', 'ForStudentsDB', '3308');
		$sql = "SELECT * FROM files";
		$result = mysqli_query($db, $sql);
		$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Регистрация на потребителя
	if (isset($_POST['reg_user'])) {
		$Username = mysqli_real_escape_string($db, $_POST['Username']);
		$FacultyNumber = mysqli_real_escape_string($db, $_POST['FacultyNumber']);
		$FirstName = mysqli_real_escape_string($db, $_POST['FirstName']);
		$LastName = mysqli_real_escape_string($db, $_POST['LastName']);
		$Speciality = mysqli_real_escape_string($db, $_POST['Speciality']);
		$Course = mysqli_real_escape_string($db, $_POST['Course']);
		$EducationType = mysqli_real_escape_string($db, $_POST['EducationType']);
		$Password_1 = mysqli_real_escape_string($db, $_POST['Password_1']);
		$Password_2 = mysqli_real_escape_string($db, $_POST['Password_2']);
		$uppercase = preg_match('@[A-Z]@', $Password_1);
		$lowercase = preg_match('@[a-z]@', $Password_1);
		$number    = preg_match('@[0-9]@', $Password_1);
		$specialChars = preg_match('@[^\w]@', $Password_1);
		
		if (empty($Username)) { array_push($errors, "Потребителското име е задължително"); }
		else  if (ValidatePostValueLength('Username',5,20)) { array_push($errors, "Потребителското име трябва да съдържа между 5 и 20 символа");}
		if (empty($FacultyNumber)) { array_push($errors, "Факултетният номер е задължителен"); }
		else if (ValidatePostValueLength('FacultyNumber',10,10)) { array_push($errors, "Факултетният номер трябва да съдържа 10 символа"); }
		if (empty($FirstName)) { array_push($errors, "Името е задължително"); }
		else if (ValidatePostValueLength('FirstName',0,100)) { array_push($errors, "Името може да бъде максимум 100 символа"); }
		if (empty($LastName)) { array_push($errors, "Фамилното име е задължително"); }
		else if (ValidatePostValueLength('LastName',0,100)) { array_push($errors, "Фамилното име може да бъде максимум 100 символа"); }
		if (empty($Speciality)) { array_push($errors, "Специалността е задължителна"); }
		else if (ValidatePostValueLength('Speciality',0,100)) { array_push($errors, "Специалността може да бъде максимум 100 символа"); }
		if (empty($Password_1)) { array_push($errors, "Паролата е задължителна"); }
		else if (ValidatePostValueLength('Password_1',6,30)) { array_push($errors, "Паролата трябва да бъде между 6 и 30 символа"); }
		else if  (!$uppercase ) { array_push($errors, "Паролата трябва да има поне една главна буква");}
		else if  (!$lowercase ) { array_push($errors, "Паролата трябва да има поне една малка буква");}
		else if  (!$number ) { array_push($errors, "Паролата трябва да има поне едно число");}
		else if  (!$specialChars) { array_push($errors, "Паролата трябва да има поне един специален символ");}
		else if ($Password_1 != $Password_2) { array_push($errors, "Двете пароли не съвпадат");}
		if($Course == 'Null') { array_push($errors, "Моля, изберете Курс");}
		if($EducationType == 'Null') { array_push($errors, "Моля, изберете Тип образование");}
			$registration_check_query = "SELECT * FROM registration WHERE Username='$Username' OR FacultyNumber='$FacultyNumber' LIMIT 1";
			$result = mysqli_query($db, $registration_check_query);
			$user = mysqli_fetch_assoc($result);
		if ($user) { 
			if ($user['Username'] === $Username) { array_push($errors, "Потребителското име вече съществува");}
			if ($user['FacultyNumber'] === $FacultyNumber) { array_push($errors, "Факултетният номер вече съществува");}
		}

		// Регистриране на потребителя, ако няма грешки във формата
		if (count($errors) == 0) {
			$query = "INSERT INTO registration (Username, FacultyNumber, FirstName, LastName, Password, Speciality, Course, EducationType) 
				VALUES('$Username', '$FacultyNumber', '$FirstName', '$LastName', '$Password_1', '$Speciality', '$Course', '$EducationType')";
			mysqli_query($db, $query);
			$_SESSION['username'] = $Username;
			$_SESSION['success'] = "Влязохте успешно в системата";
			header('location: Register.php');
		}
	}
	if (isset($_POST['login_user'])) {
		$Username = mysqli_real_escape_string($db, $_POST['Username']);
		$Password = mysqli_real_escape_string($db, $_POST['Password']);
		if (empty($Username)) { array_push($errors, "Потребителско име е задължително");}
		if (empty($Password)) { array_push($errors, "Паролата е задължителна"); }

		if (count($errors) == 0) {
				$query = "SELECT * FROM registration WHERE Username='$Username' AND Password='$Password'";
				$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $Username;
				$_SESSION['success'] = "Влязохте успешно в системата";
			header('location: index.php');
		}else{
			array_push($errors, "Грешно потребителско име или парола");
			}
		}
	}
// Качва файловете
	if (isset($_POST['save'])) {
		$Title = mysqli_real_escape_string($db, $_POST['Title']);
		if (empty($Title)) { array_push($errors, "Заглавието е задължително"); }
		$filename = $_FILES['myfile']['name'];
		$destination = 'uploads/' . $filename;
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$file = $_FILES['myfile']['tmp_name'];
		$size = $_FILES['myfile']['size'];
		if (!in_array($extension, ['zip'])) { array_push($errors, "Вашето разширение на файла трябва да бъде .zip");
		}elseif ($_FILES['myfile']['size'] > 100000000) { array_push($errors, "Файлът е твърде голям, трябва да е по-малък от 1 Megabyte");}
		$files_check_query = "SELECT * FROM files WHERE Title='$Title' OR Name='$filename' LIMIT 1";
		$Result = mysqli_query($db, $files_check_query);
		$File = mysqli_fetch_assoc($Result);
		
		// Ако потребителят съществува
		if ($File) { 
			if ($File['Title'] === $Title) { array_push($errors, "Заглавието вече съществува");}
			if ($File['Name'] === $filename) {array_push($errors, "Файл с това име вече съществува");}
		}
        if (count($errors) == 0) {
			if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (Title,UploadDate,Name,Size) VALUES ('$Title', CURRENT_TIMESTAMP,'$filename','$size')";
			mysqli_query($db, $sql);
			$_SESSION['username'] = $Username;
			$_SESSION['success'] = "Влязохте успешно в системата";
			header('location: index.php');
			}
    
		}
	}
	
	if (isset($_GET['file_id'])) {
		$id = $_GET['file_id'];
		// Извличане на файл от база данни
		$sql = "SELECT * FROM files WHERE id=$id";
		$result = mysqli_query($db, $sql);
		$file = mysqli_fetch_assoc($result);
		$filepath = 'uploads/' . $file['Name'];
		if (file_exists($filepath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($filepath));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize('uploads/' . $file['Name']));
			readfile('uploads/' . $file['Name']);
		}
	}
?>
