<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $method = $_SERVER['REQUEST_METHOD'];

    $retorno = json_encode(buscarDados($pdo1, $dados));
    
    echo $retorno;

    function buscarDados($pdo1, $dados){
            
        $retorno = array();

        if(empty($dados['cnpj'])){
            array_push($retorno , array(
                'status' => 'ERRO',
                'mensagem' => 'CNPJ deve ser informado',
                'return' => false
            ));

            return $retorno;
        }
        if(empty($dados['codSis'])){
            $dados['codSis']='1';
        }

        $sql = "select SE_ID, SE_ATIVO, SE_LIBERADO_ATE, SE_VALOR, SE_ATRAZADO from seguranca where SE_CNPJ = :cnpj and SE_SISTEMA=:codsistema";

        $pedido =$pdo1->prepare($sql);
        $pedido->bindValue(":cnpj", $dados['cnpj']);
        $pedido->bindValue(":codsistema", $dados['codSis']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            array_push($retorno , array(
                'status' => 'NAO ENCONTRADO',
                'SE_ID' => '',
                'SE_ATIVO' => '',
                'SE_LIBERADO_ATE' => '',
                'SE_VALOR' => '',
                'SE_ATRAZADO' => '',
                'SE_SISTEMA' => $dados['codSis'],
                'contas' => buscaContas($pdo1, $dados['cnpj'],$dados['codSis'])
            ));
        } else {
            array_push($retorno , array(
                'status' => 'OK',
                'SE_ID' => $rowCaixa[0]['SE_ID'],
                'SE_ATIVO' => $rowCaixa[0]['SE_ATIVO'],
                'SE_LIBERADO_ATE' => $rowCaixa[0]['SE_LIBERADO_ATE'],
                'SE_VALOR' => $rowCaixa[0]['SE_VALOR'],
                'SE_ATRAZADO' => $rowCaixa[0]['SE_ATRAZADO'],
                'contas' => buscaContas($pdo1, $dados['cnpj'],$dados['codSis'])
            ));
        }
        return $retorno;

    }

    function buscaContas($pdo1, $cnpj, $codSis){
        $retorno = array();
        $sql = "select * from contas where ct_cpfcnpj = :cnpj and ct_quitado=:quitado and ct_canc=:canc and ct_sistema=:codSis and ct_status_cod=1";

        $pedido =$pdo1->prepare($sql);
        $pedido->bindValue(":cnpj", $cnpj);
        $pedido->bindValue(":quitado", "N");
        $pedido->bindValue(":canc", "N");
        $pedido->bindValue(":codSis", $codSis);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            array_push($retorno , array(
                'ct_id' => '',
                'ct_empresa' => '',
                'ct_docto' => '',
                'ct_cliente_forn' => '',
                'ct_nome' => '',
                'ct_cpfcnpj' => '',
                'ct_emissao' => '',
                'ct_vencto' => '',
                'ct_valor' => '',
                'ct_parc' => '',
                'ct_canc' => '',
                'ct_tipdoc' => '',
                'ct_bloq' => '',
                'ct_pix_id' => '',
                'ct_pix_chave' => '',
                'ct_loccob' => '',
                'ct_pagto' => '',
                'ct_valorpago' => '',
                'ct_obs' => '',
                'ct_receber_pagar' => '',
                'ct_quitado' => '',
                'ct_referencia' => '',
                'ct_status_cod' => '',
                'ct_status_nome' => '',
                'ct_idtransaction' => '',
                'ct_plataforma' => '',
                'ct_bloq_digitableline' => '',
                'ct_bloq_barcode' => '',
                'ct_bloq_url' => '',
                'ct_bloq_bankname' => '',
                'ct_bloq_codebank' => '',
                'ct_bloq_carteira' => '',
                'ct_bloq_carteira_desc' => '',
                'ct_bloq_agencia' => '',
                'ct_bloq_conta' => '',
                'ct_bloq_codegateway' => '',
                'cl_bloq_agencia_dv' => '',
                'cl_bloq_conta_dv' => '',
                'cl_bloq_tipdocto' => '',
                'cl_bloq_aceite' => '',
                'cl_bloq_intermediador_nome' => '',
                'cl_bloq_intermediador_id' => ''
            ));
        } else {
            array_push($retorno , array(
                'ct_id' => $rowCaixa[0]['ct_id'],
                'ct_empresa' => $rowCaixa[0]['ct_empresa'],
                'ct_docto' => $rowCaixa[0]['ct_docto'],
                'ct_cliente_forn' => $rowCaixa[0]['ct_cliente_forn'],
                'ct_nome' => $rowCaixa[0]['ct_nome'],
                'ct_cpfcnpj' => $rowCaixa[0]['ct_cpfcnpj'],
                'ct_emissao' => $rowCaixa[0]['ct_emissao'],
                'ct_vencto' => $rowCaixa[0]['ct_vencto'],
                'ct_valor' => $rowCaixa[0]['ct_valor'],
                'ct_parc' => $rowCaixa[0]['ct_parc'],
                'ct_canc' => $rowCaixa[0]['ct_canc'],
                'ct_tipdoc' => $rowCaixa[0]['ct_tipdoc'],
                'ct_bloq' => $rowCaixa[0]['ct_bloq'],
                'ct_pix_id' => $rowCaixa[0]['ct_pix_id'],
                'ct_pix_chave' => $rowCaixa[0]['ct_pix_chave'],
                'ct_loccob' => $rowCaixa[0]['ct_loccob'],
                'ct_pagto' => $rowCaixa[0]['ct_pagto'],
                'ct_valorpago' => $rowCaixa[0]['ct_valorpago'],
                'ct_obs' => $rowCaixa[0]['ct_obs'],
                'ct_receber_pagar' => $rowCaixa[0]['ct_receber_pagar'],
                'ct_quitado' => $rowCaixa[0]['ct_quitado'],
                'ct_referencia' => $rowCaixa[0]['ct_referencia'],
                'ct_status_cod' => $rowCaixa[0]['ct_status_cod'],
                'ct_status_nome' => $rowCaixa[0]['ct_status_nome'],
                'ct_idtransaction' => $rowCaixa[0]['ct_idtransaction'],
                'ct_plataforma' => $rowCaixa[0]['ct_plataforma'],
                'ct_bloq_digitableline' => $rowCaixa[0]['ct_bloq_digitableline'],
                'ct_bloq_barcode' => $rowCaixa[0]['ct_bloq_barcode'],
                'ct_bloq_url' => $rowCaixa[0]['ct_bloq_url'],
                'ct_bloq_bankname' => $rowCaixa[0]['ct_bloq_bankname'],
                'ct_bloq_codebank' => $rowCaixa[0]['ct_bloq_codebank'],
                'ct_bloq_carteira' => $rowCaixa[0]['ct_bloq_carteira'],
                'ct_bloq_carteira_desc' => $rowCaixa[0]['ct_bloq_carteira_desc'],
                'ct_bloq_agencia' => $rowCaixa[0]['ct_bloq_agencia'],
                'ct_bloq_conta' => $rowCaixa[0]['ct_bloq_conta'],
                'ct_bloq_codegateway' => $rowCaixa[0]['ct_bloq_codegateway'],
                'cl_bloq_agencia_dv' => $rowCaixa[0]['cl_bloq_agencia_dv'],
                'cl_bloq_conta_dv' => $rowCaixa[0]['cl_bloq_conta_dv'],
                'cl_bloq_tipdocto' => $rowCaixa[0]['cl_bloq_tipdocto'],
                'cl_bloq_aceite' => $rowCaixa[0]['cl_bloq_aceite'],
                'cl_bloq_intermediador_nome' => $rowCaixa[0]['cl_bloq_intermediador_nome'],
                'cl_bloq_intermediador_id' => $rowCaixa[0]['cl_bloq_intermediador_id']                
            ));
        }
        return $retorno;
    }

