<?php
require_once "../config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$db = getDB();

$from = $_GET["from"] ?? date("Y-m-01");
$to   = $_GET["to"] ?? date("Y-m-d");

/* ── Summary Stats ── */

$users = $db->prepare("
    SELECT COUNT(*) FROM Users
    WHERE CreatedAt BETWEEN ? AND ?
");
$users->execute([$from, $to]);

$orders = $db->prepare("
    SELECT COUNT(*) FROM Orders
    WHERE OrderDate BETWEEN ? AND ?
");
$orders->execute([$from, $to]);

$revenue = $db->prepare("
    SELECT COALESCE(SUM(TotalAmount),0)
    FROM Orders
    WHERE OrderDate BETWEEN ? AND ?
");
$revenue->execute([$from, $to]);

/* ── Sales Over Time ── */

$sales = $db->prepare("
    SELECT DATE(OrderDate) AS day,
           COUNT(*) AS orders,
           SUM(TotalAmount) AS revenue
    FROM Orders
    WHERE OrderDate BETWEEN ? AND ?
    GROUP BY DATE(OrderDate)
    ORDER BY day ASC
");
$sales->execute([$from, $to]);

/* ── Top Products ── */

$topProducts = $db->query("
    SELECT p.Name, COUNT(o.OrderID) AS total_sold
    FROM Orders o
    JOIN Products p ON o.ProductID = p.ProductID
    GROUP BY o.ProductID
    ORDER BY total_sold DESC
    LIMIT 5
");

/* ── Top Categories ── */

$categories = $db->query("
    SELECT c.CategoryName, COUNT(o.OrderID) AS total_orders
    FROM Orders o
    JOIN Products p ON o.ProductID = p.ProductID
    JOIN Categories c ON p.CategoryID = c.CategoryID
    GROUP BY c.CategoryID
    ORDER BY total_orders DESC
    LIMIT 5
");

jsonResponse([
    "stats" => [
        "users" => (int)$users->fetchColumn(),
        "orders" => (int)$orders->fetchColumn(),
        "revenue" => (float)$revenue->fetchColumn()
    ],
    "sales" => $sales->fetchAll(),
    "top_products" => $topProducts->fetchAll(),
    "top_categories" => $categories->fetchAll()
]);