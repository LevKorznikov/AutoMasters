<?php

// Подключение пакетов
require_once 'db.php';
require_once 'jwt_utils.php';

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// Получаем токен
$bearer_token = get_bearer_token();

// Парсим payload из токена
$payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $bearer_token)[1]))));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Получение данных из тела запроса
	$data = json_decode(file_get_contents("php://input", true));

	// Проверяем валидность => делаем запись
	$is_jwt_valid = is_jwt_valid($bearer_token);
	if($is_jwt_valid) {
		$sql = "INSERT INTO Entries(user_id, full_name, phone_number, car_number, car_brand, service_type, status) VALUES(
		'" . mysqli_real_escape_string($dbConn, $payload->id) . "', 
		'" . mysqli_real_escape_string($dbConn, $data->full_name) . "', 
		'" . mysqli_real_escape_string($dbConn, $data->phone_number) . "',
		'" . mysqli_real_escape_string($dbConn, $data->car_number) . "',
		'" . mysqli_real_escape_string($dbConn, $data->car_brand) . "',
		'" . mysqli_real_escape_string($dbConn, $data->service_type) . "',
		'" . mysqli_real_escape_string($dbConn, $data->status) . "')";
	
		$result = dbQuery($sql);
		if($result) {
			echo json_encode(array('Успешно' => 'Запись создана'));
		} else {
			echo json_encode(array('Ошибка' => '???'));
		}
	} else {
		echo json_encode(array('Ошибка' => 'Отказано в доступе'));
	}

}
