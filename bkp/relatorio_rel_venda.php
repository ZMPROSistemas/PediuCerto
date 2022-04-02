<?php
require_once 'conecta.php';

$empresaMatriz = base64_decode($_GET['e']);

$empresaAcesso = base64_decode($_GET['eA']);

if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$vd_empr = '';

	} else {
		$vd_empr = ' and vd_empr= ' . $empresa;
	}

} else {
	$vd_empr = '';
}

if (isset($_GET['clientes'])) {

	$clientes = $_GET['clientes'];

	if ($clientes == null) {
		$vd_cli = '';
	} else {
		$vd_cli = '  and vd_cli= ' . $clientes;
	}
} else {
	$vd_cli = '';
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

if (isset($_GET['fPagamento'])) {
	$fPagamento = $_GET['fPagamento'];

	if ($fPagamento == null) {
		$vd_forma = '';
	} else {
		$vd_forma = '  and vd_forma=' . $fPagamento;
	}
} else {
	$vd_forma = '';
}

$dataI = $_GET['dataI'];
$dataF = $_GET['dataF'];

if (isset($_GET['vd_doc'])) {
	$vd_doc = $_GET['vd_doc'];
} else {
	$vd_doc = '';
}


if (isset($_GET['relatorio'])) {

	if (isset($_GET['pagination'])) {

		$lista = '{"result":[' . json_encode(relatorioPaginate($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma)) . ']}';
		echo $lista;

	}

	if (isset($_GET['dadosRegistro'])) {

		$lista = '{"result":[' . json_encode(relatorio($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma)) . ']}';
		echo $lista;

	}
	if (isset($_GET['relatorioTotalValor'])) {
		$lista = '{"result":[' . json_encode(relatorioTotal_Valor($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma)) . ']}';
		echo $lista;
	}
	if (isset($_GET['relatorioTotalRegistro'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalRegistro($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma)) . ']}';
		echo $lista;
	}
	
	if (isset($_GET['relatorioTotalCliente'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalCliente($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma)) . ']}';
		echo $lista;
	}

	if (isset($_GET['relatorioTotalGrupoBy'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalGrupoBy($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma)) . ']}';
		echo $lista;
	}

	if (isset($_GET['dadosVendas'])) {
		$lista = '{"result":[' . json_encode(dadosVendas($conexao, $empresaMatriz, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	
	if (isset($_GET['itensVenda'])) {
		$lista = '{"result":[' . json_encode(itensVenda($conexao, $empresaMatriz, $dataI, $dataF, $vd_doc)) . ']}';
		echo $lista;
	}

	if (isset($_GET['dadosCondicionais'])) {
		$lista = '{"result":[' . json_encode(dadosCondicionais($conexao, $empresaMatriz, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	
	if (isset($_GET['itensCondicional'])) {
		$lista = '{"result":[' . json_encode(itensCondicional($conexao, $empresaMatriz, $dataI, $dataF, $vd_doc)) . ']}';
		echo $lista;
	}

}

function relatorioPaginate($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma) {

	$resultado = array();

	$sql = "SELECT vendas.vd_id, vendas.vd_doc, vendas.vd_canc, vendas.vd_aberto, vendas.vd_forma, vendas.vd_status,
vendas.vd_pgr, vendas.vd_cli, vendas.vd_func, vendas.vd_empr, vendas.vd_matriz, vendas.vd_emis, vendas.vd_valor,
vendas.vd_desc, vendas.vd_total, vendas.vd_nome, tipo_docto.dc_descricao, tipo_docto.dc_sigla
FROM vendas inner join tipo_docto on (vendas.vd_forma = tipo_docto.dc_codigo and vendas.vd_matriz = tipo_docto.dc_matriz)
where vd_emis between '$dataI' and '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'
and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func $vd_forma;";

	//$sql = "select vd_id, vd_doc, vd_cli, vd_func, vd_empr, vd_matriz, vd_emis, vd_valor, vd_desc, vd_total, vd_nome from vendas where vd_empr and vd_emis >= '2020-04-14' and vd_emis <= '2020-04-28' and vd_func = 1 and vd_cli= 1;";

	$query = mysqli_query($conexao, $sql);

	array_push($resultado, array(
		'total' => mysqli_num_rows($query),

	));

	//echo $sql;
	return $resultado;
}

function relatorio($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma) {

	$resultado = array();

	$sql = "SELECT vendas.vd_id, vendas.vd_doc, vendas.vd_canc, vendas.vd_aberto, vendas.vd_forma, vendas.vd_status,
vendas.vd_pgr, vendas.vd_cli, vendas.vd_func, vendas.vd_empr, empresas.em_fanta, vendas.vd_matriz, vendas.vd_emis, vendas.vd_valor,
vendas.vd_desc, vendas.vd_total, vendas.vd_nome, tipo_docto.dc_descricao, tipo_docto.dc_sigla
FROM vendas inner join tipo_docto on (vendas.vd_forma = tipo_docto.dc_codigo and vendas.vd_matriz = tipo_docto.dc_matriz)
inner join empresas on (vendas.vd_empr = empresas.em_cod)
where vd_emis between '$dataI' and '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'
and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func $vd_forma;";

	//$sql = "select vd_id, vd_doc, vd_cli, vd_func, vd_empr, vd_matriz, vd_emis, vd_valor, vd_desc, vd_total, vd_nome from vendas where vd_empr and vd_emis >= '2020-04-14' and vd_emis <= '2020-04-28' and vd_func = 1 and vd_cli= 1;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'vd_id' => $row['vd_id'],
			'vd_doc' => $row['vd_doc'],
			'vd_canc' => $row['vd_canc'],
			'vd_aberto' => $row['vd_aberto'],
			'vd_forma' => $row['vd_forma'],
			'vd_status' => $row['vd_status'],
			'vd_pgr' => $row['vd_pgr'],
			'vd_cli' => $row['vd_cli'],
			'vd_func' => $row['vd_func'],
			'vd_empr' => $row['vd_empr'],
			'em_fanta' => utf8_encode($row['em_fanta']),
			'vd_matriz' => $row['vd_matriz'],
			'vd_emis' => utf8_encode($row['vd_emis']),
			'vd_valor' => $row['vd_valor'],
			'vd_desc' => $row['vd_desc'],
			'vd_taxa' => 0,
			'vd_total' => $row['vd_total'],
			'vd_nome' => utf8_encode($row['vd_nome']),
			'dc_descricao' => utf8_encode($row['dc_descricao']),
			'dc_sigla' => utf8_encode($row['dc_sigla']),

		));

	}

	//echo $sql;

	return $resultado;
}

function relatorioTotal_Valor($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma) {

	$resultado = array();

	//$sql = "select sum(vd_total) totalSoma from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT sum(vd_total) as totalSoma
FROM vendas inner join tipo_docto on (vendas.vd_forma = tipo_docto.dc_codigo and vendas.vd_matriz = tipo_docto.dc_matriz)
where vd_emis between '$dataI' and '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'
and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func $vd_forma;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'totalSoma' => $row['totalSoma'],
		));

	}

	return $resultado;
}

function relatorioTotalRegistro($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma) {

	$resultado = array();

	//$sql = "select count(vd_cli) totalRegistro from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT count(vd_cli) totalRegistro
FROM vendas inner join tipo_docto on (vendas.vd_forma = tipo_docto.dc_codigo and vendas.vd_matriz = tipo_docto.dc_matriz)
where vd_emis between '$dataI' and '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'
and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func $vd_forma;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'totalRegistro' => $row['totalRegistro'],
		));

	}

	return $resultado;
}

function relatorioTotalCliente($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT count(distinct(vd_nome)) totalCliente
FROM vendas inner join tipo_docto on (vendas.vd_forma = tipo_docto.dc_codigo and vendas.vd_matriz = tipo_docto.dc_matriz)
where vd_emis between '$dataI' and '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'
and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func $vd_forma;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'totalCliente' => $row['totalCliente'],
		));

	}

	//echo $sql;
	return $resultado;
}

