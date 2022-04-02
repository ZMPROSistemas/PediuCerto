<?php

require_once 'conecta.php';
require_once 'conectaPDO.php';

if (isset($_GET['token'])) {
	$token = $_GET['token'];
}
if (isset($_GET['dadosCliente'])) {

	$id = base64_decode($_GET['us_id']);
	$empresa = base64_decode($_GET['e']);
	$cliente_fornecedor = $_GET['cliente_fornecedor'];
	$situacao = $_GET['situacao'];
	$ativo = $_GET['ativo'];



	if (isset($_GET['empresa'])) {
		$empresaFiltrada = $_GET['empresa'];

		if ($empresaFiltrada == null) {
			$pe_empresa = '';

		} else {
			$pe_empresa = ' and pe_empresa= ' . $empresaFiltrada;
		}

	} else {
		$pe_empresa = '';
	}


	$empresaAcesso = base64_decode($_GET['eA']);
	//echo $empresaAcesso;
	if (isset($_GET['dados'])) {

		if (isset($_GET['cliente'])) {
			$cliente = $_GET['cliente'];
	
			if ($cliente == null) {
				$pe_nome = '';
	
			} else {
				$pe_nome = ' and pe_nome like "%' . $cliente . '%"';
			}
	
		} else {
			$pe_nome = '';
		}

		if (isset($_GET['cidade'])) {
			$cidade = $_GET['cidade'];
	
			if ($cidade == null) {
				$pe_cidade = '';
	
			} else {
				$pe_cidade = ' and pe_cidade like "%' . $cidade . '%"';
			}
	
		} else {
			$pe_cidade = '';
		}

		if ($empresaAcesso == 0) {
			$lista = '{"result":[' . json_encode(dadosClienteAutorizado($conexao, $id, $situacao, $ativo, $cliente_fornecedor, $pe_empresa, $pe_nome, $pe_cidade)) . ']}';
			echo $lista;

		} else {
			$lista = '{"result":[' . json_encode(dadosCliente($conexao, $id, $situacao, $ativo, $cliente_fornecedor, $pe_empresa, $pe_nome, $pe_cidade)) . ']}';
			echo $lista;

		}
	}

	if (isset($_GET['totalLista'])) {

		if ($empresaAcesso == 0) {
			$listaTotal = '{"result":[' . json_encode(dadosClienteTotalAutorizado($conexao, $id, $situacao, $ativo, $cliente_fornecedor)) . ']}';
			echo $listaTotal;
		} else {

			$listaTotal = '{"result":[' . json_encode(dadosClienteTotal($conexao, $id, $situacao, $ativo, $cliente_fornecedor)) . ']}';
			echo $listaTotal;

		}
	}
	//echo "1";
}

if (isset($_GET['buscaCliente'])) {
	$matriz = $_GET['matriz'];
	$empresa = $_GET['empresa'];
	$cliente_fornecedor = $_GET['cliente_fornecedor'];
	if (isset($_GET['pe_cod'])) {
		$pe_cod = $_GET['pe_cod'];
		$buscaBy = ' and pe_cod= ' .$pe_cod;
	}
	if (isset($_GET['pe_nome'])) {
		$pe_nome = $_GET['pe_nome'];
		$buscaBy = ' and pe_nome like "%'. $pe_nome.'%"';
	}
	

	$listaTotal = '{"result":[' . json_encode(buscarCliente($conexao, $token, $matriz, $empresa, $cliente_fornecedor, $buscaBy)) . ']}';
	echo $listaTotal;
}

if (isset($_GET['infoCliente'])) {
	$matriz = base64_decode($_GET['matriz']);
	$empresa = base64_decode($_GET['empresa']);
	$pe_cod = $_GET['pe_cod'];
	

	$lista = json_encode(buscarInfo($pdo, $matriz, $empresa,$pe_cod));
	
	echo $lista;
	
}

if (isset($_GET['descricaoItens'])) {
	$matriz = $_GET['matriz'];
	$empresa = $_GET['empresa'];
	$ped_doc = $_GET['ped_doc'];
	

	$lista = json_encode(descricaoItensBusca($pdo, $matriz, $empresa, $ped_doc));
	
	echo $lista;
	
}

