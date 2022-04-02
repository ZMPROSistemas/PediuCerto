<?php
include 'conecta.php';
include 'log.php';
include 'ocorrencia.php';
include 'lancarCaixa.php';

date_default_timezone_set('America/Bahia');

// data de alteração 28/04/2020 - Kleython
//data de upload na nuvem

$data = date('Y-m-d'); 
$hora = date('H:i:s');
$usuario = base64_decode($_GET['us_id']);

$array = json_decode(file_get_contents("php://input"), true);

$cp_id = $array['contas'][0]['cp_id'];
$ct_empresa = $array['contas'][0]['ct_empresa'];
$ct_matriz = $array['contas'][0]['ct_matriz'];
$ct_docto = $array['contas'][0]['ct_docto'];
$ct_cliente_forn = $array['contas'][0]['ct_cliente_forn'];
$ct_emissao = $array['contas'][0]['ct_emissao'];
$ct_nome = $array['contas'][0]['ct_nome'];
$ct_tipdoc = $array['contas'][0]['ct_tipdoc'];
$ct_pagto = $array['contas'][0]['ct_pagto'];
$ct_valorpago = $array['contas'][0]['ct_valorpago']; 
$ct_quitado = '';

	if ($ct_tipdoc == 1) {
		$ct_quitado = 'S';
	}
	else if ($ct_tipdoc == 2) {
		$ct_quitado = 'S';
	}
	else if ($ct_tipdoc == 4) {
		$ct_quitado = 'S';
	}
	else {
		$ct_quitado = 'N';
		$ct_pagto = null;
		$ct_valorpago = null;
	}

$ct_historico = $array['contas'][0]['ct_historico'];
//$selecionarCaixa = $array['contas'][0]['selecionarCaixa'];
$selecionarCaixa = $_GET['cx'];
//$bc_id = $array['contas'][0]['bc_id'];
if (isset($_GET['bc_codigo'])){
	$bc_codigo = base64_decode($_GET['bc_codigo']);
	if ($bc_codigo == 'undefined'){
		$bc_codigo = '""';
	}
} else {
	$bc_codigo = '""';
}

/*print_r($array['parcelas']);*/
$ocorrencia = ocorrencia ($conexao, $ct_matriz, $ct_empresa);

$i=1;

foreach ($array['parcelas'] as $parcelas) {
	
	adicionarCompra ($conexao, $ct_empresa, $ct_matriz, $ct_docto, $ct_cliente_forn, $ct_emissao, $parcelas['vencimento'], $parcelas['parcela'], $parcelas['vezes'], $ct_nome, $ct_tipdoc, $ct_quitado, $ct_historico, $ct_pagto, $ct_valorpago, $cp_id, $selecionarCaixa, $bc_codigo, $i, $usuario);
	$i++;
};

function adicionarCompra($conexao, $ct_empresa, $ct_matriz, $ct_docto, $ct_cliente_forn, $ct_emissao, $vencimento, $parcela, $vezes, $ct_nome, $ct_tipdoc, $ct_quitado, $ct_historico, $ct_pagto, $ct_valorpago, $cp_id, $selecionarCaixa, $bc_codigo, $i, $usuario) {

	$retorno = array();

	$sql = "insert into contas(ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_emissao, ct_vencto, ct_valor, ct_parc, ct_nome, ct_canc, ct_tipdoc, ct_receber_pagar, ct_quitado, ct_historico, ct_pagto, ct_valorpago, ct_caixa) values (
	'$ct_empresa', '$ct_matriz', '$ct_docto', '$ct_cliente_forn', '$ct_emissao', '$vencimento', '$parcela', '$vezes', '$ct_nome', 'N', '$ct_tipdoc', 'P', '$ct_quitado', '$ct_historico', '$ct_pagto', '$ct_valorpago', $bc_codigo);";

	$inserir = mysqli_query($conexao, $sql);
	
	$ct_id = mysqli_insert_id($conexao);

	if (mysqli_affected_rows($conexao) <= 0) {
	
		array_push($retorno, array(
                'status'=> $row = 'ERROR',
                'lancaCaixa' => false
            ));
	
	} else {

		if ($selecionarCaixa == 'true') {
			array_push($retorno, array(
                'status'=> $row = 'SUCCESS',
                'lancaCaixa' => $row = lancaCaixa($conexao, $ct_matriz, $ct_id, 'D')
            ));

            echo '{"result":[' . json_encode($retorno). ']}';
		} else {

			if ($i == 1) {
				array_push($retorno, array(
	                'status'=> $row = 'SUCCESS',
	                'lancaCaixa' => false,
	               
	            ));

	            echo '{"result":[' . json_encode($retorno). ']}';
			}
		}

		atualizarNota ($conexao, $cp_id, $usuario);
		

	}

	//echo $sql;
	
	
}

/*function lançarCaixa ($conexao, $ct_empresa, $ct_matriz, $ct_docto, $ct_emissao, $ct_historico, $ct_nome, $bc_codbanco) {

	$sql = "insert into caixa_aberto (cx_empresa, cx_matriz, cx_docto, cx_emissao, cx_historico, cx_tpdocto, cx_dc, cx_nome, cx_valor, cx_banco, cx_canc, );";

	$query = mysqli_query($conexao, $sql);

	$retorno = mysqli_affected_rows($conexao);

	//echo $sql;
	return $retorno;

}
*/

function atualizarNota($conexao, $cp_id, $usuario) {

	$sql = "update compra set cp_aberto = 'N' where cp_id = '$cp_id';";

	$query = mysqli_query($conexao, $sql);

	$retorno = mysqli_affected_rows($conexao);

	//echo $sql;
	return $retorno;

	//atualizaEstoque($conexao, $cp_id, $usuario);

}

function atualizaEstoque($conexao, $cp_id, $usuario){


	$sql = "SELECT 	cpi_id,	cpi_empresa, cpi_matriz, cpi_prod, cpi_descricao, cpi_quant, cpi_preco,	cpi_total, cpi_nota, cpi_forn
			from cp_item where cpi_idprim = $cp_id order by cpi_id;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {

		//atualizaEstoqueProduto($row['cpi_prod'], $row['cpi_quant'], $row['cpi_empresa'], $usuario, $row['cpi_id'], $row['cpi_nota'], $row['cpi_forn'],1);
		$cpi_id = $row['cpi_id'];
		$cpi_nota = $row['cpi_nota'];
		$cpi_forn = $row['cpi_forn'];

		$sqlEstoqueProduto = "call atualizaEstoqueProduto(".$row['cpi_prod'].", ".$row['cpi_quant'].", ".$row['cpi_empresa'].", $usuario, 'COMPRA: $cpi_id, NOTA: $cpi_nota, FORNECEDOR: $cpi_forn',1);";
		$querysqlEstoqueProduto = mysqli_query($conexao, $sqlEstoqueProduto);

		//echo $sqlEstoqueProduto;

		$retorno = mysqli_affected_rows($conexao);
	
	}

	$retorno = mysqli_affected_rows($conexao);

	//echo $sql;
	return $retorno;

	
}
/*
function atualizaEstoqueProduto($conexao, $produto, $quantidade, $empresa, $num_nota, $historico_prod, $operador){


	//$sql = "call atualizaEstoqueProduto($produto, $quantidade, $empresa, $usuario, 'COMPRA:'$row['cpi_id']',NOTA:'$row['cpi_nota']',FORNECEDOR:'$row['cpi_forn'],1);";
	$query = mysqli_query($conexao, $sql);

		echo $sql;


	$retorno = mysqli_affected_rows($conexao);

	//echo $sql;
	return $retorno;

*/

?>