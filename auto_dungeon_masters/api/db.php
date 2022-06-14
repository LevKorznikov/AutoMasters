<?php
// Подключение к БД
$dbConn = new mysqli('localhost', 'root', '', 'automasters', '3306');

function dbQuery($sql) {
	global $dbConn;
	$result = mysqli_query($dbConn, $sql);
	return $result;
}

function dbFetchAssoc($result) {
	return mysqli_fetch_assoc($result);
}

function dbNumRows($result) {
    return mysqli_num_rows($result);
}

function closeConn() {
	global $dbConn;
	mysqli_close($dbConn);
}