function dadosClienteAutorizado($conexao, $id, $situacao, $ativo, $cliente_fornecedor, $pe_empresa, $pe_nome, $pe_cidade) {

	$retorno = array();

	$pe_ativo = '';
	 if ($cliente_fornecedor == 'pe_fornecedor') {
		$pe_ativo = '';
	 }else{
		$pe_ativo = ' and pe_ativo = "'.$ativo.'"';
	 }
	$sql = "SELECT pe_id, pe_cod, pe_empresa, UPPER(pe_nome) as pe_nome, pe_endereco, pe_end_num, pe_cidade, pe_fone,
			pe_bairro, pe_celular from pessoas where $cliente_fornecedor = 'S' $pe_empresa $pe_nome $pe_cidade 
			and pe_matriz = (select us_empresa from usuarios where us_id = $id) order by pe_nome; ";

	$resultado = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($resultado)) {

		array_push($retorno, array(
			'pe_id' => $row['pe_id'],
			'pe_cod' => $row['pe_cod'],
			'pe_empresa' => $row['pe_empresa'],
			/*'pe_matriz' => $row['pe_matriz'],*/
			'pe_nome' => ucwords(strtolower(utf8_encode($row['pe_nome']))),
			/*			'pe_situacao' => $row['pe_situacao'],*/
			//'pe_endereco' => strstr(utf8_decode($row['pe_endereco']), ',', true),
			'pe_endereco' => ucwords(strtolower(utf8_encode($row['pe_endereco']))),
			'pe_end_num' => $row['pe_end_num'], 
			'pe_cidade' => ucwords(strtolower(utf8_encode($row['pe_cidade']))),
			'pe_bairro' => ucwords(strtolower(utf8_encode($row['pe_bairro']))),
			'pe_celular' => utf8_encode($row['pe_celular']),
				/*'pe_uf' => utf8_encode($row['pe_uf']),
				'pe_bairro' => ucwords(strtolower(utf8_encode($row['pe_bairro']))),
				'pe_cep' => utf8_encode($row['pe_cep']),
				'pe_rgie' => utf8_encode($row['pe_rgie']),
				'pe_cpfcnpj' => utf8_encode($row['pe_cpfcnpj']),*/
			'pe_fone' => utf8_encode($row['pe_fone']),
				/*			'pe_fax' => utf8_encode($row['pe_fax']),
				'pe_fanta' => ucwords(strtolower(utf8_encode($row['pe_fanta']))),
				'pe_email' => utf8_encode($row['pe_email']),
				'pe_site' => utf8_encode($row['pe_site']),
				'pe_cont' => ucwords(strtolower(utf8_encode($row['pe_cont']))),
				'pe_fonecont' => utf8_encode($row['pe_fonecont']),
				'pe_obs' => ucwords(strtolower(utf8_encode($row['pe_obs']))),
				'pe_entrega' => utf8_encode($row['pe_entrega']),
				'pe_cidentrega' => ucwords(strtolower(utf8_encode($row['pe_cidentrega']))),
				'pe_bairroentrega' => ucwords(strtolower(utf8_encode($row['pe_bairroentrega']))),
				'pe_ufentrega' => utf8_encode($row['pe_ufentrega']),
				'pe_foneentrega' => utf8_encode($row['pe_foneentrega']),
				'pe_contentrega' => utf8_encode($row['pe_contentrega']),
				'pe_cobranca' => utf8_encode($row['pe_cobranca']),
				'pe_cidcobranca' => ucwords(strtolower(utf8_encode($row['pe_cidcobranca']))),
				'pe_ufcobranca' => utf8_encode($row['pe_ufcobranca']),
				'pe_bairrocobranca' => ucwords(strtolower(utf8_encode($row['pe_bairrocobranca']))),
				'pe_fonecobranca' => utf8_encode($row['pe_fonecobranca']),
				'pe_contcobranca' => utf8_encode($row['pe_contcobranca']),
				'pe_nascto' => utf8_encode($row['pe_nascto']),
				'pe_limite' => $row['pe_limite'],
				'pe_celular' => utf8_encode($row['pe_celular']),
				'pe_trabalho' => utf8_encode($row['pe_trabalho']),
				'pe_funcao' => ucwords(strtolower(utf8_encode($row['pe_funcao']))),
				'pe_endtrab' => ucwords(strtolower(utf8_encode($row['pe_endtrab']))),
				'pe_fonetrab' => utf8_encode($row['pe_fonetrab']),
				'pe_tempotrab' => utf8_encode($row['pe_tempotrab']),
				'pe_salario' => $row['pe_salario'],
				'pe_conttrab' => utf8_encode($row['pe_conttrab']),
				'pe_conj' => ucwords(strtolower(utf8_encode($row['pe_conj']))),
				'pe_conjtrab' => utf8_encode($row['pe_conjtrab']),
				'pe_funcconj' => utf8_encode($row['pe_funcconj']),
				'pe_endtrabconj' => ucwords(strtolower(utf8_encode($row['pe_endtrabconj']))),
				'pe_fonetrabconj' => utf8_encode($row['pe_fonetrabconj']),
				'pe_tempotrabconj' => utf8_encode($row['pe_tempotrabconj']),
				'pe_salarioconj' => utf8_encode($row['pe_salarioconj']),
				'pe_conttrabconj' => utf8_encode($row['pe_conttrabconj']),
				'pe_cpfconj' => utf8_encode($row['pe_cpfconj']),
				'pe_nasctoconj' => utf8_encode($row['pe_nasctoconj']),
				'pe_celconj' => utf8_encode($row['pe_celconj']),
				'pe_banco1' => ucwords(strtolower(utf8_encode($row['pe_banco1']))),
				'pe_ag1' => utf8_encode($row['pe_ag1']),
				'pe_cc1' => utf8_encode($row['pe_cc1']),
				'pe_contbanco1' => utf8_encode($row['pe_contbanco1']),
				'pe_banco2' => utf8_encode($row['pe_banco2']),
				'pe_ag2' => utf8_encode($row['pe_ag2']),
				'pe_cc2' => utf8_encode($row['pe_cc2']),
				'pe_contbanco2' => utf8_encode($row['pe_contbanco2']),
				'pe_primeiracompra' => utf8_encode($row['pe_primeiracompra']),
				'pe_valprimcompra' => $row['pe_valprimcompra'],
				'pe_maiorcompra' => utf8_encode($row['pe_maiorcompra']),
				'pe_valmaiorcompra' => $row['pe_valmaiorcompra'],
				'pe_ultcompra' => utf8_encode($row['pe_ultcompra']),
				'pe_valultcompra' => utf8_encode($row['pe_valultcompra']),
				'pe_cadastro' => utf8_encode($row['pe_cadastro']),
				'pe_regiao' => $row['pe_regiao'],
				'pe_funcionario' => $row['pe_funcionario'],
				'pe_natural' => ucwords(strtolower(utf8_encode($row['pe_natural']))),
				'pe_valresid' => $row['pe_valresid'],
				'pe_credito' => $row['pe_credito'],
				'pe_vencto' => $row['pe_vencto'],
				'pe_descto' => $row['pe_descto'],
				'pe_novo' => utf8_encode($row['pe_novo']),
				'pe_observ' => utf8_encode($row['pe_observ']),
				'pe_cepentrega' => utf8_encode($row['pe_cepentrega']),
				'pe_cepcobranca' => utf8_encode($row['pe_cepcobranca']),
				'pe_cod_cid' => utf8_encode($row['pe_cod_cid']),
				'pe_cli_prim' => $row['pe_cli_prim'],
				'pe_isento_ipi' => utf8_encode($row['pe_isento_ipi']),
				'pe_ativo' =>  utf8_encode($row['pe_ativo']),
				'pe_email_nfe' => utf8_encode($row['pe_email_nfe']),*/
				/*'pe_foto' => utf8_encode($row['pe_foto']),
				'pe_fone1' => utf8_encode($row['pe_fone1']),
				'pe_fone2' => utf8_encode($row['pe_fone2']),
				'pe_fone3' => utf8_encode($row['pe_fone3']),
				'pe_fone4' => utf8_encode($row['pe_fone4']),
				'pe_fone5' => utf8_encode($row['pe_fone5']),
				'pe_nome1' => ucwords(strtolower(utf8_encode($row['pe_nome1']))),
				'pe_nome2' => ucwords(strtolower(utf8_encode($row['pe_nome2']))),
				'pe_nome3' => ucwords(strtolower(utf8_encode($row['pe_nome3']))),
				'pe_nome4' => ucwords(strtolower(utf8_encode($row['pe_nome4']))),
				'pe_nome5' => ucwords(strtolower(utf8_encode($row['pe_nome5']))),
				'pe_nascto1' => utf8_encode($row['pe_nascto1']),
				'pe_nascto2' => utf8_encode($row['pe_nascto2']),
				'pe_nascto3' => utf8_encode($row['pe_nascto3']),
				'pe_nascto4' => utf8_encode($row['pe_nascto4']),
				'pe_nascto5' => utf8_encode($row['pe_nascto5']),
				'pe_fornecedor' => utf8_encode($row['pe_fornecedor']),
				'pe_cliente' => utf8_encode($row['pe_cliente']),
				'pe_colaborador' => utf8_encode($row['pe_colaborador']),
				*/

		));

	}

	//echo $sql;

	return $retorno;

}

