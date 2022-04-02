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
    $adicionais = $array['adicionais'];
    $valorEntrega = $array['valorEntrega'];

    //var_dump($sacola);

    if (array_key_exists('obs',$array)) {
        $obs = $array['obs'];
    }else{
        $obs = null;
    }

    if(!isset($endereco[0]['pe_end_comp'])){
        $endereco[0]['pe_end_comp'] = NULL;
    }

    if(isset($endereco[0]['pe_cep'])){
        $cep = $endereco[0]['pe_cep'];
    }else{
        $cep = null;
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

        $modoEntrega;

        //sql execuado se o cliente buscar produto no local
        if ($endereco[0]['local'] == 'Retirar No Estabelecimento') {
            $result = 1; 
            $modoEntrega = "Retirada";
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
            '".utf8_decode($perfil[0]['pe_nome'])."', 
            '".$perfil[0]['pe_cep']."',
            '".utf8_decode($perfil[0]['pe_endereco'])."',
            '".$perfil[0]['pe_end_num']."', 
            '".utf8_decode($perfil[0]['pe_end_comp'])."', 
            '".utf8_decode($perfil[0]['pe_bairro'])."',
            '".utf8_decode($perfil[0]['pe_cidade'])."',
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
            
            $modoEntrega = "Delivery";

            $sqlTaxa = "SELECT * FROM bairro_atendido where ba_empresa = (SELECT em_cod from empresas where em_token='".$empresa[0]['em_token']."')
            and ba_codcidade = (SELECT cid_cod from cidades where cid_nome='".strtoupper($endereco[0]['pe_cidade'])."' and cid_uf='".strtoupper($endereco[0]['pe_uf'])."') and ba_nomebairro = '".ucwords(strtolower(utf8_decode($endereco[0]['pe_bairro'])))."';";

            $query_taxa = mysqli_query($conexao, $sqlTaxa);
            $result = mysqli_affected_rows($conexao);

            //echo $sqlTaxa.' '.$result;

            if ($result>=1){
                
                $taxa = mysqli_fetch_assoc($query_taxa);
                try {
                    $valor_entrega = $taxa['ba_taxa'];
                } catch (Exception $e) {
                    $valor_entrega = 0;
                }

                if ($valorEntrega=='' || $valorEntrega == null){
                    $valorEntrega = 0;
                }
                if ($valor_entrega==0 || $valor_entrega== null){
                    $valor_entrega=$valorEntrega;    
                }
                if ($valorEntrega<=0) {
                    $tota_c_entrega = $valor_entrega+$totalSacolaValor;
                }else{
                    $tota_c_entrega = $valorEntrega+$totalSacolaValor;
                }
                if ($totalSacolaValor=='' || $totalSacolaValor == null){
                    $totalSacolaValor = 0;
                }
                if ($valor_entrega=='' || $valor_entrega == null){
                    $valor_entrega = 0;
                }
                if ($tota_c_entrega=='' || $tota_c_entrega == null){
                    $tota_c_entrega = 0;
                }
                if ($troco=='' || $troco == null){
                    $troco = 0;
                }


            
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
                    ped_cliente_cep_entrega,
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
                    '".utf8_decode($perfil[0]['pe_nome'])."', 
                    '".$perfil[0]['pe_cep']."',
                    '".utf8_decode($perfil[0]['pe_endereco'])."',
                    '".$perfil[0]['pe_end_num']."', 
                    '".utf8_decode($perfil[0]['pe_end_comp'])."', 
                    '".utf8_decode($perfil[0]['pe_bairro'])."',
                    '".utf8_decode($perfil[0]['pe_cidade'])."',
                    0,
                    '$cep',
                    '".utf8_decode($endereco[0]['pe_endereco'])."',
                    '".$endereco[0]['pe_end_num']."',
                    '".utf8_decode($endereco[0]['pe_end_comp'])."',
                    '".utf8_decode($endereco[0]['pe_bairro'])."',
                    '".utf8_decode($endereco[0]['pe_cidade'])."',
                    0,
                    $totalSacolaValor,
                    $valor_entrega, 
                    $tota_c_entrega,
                    '".utf8_decode($obs)."',
                    'Novo',
                    'N',
                    $tota_c_entrega,
                    $troco,
                    'S',
                    'N',
                    'N');";
            }
        }
        //echo $valorEntrega.' '.$sqlPed_food;
        //echo $valor_entrega.' '.$sqlPed_food;
        if ($result>=1){
            $query_pedido_food = mysqli_query($conexao, $sqlPed_food);
            $result = mysqli_affected_rows($conexao);
            $id_pedido = mysqli_insert_id($conexao);
        }

        if($result > 0){
            foreach($sacola as $sacola){
               $total = 0;
               $obs;
                if (isset($sacola['pd_obs'])) {
                    if ($sacola['pd_obs'] != null) {
                        $obs .="Obs: ".utf8_decode($sacola['pd_obs'])."\n";
                    }
                }
                foreach($adicionais as $add){
                   if ($add['produto'] === $sacola['item']) {
                       $obs .= $add['ex_qts'] . ' '. $add['ex_desc'] . " / ";
                       $total += $add['ex_total'];
                   }
                }
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
                pdi_obs,
                pdi_status)
                value(
                    $id_pedido,
                    ".$ped_doc['ped_doc'].",
                     (select em_cod from empresas where em_token='".$empresa[0]['em_token']."'),
                     (select em_cod_matriz from empresas where em_token='".$empresa[0]['em_token']."'),
                     current_date(),
                    ".$sacola['pd_cod'].",
                    '".utf8_decode($sacola['pd_desc'])."',
                    ".$sacola['pd_quantidade'].",
                    ".$sacola['pd_vUnitario'].",
                    0.00,
                    $total,
                    ".$sacola['total_item'].",
                    ".$sacola['v_total'].",
                    '$obs',
                    'Novo'
                );";

               $query_pedido_item = mysqli_query($conexao, $sql_pedido_item);
                
               $resultItem = mysqli_affected_rows($conexao);
                
                $obs = null;

                //echo '<pre>'. $sql_pedido_item . '<pre>';

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
            'status' => 'FECHADO',
            'return'=> 'ERROR'
        ));
    }

    echo json_encode($returno);

    

    