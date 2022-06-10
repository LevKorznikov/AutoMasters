<?php

// Подключение пакетов
require_once 'db.php';
require_once 'jwt_utils.php';

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Получение данных из тела запроса
	$data = json_decode(file_get_contents("php://input", true));

	// Достаем соль
	$sql1 = "SELECT salt FROM Users WHERE username = '" . mysqli_real_escape_string($dbConn, $data->username) . "' LIMIT 1";
	$result1 = dbQuery($sql1);
	$row = dbFetchAssoc($result1);
	
	// Хэшируем пароль и сравниваем с хэшем в БД
	$password = hash('sha256', $data->password.$row['salt']);  
	$sql = "SELECT * FROM Users WHERE username = '" . mysqli_real_escape_string($dbConn, $data->username) . "' AND password = '" . mysqli_real_escape_string($dbConn, $password) . "' LIMIT 1";
	
	$result = dbQuery($sql);

    // Выдача токена
	if(dbNumRows($result) < 1) {
		echo json_encode(array('Ошибка' => 'Неправильное имя пользователя или пароль'));
	} else {
		$row = dbFetchAssoc($result);
		
		$id = $row['id'];
		$username = $row['username'];
		$role = $row['role'];
		
		$headers = array('alg'=>'HS256','typ'=>'JWT');
		$payload = array('id' => $id, 'username'=>$username, 'role' => $role, 'exp' => (time() + 60 * 60 * 24));

		$jwt = generate_jwt($headers, $payload);
		
		echo json_encode(array('token' => $jwt));
	}
}

