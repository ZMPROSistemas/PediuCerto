<?php
    include 'conectaPDO.php';
    include 'analisaToken.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $method = $_SERVER['REQUEST_METHOD'];
    //$retornoToken = array();
    $retornoToken = analisaToken($pdo, $dados);
    if($retornoToken[0]['status'] == 'ERRO'){
        echo json_encode($retornoToken);
    }else{
        $update = "update empresas set em_entrega1 = :entrega1, em_entrega2 = :entrega2, em_retira = :retira where em_cod = :empresa";
        $pedido =$pdo->prepare($update);
        $pedido->bindValue(":entrega1", $dados['entrega1']);
        $pedido->bindValue(":entrega2", $dados['entrega2']);
        $pedido->bindValue(":retira", $dados['retira']);
        $pedido->bindValue(":empresa", $retornoToken[0]['id']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $resultado='{"status":"ERRO","mensagem":"alteracao nao realizada"}';
        } else {
            $resultado='{"status":"OK"}';
        }
        echo $resultado;
    }