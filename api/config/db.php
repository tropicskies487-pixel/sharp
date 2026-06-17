<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
function getDB(): PDO {

    $host = getenv("MYSQLHOST") ?: getenv("DB_HOST");
    $db   = getenv("MYSQLDATABASE") ?: getenv("DB_NAME");
    $user = getenv("MYSQLUSER") ?: getenv("DB_USER");
    $pass = getenv("MYSQLPASSWORD") ?: getenv("DB_PASS");
    $port = getenv("MYSQLPORT") ?: 3306;

    if (!$host || !$db || !$user) {
        throw new Exception("Database environment variables not set correctly.");
    }

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

function getBody() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}