<?php
include './db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	session_start();
    $series_id = $_POST['series_id'];
    $username = $_POST['username'];
    $rating = $_POST['rating'];

    // Erstelle die Verbindung
    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $sql = "UPDATE series SET Bewertung = ? WHERE id = ? AND username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $rating, $series_id, $username); 

    if ($stmt->execute()) {
		header('Location: dashboard.php');
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>