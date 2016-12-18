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

$usr_username = "test";
$usr_password = "pass";

try {
    $db = new PDO("mysql:host={$server};dbname={$dbname}", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
     echo $e->getMessage();
}

$sql = $db->prepare("SELECT * FROM users WHERE username=:username");
try {
	$sql->execute(array(':username' => $usr_username));
	$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
	if (password_verify($usr_password, $rows[0]["password"])) {
		echo 'true->' . strtolower($usr_username);
	} else {
		echo 'false->' . strtolower($usr_username);
	}
}
catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
}
?>