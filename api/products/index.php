<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$db = getDB();

$stmt = $db->query("
SELECT ProductID, Name, Description, Price, Images, Status
FROM Products
WHERE Status = 'Active'
");

$products = $stmt->fetchAll();

foreach ($products as &$p) {
    $p["Images"] = json_decode($p["Images"] ?? "[]", true);
}

jsonResponse(["data" => $products]);