function relatorioTotalGrupoBy($conexao, $empresaMatriz, $dataI, $dataF, $vd_empr, $vd_cli, $vd_func, $vd_forma) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT sum(vd_total) as total , dc_descricao
FROM vendas inner join tipo_docto on (vendas.vd_forma = tipo_docto.dc_codigo and vendas.vd_matriz = tipo_docto.dc_matriz)
where vd_emis between '$dataI' and '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'
and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func $vd_forma group by dc_descricao;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'total' => $row['total'],
			'dc_descricao' => utf8_encode($row['dc_descricao']),
		));

	}

	//echo $sql;
	return $resultado;
}

function dadosVendas($conexao, $empresaMatriz, $dataI, $dataF) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "select vendas.vd_doc, vendas.vd_emis, vendas.vd_hora, vendas.vd_nome, vendas.vd_total, 
					vendas.vd_nf, vendas.vd_vl_pagto_dn, vendas.vd_vl_pagto_ca, vendas.vd_vl_pagto_dp, empresas.em_fanta 
			from vendas inner join empresas on vendas.vd_empr = empresas.em_cod
			where vendas.vd_matriz = 1
			and vendas.vd_emis between '$dataI' and '$dataF'
			order by vendas.vd_emis DESC, vendas.vd_hora DESC;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'vd_doc' => $row['vd_doc'],
			'vd_emis' => utf8_encode($row['vd_emis']),
			'vd_hora' => utf8_encode($row['vd_hora']),
			'vd_nf' => $row['vd_nf'],
			'vd_vl_pagto_dn' => utf8_encode($row['vd_vl_pagto_dn']),
			'vd_vl_pagto_ca' => utf8_encode($row['vd_vl_pagto_ca']),
			'vd_vl_pagto_dp' => utf8_encode($row['vd_vl_pagto_dp']),
			'vd_nome' => ucwords(strtolower(utf8_decode($row['vd_nome']))),
			'vd_total' => utf8_encode($row['vd_total']),
			'em_fanta' => ucwords(strtolower(utf8_decode($row['em_fanta']))),
		));

	}

	//echo $sql;
	return $resultado;
}

