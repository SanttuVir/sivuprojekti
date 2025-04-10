<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root"; // Muuta tarvittaessa
$password = ""; // Muuta tarvittaessa
$dbname = "menudb"; // Muuta tarvittaessa

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Tietokantayhteys epäonnistui"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        // Muokkaa olemassa olevaa alkuruokaa
        $id = $conn->real_escape_string($_POST['id']);
        $name = $conn->real_escape_string($_POST['name']);
        $tietoa = $conn->real_escape_string($_POST['tietoa']);

        $sql = "UPDATE menu SET name = '$name', tietoa = '$tietoa' WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Alkuruoka päivitetty"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe päivittäessä tietoja: " . $conn->error]);
        }
    } else {
        // Lisää uusi alkuruoka
        $name = $conn->real_escape_string($_POST['name']);
        $tietoa = $conn->real_escape_string($_POST['tietoa']);

        $sql = "INSERT INTO menu (name, tietoa) VALUES ('$name', '$tietoa')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Alkuruoka lisätty onnistuneesti"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Virhe lisättäessä tietoja: " . $conn->error]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);
    $alkuruoat = [];

    while ($row = $result->fetch_assoc()) {
        $alkuruoat[] = $row;
    }
    echo json_encode($alkuruoat);
}

$conn->close();
