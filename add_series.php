<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $platform = $_POST['platform'];
    $seasons = $_POST['seasons'];

    session_start();
    $username = $_SESSION["username"];

    $url = 'http://127.0.0.1:5000/user/' . $username . '/series';
    $data = array(
        'title' => $title,
        'genre' => $genre,
        'platform' => $platform,
        'seasons' => $seasons,
        'username' => $username
    );

    // Build the HTTP query string
    $post_fields = http_build_query($data);

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_fields,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        CURLOPT_RETURNTRANSFER => true
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Print raw response for debugging
    echo 'Raw response: ' . htmlspecialchars($response) . '<br>';
    echo 'HTTP status: ' . $http_status . '<br>';

    $response_data = json_decode($response, true);

    // Check for JSON decode errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
    }

    if ($http_status == 200 && isset($response_data["status"]) && $response_data["status"] == "success") {
        header('Location: dashboard.php');
        exit();
    } else {
        
        if ($response_data === null) {
            echo 'Fehler: Invalid JSON response';
        } else {
            echo 'Fehler: ' . $response_data['message'];
        }
    }
}
?>