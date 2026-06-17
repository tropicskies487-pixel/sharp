<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$db = getDB();

$stmt = $db->query("
SELECT o.*, p.Name AS ProductName, u.Name AS BuyerName
FROM Orders o
JOIN Products p ON o.ProductID = p.ProductID
JOIN Users u ON o.BuyerID = u.UserID
ORDER BY o.OrderDate DESC
");

jsonResponse(["data" => $stmt->fetchAll()]);