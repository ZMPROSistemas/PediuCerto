<?php
include 'conecta.php';
include 'conectaPDO.php';
include 'log.php';
include 'ocorrencia.php';
include 'lancarCaixa.php';
include 'getIp.php';

date_default_timezone_set('America/Bahia');

$id = base64_decode($_GET['us_id']);
$empresa = base64_decode($_GET['e']);
$empresaAcesso = base64_decode($_GET['eA']);

// data de alteração 28/04/2020 - Kleython
//data de upload na nuvem

$data = date('Y-m-d'); 
$hora = date('H:i:s');
$ip = get_client_ip();

if(isset($_GET['SalvarDespesa'])){



	$array = json_decode(file_get_contents("php://input"), true);

//	$ct_empresa = $empresaAcesso;
	$ct_matriz = $empresa;
	/*
	$ct_docto = $array['despesa']['ct_docto'];
	$ct_cliente_forn = $array['despesa']['ct_cliente_forn'];
	$ct_emissao = $array['despesa']['ct_emissao'];
	$ct_nome = $array['despesa']['ct_nome'];
	$ct_tipdoc = $array['despesa']['ct_tipdoc'];
	$ct_pagto = $array['despesa']['vencimento'];
	$ct_valorpago = $array['despesa']['inputValor'];*/

	$selecionarCaixa = $_GET['cx'];
	$bc_codigo = base64_decode($_GET['bc_codigo']);
	$dataPagto = base64_decode($_GET['dataPagto']);

	$despesa = $array['despesa'];
	$rateio = $array['rateio'];
	$parcelas = $array['parcelas'];
	//print_r($despesa). '<p>';
	print_r($despesa);

	if (isset($_GET['bc_codigo'])){
		if ($bc_codigo == 'undefined'){
			$bc_codigo = "''";
		} else if ($bc_codigo == 0){
			$bc_codigo = "''";
		}

	}

	//$selecionarCaixa = $array['contas'][0]['selecionarCaixa'];

	//$bc_id = $array['contas'][0]['bc_id'];

	/*print_r($array['parcelas']);*/
	//$ocorrencia = ocorrencia ($conexao, $ct_matriz);

	$i=1;

	//echo $parcelas;

	foreach ($parcelas as $parcelas) {
		
		if ($selecionarCaixa == true) {

			$valorPago = $despesa['inputValor'];

			if ($dataPagto == 'undefined'){
				$dataPagto = $data;
			} 
	
		} 

		if ($despesa['ct_rateia'] == 'N') {
			$ct_empresa = $despesa['ct_empresa'];
		} else {
			$ct_empresa = $ct_matriz;
		}

		//$ct_pagto = $parcelas['vencimento'];
		//$ct_valorpago = $parcelas['parcela'];
		$ct_tipdoc = $despesa['ct_tipdoc'];
		print_r($ct_tipdoc);
		
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
			$dataPagto = null;
			$valorPago = null;
		}
	
		adicionarCompra ($conexao, $pdo, $ct_empresa, $ct_matriz, $despesa['ct_docto'], $despesa['ct_cliente_forn'], $despesa['ct_obs'], $despesa['ct_emissao'], $parcelas['vencimento'], $parcelas['parcela'], $parcelas['vezes'], $ct_tipdoc, $ct_quitado, $despesa['ct_historico'], $despesa['ct_rateia'], $dataPagto, $valorPago, $selecionarCaixa, $bc_codigo, $i, $rateio, $id, $data, $hora, $ip);
		$i++;
	};
}

if (isset($_GET['editarDespesa'])) {
	$array = json_decode(file_get_contents("php://input"), true);

	$editarConta = $array['editarConta'][0];
	//print_r($editarConta);

	editarDespesa($conexao, $editarConta['ct_id'], $editarConta['empresa'], $editarConta['parc'], $editarConta['mudarVencimento'], $editarConta['mudarValor'], $editarConta['mudarTipoDocto'], $editarConta['ct_docto'], $editarConta['ct_obs'], $editarConta['ct_cliente_forn'], $id, $data, $hora, $ip);
}

