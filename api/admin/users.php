<?php
require_once "../config/db.php";

$db = getDB();

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

if ($method === "GET") {

    if ($id) {
        $stmt = $db->prepare("
            SELECT UserID, Name, Email, Phone, RoleID, Status, CreatedAt
            FROM Users
            WHERE UserID = ?
        ");
        $stmt->execute([$id]);
        jsonResponse(["data" => $stmt->fetch()]);
    }

    $stmt = $db->query("
        SELECT UserID, Name, Email, Phone, RoleID, Status, CreatedAt
        FROM Users
        ORDER BY CreatedAt DESC
    ");

    jsonResponse(["data" => $stmt->fetchAll()]);
}

if ($method === "PUT") {

    $data = getBody();

    $stmt = $db->prepare("
        UPDATE Users
        SET Name = ?, Email = ?, Phone = ?, RoleID = ?, Status = ?
        WHERE UserID = ?
    ");

    $stmt->execute([
        $data["name"],
        $data["email"],
        $data["phone"],
        $data["role_id"],
        $data["status"],
        $id
    ]);

    jsonResponse(["success" => true]);
}

if ($method === "DELETE") {

    $stmt = $db->prepare("
        UPDATE Users SET Status = 'Banned' WHERE UserID = ?
    ");

    $stmt->execute([$id]);

    jsonResponse(["success" => true]);
}