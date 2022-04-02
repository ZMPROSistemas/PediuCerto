
<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


// Servidor New ZMPro
$DB_SERVER = 'db-zmpro.cg5tyrexerwf.us-east-1.rds.amazonaws.com';
$DB_USERNAME = 'root';
$DB_PASSWORD = 'lxmcz2020';
$DB_DATABASE = 'Lexus';
try{
    $pdo1 = new PDO("mysql:host=$DB_SERVER;dbname=$DB_DATABASE;charset=utf8", $DB_USERNAME, $DB_PASSWORD);
}catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