function adicionarCompra($conexao, $pdo, $ct_empresa, $ct_matriz, $ct_docto, $ct_cliente_forn, $ct_obs, $ct_emissao, $vencimento, $parcela, $vezes, $ct_tipdoc, $ct_quitado, $ct_historico, $ct_rateia, $dataPagto, $valorPago, $selecionarCaixa, $bc_codigo, $i, $rateio,  $id, $data, $hora, $ip) {

	$retorno = array();
	$dc = 'D';

	$sql = "INSERT into contas(ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_nome, ct_obs, ct_emissao, ct_vencto, ct_valor, ct_parc, ct_canc, ct_tipdoc, ct_receber_pagar, ct_quitado, ct_historico, ct_desc_hist, ct_rateia, ct_pagto, ct_valorpago, ct_caixa) values (
	$ct_empresa, $ct_matriz, $ct_docto, $ct_cliente_forn, (select pe_nome from pessoas where pe_cod = $ct_cliente_forn and pe_empresa = $ct_matriz), UPPER ('$ct_obs'), '$ct_emissao', '$vencimento', '$parcela', '$vezes', 'N', '$ct_tipdoc', 'P', '$ct_quitado', (select ht_cod from historico where ht_id = $ct_historico), (select ht_descricao from historico where ht_id = $ct_historico), '$ct_rateia', '$dataPagto', '$valorPago', $bc_codigo);";

	$inserir = mysqli_query($conexao, $sql);

	//echo $sql;
	
	$ct_id = mysqli_insert_id($conexao);

	if ($ct_rateia == 'S') {

        $sqlRateia = "INSERT INTO rateio_contas (rc_empresa, rc_matriz, rc_idconta, rc_valor, rc_emissao, rc_vencto, rc_pagto, rc_historico, rc_pago) VALUES ";
        $novaArray = array();
        $queryPDO = $pdo->prepare($sqlRateia);
        //echo $sql;

        foreach($rateio as $rateio){
			$sqlRateia .= '(?,?,?,?,?,?,?,?,?),';
			$valorPercentual = ($rateio['prc_percentual'] * ($parcela / 100));
			//$historico = 'select ht_descricao from historico where ht_id = "' . $ct_historico .'"';
			
            array_push($novaArray, $rateio['prc_empresa'], $rateio['prc_matriz'], $ct_id, $valorPercentual, $ct_emissao, $vencimento, $dataPagto, $ct_historico, $ct_quitado);
        }

        $sqlRateia = trim($sqlRateia, ','); //remover a última vírgula

        $queryPDO = $pdo->prepare($sqlRateia);
        if(!$queryPDO->execute($novaArray)){
            echo "<pre>";
            print_r($queryPDO->errorInfo());
        }
        //print_r($delete);
    }


	if (mysqli_affected_rows($conexao) <= 0) {
	
		array_push($retorno, array(
                'status'=> $row = 'ERROR',
            ));
	
	} else {

		if ($selecionarCaixa == 'true') {
			
			array_push($retorno, array(
				'status'=> $row = 'SUCCESS',
				'lancaCaixa' => $row = lancaCaixa($conexao, $ct_empresa, $ct_id, $dc)
				
            ));
			$ocorrencia = ocorrencia($conexao, $ct_matriz, $ct_empresa);
            logSistema_Baixar_Conta_Pagar_forOcorrencia($conexao, $data, $hora, $ip, $id, 'Conta Baixada Ocorrencia N ', $ct_matriz , $ct_empresa);

            echo '{"result":[' . json_encode($retorno). ']}';

		} else {

			if ($i == 1) {
				array_push($retorno, array(
	                'status'=> $row = 'SUCCESS',
					'lancaCaixa' => false
	               
	            ));

	            echo '{"result":[' . json_encode($retorno). ']}';
			}
		}

		return $retorno;

	}

	//echo $sql;
	
}

function editarDespesa($conexao, $ct_id, $empresa, $parc, $mudarVencimento, $mudarValor, $mudarTipoDoctolor, $ct_docto, $ct_obs, $ct_cliente_forn, $id, $data, $hora, $ip){
	$retorno = array();

	$valor = str_replace('R','',$mudarValor);
	$valor = str_replace('$','',$valor); 
	$valor = str_replace('.','',$valor); 
	$valor = str_replace(',','.',$valor); 

	$sql = "UPDATE contas set ct_vencto = '$mudarVencimento', ct_valor = $valor, ct_empresa = $empresa, ct_tipdoc = $mudarTipoDoctolor, ct_obs = '$ct_obs', 
	ct_cliente_forn = (SELECT pe_cod from pessoas where pe_id = $ct_cliente_forn), 
	ct_nome = (SELECT pe_nome from pessoas where pe_id = $ct_cliente_forn) where ct_id = $ct_id;";

	$query = mysqli_query ($conexao, $sql);

	if (mysqli_affected_rows($conexao) <= 0) {
		array_push($retorno, array(
			'status'=> $row = 'ERROR',
			
		));

	} else {
	   
		array_push($retorno, array(
			'status'=> $row = 'SUCCESS',
		));
		
		$msg = "Despesa editada N Docto. ". $ct_docto;

		logSistema_forID($conexao, $data, $hora, $ip, $id, $msg, $empresa, $empresa);
	

	}

	echo $sql;
	echo '{"result":[' . json_encode($retorno) . ']}';
}

?>