function itensVenda($conexao, $empresaMatriz, $dataI, $dataF, $vd_doc) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "select vdi_prod, vdi_descricao, vdi_quant, vdi_valprod, vdi_total 
			from venda_item
			where vdi_doc = $vd_doc
			order by vdi_prod;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'vdi_prod' => $row['vdi_prod'],
			'vdi_descricao' => ucwords(strtolower(utf8_decode($row['vdi_descricao']))),
			'vdi_quant' => $row['vdi_quant'],
			'vdi_valprod' => utf8_encode($row['vdi_valprod']),
			'vdi_total' => utf8_encode($row['vdi_total']),
		));

	}

//	echo $sql;
	return $resultado;
}

function dadosCondicionais($conexao, $empresaMatriz, $dataI, $dataF) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "select condicional.vd_doc, condicional.vd_emis, condicional.vd_hora, condicional.vd_nome, condicional.vd_total, empresas.em_fanta 
			from condicional inner join empresas on condicional.vd_empr = empresas.em_cod
			where condicional.vd_matriz = 1
			and condicional.vd_emis between '$dataI' and '$dataF'
			order by condicional.vd_emis DESC, condicional.vd_hora DESC;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'vd_doc' => $row['vd_doc'],
			'vd_emis' => utf8_encode($row['vd_emis']),
			'vd_hora' => utf8_encode($row['vd_hora']),
			'vd_nome' => ucwords(strtolower(utf8_decode($row['vd_nome']))),
			'vd_total' => utf8_encode($row['vd_total']),
			'em_fanta' => $row['em_fanta'],
		));

	}

	//echo $sql;
	return $resultado;
}

function itensCondicional($conexao, $empresaMatriz, $dataI, $dataF, $vd_doc) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "select vdi_prod, vdi_descricao, vdi_quant, vdi_valprod, vdi_total 
			from condic_item
			where vdi_doc = $vd_doc
			order by vdi_prod;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'vdi_prod' => $row['vdi_prod'],
			'vdi_descricao' => ucwords(strtolower(utf8_decode($row['vdi_descricao']))),
			'vdi_quant' => $row['vdi_quant'],
			'vdi_valprod' => utf8_encode($row['vdi_valprod']),
			'vdi_total' => utf8_encode($row['vdi_total']),
		));

	}

//	echo $sql;
	return $resultado;
}


?>