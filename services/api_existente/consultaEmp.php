<?php

date_default_timezone_set('America/Sao_Paulo');
require_once '../conectaPDO.php';
$date = date('H:i');
$body = json_decode(file_get_contents("php://input"), true);

if($body == null){
    $body = $_REQUEST;
}

$sql="SELECT * FROM empresas where em_cnpj =:cnpj;";
$smtp=$pdo->prepare($sql);
$smtp->bindvalue(":cnpj", $body['cnpj']);
$smtp->execute();
$rowEmp=$smtp->fetchAll(PDO::FETCH_ASSOC);

$retorno = array();

if ($rowEmp == null) {

    $pontos=array(".", ",", "/", "-", "R", "$", "(", ")");
    $cnpj=str_replace($pontos, "", $body['cnpj'] );

    $sql="SELECT * FROM empresas where em_cnpj =:cnpj;";
    $smtp=$pdo->prepare($sql);
    $smtp->bindvalue(":cnpj", $cnpj);
    $smtp->execute();
    $rowEmp=$smtp->fetchAll(PDO::FETCH_ASSOC);
    
    if ($rowEmp != null) {
        array_push($retorno, array(
            'retorno' => 'ERROR', 
            'msg' => 'Empresa Existente',
        ));

    }else {
        array_push($retorno, array(
            'retorno' => 'SUCCESS',
        ));    
    }
        
} else {
    $pontos=array(".", ",", "/", "-", "R", "$", "(", ")");
    $cnpj=str_replace($pontos, "", $body['cnpj'] );

    $sql="SELECT * FROM empresas where em_cnpj =:cnpj;";
    $smtp=$pdo->prepare($sql);
    $smtp->bindvalue(":cnpj", $cnpj);
    $smtp->execute();
    $rowEmp=$smtp->fetchAll(PDO::FETCH_ASSOC);
    
    if ($rowEmp != null) {
        array_push($retorno, array(
            'retorno' => 'ERROR', 
            'msg' => 'Empresa Existente',
        ));

    }else {
        array_push($retorno, array(
            'retorno' => 'SUCCESS',
        ));    
    }
    
}
echo json_encode($retorno);