/*function dadosClienteTotalAutorizado($conexao, $id, $situacao, $ativo, $cliente_fornecedor) {

	$retorno = array();

	$sql = "select COUNT(*) from pessoas where $cliente_fornecedor = 'S' and pe_situacao = $situacao and pe_ativo = '$ativo' and pe_matriz = (select us_empresa from usuarios where us_id = $id);";

	$resultado = mysqli_query($conexao, $sql);

	array_push($retorno, array(
	'total' => mysqli_num_rows($resultado),

	));

	return $retorno;

}*/

function dadosCliente($conexao, $id, $situacao, $ativo, $cliente_fornecedor, $pe_empresa, $pe_nome, $pe_cidade) {

	$retorno = array();

	$sql = "SELECT pe_id, pe_cod, pe_empresa, UPPER(pe_nome) as pe_nome, pe_endereco, pe_end_num, pe_cidade, pe_fone 
			from pessoas where $cliente_fornecedor = 'S' and pe_ativo = '$ativo' 
			and pe_empresa = (select us_empresa_acesso from usuarios where us_id = $id) $pe_nome $pe_cidade order by pe_nome;";

	$resultado = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($resultado)) {

		array_push($retorno, array(
			'pe_id' => $row['pe_id'],
			'pe_cod' => $row['pe_cod'],
			'pe_empresa' => $row['pe_empresa'],
			/*'pe_matriz' => $row['pe_matriz'], */
			'pe_nome' => utf8_encode($row['pe_nome']),
			/*			'pe_situacao' => $row['pe_situacao'], */
			//'pe_endereco' => strstr(utf8_encode($row['pe_endereco']), ',', true),
			'pe_endereco' => ucwords(strtolower(utf8_encode($row['pe_endereco']))),
			'pe_end_num' => $row['pe_end_num'], 
			'pe_cidade' => ucwords(strtolower(utf8_encode($row['pe_cidade']))),
			/*			'pe_uf' => mb_strtoupper(utf8_encode($row['pe_uf'])),
			'pe_bairro' => ucwords(strtolower(utf8_encode($row['pe_bairro']))),
			'pe_cep' => utf8_encode($row['pe_cep']),
			'pe_rgie' => utf8_encode($row['pe_rgie']),
			'pe_cpfcnpj' => utf8_encode($row['pe_cpfcnpj']),*/
			'pe_fone' => utf8_encode($row['pe_fone']),
			/*			'pe_fax' => utf8_encode($row['pe_fax']),
			'pe_fanta' => ucwords(strtolower(utf8_encode($row['pe_fanta']))),
			'pe_email' => utf8_encode($row['pe_email']),
			'pe_site' => utf8_encode($row['pe_site']),
			'pe_cont' => ucwords(strtolower(utf8_encode($row['pe_cont']))),
			'pe_fonecont' => utf8_encode($row['pe_fonecont']),
			'pe_obs' => mb_strtoupper(utf8_encode($row['pe_obs'])),
			'pe_entrega' => utf8_encode($row['pe_entrega']),
			'pe_cidentrega' => ucwords(strtolower(utf8_encode($row['pe_cidentrega']))),
			'pe_bairroentrega' => ucwords(strtolower(utf8_encode($row['pe_bairroentrega']))),
			'pe_ufentrega' => mb_strtoupper(utf8_encode($row['pe_ufentrega'])),
			'pe_foneentrega' => utf8_encode($row['pe_foneentrega']),
			'pe_contentrega' => utf8_encode($row['pe_contentrega']),
			'pe_cobranca' => utf8_encode($row['pe_cobranca']),
			'pe_cidcobranca' => ucwords(strtolower(utf8_encode($row['pe_cidcobranca']))),
			'pe_ufcobranca' => mb_strtoupper(utf8_encode($row['pe_ufcobranca'])),
			'pe_bairrocobranca' => ucwords(strtolower(utf8_encode($row['pe_bairrocobranca']))),
			'pe_fonecobranca' => utf8_encode($row['pe_fonecobranca']),
			'pe_contcobranca' => utf8_encode($row['pe_contcobranca']),
			'pe_nascto' => utf8_encode($row['pe_nascto']),
			'pe_limite' => $row['pe_limite'],
			'pe_celular' => utf8_encode($row['pe_celular']),
			'pe_trabalho' => utf8_encode($row['pe_trabalho']),
			'pe_funcao' => ucwords(strtolower(utf8_encode($row['pe_funcao']))),
			'pe_endtrab' => ucwords(strtolower(utf8_encode($row['pe_endtrab']))),
			'pe_fonetrab' => utf8_encode($row['pe_fonetrab']),
			'pe_tempotrab' => utf8_encode($row['pe_tempotrab']),
			'pe_salario' => $row['pe_salario'],
			'pe_conttrab' => utf8_encode($row['pe_conttrab']),
			'pe_conj' => ucwords(strtolower(utf8_encode($row['pe_conj']))),
			'pe_conjtrab' => utf8_encode($row['pe_conjtrab']),
			'pe_funcconj' => utf8_encode($row['pe_funcconj']),
			'pe_endtrabconj' => ucwords(strtolower(utf8_encode($row['pe_endtrabconj']))),
			'pe_fonetrabconj' => utf8_encode($row['pe_fonetrabconj']),
			'pe_tempotrabconj' => utf8_encode($row['pe_tempotrabconj']),
			'pe_salarioconj' => utf8_encode($row['pe_salarioconj']),
			'pe_conttrabconj' => utf8_encode($row['pe_conttrabconj']),
			'pe_cpfconj' => utf8_encode($row['pe_cpfconj']),
			'pe_nasctoconj' => utf8_encode($row['pe_nasctoconj']),
			'pe_celconj' => utf8_encode($row['pe_celconj']),
			'pe_banco1' => ucwords(strtolower(utf8_encode($row['pe_banco1']))),
			'pe_ag1' => utf8_encode($row['pe_ag1']),
			'pe_cc1' => utf8_encode($row['pe_cc1']),
			'pe_contbanco1' => utf8_encode($row['pe_contbanco1']),
			'pe_banco2' => utf8_encode($row['pe_banco2']),
			'pe_ag2' => utf8_encode($row['pe_ag2']),
			'pe_cc2' => utf8_encode($row['pe_cc2']),
			'pe_contbanco2' => utf8_encode($row['pe_contbanco2']),
			'pe_primeiracompra' => utf8_encode($row['pe_primeiracompra']),
			'pe_valprimcompra' => $row['pe_valprimcompra'],
			'pe_maiorcompra' => utf8_encode($row['pe_maiorcompra']),
			'pe_valmaiorcompra' => $row['pe_valmaiorcompra'],
			'pe_ultcompra' => utf8_encode($row['pe_ultcompra']),
			'pe_valultcompra' => utf8_encode($row['pe_valultcompra']),
			'pe_cadastro' => utf8_encode($row['pe_cadastro']),
			'pe_regiao' => $row['pe_regiao'],
			'pe_funcionario' => $row['pe_funcionario'],
			'pe_natural' => ucwords(strtolower(utf8_encode($row['pe_natural']))),
			'pe_valresid' => $row['pe_valresid'],
			'pe_credito' => $row['pe_credito'],
			'pe_vencto' => $row['pe_vencto'],
			'pe_descto' => $row['pe_descto'],
			'pe_novo' => utf8_encode($row['pe_novo']),
			'pe_observ' => utf8_encode($row['pe_observ']),
			'pe_cepentrega' => utf8_encode($row['pe_cepentrega']),
			'pe_cepcobranca' => utf8_encode($row['pe_cepcobranca']),
			'pe_cod_cid' => utf8_encode($row['pe_cod_cid']),
			'pe_cli_prim' => $row['pe_cli_prim'],
			'pe_isento_ipi' => utf8_encode($row['pe_isento_ipi']),
			'pe_ativo' => utf8_encode($row['pe_ativo']),
			'pe_email_nfe' => utf8_encode($row['pe_email_nfe']),*/
			/*'pe_foto' => utf8_encode($row['pe_foto']),
				'pe_fone1' => utf8_encode($row['pe_fone1']),
				'pe_fone2' => utf8_encode($row['pe_fone2']),
				'pe_fone3' => utf8_encode($row['pe_fone3']),
				'pe_fone4' => utf8_encode($row['pe_fone4']),
				'pe_fone5' => utf8_encode($row['pe_fone5']),
				'pe_nome1' => ucwords(strtolower(utf8_encode($row['pe_nome1']))),
				'pe_nome2' => ucwords(strtolower(utf8_encode($row['pe_nome2']))),
				'pe_nome3' => ucwords(strtolower(utf8_encode($row['pe_nome3']))),
				'pe_nome4' => ucwords(strtolower(utf8_encode($row['pe_nome4']))),
				'pe_nome5' => ucwords(strtolower(utf8_encode($row['pe_nome5']))),
				'pe_nascto1' => utf8_encode($row['pe_nascto1']),
				'pe_nascto2' => utf8_encode($row['pe_nascto2']),
				'pe_nascto3' => utf8_encode($row['pe_nascto3']),
				'pe_nascto4' => utf8_encode($row['pe_nascto4']),
				'pe_nascto5' => utf8_encode($row['pe_nascto5']),
				'pe_fornecedor' => utf8_encode($row['pe_fornecedor']),
				'pe_cliente' => utf8_encode($row['pe_cliente']),
				'pe_colaborador' => utf8_encode($row['pe_colaborador']),
			*/

		));

	}

	//echo $sql;

	return $retorno;

}

