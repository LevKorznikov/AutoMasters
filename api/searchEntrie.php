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

$data = json_decode(file_get_contents("php://input", true));

// Проверяем валидность и роль => производим поиск
$is_jwt_valid = is_jwt_valid($bearer_token);
if($is_jwt_valid && $payload->role == 'admin') {
    $full_name = $_GET['full_name'];
    $sql = "SELECT * FROM Entries WHERE full_name = '$full_name'";
	
	$result = mysqli_query($dbConn, $sql);
	
    $rows = array();

	while($row = dbFetchAssoc($result)) {
		$rows[] = $row;
	}
	
	if($rows != null) {
        echo json_encode($rows);
    } else {
        echo json_encode(array('Ошибка' => 'Ничего не найдено'));
    }
} else {
	echo json_encode(array('Ошибка' => 'Отказано в доступе'));
}

