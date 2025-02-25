<?php
// Database connection
$host = 'localhost'; // Your database host
$dbname = 'feedback_db'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create a PDO instance (PHP Data Object) to interact with the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Get the user's IP address
$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user has already submitted feedback using their IP address
    $stmt = $pdo->prepare("SELECT * FROM feedbacks WHERE user_ip = :user_ip");
    $stmt->bindParam(':user_ip', $user_ip);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // User has already submitted feedback, return an error message
        echo json_encode(['status' => 'error', 'message' => 'You have already submitted feedback.']);
        exit();
    }

    // Get the form data
    $name = htmlspecialchars($_POST['name']);
    $feedback = htmlspecialchars($_POST['feedback']);
    $rating = (int)$_POST['rating']; // Assuming rating is sent as a numeric value (1 to 5)

    // Prepare SQL query to insert the feedback into the database
    $sql = "INSERT INTO feedbacks (name, feedback, rating, user_ip) VALUES (:name, :feedback, :rating, :user_ip)";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters and execute the query
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':feedback', $feedback);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':user_ip', $user_ip);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Thank you for your feedback!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'There was an error saving your feedback.']);
    }
}
?>