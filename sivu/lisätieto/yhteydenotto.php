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
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Prepare the data to send as a JSON response
    $submissions = [];
    while ($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }
    
    echo json_encode($submissions);
} else {
    // Handle POST request (form submission)
    $name = $email = $phone = $subject = $message = "";
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Get form data from AJAX request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate form data
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        // Check if required fields are not empty
        if (empty($name) || empty($email) || empty($message)) {
            echo json_encode(["success" => false, "message" => "Täytä kaikki kentät"]);
            exit();
        }

        // Check if the user has already submitted a form from this IP address
        $stmt = $conn->prepare("SELECT ip_address FROM submissions WHERE ip_address = ?");
        $stmt->bind_param("s", $user_ip);
        $stmt->execute();
        $stmt->store_result();

        // If the IP address already exists, block further submissions
        if ($stmt->num_rows > 0) {
            echo json_encode([ "success" => false, "message" => "Olet ottanut jo yhteyttä." ]);
            exit();
        }

        // Prepare and bind SQL statement to insert the new submission
        $stmt = $conn->prepare("INSERT INTO submissions (name, email, phone, subject, message, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $user_ip);

        // Execute the query and send the response
        if ($stmt->execute()) {
            echo json_encode([ "success" => true, "message" => "Kiitos yhteydenotosta, $name! Vastaamme mahdollisimman pian!" ]);
        } else {
            echo json_encode([ "success" => false, "message" => "Error: " . $stmt->error ]);
        }

        // Close statement and connection
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
