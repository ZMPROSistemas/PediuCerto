<?php

require_once 'conecta.php';
require_once 'conectaPDO.php';

date_default_timezone_set('America/Bahia');
$array = json_decode(file_get_contents("php://input"), true);
 if ($array == null){
     $array=$_REQUEST;  
 };



$sentenca_sql = "";
if (isset($array['sentenca_sql'])){
    $sentenca_sql = $array['sentenca_sql'];    
} else {
    $sentenca_sql = $_POST['sentenca_sql'];  
};



if (isset($array['clausula_where'])){
    $clausula_where = $array['clausula_where'];
};


$listagem = json_encode(listagem($pdo, $sentenca_sql, $clausula_where));
echo $listagem;

 function listagem($pdo, $sentenca_sql, $clausula_where){
   
   $retorno = array();
   $sql = $sentenca_sql;
   
    if ($clausula_where!=""){ 
        $sql .=" ".$clausula_where;
    };

    //print_r($sentenca_sql);
    // $query = mysqli_query($conexao, $sql);
	// while ($row = mysqli_fetch_assoc($query)) {
	// 	array_push($retorno, array(
	// 			'pd_id' => $row['pd_id'],
    //             'pd_cod' => $row['pd_cod'],
    //             'pd_desc' => utf8_encode($row['pd_desc']),
    //             'pd_marca' => utf8_encode($row['pd_marca']),
	// 			'pd_vista' => $row['pd_vista'],
    //             'pd_prazo' => $row['pd_prazo'],
    //             'sbp_descricao' => utf8_encode($row['sbp_descricao']),
	// 	));
	// }


    $smtp = $pdo->prepare($sql);
     //$smtp->bindParam(":empr", $empresa);
     $smtp->execute();
     $retorno = $smtp->fetchAll(PDO::FETCH_ASSOC);
//      $erro = $smtp->errorInfo();
     
    
    return $retorno;
 }