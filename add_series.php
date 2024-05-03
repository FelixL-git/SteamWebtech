<?php
include './db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $platform = $_POST['platform'];
    $seasons = $_POST['seasons'];
	session_start();
    $username = $_SESSION["username"];

    // Erstelle die Verbindung
    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $sql = "INSERT INTO series (Titel, Genre, Plattform, Staffeln, username) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $title, $genre, $platform, $seasons, $username); // parajmeter werden als values eingesetzt s=string, i=integer

    if ($stmt->execute()) {
		header('Location: dashboard.php');
        //echo "Neue Serie erfolgreich hinzugefügt!";
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>