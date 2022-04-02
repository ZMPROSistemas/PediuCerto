<?php
    include 'conectaPDO.php';
    include 'analisaToken.php';
    date_default_timezone_set('America/Bahia');
    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    $method = $_SERVER['REQUEST_METHOD'];
    //$retornoToken = array();
    $retornoToken = analisaToken($pdo, $dados);
    if($retornoToken[0]['status'] == 'ERRO'){
        echo  json_encode($retornoToken);
    }else{
        $update = "update pedido_food set ped_confirmado = 'S' where ped_empresa = :empresa and ped_id = :id";
        $pedido =$pdo->prepare($update);
        $pedido->bindValue(":empresa", $retornoToken[0]['id']);
        $pedido->bindValue(":id", $dados['id']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $resultado='{"status":"ERRO","mensagem":"pedido nao encontrado"}';
        } else {
            $resultado='{"status":"OK"}';
        }
        echo $resultado;
    }
