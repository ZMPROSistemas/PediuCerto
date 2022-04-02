
<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

//$conexao = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$DB_SERVER = 'db-zmpro.cg5tyrexerwf.us-east-1.rds.amazonaws.com';
$DB_USERNAME = 'root';
$DB_PASSWORD = 'lxmcz2020';
$DB_DATABASE = 'zmpay';


try{

    $pdo = new PDO("mysql:dbname=". $DB_DATABASE . "; host=". $DB_SERVER, $DB_USERNAME, $DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
    //echo 'Conexao efetuada com sucesso!';
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}