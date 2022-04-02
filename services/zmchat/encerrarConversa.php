<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = buscaDados($pdo, $dados);
    if($retorno=='0'){
        $retorno = gravaEspera($pdo, $dados);
    }else{
        $retorno = alteraEspera($pdo, $dados);
    }  
    echo $retorno;