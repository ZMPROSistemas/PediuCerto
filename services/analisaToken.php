<?php

function analisaToken($pdo, $dados){
    $retorno = array();
    if(empty($dados['tokenprincipal'])){
        array_push($retorno , array(
            'status' => 'ERRO',
            'mensagem' => 'token principal deve ser informado'
        ));
        return $retorno;
    }
    if(empty($dados['tokencliente'])){
        array_push($retorno , array(
            'status' => 'ERRO',
            'mensagem' => 'token do cliente deve ser informado'
        ));
        return $retorno;
    }
    
    $sql = "select ativo from token where token = :tokenprincipal";
    $pedido =$pdo->prepare($sql);
    $pedido->bindValue(":tokenprincipal", $dados['tokenprincipal']);
    $pedido->execute();
    $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
    if ($pedido->rowCount()== 0 ){
        array_push($retorno , array(
            'status' => 'ERRO',
            'mensagem' => 'token principal nao encontrado'
        ));
        return $retorno;
    } else {
        if ($rowCaixa[0]['ativo'] =='N'){
            array_push($retorno , array(
                'status' => 'ERRO',
                'mensagem' => 'token principal desativado'
            ));
            return $retorno;
        }
    }
    $sql = "select em_cod, em_ativo, em_token, em_cod_matriz from empresas where em_token = :tokencliente";
    $pedido =$pdo->prepare($sql);
    $pedido->bindValue(":tokencliente", $dados['tokencliente']);
    $pedido->execute();
    $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
    if ($pedido->rowCount()== 0 ){
        array_push($retorno , array(
            'status' => 'ERRO',
            'mensagem' => 'token do cliente nao encontrado'
        ));
        return $retorno;
    } else {
        if ($rowCaixa[0]['em_ativo'] =='N'){
            array_push($retorno , array(
                'status' => 'ERRO',
                'mensagem' => 'token do cliente desativado'
            ));
            return $retorno;
         } else {
            array_push($retorno , array(
                'status' => 'SUCESSO',
                'mensagem' => 'SUCCESS',
                'id' => $rowCaixa[0]['em_cod'],
                'id_matriz' => $rowCaixa[0]['em_cod_matriz']
                
            ));
            return $retorno;
        }

    }

    

}