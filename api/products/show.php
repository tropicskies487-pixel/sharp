<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$db = getDB();
$id = $_GET["id"];

$stmt = $db->prepare("
SELECT p.*, c.CategoryName
FROM Products p
LEFT JOIN Categories c ON p.CategoryID = c.CategoryID
WHERE ProductID = ?
");

$stmt->execute([$id]);

$product = $stmt->fetch();
$product["Images"] = json_decode($product["Images"] ?? "[]", true);

jsonResponse(["data" => $product]);