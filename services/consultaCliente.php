<?php
    require_once 'conecta.php';
    require_once 'conectaPDO.php';
    
    $matriz = base64_decode($_GET['matriz']);
    $empresa = base64_decode($_GET['empresa']);

    if($empresa == 0 ){
        $empresa = $matriz;
    }

    if (isset($_GET['buscaCliente'])) {
        
        $lista = json_encode(consultaCliente($pdo, $matriz, $empresa));
        echo $lista;
        
    }

    if (isset($_GET['maisInfo'])){

        $cliente = $_GET['cliente'];
        $lista = json_encode(maisInfo($pdo, $matriz, $empresa, $cliente));
        
        echo $lista;
    }


    function consultaCliente($pdo, $matriz, $empresa){

        if($empresa == 0){
            $empresa = $matriz;
        }
        
        $retorno = array();
        $sql = "SELECT * FROM pedido_food where ped_empresa = $empresa and ped_matriz = $matriz group by ped_cliente_cod;";

        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        $row = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach($row as $row){

            array_push($retorno, array(
                'ped_id' => $row['ped_id'],
                'ped_doc' => $row['ped_doc'],
                'ped_empresa' => $row['ped_empresa'],
                'ped_matriz' => $row['ped_matriz'],
                'ped_emis' => $row['ped_emis'],
                'ped_hora_entrada' => $row['ped_hora_entrada'],
                'ped_hora_preparo' => $row['ped_hora_preparo'],
                'ped_hora_saida' => $row['ped_hora_saida'],
                'ped_hora_entrega' => $row['ped_hora_entrega'],
                'ped_hora_cancel' => $row['ped_hora_cancel'],
                'ped_hora_retornado' => $row['ped_hora_retornado'],
                'ped_cliente_cod' => $row['ped_cliente_cod'],
                'ped_cliente_fone' => $row['ped_cliente_fone'],
                'ped_cliente_nome' => $row['ped_cliente_nome'],
                'ped_cliente_cep' => $row['ped_cliente_cep'],
                'ped_cliente_end' => $row['ped_cliente_end'],
                'ped_cliente_end_num' => $row['ped_cliente_end_num'],
                'ped_cliente_compl' => $row['ped_cliente_compl'],
                'ped_cliente_bairro' => $row['ped_cliente_bairro'],
                'ped_cliente_cid' => $row['ped_cliente_cid'],
                'ped_cliente_regiao' => $row['ped_cliente_regiao'],
                'ped_cliente_cep_entrega' => $row['ped_cliente_cep_entrega'],
                'ped_cliente_end_entrega' => $row['ped_cliente_end_entrega'],
                'ped_cliente_end_num_entrega' => $row['ped_cliente_end_num_entrega'],
                'ped_cliente_compl_entrega' => $row['ped_cliente_compl_entrega'],
                'ped_cliente_bairro_entrega' => $row['ped_cliente_bairro_entrega'],
                'ped_cliente_cid_entrega' => $row['ped_cliente_cid_entrega'],
                'ped_cliente_regiao_entrega' => $row['ped_cliente_regiao_entrega'],
                'ped_valor' => $row['ped_valor'],
                'ped_val_desc' => $row['ped_val_desc'],
                'ped_val_entrega' => $row['ped_val_entrega'],
                'ped_total' => $row['ped_total'],
                'ped_obs' => utf8_encode($row['ped_obs']),
                'ped_status' => $row['ped_status'],
                'ped_pago' => $row['ped_pago'],
                'ped_val_pg_dn' => $row['ped_val_pg_dn'],
                'ped_val_pg_ca' => $row['ped_val_pg_ca'],
                'ped_troco_para' => $row['ped_troco_para'],
                'ped_num_plataforma' => $row['ped_troco_para'],
                'ped_transacao' => $row['ped_transacao'],
                'ped_entregar' => $row['ped_entregar'],
                'ped_confirmado' => $row['ped_confirmado'],
                'ped_finalizado' => $row['ped_finalizado'],
                'ped_motivo_canc' => $row['ped_motivo_canc'],
            ));
        }
        
       return $retorno;
    }

    function maisInfo($pdo, $matriz, $empresa, $cliente){

        $retorno = array();

        $sql = "select pe_id, pe_cod, pe_empresa, pe_matriz, pe_nome, pe_endereco, pe_end_num, pe_end_comp, pe_bairro,pe_cidade, pe_uf, pe_cep,
        pe_cep_trab, pe_endtrab, pe_end_num_trab, pe_bairro_trab, pe_end_cid_trab, pe_uf_trab, pe_end_comp_trab, pe_celular, pe_cadastro, pe_app_origem, 
        pe_emp_origem FROM pessoas where pe_id = $cliente;";
        $maisinfo = $pdo->prepare($sql);
        $maisinfo->execute();
        $retorno = $maisinfo->fetchAll(PDO::FETCH_ASSOC);

         array_push($retorno, array(
            'pedidos' => maisInfoPrd($pdo, $matriz, $empresa, $retorno[0]['pe_id']),
            'Totalpedidos' => totalPed($pdo, $matriz, $empresa,  $retorno[0]['pe_id'])
        ));

        return $retorno;
    }

    function maisInfoPrd($pdo, $matriz, $empresa, $id){

        $retorno = array();

        $sql = "SELECT ped_id, ped_doc, ped_empresa, (SELECT em_fanta FROM empresas where em_cod = ped_empresa) as em_fanta, ped_matriz, ped_emis, ped_hora_entrada, ped_cliente_cep_entrega, 
        ped_cliente_end_entrega, ped_cliente_end_num_entrega, ped_hora_entrega, ped_hora_cancel, ped_cliente_compl_entrega, ped_cliente_bairro_entrega, ped_cliente_cid_entrega
        ped_valor, ped_val_desc, ped_val_entrega, ped_total, ped_obs, ped_status, ped_val_pg_dn, ped_val_pg_ca, ped_troco_para
        ped_entregar, ped_finalizado FROM zmpro.pedido_food where ped_empresa = $empresa and ped_matriz =$matriz and ped_cliente_cod =  $id;";
        $infoPed = $pdo->prepare($sql);
        $infoPed->execute();
        $retorno = $infoPed->fetchAll(PDO::FETCH_ASSOC);

        return $retorno;

    }
    
    function totalPed($pdo, $matriz, $empresa, $id){

        $sql = "SELECT count(705476) as total FROM zmpro.pedido_food where ped_empresa = $empresa and ped_matriz =$matriz and ped_cliente_cod = $id;";
        $infoPed = $pdo->prepare($sql);
        $infoPed->execute();
        $retorno = $infoPed->fetch(PDO::FETCH_ASSOC);

        return $retorno['total'];

    }
