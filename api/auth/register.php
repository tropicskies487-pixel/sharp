<?php
require_once "../config/db.php";

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