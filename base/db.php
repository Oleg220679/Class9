<?php


$db = array(
  'db_name' => 'mydatabase',
  'db_user' => 'mysql',
  'db_pass' => 'mysql',
);
try {
    $dsn = "mysql:host=localhost;dbname={$db['db_name']}";
    $conn = new PDO($dsn, $db['db_user'], $db['db_pass']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    print "DB ERROR: {$e->getMessage()}";
}
