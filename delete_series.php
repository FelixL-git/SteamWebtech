<?php
include './db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	session_start();
    $series_id = $_POST['series_id'];

    // Erstelle die Verbindung
    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $sql = "DELETE FROM series WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $series_id); // parajmeter werden als values eingesetzt i=integer

    if ($stmt->execute()) {
		header('Location: dashboard.php');
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>