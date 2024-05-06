<!DOCTYPE html>
<html lang="de">
	<head>
		<title>Steam - Login</title>
		<link rel="stylesheet" href="./style.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
				
				$sql = "SELECT 'username' FROM user WHERE username = '" . $username . "' AND password = '" . $password . "';";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
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
				
			}
		?>
	</body>
</html>