function buscarCliente($conexao, $token, $matriz, $empresa, $cliente_fornecedor, $buscaBy){
	$resultado = array();

	$sql = "SELECT pe_id, pe_cod, pe_empresa, pe_matriz, UPPER(pe_nome) as pe_nome, pe_endereco 
			FROM pessoas where pe_matriz= (select em_cod from empresas where em_token = '$token') 
			and $cliente_fornecedor = 'S' $buscaBy order by pe_nome;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'pe_id' => $row['pe_id'],
			'pe_cod' => $row['pe_cod'],
			'pe_empresa' => $row['pe_empresa'],
			'pe_matriz' => $row['pe_matriz'],
			'pe_nome' => utf8_encode($row['pe_nome']),
			'pe_endereco' => ucwords(strtolower(utf8_encode($row['pe_endereco']))),
		));
	}
	//echo $sql;
	return $resultado;
}

function buscarInfo($pdo, $matriz, $empresa, $pe_cod){

	$retorno = array();

	$sql = "SELECT pe_id, pe_cod, pe_empresa, pe_matriz, pe_nome, pe_endereco, pe_end_num, pe_end_comp, pe_bairro,pe_cidade, pe_uf, pe_cep,
	pe_cep_trab, pe_endtrab, pe_end_num_trab, pe_bairro_trab, pe_end_cid_trab, pe_uf_trab, pe_end_comp_trab, pe_celular, pe_cadastro, pe_app_origem, pe_emp_origem
	 FROM pessoas where pe_matriz = $matriz and pe_id = $pe_cod;";
	
	$buscarInfo =$pdo->prepare($sql);
	$buscarInfo->execute();
	$retorno = $buscarInfo->fetchAll(PDO::FETCH_ASSOC);

	
	array_push($retorno, array(
		'pedidos' => buscarPedidoCliente($pdo, $retorno[0]['pe_id']),
		'Totalpedidos' => totalPedidoCliente($pdo,  $retorno[0]['pe_id'])
	));
	
	/*$resultado = mysqli_query($conexao, $sql);
	
	while ($row = mysqli_fetch_assoc($resultado)) {
		array_push($retorno, array(
			'pe_id' => $row['pe_id'],
			'pe_cod' => $row['pe_cod'], 
			'pe_empresa' => $row['pe_empresa'], 
			'pe_matriz' => $row['pe_matriz'], 
			'pe_nome' => ucwords(strtolower(utf8_encode($row['pe_nome']))), 
			'pe_endereco' => ucwords(strtolower(utf8_encode($row['pe_endereco']))), 
			'pe_end_num' => ucwords(strtolower(utf8_encode($row['pe_end_num']))), 
			'pe_end_comp' => ucwords(strtolower(utf8_encode($row['pe_end_comp']))), 
			'pe_bairro' => ucwords(strtolower(utf8_encode($row['pe_bairro']))),
			'pe_cidade' => utf8_encode($row['pe_cidade']), 
			'pe_uf' => utf8_encode($row['pe_uf']), 
			'pe_cep' => utf8_encode($row['pe_cep']),
			'pe_endtrab' => ucwords(strtolower(utf8_($row['pe_endtrab']))), 
			'pe_end_num_trab' => utf8_encode($row['pe_end_num_trab']), 
			'pe_bairro_trab' =>ucwords(strtolower(utf8_encode($row['pe_bairro_trab']))), 
			'pe_end_cid_trab' => ucwords(strtolower(utf8_encode($row['pe_end_cid_trab']))), 
			'pe_uf_trab' => ucwords(strtolower(utf8_en($row['pe_uf_trab']))), 
			'pe_celular' => utf8_encode($row['pe_celular']), 
			'pe_cadastro' => utf8_encode($row['pe_cadastro']), 
			'pe_app_origem' => ucwords(strtolower(utf8_encode($row['pe_app_origem']))), 
			'pe_ep_origem' => $row['pe_ep_origem'],
			'pedidos' => buscarPedidoCliente($conexao, $row['pe_id'])
		));
	}*/

	return $retorno;


}

