<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poytavaraus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Yhteys epäonnistui: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM reservations WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Varaus poistettu onnistuneesti.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Virhe poistettaessa varausta: ' . $conn->error]);
    }
}

$conn->close();
?>
