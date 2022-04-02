<?php

require_once 'conecta.php';

$empresaMatriz = base64_decode($_GET['e']);

$empresaAcesso = base64_decode($_GET['eA']);

if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$tr_empresa = '';

	} else {
		$tr_empresa = ' and tr_empresa= ' . $empresa;
	}

} else {
	$tr_empresa = '';
}
if (isset($_GET['dataI'])){
	$dataI = $_GET['dataI'];
}
if (isset($_GET['dataF'])){
	$dataF = $_GET['dataF'];
}


if (isset($_GET['tr_id'])) {
	$tr_id = $_GET['tr_id'];
} else {
	$tr_id = '';
}

if (isset($_GET['funcionario'])) {
	$funcionario = $_GET['funcionario'];

	if ($funcionario == null) {
		$vd_func = '';
	} 
} else {
	$vd_func = '';
}

//$EditarCadastrarExcluir = $_GET['EditarCadastrarExcluir'];


//$array = json_decode(file_get_contents("php://input"), true);

//$id = $_GET['id'];

if (isset($_GET['dadosTransferencias'])) {

	$lista = '{"result":[' . json_encode(dadosTransferencias($conexao, $empresaMatriz, $tr_empresa, $dataI, $dataF)) . ']}';
	echo $lista;

} 

if (isset($_GET['itensTransf'])) {

	$lista = '{"result":[' . json_encode(itensTransf($conexao, $empresaMatriz, $dataI, $dataF, $tr_id)) . ']}';
	echo $lista;

}

if (isset($_GET['estoqueSimplificado'])){

	$es_prod = $_GET['pd_cod'];
	$lista = '{"result":[' .json_encode(estoqueSimplificado($conexao, $empresaMatriz, $es_prod)) . ']}';
	echo $lista;

}

if (isset($_GET['movimento_cardex'])){
	$es_prod = $_GET['pd_cod'];
	$lista = '{"result":[' . json_encode(movimentacao_cardex($conexao, $empresaMatriz, $es_prod)).']}';
	echo $lista;
}

function dadosTransferencias($conexao, $empresaMatriz, $tr_empresa, $dataI, $dataF) {

	$retorno = array();

	$sql = "select 	transferencia.tr_id,
					transferencia.tr_cod,
					transferencia.tr_empresa,
					transferencia.tr_data,
					(select empresas.em_fanta from empresas where empresas.em_cod_local = transferencia.tr_saida and transferencia.tr_matriz = empresas.em_cod_matriz) as emp_saida,
					(select empresas.em_fanta from empresas where empresas.em_cod_local = transferencia.tr_entrada and transferencia.tr_matriz = empresas.em_cod_matriz) as emp_entrada,
					transferencia.tr_pedido,
					transferencia.tr_autorizado,
					transferencia.tr_sel,
					transferencia.tr_lancado,
					transferencia.tr_enviado,
					transferencia.tr_recebido
 			from transferencia inner join empresas on transferencia.tr_empresa = empresas.em_cod and transferencia.tr_matriz = empresas.em_cod_matriz
 			where tr_matriz = $empresaMatriz $tr_empresa
			and tr_data between '$dataI' and '$dataF';";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($retorno, array(
				'tr_id' => $row['tr_id'],
				'tr_cod' => $row['tr_cod'],
				'tr_empresa' => $row['tr_empresa'],
				'tr_data' => utf8_encode($row['tr_data']),
				'emp_saida' => ucwords(strtolower(utf8_encode($row['emp_saida']))),
				'emp_entrada' => ucwords(strtolower(utf8_encode($row['emp_entrada']))),
				'tr_pedido' => $row['tr_pedido'],
				'tr_autorizado' => $row['tr_autorizado'],
				'tr_sel' => $row['tr_sel'],
				'tr_lancado' => $row['tr_lancado'],
				'tr_enviado' => $row['tr_enviado'],
				'tr_recebido' => $row['tr_recebido'],
		));
	}

	//echo $sql;

	return $retorno;
}


