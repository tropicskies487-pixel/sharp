<?php
require_once "../config/db.php";

$db = getDB();

$stmt = $db->query("
SELECT o.*, p.Name AS ProductName, u.Name AS BuyerName
FROM Orders o
JOIN Products p ON o.ProductID = p.ProductID
JOIN Users u ON o.BuyerID = u.UserID
ORDER BY o.OrderDate DESC
");

jsonResponse(["data" => $stmt->fetchAll()]);