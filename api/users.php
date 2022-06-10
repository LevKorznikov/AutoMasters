<?php

// Подключение пакетов
require_once 'db.php';
require_once 'jwt_utils.php';

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// Получаем токен
$bearer_token = get_bearer_token();

// Парсим payload из токена
$payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $bearer_token)[1]))));

// Проверяем валидность и роль => отдаем данные
$is_jwt_valid = is_jwt_valid($bearer_token);
if($is_jwt_valid && $payload->role == 'admin') {
	$sql = "SELECT * FROM Users";
	$results = dbQuery($sql);

	$rows = array();

	while($row = dbFetchAssoc($results)) {
		$rows[] = $row;
	}

	echo json_encode($rows);
} else if ($is_jwt_valid && $payload->role == 'user'){
	echo json_encode(array('username' => $payload->username, 'role' => $payload->role));
} else {
	echo json_encode(array('Ошибка' => 'Отказано в доступе'));
}

