<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$data = getBody();
$db = getDB();

$stmt = $db->prepare("SELECT * FROM Users WHERE Email = ?");
$stmt->execute([$data["email"]]);
$user = $stmt->fetch();

if (!$user || !password_verify($data["password"], $user["Password"])) {
    jsonResponse(["error" => "Invalid credentials"], 401);
}

jsonResponse([
    "success" => true,
    "user" => [
        "id" => $user["UserID"],
        "name" => $user["Name"],
        "role" => $user["RoleID"]
    ]
]);