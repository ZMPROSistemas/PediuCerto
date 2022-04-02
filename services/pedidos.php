<?php

require_once 'conecta.php';
require_once 'conectaPDO.php';
include 'log.php';
date_default_timezone_set('America/Bahia');

$empresaMatriz = base64_decode($_GET['empresa_matriz']);

$empresaAcesso = base64_decode($_GET['empresa_filial']);
$us_id = base64_decode($_GET['us_id']);
$em_razao = $_GET['nomeEmp'];
$us = base64_decode($_GET['us']);
$status = $_GET['status'];
$dataAbertura = $_GET['dataAbertura'];

if(isset($_GET['id'])){
	$id = $_GET['id'];
}
if(isset($_GET['ped_doc'])){
	$ped_doc = $_GET['ped_doc'];
}
$data = date('Y-m-d');
$hora = date('H:i:s');
$ip = get_client_ip();

if (isset($_GET['vericaPedidos'])) {

	if (isset($_GET['pedidosNovos'])) {

		$lista = '{"result":[' . json_encode(pedidosNovos($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura)) . ']}';
		echo $lista;
	}

	if(isset($_GET['descricao'])){
		$lista = '{"result":[' . json_encode(descricao($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura, $id)) . ']}';
		echo $lista;
	}
	if(isset($_GET['descricaoItens'])){
		$lista = '{"result":[' . json_encode(descricaoItens($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura, $ped_doc)) . ']}';
		echo $lista;
	}
	if(isset($_GET['confirmarPedido'])){
		$confirmarPedifo = confirmarPedido($pdo, $conexao, $empresaMatriz, $empresaAcesso, $dataAbertura, $id, $ped_doc, $us, $data, $hora, $em_razao, $ip);
	}

	if(isset($_GET['pedidosPreparo'])){
		$lista = '{"result":[' . json_encode(pedidosPreparo($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura)). ']}';
		echo $lista;
	}

	if (isset($_GET['pedidosTransito'])) {
		$lista = '{"result":[' . json_encode(pedidosTransito($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura)). ']}';
		echo $lista;
	}

	if (isset($_GET['pedidosEntregue'])) {
		$lista = '{"result":[' . json_encode(pedidosEntregue($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura)). ']}';
		echo $lista;
	}

	if (isset($_GET['pedidosRetornado'])) {
		$lista = '{"result":[' . json_encode(pedidosRetornado($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura)). ']}';
		echo $lista;
	}

	if (isset($_GET['pedidosCancelado'])) {
		$lista = '{"result":[' . json_encode(pedidosCancelado($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura)). ']}';
		echo $lista;
	}

	if (isset($_GET['mudarStatusPedido'])) {
		$array = json_decode(file_get_contents("php://input"), true);
		if (isset($array['motivo'])) {
			$motivo = $array['motivo'];
		}else{
			$motivo = NULL;
		}
		$mudarStatus = $_GET['mudarStatus'];

		$campoHora = '';
		if ($mudarStatus == 'Preparando') {
			$campoHora = ' ped_hora_preparo=';
		}
		else if ($mudarStatus == 'Transito') {
			$campoHora = ' ped_hora_saida=';
		}
		else if ($mudarStatus == 'Entregue') {
			$campoHora = ' ped_hora_entrega=';
		}
		else if ($mudarStatus == 'Cancelado') {
			$campoHora = ' ped_hora_cancel=';
		}
		else if ($mudarStatus == 'Retornado') {
			$campoHora = ' ped_hora_retornado=';
		}
		else if ($mudarStatus == 'Novo') {
			$campoHora = ' ped_hora_preparo=';
		}
		
		$mudarStatus = atualizaPedidoStatus($conexao, $empresaMatriz, $empresaAcesso, $id, $campoHora, $mudarStatus, $ped_doc, $data, $hora, $ip, $us, $motivo);
	}

	if (isset($_GET['ultimaAtualizacao'])) {
		$lista = atualizaPedido($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura);
		echo $lista;
	}
}

function pedidosNovos($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura) {

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}
	$resultado = array();

	$sql = "SELECT * FROM pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Novo'
 	order by ped_hora_entrada desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}

	//echo $sql;
	
	return $resultado;
}

function pedidosPreparo($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura){
	
	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$resultado = array();

	$sql = "SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Preparando'
 	order by ped_hora_entrada desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}
	return $resultado;
}

function pedidosTransito($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$resultado = array();

	$sql = "SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Transito'
 	order by ped_hora_entrada desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}
	return $resultado;
}