function buscarPedidoCliente($pdo, $ped_id){
	$retorno = array();

	$sql ="SELECT ped_id, ped_doc, ped_empresa, (SELECT em_fanta FROM empresas where em_cod = ped_empresa) as em_fanta, ped_matriz, ped_emis, ped_hora_entrada, ped_cliente_cep_entrega, 
	ped_cliente_end_entrega, ped_cliente_end_num_entrega, ped_hora_entrega, ped_hora_cancel, ped_cliente_compl_entrega, ped_cliente_bairro_entrega, ped_cliente_cid_entrega
	ped_valor, ped_val_desc, ped_val_entrega, ped_total, ped_obs, ped_status, ped_val_pg_dn, ped_val_pg_ca, ped_troco_para
	ped_entregar, ped_finalizado FROM pedido_food where ped_cliente_cod = $ped_id";

	$PedidoCliente =$pdo->prepare($sql);
	$PedidoCliente->execute();
	$retorno = $PedidoCliente->fetchAll(PDO::FETCH_ASSOC);

	//$resultado = mysqli_query($conexao, $sql);

	return $retorno;
}

function totalPedidoCliente($pdo, $ped_id){
	
	$sql ="SELECT COUNT(*) as total FROM pedido_food where ped_cliente_cod = $ped_id;";
	$totalPedidoCliente =$pdo->prepare($sql);
	$totalPedidoCliente->execute();

	$retorno = $totalPedidoCliente->fetch(PDO::FETCH_ASSOC);

	return $retorno['total'];
}

