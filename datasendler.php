<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require_once 'phpmailer/src/Exception.php';
	require_once 'phpmailer/src/PHPMailer.php';
	require_once __DIR__ . '/classes/Uploader.php';
	require_once __DIR__ . '/classes/Db.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('summer_practise@anreyz.tmweb.ru', 'Test send');
	//Кому отправить
	$mail->addAddress('summer_practise@anreyz.tmweb.ru');
	//Тема письма
	$mail->Subject = 'Отклик на вакансию!"';
	$gender = "male";
	if(isset($_POST['gender']) && ($_POST['gender'] == "female")){
		$gender = "female";
	} 
	//Тело письма
	$body = '';
	if(trim(!empty($_POST['developer']))){
		$developer = $_POST['developer'];
		$body = '<h1>Резюме на должность ' . $developer . '</h1>';
	} else {
		$body.='<h1>Резюме, должность обсудим на собеседовании </h1>';
		$developer = "Отсутсвует";
	}
	if(trim(!empty($_POST['name']))){
		$name = $_POST['name'];
		$body.='<p><strong>Имя:</strong> '. $name .'</p>';
	}
	if(trim(!empty($_POST['surname']))){
		$surname = $_POST['surname'];
		$body.='<p><strong>Фамилия:</strong> '. $surname .'</p>';
	}
	if(trim(!empty($_POST['email'])) && preg_match('|^[-0-9A-Za-z_\.]+@[-0-9A-Za-z^\.]+\.[a-z]{2,6}$|i', $_POST['email']) ){
		$email = $_POST['email'];
		$body.='<p><strong>E-mail:</strong> '. $email .'</p>';
	}
	if(trim(!empty($_POST['gender']))){
		$gender = $_POST['gender'];
		$body.='<p><strong>Пол:</strong> '. $gender .'</p>';
	}
	if(trim(!empty($_POST['chb']))){
        $str_cnb = implode(",",$_POST['chb']);
		$body.='<p><strong>Навыки:</strong> '. $str_cnb .'</p>';	
	} else {
		$str_cnb = 'отсутсвуют!';
		$body.='<p><strong>Навыки:</strong> '. $str_cnb .'</p>';	
	}
	if(trim(!empty($_POST['message']))){
		$message = $_POST['message'];
		$body.='<p><strong>О себе:</strong> '. $message .'</p>';
	} else {
		$message = 'информация отсутвует!';	
	}

	if (!empty($_FILES['image']['tmp_name'])){
		$uploaded = $_FILES['image'];
		$fileTmpPath = $_FILES['image']['tmp_name'];
		$filename = $_FILES['image']['name'];
		$uploadedFiles = new Uploader($uploaded);
		$uploadedFiles->isUploaded();
		$fileAttach = __DIR__ . '/files/' . $_FILES['image']['name'];
		$body.='<p><strong>Фото в приложении</strong>';
		$mail->addAttachment($fileAttach);
		
	} else {
		$fileAttach = __DIR__ . '/files/not_photo.png';
		$body.='<p><strong>Фото отсутсвует!</strong>';
		$fileTmpPath = 'Нет фото!';
		$filename = 'not_photo.png';
		$mail->addAttachment($fileAttach);

	}
	if(trim(!empty($_POST['agreement']))){
		$agreement = 1;
		$body.='<p><strong>Подписал соглашение!</strong></p>';
	} else {
		$agreement = 0;
		$body.='<p><strong>Не подписал соглашене!</strong></p>';
	}

	$connect = new Db();
	try{
		$connect->query("INSERT INTO `application` (application_id, name, surname, email, gender, agreement, application_date) VALUES (NULL, :name, :surname, :email, :gender, :agreement, NOW());",
			[':name' => $name,':surname' => $surname, ':email' => $email, ':gender' => $gender, ':agreement' => $agreement]);

		$connect->query("INSERT INTO about_myself (info_id, developer, skills, about_me, application_id_fk) VALUES (LAST_INSERT_ID(), :developer, :skills, :about_me, LAST_INSERT_ID());",
			[':developer' => $developer, ':skills' => $str_cnb, ':about_me' => $message]);


		$connect->query("INSERT INTO `file` (`file_id`, `file__name`, `file_path`, `file_tmp_path`, `application_id`) VALUES (LAST_INSERT_ID(), :file__name, :file_path, :file_tmp_path, LAST_INSERT_ID());",
			[':file__name' => $filename, ':file_path' => $fileAttach, ':file_tmp_path' => $fileTmpPath]);
	
	} catch(PDOException $e) {
		die ("ERROR: " . $e->getMessage());
	}
		
	$mail->Body = $body;

	if (!$mail->send()) {
		$message = 'Ошибка';
		header('location: /');
	} else {
		$message = 'Данные отправлены!';
		header('location: /');
	}
	
	//$response = ['message' => $message];	
	//header('Content-type: application/json');
	//echo json_encode($response);
?>

