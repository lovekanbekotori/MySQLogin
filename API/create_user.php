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
$usr_password = password_hash($usr_password, PASSWORD_BCRYPT);
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "INSERT INTO users (id, username, password)
VALUES ('', '{$usr_username}', '{$usr_password}')";
$sqlUsernameCheck = "SELECT * FROM users WHERE username='{$usr_username}'";
$usrCheckResult = $conn->query($sqlUsernameCheck);
$usrCheckData = mysqli_fetch_assoc($usrCheckResult);
$usrMatchPass = $usrCheckData["password"];
if (strlen($usrMatchPass) <= 1) {
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} else {
	echo "Username already taken.";
}
$conn->close();
?>