function descricaoItensBusca($pdo, $matriz, $empresa, $ped_doc){

	$retorno = array();

	$sql= "SELECT pdi_id, pdi_idprim, pdi_doc, pdi_empresa, pdi_matriz, pdi_emis, pdi_produto, pdi_descricao,
			pdi_quantidade, pdi_preco_base, pdi_val_desc, pdi_val_adicional, pdi_preco_total_item, pdi_total,
			pdi_obs, pdi_status FROM pedido_item_food where pdi_matriz = $matriz and pdi_empresa = $empresa and pdi_doc = $ped_doc;";

	$ItensBusca =$pdo->prepare($sql);
	$ItensBusca->execute();
	$retorno = $ItensBusca->fetchAll(PDO::FETCH_ASSOC);
	
	return $retorno;

}

/*function dadosClienteTotal($conexao, $id, $situacao, $ativo, $cliente_fornecedor) {

	$retorno = array();

	$sql = "select COUNT(*) from pessoas where $cliente_fornecedor = 'S' and pe_situacao= $situacao and pe_ativo = '$ativo' and pe_empresa = (select us_empresa_acesso from usuarios where us_id = $id);";

	$resultado = mysqli_query($conexao, $sql);

	array_push($retorno, array(
	'total' => mysqli_num_rows($resultado),

	));

	return $retorno;

}

function soNumero($str) {

	return preg_replace("/[^0-9]/", "", $str);

}*/

?>