<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$data = getBody();
$db = getDB();

$stmt = $db->prepare("
INSERT INTO Products
(UserID, CategoryID, Name, Description, Price, `Condition`, Location, Images)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $data["user_id"],
    $data["category_id"],
    $data["name"],
    $data["description"],
    $data["price"],
    $data["condition"] ?? "Good",
    $data["location"] ?? null,
    json_encode($data["images"] ?? [])
]);

jsonResponse(["success" => true]);