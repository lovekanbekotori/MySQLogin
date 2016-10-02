<?php
include 'config.php';
$server = $config['server'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];
$usr_username = $_POST['username'];
$usr_password = $_POST['password'];
$usr_username = stripcslashes($usr_username);
$usr_password = stripcslashes($usr_password);
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users WHERE username='{$usr_username}'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
if (password_verify($usr_password, $row["password"])) {
	echo 'true->' . strtolower($usr_username);
} else {
	echo 'false->' . strtolower($usr_username);
}
$conn->close();
?>