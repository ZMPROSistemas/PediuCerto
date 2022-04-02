<?php
    session_name('http://localhost/pediucerto');
    session_start();
    date_default_timezone_set('America/Sao_Paulo');


    require_once 'conn.php';
    
    $date = date('H:i');
    $array = json_decode(file_get_contents("php://input"), true);

    //var_dump($array);

    $returno = array();
    $empresa = $array['empresa'];
    $perfil = $array['perfil'];
    $endereco = $array['endereco'];
    $formaPagamento = $array['formaPagamento'];
    $sacola = $array['sacola'];
    $totalSacolaValor = $array['totalSacolaValor'];

    if (array_key_exists('obs',$array)) {
        $obs = $array['obs'];
    }else{
        $obs = null;
    }

    //var_dump($empresa);
    //echo $empresa[0]['em_token'];

    $sqlEmpresa = "select * from empresas where em_token='".$empresa[0]['em_token']."';";
    $queryEmp = mysqli_query($conexao, $sqlEmpresa);
    $rowEmp = mysqli_fetch_assoc($queryEmp);
    
    if($rowEmp['em_aberto'] == 'S'){

         $sql_ped_doc ="select max(ped_doc)+1 as ped_doc from pedido_food where ped_empresa = (select em_cod from empresas where em_token='".$empresa[0]['em_token']."');";
         $queryPed_doc = mysqli_query($conexao, $sql_ped_doc);
         $ped_doc = mysqli_fetch_assoc($queryPed_doc);

         if($ped_doc['ped_doc'] == null){
            $ped_doc['ped_doc'] = 1;
         }

         $valor_entrega = 5;
         $tota_c_entrega = $valor_entrega+$totalSacolaValor;

         $troco =str_replace('R','',$formaPagamento[0]['trocoP']);
         $troco = str_replace('$','',$troco);
         $troco = str_replace(',','.',$troco);

        $forma_pagamento = $formaPagamento[0]['tipo'];

        if($forma_pagamento == 'D'){
            $sqlForma = 'ped_val_pg_dn';
        }
        else if($forma_pagamento == 'C'){
            $sqlForma = 'ped_val_pg_ca';
        }

        //sql execuado se o cliente buscar produto no local
        if ($endereco[0]['local'] == 'Retirar No Estabelecimento') {

            $tota_c_entrega = $totalSacolaValor;

            $sqlPed_food = "INSERT INTO pedido_food (
            ped_doc, 
            ped_empresa, 
            ped_matriz, 
            ped_emis, 
            ped_hora_entrada, 
            ped_cliente_cod, 
            ped_cliente_fone,
            ped_cliente_nome, 
            ped_cliente_cep, 
            ped_cliente_end, 
            ped_cliente_end_num, 
            ped_cliente_compl, 
            ped_cliente_bairro,
            ped_cliente_cid, 
            ped_cliente_regiao, 
           
            ped_valor,
            ped_val_entrega,
            ped_total, 
            ped_obs, 
            ped_status,
            ped_pago,
            $sqlForma, 
            ped_troco_para,
            ped_entregar,
            ped_confirmado, 
            ped_finalizado)
            value(
            ".$ped_doc['ped_doc'].", 
            (select em_cod from empresas where em_token='".$empresa[0]['em_token']."'),
            (select em_cod_matriz from empresas where em_token='".$empresa[0]['em_token']."'), 
            current_date(), 
            '$date', 
            ".$perfil[0]['pe_id'].", 
            '".$perfil[0]['pe_celular']."', 
            '".$perfil[0]['pe_nome']."', 
            '".$perfil[0]['pe_cep']."',
            '".$perfil[0]['pe_endereco']."',
            '".$perfil[0]['pe_end_num']."', 
            '".$perfil[0]['pe_end_comp']."', 
            '".$perfil[0]['pe_bairro']."',
            '".$perfil[0]['pe_cidade']."',
            0,
            
            $totalSacolaValor,
            '0', 
            $tota_c_entrega,
            '$obs',
            'Novo',
            'N',
            $tota_c_entrega,
            $troco,
            'N',
            'N',
            'N');";
        }

        //sql executado se o cliente pedir para entregar
        if ($endereco[0]['local'] == 'Casa' || $endereco[0]['local'] == 'Trabalho' || $endereco[0]['local'] == 'Local Atual'){
            $sqlPed_food = "INSERT INTO pedido_food (
                ped_doc, 
                ped_empresa, 
                ped_matriz, 
                ped_emis, 
                ped_hora_entrada, 
                ped_cliente_cod, 
                ped_cliente_fone,
                ped_cliente_nome, 
                ped_cliente_cep, 
                ped_cliente_end, 
                ped_cliente_end_num, 
                ped_cliente_compl, 
                ped_cliente_bairro,
                ped_cliente_cid, 
                ped_cliente_regiao,

                ped_cliente_end_entrega, 
                ped_cliente_end_num_entrega, 
                ped_cliente_compl_entrega,
                ped_cliente_bairro_entrega, 
                ped_cliente_cid_entrega,
                ped_cliente_regiao_entrega, 
               
                ped_valor,
                ped_val_entrega,
                ped_total, 
                ped_obs, 
                ped_status,
                ped_pago,
                $sqlForma, 
                ped_troco_para,
                ped_entregar,
                ped_confirmado, 
                ped_finalizado)
                value(
                ".$ped_doc['ped_doc'].", 
                (select em_cod from empresas where em_token='".$empresa[0]['em_token']."'),
                (select em_cod_matriz from empresas where em_token='".$empresa[0]['em_token']."'), 
                current_date(), 
                '$date', 
                ".$perfil[0]['pe_id'].", 
                '".$perfil[0]['pe_celular']."', 
                '".$perfil[0]['pe_nome']."', 
                '".$perfil[0]['pe_cep']."',
                '".$perfil[0]['pe_endereco']."',
                '".$perfil[0]['pe_end_num']."', 
                '".$perfil[0]['pe_end_comp']."', 
                '".$perfil[0]['pe_bairro']."',
                '".$perfil[0]['pe_cidade']."',
                0,
                
                '".$endereco[0]['pe_endereco']."',
                '".$endereco[0]['pe_end_num']."',
                '".$endereco[0]['pe_end_comp']."',
                '".$endereco[0]['pe_bairro']."',
                '".$endereco[0]['pe_cidade']."',
                0,
                
                $totalSacolaValor,
                $valor_entrega, 
                $tota_c_entrega,
                '$obs',
                'Novo',
                'N',
                $tota_c_entrega,
                $troco,
                'S',
                'N',
                'N');";
        }

        $query_pedido_food = mysqli_query($conexao, $sqlPed_food);
        
        $result = mysqli_affected_rows($conexao);

        $id_pedido = mysqli_insert_id($conexao);
        
        //$result = 1;
        //$id_pedido = 1;

        if($result > 0){

            foreach($sacola as $sacola){
                $sql_pedido_item = "INSERT INTO  pedido_item_food (
                pdi_idprim, 
                pdi_doc, 
                pdi_empresa, 
                pdi_matriz,
                pdi_emis,
                pdi_produto,
                pdi_descricao,
                pdi_quantidade,
                pdi_preco_base,
                pdi_val_desc,
                pdi_val_adicional,
                pdi_preco_total_item,
                pdi_total,
                pdi_status)
                value(
                    $id_pedido,
                    ".$ped_doc['ped_doc'].",
                     (select em_cod from empresas where em_token='".$empresa[0]['em_token']."'),
                     (select em_cod_matriz from empresas where em_token='".$empresa[0]['em_token']."'),
                     current_date(),
                    ".$sacola['pd_cod'].",
                    '".$sacola['pd_desc']."',
                    ".$sacola['pd_quantidade'].",
                    ".$sacola['pd_vUnitario'].",
                    0.00,
                    0.00,
                    0.00,
                    ".$sacola['pd_vista'].",
                    'Novo'
                );";

                $query_pedido_item = mysqli_query($conexao, $sql_pedido_item);
                
                $resultItem = mysqli_affected_rows($conexao);
                //echo $sql_pedido_item . '<br>';
            }

            array_push($returno, array(
                'status' => 'ABERTO',
                'return'=> 'SUCCESS'
            ));
           
        }else{
            array_push($returno, array(
                'status' => 'ABERTO',
                'return'=> 'ERROR'
            ));
        }

        //echo $sqlPed_food;
    }else{
        array_push($returno, array(
            'status' => 'ABERTO',
            'return'=> 'ERROR'
        ));
    }

    echo json_encode($returno);

    

    