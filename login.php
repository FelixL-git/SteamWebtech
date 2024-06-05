<?php

$curl = curl_init();

$username = $_POST['username'];
$password = $_POST['password'];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:5000/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => $username,'password' => $password),
));

$response = curl_exec($curl);

if (json_decode($response)->{"status"} == "success") {
	session_start();
	$_SESSION["username"] = $username;
	header('Location: dashboard.php');
} else {
readfile("./index.html");
echo '<center><p class="warning"> Die eingegebenen Anmeldeinformationen sind falsch. </p></center>';
}



/* 	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "webtechsteam";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Verbindung fehlgeschlagen: " . $conn->connect_error);
		}
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		//$sql = "SELECT 'username' FROM user WHERE username = '" . $username . "' AND password = '" . $password . "';";
		$result = file_get_contents('127.0.0.1:5000/login')
		
		if (json_decode($result) == success) {
			session_start();
			$_SESSION["username"] = $username;
			header('Location: dashboard.php');
			//echo "<h1>Erfolgreich eingeloggt</h1>";
		} else {
			readfile("./index.html");
			echo '<center><p class="warning"> Die eingegebenen Anmeldeinformationen sind falsch. </p></center>';
		}
		$conn->close();
		die();
		
	} */
?>
