<?php  

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$conexao = mysqli_connect('db-zmpro.cg5tyrexerwf.us-east-1.rds.amazonaws.com', 'root', 'lxmcz2020', 'zmpro');
//$conexao->set_charset("utf8");
