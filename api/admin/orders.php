<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$db = getDB();

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

if ($method === "GET") {

    if ($id) {
        $stmt = $db->prepare("
            SELECT o.*, u.Name AS BuyerName, p.Name AS ProductName
            FROM Orders o
            JOIN Users u ON o.BuyerID = u.UserID
            JOIN Products p ON o.ProductID = p.ProductID
            WHERE o.OrderID = ?
        ");
        $stmt->execute([$id]);
        jsonResponse(["data" => $stmt->fetch()]);
    }

    $stmt = $db->query("
        SELECT o.*, u.Name AS BuyerName, p.Name AS ProductName
        FROM Orders o
        JOIN Users u ON o.BuyerID = u.UserID
        JOIN Products p ON o.ProductID = p.ProductID
        ORDER BY o.OrderDate DESC
    ");

    jsonResponse(["data" => $stmt->fetchAll()]);
}

if ($method === "PUT") {

    $data = getBody();

    $stmt = $db->prepare("
        UPDATE Orders SET Status = ?
        WHERE OrderID = ?
    ");

    $stmt->execute([
        $data["status"],
        $id
    ]);

    jsonResponse(["success" => true]);
}