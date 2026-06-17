<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$data = getBody();
$db = getDB();

$stmt = $db->prepare("
INSERT INTO Users (Name, Email, Password, Phone, RoleID)
VALUES (?, ?, ?, ?, 5)
");

$stmt->execute([
    $data["name"],
    $data["email"],
    password_hash($data["password"], PASSWORD_BCRYPT),
    $data["phone"] ?? null
]);

jsonResponse(["success" => true]);