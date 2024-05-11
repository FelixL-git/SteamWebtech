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
		$password2 = $_POST['password2'];
		if($password != $password2) {
			readfile("./index.html");
			echo '<center><p class="warning"> The passwords are not identical. </p></center>';
			$conn->close();
			die();
		}
		
		$sql = "SELECT 'username' FROM user WHERE username = '" . $username . "';";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			readfile("./index.html");
			echo '<center><p class="warning"> A user with this name already exists. </p></center>';
			$conn->close();
			die();
		} else {
			$sql = "INSERT INTO user (username, password) VALUES (?, ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ss", $username, $password);
			if ($stmt->execute()) {
				session_start();
				$_SESSION["username"] = $username;
				header('Location: dashboard.php');
			} else {
				readfile("./index.html");
				echo '<center><p class="warning"> Failed to register new user. </p></center>';
				$conn->close();
				die();
			}
		}
		$conn->close();
		die();
		
	}
?>
