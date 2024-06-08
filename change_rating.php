<?php
//Nicht-REST
/*
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
*/
//REST

$curl = curl_init();

$username = $_POST['username'];
$series_id = $_POST['series_id'];
$rating = $_POST['rating'];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/user/' . $username . '/change_rating',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => $username,'series_id' => $series_id, 'rating' => $rating),
));

$response = curl_exec($curl);

if (json_decode($response)->{"status"} == "success") {
	header('Location: dashboard.php');
} else {
    echo "Fehler beim ändern des Rating mittels REST";
    echo "<br>user: $username";
    echo "<br>series_id: $series_id";
    echo "<br>rating: $rating";
}
?>