<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$data = getBody();
$db = getDB();

$stmt = $db->prepare("
INSERT INTO Orders (BuyerID, ProductID, TotalAmount, ShippingAddress)
VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $data["buyer_id"],
    $data["product_id"],
    $data["total"],
    $data["address"] ?? ""
]);

jsonResponse(["success" => true]);