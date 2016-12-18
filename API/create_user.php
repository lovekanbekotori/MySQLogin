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

try {
    $db = new PDO("mysql:host={$server};dbname={$dbname}", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
     echo $e->getMessage();
}

$sql = $db->prepare("INSERT INTO users (id, username, password) VALUES (:id, :user, :pass)");
$affected_rows = 0;
try {
	$affected_rows = $sql->execute(array(':id' => '', ':user' => $usr_username, ':pass' => $usr_password));
}
catch (PDOException $e) {
    echo $e->getMessage() . "<br>"; //Handle duplicate id's
}

$usrCheckResult = $db->query("SELECT * FROM users WHERE username='{$usr_username}'");
$usrCheckData = $usrCheckResult->fetch(PDO::FETCH_ASSOC);

if (count($usrCheckData) == 0) { //Check if username exists already
	if ($affected_rows != 0) { //Ensure nothing went wrong (redundant)
		echo "New record created successfully.";
	} else {
		echo "SQL State: " . $db->errorInfo()[0] . "<br>Error Code: " . $db->errorInfo()[1] . "<br>Error Message: " . $db->errorInfo()[2] . "<br>";
	}
} else {
	echo "Username already taken.";
}
?>