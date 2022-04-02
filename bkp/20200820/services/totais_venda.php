<?php
include 'conecta.php';
include 'log.php';

date_default_timezone_set('America/Bahia');


$ip = get_client_ip();

$data = date('Y-m-d');
$hora = date('H:i:s');

$empresaMatriz = base64_decode($_GET['e']);

$empresaAcesso = base64_decode($_GET['eA']);

if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$cf_empresa = '';

	} else {
		$cf_empresa = ' and cf_empresa= ' . $empresa;
	}

} else {
	$cf_empresa = '';
}

if (isset($_GET['funcionario'])) {
	$funcionario = $_GET['funcionario'];

	if ($funcionario == null) {
		$vd_func = '';
	} else {
		$vd_func = ' and vd_func=' . $funcionario;
	}
} else {
	$vd_func = '';
}

if (isset($_GET['status'])) {
	$status = $_GET['status'];
	if ($status == 'A') {
		$vd_status = 'and vd_status = "Aberto"';
	} else if ($status == 'F') {
		$vd_status = 'and vd_status = "Fechado" and vd_emis between ' . $dataI . ' and ' . $dataF;
	}
} else {
	$vd_status = '';
}

if (isset($_GET['relatorio'])) {


	if (isset($_GET['totaisVendas'])) {
		$dataI = $_GET['dataI'];
		$dataF = $_GET['dataF'];
		$lista = '{"result":[' . json_encode(totaisVendas($conexao, $empresaMatriz, $cf_empresa, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	
	if (isset($_GET['despesasFixas'])) {
		$lista = '{"result":[' . json_encode(despesasFixas($conexao, $empresaMatriz, $cf_empresa)) . ']}';
		echo $lista;
	}


}

if (isset($_GET['salvar'])) {
    $cf_nome = utf8_decode($_GET['cf_nome']);
    $cf_historico = $_GET['cf_historico'];
    salvarCustoFixo($conexao, $empresaAcesso, $empresaMatriz, $cf_nome, $cf_historico, $data, $hora, $ip, $us_id);
}


function salvarCustoFixo($conexao, $empresaAcesso, $empresaMatriz, $cf_nome, $cf_historico, $data, $hora, $ip, $us_id){
    
    $sql = "INSERT INTO custos_fixos (cf_empresa, cf_matriz, cf_nome, cf_ativo, cf_historico) values ('$empresaAcesso', $empresaMatriz, (select ht_descricao from historico where ht_id = $cf_nome), 'S', $cf_historico);";

    //echo $sql;

    $query = mysqli_query($conexao,$sql);
    $retorno = mysqli_affected_rows($conexao);

    if ($retorno <= 0) {
        echo 0;
    }else if($retorno >= 1){
        echo 1;
        logSistema_forID($conexao, $data, $hora, $ip, $us_id, utf8_decode('Custo Fixo Criado Nome - ' . $cf_nome . ''), $empresaAcesso, $empresaMatriz);
    }
}



function totaisVendas($conexao, $empresaMatriz, $cf_empresa, $dataI, $dataF) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT sum(vd_total) as total, sum(vd_vl_pagto_dn - vd_vl_troco) as dinheiro , sum(vd_vl_pagto_ca) as cartao, sum(vd_vl_pagto_bl + vd_vl_pagto_dp) as prazo,
	(select sum(vd_total) from vendas where vd_nf <> 0 and vd_emis between '$dataI' and '$dataF'
and vd_matriz = $empresaMatriz) as totalred
FROM vendas where vd_emis between '$dataI' and '$dataF'
and vd_matriz = $empresaMatriz;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(

			'total' => $row['total'],
			'dinheiro' => $row['dinheiro'],
			'cartao' => $row['cartao'],
			'prazo' => $row['prazo'],
			'totalred' => $row['totalred'],
		));

	}

	echo $sql;
	return $resultado;
}

function despesasFixas($conexao, $empresaMatriz, $cf_empresa) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT * FROM custos_fixos where cf_ativo <> ''
and cf_matriz = $empresaMatriz $cf_empresa;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(

			'cf_empresa' => $row['cf_empresa'],
			'cf_matriz' => $row['cf_matriz'],
			'cf_nome' => ucwords(strtolower(utf8_decode($row['cf_nome']))),
			'cf_valor' => utf8_encode($row['cf_valor']),
			'cf_historico' => $row['cf_historico'],
		));

	}

	echo $sql;
	return $resultado;
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

?>