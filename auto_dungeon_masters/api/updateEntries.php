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

// Получение данных из тела запроса
$data = json_decode(file_get_contents("php://input", true));

// Динамическое построение SET для обновления (костыль):
$request = explode('/', trim($_SERVER['REQUEST_METHOD'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0;
// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($dbConn) {
  if ($value===null) return null;
  return mysqli_real_escape_string($dbConn,(string)$value);
},array_values($input));
// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
	$set.=($i>0?',':'').'`'.$columns[$i].'`=';
  	$set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}


// Проверяем валидность => обновляем данные записи
$is_jwt_valid = is_jwt_valid($bearer_token);
if($is_jwt_valid && $payload->role == 'admin') {
	$sql = "UPDATE Entries SET $set
	WHERE user_id='$data->user_id'";

	$result = dbQuery($sql);
	if($result) {
		echo json_encode(array('Успешно' => 'Запись изменена'));
	} else {
		echo json_encode(array('Ошибка' => '???'));
	}
} else {
	echo json_encode(array('Ошибка' => 'Отказано в доступе'));
}

