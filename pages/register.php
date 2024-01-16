<?php
// Change this to your connection info.
$dtb_host = "localhost";
$dtb_name = "ternakkuy";
$dtb_pass = "root";
$dtb_password = "";
// Try and connect using the info above.
$conn = mysqli_connect($dtb_host, $dtb_pass, $dtb_password, $dtb_name);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['email'], $_POST['phonenumber'], $_POST['password'] )) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['phonenumber']) || empty($_POST['password'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Password must be between 5 and 20 characters long!');
}

// We need to check if the account with that username exists.
if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
        // Username doesn't exists, insert new account
        if ($stmt = $conn->prepare('INSERT INTO users (username, email, phonenumber, password) VALUES (?, ?, ?, ?)')) {
        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bind_param('ssss', $_POST['username'], $_POST['email'], $_POST['phonenumber'], $password);
        $stmt->execute();
        echo 'You have successfully registered! You can now login!';
        header('Location: login.html');
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all three fields.
	echo 'Could not prepare statement!';
}
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$conn->close();
?>