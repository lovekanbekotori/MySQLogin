<?php
include 'config.php';
$server = $config['server'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

try {
    $db = new PDO("mysql:host={$server};dbname={$dbname}", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
     echo $e->getMessage();
}

$sql = "SELECT COUNT(DISTINCT id) FROM users";
$result = $db->query($sql);
$count = $result->fetchColumn();
echo $count;
?>