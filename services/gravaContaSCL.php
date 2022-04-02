<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    if(empty($dados['cl_sistema'])){
        $dados['cl_sistema']='1';
    }

    $retorno = gravaDados($pdo1, $dados);
    echo $retorno;

    function gravaDados($pdo1, $dados){
        $passou = 'T';
        // if( (!isset($_POST['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $sql="insert into contas (ct_empresa,ct_docto,ct_cliente_forn,ct_nome,ct_cpfcnpj,ct_emissao,ct_vencto,ct_valor,ct_parc,ct_canc,";
            $sql=$sql.               'ct_tipdoc,ct_bloq,ct_pix_id,ct_pix_chave,ct_loccob,ct_pagto,ct_valorpago,ct_obs,ct_receber_pagar,ct_quitado,';
            $sql=$sql.               'ct_referencia,ct_status_cod,ct_status_nome,ct_idtransaction,ct_plataforma,ct_bloq_digitableline,';
            $sql=$sql.               'ct_bloq_barcode,ct_bloq_url,ct_bloq_bankname,ct_bloq_codebank,ct_bloq_carteira,ct_bloq_carteira_desc,';
            $sql=$sql.               'ct_bloq_agencia,ct_bloq_conta,ct_bloq_codegateway,cl_bloq_agencia_dv,cl_bloq_conta_dv,cl_bloq_tipdocto,';
            $sql=$sql.               'cl_bloq_aceite,cl_bloq_intermediador_nome,cl_bloq_intermediador_id,ct_sistema)';
            $sql=$sql.     ' values (:ct_empresa,:ct_docto,:ct_cliente_forn,:ct_nome,:ct_cpfcnpj,:ct_emissao,:ct_vencto,:ct_valor,:ct_parc,:ct_canc,';
            $sql=$sql.              ':ct_tipdoc,:ct_bloq,:ct_pix_id,:ct_pix_chave,:ct_loccob,:ct_pagto,:ct_valorpago,:ct_obs,:ct_receber_pagar,:ct_quitado,';
            $sql=$sql.               ':ct_referencia,:ct_status_cod,:ct_status_nome,:ct_idtransaction,:ct_plataforma,:ct_bloq_digitableline,';
            $sql=$sql.               ':ct_bloq_barcode,:ct_bloq_url,:ct_bloq_bankname,:ct_bloq_codebank,:ct_bloq_carteira,:ct_bloq_carteira_desc,';
            $sql=$sql.               ':ct_bloq_agencia,:ct_bloq_conta,:ct_bloq_codegateway,:cl_bloq_agencia_dv,:cl_bloq_conta_dv,:cl_bloq_tipdocto,';
            $sql=$sql.               ':cl_bloq_aceite,:cl_bloq_intermediador_nome,:cl_bloq_intermediador_id,:ct_sistema)';
            $pedido =$pdo1->prepare($sql);
            $pedido->bindValue(":ct_empresa", "1");
            $pedido->bindValue(":ct_docto", $dados['ct_docto']);
            $pedido->bindValue(":ct_cliente_forn", $dados['ct_cliente_forn']);
            $pedido->bindValue(":ct_nome", $dados['ct_nome']);
            $pedido->bindValue(":ct_cpfcnpj", $dados['ct_cpfcnpj']);
            $pedido->bindValue(":ct_emissao", $dados['ct_emissao']);
            $pedido->bindValue(":ct_vencto", $dados['ct_vencto']);
            $pedido->bindValue(":ct_valor", $dados['ct_valor']);
            $pedido->bindValue(":ct_parc", $dados['ct_parc']);
            $pedido->bindValue(":ct_canc", $dados['ct_canc']);
            $pedido->bindValue(":ct_tipdoc", $dados['ct_tipdoc']);
            $pedido->bindValue(":ct_bloq", $dados['ct_bloq']);
            $pedido->bindValue(":ct_pix_id", $dados['ct_pix_id']);
            $pedido->bindValue(":ct_pix_chave", $dados['ct_pix_chave']);
            $pedido->bindValue(":ct_loccob", $dados['ct_loccob']);
            $pedido->bindValue(":ct_pagto", $dados['ct_pagto']);
            $pedido->bindValue(":ct_valorpago", $dados['ct_valorpago']);
            $pedido->bindValue(":ct_obs", $dados['ct_obs']);
            $pedido->bindValue(":ct_receber_pagar", $dados['ct_receber_pagar']);
            $pedido->bindValue(":ct_quitado", $dados['ct_quitado']);
            $pedido->bindValue(":ct_referencia", $dados['ct_referencia']);
            $pedido->bindValue(":ct_status_cod", $dados['ct_status_cod']);
            $pedido->bindValue(":ct_status_nome", $dados['ct_status_nome']);
            $pedido->bindValue(":ct_idtransaction", $dados['ct_idtransaction']);
            $pedido->bindValue(":ct_plataforma", $dados['ct_plataforma']);
            $pedido->bindValue(":ct_bloq_digitableline", $dados['ct_bloq_digitableline']);            
            $pedido->bindValue(":ct_bloq_barcode", $dados['ct_bloq_barcode']);            
            $pedido->bindValue(":ct_bloq_url", $dados['ct_bloq_url']);            
            $pedido->bindValue(":ct_bloq_bankname", $dados['ct_bloq_bankname']);            
            $pedido->bindValue(":ct_bloq_codebank", $dados['ct_bloq_codebank']);            
            $pedido->bindValue(":ct_bloq_carteira", $dados['ct_bloq_carteira']);            
            $pedido->bindValue(":ct_bloq_carteira_desc", $dados['ct_bloq_carteira_desc']);            
            $pedido->bindValue(":ct_bloq_agencia", $dados['ct_bloq_agencia']);            
            $pedido->bindValue(":ct_bloq_conta", $dados['ct_bloq_conta']);            
            $pedido->bindValue(":ct_bloq_codegateway", $dados['ct_bloq_codegateway']);            
            $pedido->bindValue(":cl_bloq_agencia_dv", $dados['cl_bloq_agencia_dv']);            
            $pedido->bindValue(":cl_bloq_conta_dv", $dados['cl_bloq_conta_dv']);            
            $pedido->bindValue(":cl_bloq_tipdocto", $dados['cl_bloq_tipdocto']);            
            $pedido->bindValue(":cl_bloq_aceite", $dados['cl_bloq_aceite']);            
            $pedido->bindValue(":cl_bloq_intermediador_nome", $dados['cl_bloq_intermediador_nome']);            
            $pedido->bindValue(":cl_bloq_intermediador_id", $dados['cl_bloq_intermediador_id']);
            $pedido->bindValue(":ct_sistema", $dados['ct_sistema']);
            try {
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                if ($pedido->rowCount()== 0 ){
                    $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
                } else {
                    $resultado='{"status":"OK"}';
                }
            } catch(PDOException $e) {
                $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            }
        }
        return $resultado;
    }
    