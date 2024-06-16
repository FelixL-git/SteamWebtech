<?php
include './db_config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $series_id = $_POST['series_id'];


    session_start();
    $username = $_SESSION["username"];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://127.0.0.1:5000/user/' . $username . '/series' . '/' . $series_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        ));

    $response = curl_exec($curl);

    curl_close($curl);

    if (json_decode($response)->{"status"} == "success") {
        session_start();
	    $_SESSION["username"] = $username;
	    header('Location: dashboard.php');
    } else {
    readfile("./index.html");
    echo '<center><p class="warning"> Serie nicht gefunden. </p></center>';
    }
}
?>