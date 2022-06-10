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
	$sql = "SELECT * FROM Entries";
	
    $result = mysqli_query($dbConn, $sql);

	$rows = array();

	while($row = dbFetchAssoc($result)) {
		$rows[] = $row;
	}
	
	echo json_encode($rows);
} else if ($is_jwt_valid && $payload->role == 'user'){
	$sql = "SELECT * FROM Entries WHERE user_id='$payload->id'";

    $result = mysqli_query($dbConn, $sql);
	
    $rows = array();

	while($row = dbFetchAssoc($result)) {
		$rows[] = $row;
	}

	echo json_encode($rows);
} else {
	echo json_encode(array('Ошибка' => 'Отказано в доступе'));
}

