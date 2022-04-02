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
        echo  json_encode($retornoToken);
    }else{
        if($method == 'GET'){
            $lista =         '{"Quantidades":'       . json_encode(buscarQuantidadesPedidos($pdo, $retornoToken[0]['id'],$dados['data'])) . ',';
            $lista = $lista . '"PedidosNovos":'      . json_encode(buscarPedidos($pdo, $retornoToken[0]['id'], 'PedidosNovos'     ,'')) . ',';
            $lista = $lista . '"PedidosPreparo":'    . json_encode(buscarPedidos($pdo, $retornoToken[0]['id'], 'PedidosPreparo'   ,'')) . ',';
            $lista = $lista . '"PedidosTransito":'   . json_encode(buscarPedidos($pdo, $retornoToken[0]['id'], 'PedidosTransito'  ,'')) . ',';
            $lista = $lista . '"PedidosEntregues":'  . json_encode(buscarPedidos($pdo, $retornoToken[0]['id'], 'PedidosEntregues' ,$dados['data'])) . ',';
            $lista = $lista . '"PedidosRetornados":' . json_encode(buscarPedidos($pdo, $retornoToken[0]['id'], 'PedidosRetornados',$dados['data'])) . ',';
            $lista = $lista . '"PedidosCancelados":' . json_encode(buscarPedidos($pdo, $retornoToken[0]['id'], 'PedidosCancelados',$dados['data'])) . '}';
            echo $lista;
    }
}

function buscarQuantidadesPedidos($pdo, $idempresa,$dataAbertura){
    $retorno = array();
    $sql = "select count(ped_id) as total from zmpro.pedido_food where ped_empresa = $idempresa and ped_status= 'Novo'";
    $pedido =$pdo->prepare($sql);
    $pedido->execute();
    $row = $pedido->fetchAll(PDO::FETCH_ASSOC);
    $qnt_novos = $row[0]['total']; 
    
    
    $sql = "select count(ped_id) as total from zmpro.pedido_food where ped_empresa = $idempresa and ped_status= 'Preparando'";
    $pedido =$pdo->prepare($sql);
    $pedido->execute();
    $row = $pedido->fetchAll(PDO::FETCH_ASSOC);
    $qnt_preparando = $row[0]['total']; 

    $sql = "select count(ped_id) as total from zmpro.pedido_food where ped_empresa = $idempresa and ped_status= 'Transito'";
    $pedido =$pdo->prepare($sql);
    $pedido->execute();
    $row = $pedido->fetchAll(PDO::FETCH_ASSOC);
    $qnt_transito = $row[0]['total']; 

    $sql = "select count(ped_id) as total from zmpro.pedido_food where ped_empresa = $idempresa  and ped_status= 'Entregue' and ped_emis between '$dataAbertura' and now()";
    $pedido =$pdo->prepare($sql);
    $pedido->execute();
    $row = $pedido->fetchAll(PDO::FETCH_ASSOC);
    $qnt_entregue = $row[0]['total']; 

    $sql = "select count(ped_id) as total from zmpro.pedido_food where ped_empresa = $idempresa  and ped_status= 'Retornado' and ped_emis between '$dataAbertura' and now()";
    $pedido =$pdo->prepare($sql);
    $pedido->execute();
    $row = $pedido->fetchAll(PDO::FETCH_ASSOC);
    $qnt_retornado = $row[0]['total']; 

    $sql = "select count(ped_id) as total from zmpro.pedido_food where ped_empresa = $idempresa  and ped_status= 'Cancelado' and ped_emis between '$dataAbertura' and now()";
    $pedido =$pdo->prepare($sql);
    $pedido->execute();
    $row = $pedido->fetchAll(PDO::FETCH_ASSOC);
    $qnt_cancelado = $row[0]['total']; 

    array_push($retorno , array(
        'Novo' => $qnt_novos,
        'Preparando' => $qnt_preparando,
        'Transito' => $qnt_transito,
        'Entregue' => $qnt_entregue,
        'Retornado' => $qnt_retornado,
        'Cancelado' => $qnt_cancelado
    ));

    return $retorno;
}

