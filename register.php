<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];

		if($password != $password2) {
			readfile("./index.html");
			echo '<center><p class="warning"> The passwords are not identical. </p></center>';
			die();
		}

		$url = 'http://127.0.0.1:5000/register';
    	$data = array(
        'username' => $username,
        'password' => $password
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
        curl_close($ch);
        exit();
    }

    curl_close($ch);

    $response_data = json_decode($response, true);

	// Check for JSON decode errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
        exit();
    }

    if ($http_status == 201 && isset($response_data["status"]) && $response_data["status"] == "success") {
        session_start();
        $_SESSION["username"] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        readfile("./index.html");
        if ($response_data === null) {
            echo '<center><p class="warning"> Invalid JSON response </p></center>';
        } else {
            echo '<center><p class="warning"> ' . htmlspecialchars($response_data['message']) . ' </p></center>';
        }
        die();
	
		}
	}
?>
