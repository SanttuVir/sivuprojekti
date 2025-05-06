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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch messages from the database
    $stmt = $conn->prepare("SELECT id, name, email, subject, message, created_at FROM submissions ORDER BY created_at DESC");
    
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if there are any messages
    if ($result->num_rows > 0) {
        // Prepare the data to send as a JSON response
        $submissions = [];
        while ($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        }
        echo json_encode($submissions);
    } else {
        echo json_encode(["success" => false, "message" => "No messages found."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

// Close connection
$conn->close();
?>