function buscarPedidos($pdo, $idempresa, $tipo, $dataAbertura){
    $retorno = array();
    if ($tipo =='PedidosNovos'){
        $sql = "SELECT * FROM pedido_food where ped_empresa = $idempresa and ped_status= 'Novo' order by ped_hora_entrada desc";
    }
    if ($tipo=='PedidosPreparo'){
        $sql = "SELECT * FROM pedido_food where ped_empresa = $idempresa and ped_status= 'Preparando' order by ped_hora_entrada desc";
    }
    if ($tipo=='PedidosTransito'){
        $sql = "SELECT * FROM pedido_food where ped_empresa = $idempresa and ped_status= 'Transito' order by ped_hora_entrada desc";
    }
    if ($tipo=='PedidosEntregues'){
        $sql = "SELECT * FROM zmpro.pedido_food where ped_empresa = $idempresa and ped_status='Entregue' and ped_emis between '$dataAbertura' and now() order by ped_hora_entrada desc";
    }
    if ($tipo=='PedidosRetornados'){
        $sql = "SELECT * FROM zmpro.pedido_food where ped_empresa = $idempresa and ped_status='Retornado' and ped_emis between '$dataAbertura' and now() order by ped_hora_entrada desc";
    }
    if ($tipo=='PedidosCancelados'){
        $sql = "SELECT * FROM zmpro.pedido_food where ped_empresa = $idempresa and ped_status='Cancelado' and ped_emis between '$dataAbertura' and now() order by ped_hora_entrada desc";
    }
    foreach ($pdo->query($sql) as $row) {
		array_push($retorno, array(
			'id' => $row['ped_id'],
			'docto' => $row['ped_doc'],
			//'ped_empresa' => $row['ped_empresa'],
			//'ped_matriz' => $row['ped_matriz'],
			'emissao' => utf8_encode($row['ped_emis']),
			'hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'hora_saida' => utf8_encode($row['ped_hora_saida']),
			'hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'hora_cancel' => utf8_encode($row['ped_hora_cancel']),
            'hora_retorno' => utf8_encode($row['ped_hora_retornado']),
			'cliente_cod' => $row['ped_cliente_cod'],
			'cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'cliente_nome' => utf8_encode($row['ped_cliente_nome']),
            'cliente_cep' => utf8_encode($row['ped_cliente_cep']),
			'cliente_end' => utf8_encode($row['ped_cliente_end']),
            'cliente_end_num' => utf8_encode($row['ped_cliente_end_num']),
			'cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
            'cliente_cep_entrega' => utf8_encode($row['ped_cliente_cep_entrega']),
			'cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
            'cliente_end_num_entrega' => utf8_encode($row['ped_cliente_end_num_entrega']),
			'cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'valor_itens' => $row['ped_valor'],
			'valor_descto' => $row['ped_val_desc'],
			'valor_entrega' => $row['ped_val_entrega'],
			'total_pedido' => $row['ped_total'],
			'obs' => utf8_encode($row['ped_obs']),
			'status' => utf8_encode($row['ped_status']),
			'pago' => utf8_encode($row['ped_pago']),
			'val_pg_dn' => $row['ped_val_pg_dn'],
			'val_pg_ca' => $row['ped_val_pg_ca'],
			'troco_para' => $row['ped_troco_para'],
			//'num_plataforma' => $row['ped_num_plataforma'],
			//'transacao' => utf8_encode($row['ped_transacao']),
			'entregar' => utf8_encode($row['ped_entregar']),
			'confirmado' => utf8_encode($row['ped_confirmado']),
            'finalizado'=>utf8_encode($row['ped_finalizado']),
            'itens'=>itens_pedido($pdo,$row['ped_id'])
        ));
    }
    return $retorno;
}

function itens_pedido($pdo, $id){
    $retorno = array();
    $sql = "SELECT * FROM pedido_item_food where pdi_idprim = $id order by pdi_id";
    foreach ($pdo->query($sql) as $row) {
        array_push($retorno, array(
            'id' => $row['pdi_id'],    
            'codigo_produto' => $row['pdi_produto'],
            'descricao' => utf8_encode($row['pdi_descricao']),
            'quantidade' => $row['pdi_quantidade'],
            'preco_base' => $row['pdi_preco_base'],
            'desconto' => $row['pdi_val_desc'],
            'valor_adicionais' => $row['pdi_val_adicional'],
            'valor_total_item' => $row['pdi_preco_total_item'],
            'valor_total' => $row['pdi_total'],
            'obs' => utf8_encode($row['pdi_obs'])
        ));
    }
    return $retorno;
}
