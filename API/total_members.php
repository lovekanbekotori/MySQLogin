<?php

require __DIR__  . '/db.php';

$db = DB::connect();

if ($db === false) {
    die();
}

$findCount = $db->prepare("SELECT COUNT(id) FROM users");
$findCount = DB::execute($findCount);
$foundCount = $findCount->fetch(PDO::FETCH_ASSOC);

echo $foundCount['COUNT(id)'];
