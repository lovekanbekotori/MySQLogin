<?php

require __DIR__  . '/db.php';

$db = DB::connect();

if (!isset($_POST['username'], $_POST['password']) || $db === false) {
    die();
}

$findUser = $db->prepare("SELECT * FROM users WHERE username= :username LIMIT 1");
$findUser = DB::execute($findUser, [
    'username' => $_POST['username'],
]);
$foundUser = $findUser->fetch(PDO::FETCH_ASSOC);

if (!empty($foundUser)) {
    // User already exists.
    die();
}

$addUser = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
$addUser = DB::execute($addUser, [
    'username' => $_POST['username'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
]);

// If we got to this step, it means all went well.
