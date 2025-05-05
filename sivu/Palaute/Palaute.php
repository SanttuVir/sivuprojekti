<?php
$host = 'localhost';
$dbname = 'feedback_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed!']);
    exit();
}

$user_ip = $_SERVER['REMOTE_ADDR'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM feedbacks WHERE user_ip = :user_ip");
    $stmt->bindParam(':user_ip', $user_ip);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'You have already submitted feedback.']);
        exit();
    }

    $name = htmlspecialchars($_POST['name']);
    $feedback = htmlspecialchars($_POST['feedback']);
    $rating = (int)$_POST['rating'];

    $sql = "INSERT INTO feedbacks (name, feedback, rating, user_ip) VALUES (:name, :feedback, :rating, :user_ip)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':feedback', $feedback);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':user_ip', $user_ip);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Thank you for your feedback!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving feedback.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT id, name, feedback, rating, created_at FROM feedbacks ORDER BY created_at DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($reviews);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = (int)$_DELETE['id'];

    $stmt = $pdo->prepare("DELETE FROM feedbacks WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Feedback deleted.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Deletion failed.']);
    }
}
?>
