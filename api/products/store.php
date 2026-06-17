<?php
require_once "../config/db.php";

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