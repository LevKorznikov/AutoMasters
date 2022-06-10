<?php

// Подключение пакетов
require_once 'db.php';
require_once 'jwt_utils.php';

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

// Получаем токен
$bearer_token = get_bearer_token();

// Парсим payload из токена
$payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $bearer_token)[1]))));

// Получение данных из тела запроса
$data = json_decode(file_get_contents("php://input", true));

// Проверяем валидность и роль => удаляем запись
$is_jwt_valid = is_jwt_valid($bearer_token);
if($is_jwt_valid && $payload->role == 'admin') {
	$sql = "DELETE FROM Entries
	WHERE user_id='$data->user_id'";

	$result = dbQuery($sql);
	if($result) {
		echo json_encode(array('Успешно' => 'Запись удалена'));
	} else {
		echo json_encode(array('Ошибка' => '???'));
	}
} else {
	echo json_encode(array('Ошибка' => 'Отказано в доступе'));
}