function pedidosEntregue($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$resultado = array();

	$sql = "SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_emis between '$dataAbertura' and now() and ped_status= 'Entregue'
	order by ped_hora_entrada desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}
	return $resultado;
}

function pedidosRetornado($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$resultado = array();

	$sql = "SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Retornado'
	and ped_emis between '$dataAbertura' and now() order by ped_hora_entrada desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}
	return $resultado;
}

function pedidosCancelado($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$resultado = array();

	$sql = "SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Cancelado'
	and ped_emis between '$dataAbertura' and now() order by ped_hora_entrada desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}
	return $resultado;
}


function descricao($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura, $id) {

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}
	$resultado = array();

	//$sql = "SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_emis between '$dataAbertura' and now()  and ped_id = $id";

	$sql = "SELECT * FROM pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_id = $id";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'ped_id' => $row['ped_id'],
			'ped_doc' => $row['ped_doc'],
			'ped_empresa' => $row['ped_empresa'],
			'ped_matriz' => $row['ped_matriz'],
			'ped_emis' => utf8_encode($row['ped_emis']),
			'ped_hora_entrada' => utf8_encode($row['ped_hora_entrada']),
			'ped_hora_preparo' => utf8_encode($row['ped_hora_preparo']),
			'ped_hora_saida' => utf8_encode($row['ped_hora_saida']),
			'ped_hora_entrega' => utf8_encode($row['ped_hora_entrega']),
			'ped_hora_cancel' => utf8_encode($row['ped_hora_cancel']),
			'ped_cliente_cod' => $row['ped_cliente_cod'],
			'ped_cliente_fone' => utf8_encode($row['ped_cliente_fone']),
			'ped_cliente_nome' => utf8_encode($row['ped_cliente_nome']),
			'ped_cliente_end' => utf8_encode($row['ped_cliente_end']),
			'ped_cliente_compl' => utf8_encode($row['ped_cliente_compl']),
			'ped_cliente_bairro' => utf8_encode($row['ped_cliente_bairro']),
			'ped_cliente_cid' => utf8_encode($row['ped_cliente_cid']),
			'ped_cliente_regiao' => utf8_encode($row['ped_cliente_regiao']),
			'ped_cliente_end_entrega' => utf8_encode($row['ped_cliente_end_entrega']),
			'ped_cliente_end_num_entrega' => $row['ped_cliente_end_num_entrega'],
			'ped_cliente_compl_entrega' => utf8_encode($row['ped_cliente_compl_entrega']),
			'ped_cliente_bairro_entrega' => utf8_encode($row['ped_cliente_bairro_entrega']),
			'ped_cliente_cid_entrega' => utf8_encode($row['ped_cliente_cid_entrega']),
			'ped_cliente_regiao_entrega' => utf8_encode($row['ped_cliente_regiao_entrega']),
			'ped_valor' => $row['ped_valor'],
			'ped_val_desc' => $row['ped_val_desc'],
			'ped_val_entrega' => $row['ped_val_entrega'],
			'ped_total' => $row['ped_total'],
			'ped_obs' => utf8_encode($row['ped_obs']),
			'ped_status' => utf8_encode($row['ped_status']),
			'ped_pago' => utf8_encode($row['ped_pago']),
			'ped_val_pg_dn' => $row['ped_val_pg_dn'],
			'ped_val_pg_ca' => $row['ped_val_pg_ca'],
			'ped_troco_para' => $row['ped_troco_para'],
			'ped_num_plataforma' => $row['ped_num_plataforma'],
			'ped_transacao' => utf8_encode($row['ped_transacao']),
			'ped_entregar' => utf8_encode($row['ped_entregar']),
			'ped_confirmado' => utf8_encode($row['ped_confirmado']),
			'ped_cliente_cep' => utf8_encode($row['ped_cliente_cep']),
			'ped_cliente_end_num' => utf8_encode($row['ped_cliente_end_num']),
			'ped_finalizado'=>utf8_encode($row['ped_finalizado']),

		));
	}
	//echo $sql;
	return $resultado;
}

