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
?>
