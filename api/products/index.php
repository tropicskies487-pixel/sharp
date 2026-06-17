<?php
require_once "../config/db.php";

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