function itensTransf($conexao, $empresaMatriz, $dataI, $dataF, $tr_id) {

	$resultado = array();

	//$sql = "select count(distinct(vd_cli)) totalCliente from vendas where vd_emis >= '$dataI' and vd_emis <= '$dataF' and vd_canc<>'S' and vd_pgr<>'D' and vd_matriz = $empresaMatriz $vd_empr $vd_cli $vd_func";

	$sql = "SELECT 	tri_id,
					tri_empresa,
					tri_matriz,
					tri_cod,
					tri_data,
					tri_saida,
					tri_entrada,
					tri_prod,
					tri_desc,
					tri_quant
			from transf_item
			where tri_idprim = $tr_id
			order by tri_desc;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		
		array_push($resultado, array(

				'tri_id' => $row['tri_id'],
				'tri_empresa' => $row['tri_empresa'],
				'tri_matriz' => $row['tri_matriz'],
				'tri_cod'  => $row['tri_cod'],
				'tri_data' => utf8_encode($row['tri_data']),
				'tri_saida' => $row['tri_saida'],
				'tri_entrada' => $row['tri_entrada'],
				'tri_prod' => $row['tri_prod'],
				'tri_desc' => ucwords(strtolower(utf8_encode($row['tri_desc']))),
				'tri_quant' => utf8_encode($row['tri_quant']),

		));

	}

	//echo $sql;
	return $resultado;
}

function estoqueSimplificado($conexao, $empresaMatriz, $es_prod){
	$retorno = array();
	$sql ="select es_id, es_prod, es_empr,
	(select em_fanta from empresas where em_cod = es_empr) as em_fanta,
	 es_matriz, es_estmin, es_estmax, es_est, es_estant, es_validade, es_fab
	FROM estoque where es_matriz = $empresaMatriz and es_prod= 	$es_prod;";
	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($retorno, array(
			'es_id' => $row['es_id'],
			'es_prod' => $row['es_prod'],
			'es_empr' => $row['es_empr'],
			'em_fanta' =>utf8_decode($row['em_fanta']),
			'es_matriz' => $row['es_matriz'],
			'es_estmin' => $row['es_estmin'],
			'es_estmax' => $row['es_estmax'],
			'es_est' => $row['es_est'],
			'es_estant' => $row['es_estant'],
			'es_validade' => $row['es_validade'],
			'es_fab' => $row['es_fab'],

		));
	}

	return $retorno;

}

function movimentacao_cardex($conexao, $empresaMatriz, $es_prod){

	$resultado = array();

	$sql="select sd_id, sd_idlocal, sd_prod, sd_empr, 
	(select em_fanta from empresas where em_cod = sd_empr) as em_fanta,
	sd_matriz, sd_data, sd_estant, sd_hist, sd_quant, sd_estat, sd_usuario, 
	(select us_nome from usuarios where us_empresa = sd_empr and us_cod = sd_usuario) as usuario,
	sd_hora, sd_motivo, sd_valor FROM zmpro.saldo_estoque where sd_matriz = $empresaMatriz and sd_prod = $es_prod;";

	$query = mysqli_query($conexao, $sql);
	
	while ($row = mysqli_fetch_assoc($query)){
		array_push($resultado, array(
			'sd_id' => $row['sd_id'],
			'sd_idlocal' => $row['sd_idlocal'],
			'sd_prod' => $row['sd_prod'],
			'sd_empr' => $row['sd_empr'],
			'em_fanta' => utf8_encode($row['em_fanta']),
			'sd_matriz' => $row['sd_matriz'],
			'sd_data' => utf8_encode($row['sd_data']),
			'sd_estant' => $row['sd_estant'],
			'sd_hist' => utf8_encode($row['sd_hist']),
			'sd_quant' => $row['sd_quant'],
			'sd_estat' => $row['sd_estat'],
			'sd_usuario' => $row['sd_usuario'],
			'usuario' => utf8_encode($row['usuario']),
			'sd_hora' => $row['sd_hora'],
			'sd_motivo' => utf8_encode($row['sd_motivo']),
			'sd_valor' => $row['sd_valor'],

		));
	};

	return $resultado;
}


?>
