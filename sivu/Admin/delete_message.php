<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID of the message to delete
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $messageId = $data['id'];

        // Prepare the delete query
        $stmt = $conn->prepare("DELETE FROM submissions WHERE id = ?");
        $stmt->bind_param("i", $messageId);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Message deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete message."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "No ID provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

// Close connection
$conn->close();
?>
