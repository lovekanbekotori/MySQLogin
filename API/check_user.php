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

if (empty($foundUser)) {
    // User does not exists.
    die();
}

if (password_verify($_POST['password'], $foundUser['password'])) {
    echo 'true';
} else {
    echo 'false';
}
