<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "menu_db"; // Update as needed

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Tietokantayhteys epäonnistui"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add or update Paaruoka (menu item)
    $name = $conn->real_escape_string($_POST['name']);
    $tietoa = $conn->real_escape_string($_POST['tietoa']);
    $hinta = isset($_POST['hinta']) ? $conn->real_escape_string($_POST['hinta']) : null;
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;

    if ($id) {
        // Update existing item
        $sql = "UPDATE paaruoka SET name = '$name', tietoa = '$tietoa', hinta = '$hinta' WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Paaruoka päivitetty"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe päivittäessä tietoja: " . $conn->error]);
        }
    } else {
        // Insert new item
        $sql = "INSERT INTO paaruoka (name, tietoa, hinta) VALUES ('$name', '$tietoa', '$hinta')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Paaruoka lisätty onnistuneesti"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe lisättäessä tietoja: " . $conn->error]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve all Paaruoka items
    $sql = "SELECT * FROM paaruoka";
    $result = $conn->query($sql);
    $paaruoka = [];

    while ($row = $result->fetch_assoc()) {
        $paaruoka[] = $row;
    }
    echo json_encode($paaruoka);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Delete a specific Paaruoka item
    $id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : null;

    if ($id) {
        $sql = "DELETE FROM paaruoka WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Paaruoka poistettu"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe poistaessa tietoja: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "ID puuttuu"]);
    }
}

$conn->close();
?>
