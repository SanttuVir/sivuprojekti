<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $people = (int)$_POST['people'];

    // Basic validation
    if (!empty($name) && !empty($date) && !empty($time) && $people > 0 && $people <= 8) {
        // Simulate saving data (you can replace this with database operations)
        echo "<h2>Varaus onnistui!</h2>";
        echo "<p>Koko nimi: $name</p>";
        echo "<p>Päivämäärä: $date</p>";
        echo "<p>Aika: $time</p>";
        echo "<p>Ihmisiä: $people</p>";
    } else {
        echo "<h2>Virhe: Täytä kaikki kentät oikein.</h2>";
    }
}
?>