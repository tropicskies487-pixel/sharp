<?php
require_once "../config/db.php";

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