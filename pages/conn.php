<?php
session_start();

$dtb_host = "localhost";
$dtb_pass = "root";
$dtb_password = "";
$dtb_name = "ternakkuy";

$conn = mysqli_connect($dtb_host, $dtb_pass, $dtb_password, $dtb_name);
if(mysqli_connect_errno()){
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])){
    exit('Isi kedua kolom username dan password!');
}

if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')) {
	
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            //echo 'Welcome ' . $_SESSION['name'] . '!';
            header('Location: productpage.php');
        } else {
            // Incorrect password
            $_SESSION['login_error'] = "Wrong username or password. Please try again.";
            header('Location: login.php');
        }
    } else {
        // Incorrect username
        $_SESSION['login_error'] = "Wrong username or password. Please try again.";
        header('Location: login.php');
    }

	$stmt->close();
}

?>