function descricaoItens($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura, $ped_doc){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$resultado = array();

	$sql= "SELECT * FROM pedido_item_food where pdi_matriz = $empresaMatriz and pdi_empresa = $empresaAcesso and pdi_doc = $ped_doc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'pdi_id' => $row['pdi_id'],
			'pdi_idprim' => $row['pdi_idprim'],
			'pdi_doc' => $row['pdi_doc'],
			'pdi_empresa' => $row['pdi_empresa'],
			'pdi_matriz' => $row['pdi_matriz'],
			'pdi_emis' => utf8_encode($row['pdi_emis']),
			'pdi_produto' => $row['pdi_produto'],
			'pdi_descricao' => utf8_encode($row['pdi_descricao']),
			'pdi_quantidade' => $row['pdi_quantidade'],
			'pdi_preco_base' => $row['pdi_preco_base'],
			'pdi_val_desc' => $row['pdi_val_desc'],
			'pdi_val_adicional' => $row['pdi_val_adicional'],
			'pdi_preco_total_item' => $row['pdi_preco_total_item'],
			'pdi_total' => $row['pdi_total'],
			'pdi_obs' => utf8_encode($row['pdi_obs']),
			'pdi_status' => utf8_encode($row['pdi_status']),

		));
	}
	
	//echo $sql;
	return $resultado;
}

function confirmarPedido($pdo, $conexao, $empresaMatriz, $empresaAcesso, $dataAbertura, $id, $ped_doc, $us, $data, $hora, $em_razao, $ip){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$sqlEmp = "SELECT em_cod, em_fanta, em_end, em_end_num, em_entrega1, em_entrega2, em_retira FROM empresas where em_cod = $empresaAcesso;";
	$queryEmp = mysqli_query($conexao, $sqlEmp);
	$rowEmp = mysqli_fetch_assoc($queryEmp);
	
	$sql = "UPDATE pedido_food set ped_confirmado = 'S' where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_id = $id ";

	$query = mysqli_query($conexao, $sql);

	if (mysqli_affected_rows($conexao) < 0) {
		echo 0;
	} else {
		echo 1;
		logSistema($conexao, $data, $hora, $ip, $us, 'Pedido '. $ped_doc .' Aberto ',$empresaAcesso, $empresaMatriz);

		$sqlP ="SELECT ped_id, ped_doc, ped_matriz, ped_empresa, (select em_fanta from empresas where em_cod = ped_empresa) as em_fanta, 
		ped_emis, ped_hora_entrada, ped_cliente_cod, ped_cliente_fone, ped_cliente_nome, ped_cliente_cep_entrega, ped_cliente_end_entrega,
		ped_cliente_end_num_entrega, ped_cliente_compl_entrega, ped_cliente_bairro_entrega, ped_cliente_cid_entrega, ped_valor,
		ped_val_entrega, ped_total, ped_status, ped_entregar, ped_confirmado FROM pedido_food where ped_empresa = $empresaAcesso and ped_id = $id;";
		$queryP = mysqli_query($conexao, $sqlP);
		$row = mysqli_fetch_assoc($queryP);

		/*echo '<pre>';
		print_r($row);
		echo '</pre>';*/
		
		$stmt = $pdo->prepare("SELECT * FROM pedido_item_food where pdi_empresa = :pdi_empresa and pdi_doc = :pdi_doc;");
		$stmt->bindValue(":pdi_empresa",$empresaAcesso);
		$stmt->bindValue(":pdi_doc",$row['ped_doc']);
		$stmt->execute();
		$rowItemP = $stmt->fetchAll(PDO::FETCH_ASSOC);

		//envia pedido WhatsApp

		$modoEntrega = "";

		if($row['ped_entregar'] == 'S'){
			$modoEntrega = "Delivery";
		}else{
			$modoEntrega = "Retirada";
		}
          
		$msg = "Olá ".utf8_encode($row['ped_cliente_nome']).", seu pedido foi confirmado &#013;";
		$msg .= "&#013;";
		$msg .= "&#013;";
		$msg .= " Estabelecimento *". utf8_encode($row['em_fanta']) ."*&#013;";
		$msg .= "&#013;";
		$msg .= "&#013;";
		$msg .= " Pedido nº *".$row['ped_doc']. "*&#013;";
		if($modoEntrega == "Delivery"){
			$msg .= "🛵 ";
		}else{
			$msg .= "🤤 ";
		}
		$msg .= " Modo de entrega: *".$modoEntrega."* &#013;";
		if($modoEntrega == "Delivery"){
			$msg .= " Endereço: ". utf8_encode($row['ped_cliente_end_entrega']).", ".$row['ped_cliente_end_num_entrega']." &#013;";
			$msg .= " Taxa de entrega: ". $row['ped_val_entrega'] . "&#013;";
		}
		$msg .= "&#013;";
		$msg .= "&#013;";
		if(count($rowItemP) > 1){
			$msg .= "Itens &#013;";
		}else{
			$msg .= "Item &#013;";
		}
		foreach ($rowItemP as $rowItemP){
			$msg .= "👉 ". (int)$rowItemP['pdi_quantidade'] . ' X ' . $rowItemP['pdi_descricao'];
			if($rowItemP['pdi_obs'] != null && $rowItemP['pdi_obs'] != ""){
				$msg .= "(".$rowItemP['pdi_obs'].")";
			}
			$msg .= "&#013;";
		}
		$msg .= "&#013;";
		$msg .= "&#013;";
		$msg .= "&#013;";
		$msg.="Total: *" .$row['ped_total']. "*";
		$msg ."&#013;";
		$msg .="⏱ Tempo estimado (".$modoEntrega.")&#013;";
		
		if($modoEntrega == "Delivery"){
			$msg .="Entre *" .$rowEmp['em_entrega1']." à " .$rowEmp['em_entrega2']." minutos*";
		}else{
			$msg .="Entre *" .$rowEmp['em_retira']." minutos*";
		}
		
		
		/*echo '<pre>';
		print_r($rowEmp);
		echo '</pre>';

		
		echo '<pre>';
		print_r($msg);
		echo '</pre>';*/

		enviarmsg($row['ped_cliente_fone'],$msg);
	}
		

}

