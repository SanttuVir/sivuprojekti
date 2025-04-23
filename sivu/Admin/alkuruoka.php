<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, DELETE");

$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "menu_db"; // Update as needed


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Tietokantayhteys epäonnistui"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add or update Alkuruoka (menu item)
    $name = $conn->real_escape_string($_POST['name']);
    $tietoa = $conn->real_escape_string($_POST['tietoa']);
    $hinta = isset($_POST['hinta']) ? $conn->real_escape_string($_POST['hinta']) : null;
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;

    if ($id) {
        // Update existing item
        $sql = "UPDATE alkuruoat SET name = '$name', tietoa = '$tietoa', hinta = '$hinta' WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Alkuruoka päivitetty"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe päivittäessä tietoja: " . $conn->error]);
        }
    } else {
        // Insert new item
        $sql = "INSERT INTO alkuruoat (name, tietoa, hinta) VALUES ('$name', '$tietoa', '$hinta')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Alkuruoka lisätty onnistuneesti"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe lisättäessä tietoja: " . $conn->error]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve all Alkuruoka items
    $sql = "SELECT * FROM alkuruoat";
    $result = $conn->query($sql);
    $alkuruoat = [];

    while ($row = $result->fetch_assoc()) {
        $alkuruoat[] = $row;
    }
    echo json_encode($alkuruoat);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Delete a specific Alkuruoka item
    $id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : null;

    if ($id) {
        $sql = "DELETE FROM alkuruoat WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Alkuruoka poistettu"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe poistaessa tietoja: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "ID puuttuu"]);
    }
}

$conn->close();
?>
