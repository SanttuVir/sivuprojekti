<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poytavaraus";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$query = "SELECT id, name, date, time, people, email FROM reservations";
$result = $conn->query($query);

$reservations = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

$conn->close();

echo json_encode($reservations);
?>
