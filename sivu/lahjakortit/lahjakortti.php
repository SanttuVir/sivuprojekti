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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $message = isset($_POST['message']) ? $_POST['message'] : ''; // Jos viesti on jätetty tyhjäksi

    // Suojaamme SQL-injektioita
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $amount = $conn->real_escape_string($amount);
    $message = $conn->real_escape_string($message);

    // SQL-kysely lahjakortin lisäämiseksi tietokantaan
    $sql = "INSERT INTO gift_cards (name, email, amount, message) 
            VALUES ('$name', '$email', '$amount', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Vahvistusviesti asiakkaalle
        echo "Lahjakortti ostettu onnistuneesti! Lahjakortti on lähetetty sähköpostiisi.";
    } else {
        echo "Virhe: " . $sql . "<br>" . $conn->error;
    }
}

// Suljetaan yhteys
$conn->close();
?>
