<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = "localhost";
$dbname = "lahjakortit";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, email, amount, message FROM giftcards ORDER BY id DESC");
    $giftcards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($giftcards);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
