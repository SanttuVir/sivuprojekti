<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


$host = "localhost";
$dbname = "lahjakortit";
$username = "root";
$password = ""; 


$data = json_decode(file_get_contents("php://input"), true);


if (!isset($data['name'], $data['email'], $data['amount'])) {
    echo json_encode(["success" => false, "message" => "Pakollisia kenttiä puuttuu."]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $pdo->prepare("INSERT INTO giftcards (name, email, amount, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $data['name'],
        $data['email'],
        $data['amount'],
        $data['message'] ?? null 
    ]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
