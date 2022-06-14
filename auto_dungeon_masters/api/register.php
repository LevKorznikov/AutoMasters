<?php

// Подключение пакетов
require_once 'db.php';

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Получение данных из тела запроса
	$data = json_decode(file_get_contents("php://input", true));
	$role = "user";
	$salt = bin2hex(random_bytes(10));

	$password = hash('sha256', $data->password.$salt);  

	$sql = "INSERT INTO Users(username, password, salt, role) VALUES('" . mysqli_real_escape_string($dbConn, $data->username) . "', '" . mysqli_real_escape_string($dbConn, $password) . "', '" . mysqli_real_escape_string($dbConn, $salt) . "', '" . mysqli_real_escape_string($dbConn, $role) . "')";
	
	$result = dbQuery($sql);
	
	if($result) {
		echo json_encode(array('Успешно' => 'Вы зарегистрированы'));
	} else {
		echo json_encode(array('Ошибка' => '???'));
	}
}
