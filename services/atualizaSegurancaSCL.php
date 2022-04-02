<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    if(empty($dados['SE_SISTEMA'])){
        $dados['SE_SISTEMA']='1';
    }

    $retorno = atualizaDados($pdo1, $dados);
    echo $retorno;


    function atualizaDados($pdo,$dados){
        $update = "update seguranca set seguranca.SE_ATIVO = :SE_ATIVO, seguranca.SE_LIBERADO_ATE = :SE_LIBERADO_ATE where seguranca.SE_CNPJ = :SE_CNPJ and seguranca.SE_SISTEMA = :SE_SISTEMA";
        $pedido =$pdo->prepare($update);
        $pedido->bindValue(":SE_ATIVO", $dados['SE_ATIVO']);
        $pedido->bindValue(":SE_LIBERADO_ATE", $dados['SE_LIBERADO_ATE']);
        $pedido->bindValue(":SE_CNPJ", $dados['SE_CNPJ']);
        $pedido->bindValue(":SE_SISTEMA", $dados['SE_SISTEMA']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $resultado='{"status":"ERRO","mensagem":"alteracao nao realizada"}';
        } else {
            $resultado='{"status":"OK"}';
        }
        return $resultado;
    }
