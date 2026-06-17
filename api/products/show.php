<?php
require_once "../config/db.php";

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