<?php
// Tietokannan yhteyden tiedot
$servername = "localhost";
$username = "root";  // Käyttäjänimi
$password = "";      // Salasana
$dbname = "poytavaraus"; // Tietokannan nimi

// Yhteyden luominen
$conn = new mysqli($servername, $username, $password, $dbname);

// Tarkistetaan, että yhteys on onnistunut
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tarkistetaan, onko lomake lähetetty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Otetaan vastaan lomakkeen tiedot
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $email = $_POST['email'];

    // Suojaamme SQL-injektioita
    $name = $conn->real_escape_string($name);
    $date = $conn->real_escape_string($date);
    $time = $conn->real_escape_string($time);
    $people = $conn->real_escape_string($people);
    $email = $conn->real_escape_string($email);

    // Tarkistetaan, että käyttäjä ei ole jo tehnyt varauksia saman ajan sisällä
    $checkQuery = "SELECT * FROM reservations WHERE email = '$email' AND date = '$date' AND time = '$time'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // If a reservation already exists
        $response = [
            'success' => false,
            'message' => 'Olet jo tehnyt varauksen tälle päivälle ja ajalle.'
        ];
    } else {
        // SQL-kysely pöytavarauksen lisäämiseksi
        $sql = "INSERT INTO reservations (name, date, time, people, email) 
                VALUES ('$name', '$date', '$time', '$people', '$email')";

        if ($conn->query($sql) === TRUE) {
            $response = [
                'success' => true,
                'message' => "Varaus päivälle $date kello $time nimellä $name on onnistunut."
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Virhe: " . $sql . "<br>" . $conn->error
            ];
        }
    }

    // Send the response back to JavaScript as JSON
    echo json_encode($response);
}

// Suljetaan yhteys
$conn->close();
?>