function atualizaPedidoStatus($conexao, $empresaMatriz, $empresaAcesso, $id, $campoHora, $mudarStatus, $ped_doc, $data, $hora, $ip, $us, $motivo){
	
	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}
	
	$sql="update pedido_food set ped_status='$mudarStatus', $campoHora'$hora' , ped_motivo_canc= '$motivo' where ped_matriz = $empresaMatriz  and ped_empresa = $empresaAcesso and ped_id=$id;";

	$query = mysqli_query($conexao, $sql);

	if (mysqli_affected_rows($conexao) < 0) {
		echo 0;
	} else {
		echo 1;
		
		logSistema($conexao, $data, $hora, $ip, $us, 'Pedido '. $ped_doc .' Mudou Status para ' . $mudarStatus .'',$empresaAcesso, $empresaMatriz);
		
		$sqlP ="SELECT ped_id, ped_doc, ped_matriz, ped_empresa, (select em_fanta from empresas where em_cod = ped_empresa) as em_fanta, 
		ped_emis, ped_hora_entrada, ped_cliente_cod, ped_cliente_fone, ped_cliente_nome, ped_cliente_cep_entrega, ped_cliente_end_entrega,
		ped_cliente_end_num_entrega, ped_cliente_compl_entrega, ped_cliente_bairro_entrega, ped_cliente_cid_entrega, ped_valor,
		ped_val_entrega, ped_total, ped_status, ped_entregar, ped_confirmado, ped_motivo_canc FROM pedido_food where ped_empresa = $empresaAcesso and ped_id = $id;";
		$queryP = mysqli_query($conexao, $sqlP);
		$row = mysqli_fetch_assoc($queryP);

			/*echo '<pre>';
			print_r($row);
			echo '</pre>';*/

		if($mudarStatus == "Transito"){

			$msg = "Seu Pedido esta a caminho 🤤";
			enviarmsg($row['ped_cliente_fone'], $msg);
		}else if($mudarStatus == "Retornado"){
			$msg = "Seu foi retornado 😟";
			enviarmsg($row['ped_cliente_fone'], $msg);
		}else if($mudarStatus == "Entregue"){
			$msg = "Obrigado pelo seu pedido 😍 &#013;";
			$msg .= utf8_encode($row['em_fanta']) . " agradece sua preferencia 👏👏";
			enviarmsg($row['ped_cliente_fone'], $msg);
		}
		
	}
	
}

function atualizaPedido($conexao, $empresaMatriz, $empresaAcesso, $dataAbertura){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}

	$sql = "SELECT max(ped_id) as ped_id FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Novo'
	and ped_confirmado = 'N' and ped_emis between '$dataAbertura' and now();";
	
	$query = mysqli_query($conexao, $sql);

	$row = mysqli_fetch_assoc($query);

	//echo $row['ped_id'];
	
	//echo $sql;
	return $row['ped_id'];

}
function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}

function enviarmsg($numero, $msg){

	
	$curl = curl_init();
		
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.wassenger.com/v1/messages",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "{\"phone\":\"+55".$numero."\",\"message\":\" $msg \"}",
	  CURLOPT_HTTPHEADER => array(
		  "content-type: application/json",
		  "token: 6fc9dca1dd8bc8af52c6848e1b97b98f27fd497cbf3f285af356a06f022767467c2ba6fbad5d49c8"
	  )
	));
  
	$response= curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);

	/*if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo '<pre>';
		  print_r($response);
	  echo '</pre>';
	  
	}
*/

	///----------------


	
}	
?>