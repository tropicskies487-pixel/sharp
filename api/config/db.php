<?php

function getDB() {
    $host = getenv("MYSQLHOST");
    $db   = getenv("MYSQLDATABASE");
    $user = getenv("MYSQLUSER");
    $pass = getenv("MYSQLPASSWORD");
    $port = getenv("MYSQLPORT");

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

function getBody() {
    return json_decode(file_get_contents("php://input"), true);
}