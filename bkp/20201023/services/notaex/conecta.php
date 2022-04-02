<?php 
include "../../../inc/dbzmpro.inc"; 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$conexao = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
