<?php
//include 'conecta.php';

	function logSistema($conexao, $data, $hora, $ip, $us, $msg, $empresa, $matriz) {

		$sql = "insert into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
	lg_matriz, lg_sistema, lg_func_cod
	) value('$data', '$hora', '$ip', '$us', '$msg', $empresa, $matriz,'N', (SELECT us_cod FROM usuarios where us_empresa = $empresa and us_nome = $us))";

		$inserir = mysqli_query($conexao, $sql);

		//echo $sql;
		return $inserir;
	}

	function logSistemaLogin($conexao, $data, $hora, $ip, $us, $msg, $empresa, $matriz) {

		if($empresa == 0){
			$empresa = $matriz;
		}
		$sql = "INSERT INTO log (lg_data, lg_hora, lg_ip, lg_hist, lg_empresa, lg_matriz, lg_sistema, lg_func_cod, lg_func_nome)
		VALUE('$data','$hora','$ip', '$msg',$empresa,$matriz,'N', (SELECT us_cod FROM usuarios where us_id = $us),(SELECT us_nome FROM usuarios where us_id = $us));";

		$inserir = mysqli_query($conexao, $sql);

		echo $sql;
		return $inserir;
	}

	function logSistema_forID($conexao, $data, $hora, $ip, $us, $msg, $empresa, $matriz) {
		
		$sql = "insert into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
	lg_matriz,lg_sistema, lg_func_cod
	) value('$data', '$hora', '$ip', (SELECT us_nome FROM usuarios where us_id=$us), '$msg', $empresa, $matriz,'N',(SELECT us_cod FROM usuarios where us_id=$us))";

		$inserir = mysqli_query($conexao, $sql);

		//echo $sql;
		return $inserir;
	}

	function logSistema_Baixar_Conta_Pagar_forOcorrencia($conexao, $data, $hora, $ip, $us, $msg, $empresa, $matriz) {
		
		$sql = "insert into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
	lg_matriz,lg_sistema, lg_func_cod
	) value('$data', '$hora', '$ip', (SELECT us_nome FROM usuarios where us_id=$us), concat('$msg',(SELECT max(dc_ocorrencia) FROM doctos where dc_matriz = $matriz)), $empresa, $matriz,'N', (SELECT us_cod FROM usuarios where us_id=$us))";

		$inserir = mysqli_query($conexao, $sql);

		//echo $sql;
		return $inserir;
	}


	function logSistema_Movimentacao_forOcorrencia($conexao, $data, $hora, $ip, $us, $msg, $cx_id, $matriz) {
		
		$sql = "INSERT into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
	lg_matriz,lg_sistema, lg_func_cod
	) value('$data', '$hora', '$ip', (SELECT us_nome FROM usuarios where us_id=$us), concat('$msg',(SELECT cx_ocorrencia FROM caixa_aberto where cx_id =  $cx_id)), $matriz, $matriz,'N', (SELECT us_cod FROM usuarios where us_id=$us))";

		$inserir = mysqli_query($conexao, $sql);

		//echo $sql;
		//return $inserir;
	}

	function logSistemaBaixaContaReceber($conexao, $data, $hora, $ip, $us_id, $msg, $empresa, $matriz, $ArrayLog, $getOcorrencia){

		if ($empresa == 0) {
			$empresa = $matriz;
		}

		$buscarNomeCaixa = "SELECT * FROM zmpro.bancos where bc_codigo =". $ArrayLog['caixa'] ." and bc_empresa = $empresa and bc_matriz = $matriz;";
		$queryCaixa = mysqli_query($conexao, $buscarNomeCaixa);

		$rowNomeCaixa = mysqli_fetch_assoc($queryCaixa);
		
		$buscarNomeEmpresa = "SELECT * FROM zmpro.empresas where em_cod = $empresa;";
		$queryCaixa = mysqli_query($conexao, $buscarNomeEmpresa);

		$rowNomeEmpresa = mysqli_fetch_assoc($queryCaixa);

		//var_dump($ArrayLog);
		
		$lg_obs = "Nº De Ocorrencia: ". $getOcorrencia. "\n";
		$lg_obs .= "Data de Emissão - ".$data. " Data de Pagamento - ".$ArrayLog['dataPagto']. " Caixa - ".$rowNomeCaixa['bc_descricao']."\n";
		$lg_obs .= "Total de juros - ".$ArrayLog['totalJuros']. " Desconto - ". $ArrayLog['descto']." Saldo Total - ". $ArrayLog['saldoDevedor']."\n";
		$lg_obs .= "Forma de Pagamento: \n";
		$lg_obs .= "Dinheiro ".$ArrayLog['formaPagamento']['totalDinheiro'] . " Cartão ".$ArrayLog['formaPagamento']['totalCartao'] . " Cheque ".$ArrayLog['formaPagamento']['totalCheque']."\n";
		foreach($ArrayLog['parcelas'] as $parcelas){
			$lg_obs .= "\n";
			$lg_obs .= "----------------------------------------------------------------------------------------\n";
			$lg_obs .= "ID: ". $parcelas['ct_id'] . "ID Local: ".$parcelas['ct_idlocal'] . "Documento Nº: " . $parcelas['ct_docto'] . "\n";
			$lg_obs .= "Empresa: ". $rowNomeEmpresa['em_fanta']. "\n";
			$lg_obs .= "Cod. Cliente: ". $parcelas['ct_cliente_forn_id'] . " Nome: " . $parcelas['ct_nome']."\n";
			
			$lg_obs .= "Parcela: ".$parcelas['ct_parc']. " Vencimento: " .$parcelas['ct_vencto'] . " Valor:". $parcelas['ct_valor']."\n";
		}

		//echo $lg_obs;

		
		$sql = "INSERT into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
		lg_matriz,lg_sistema, lg_func_cod, lg_obs
		) VALUE($data, '$hora', '$ip', (SELECT us_nome FROM usuarios where us_id= $us_id), '$msg', $empresa, $matriz,'N',
		(SELECT us_cod FROM usuarios where us_id=$us_id),'". utf8_decode($lg_obs)."')";
		$inserir = mysqli_query($conexao, $sql);

		//echo $sql;
		
	}

	function logProdutos($conexao, $data, $hora, $ip, $us_id, $msg, $empresa, $matriz, $produtoNovo, $produtoAntigo, $cadastrar_alterar){


		if ($empresa == 0) {
			$empresa = $matriz;
		}

		//var_dump($produtoNovo);

		if ($cadastrar_alterar == 'N') {

			$buscarSubgrupo = "SELECT * from subgrupo_prod where sbp_codigo = ".$produtoNovo['pd_subgrupo']." and  sbp_matriz=$matriz;";
			$querySubgrupo = mysqli_query($conexao, $buscarSubgrupo);

			$rowNomeSubgrupo = mysqli_fetch_assoc($querySubgrupo);


			$lg_obs = "Cadastrado novo produto \n";

			$lg_obs .= "Codigo: ". $produtoNovo['pd_cod'] . " Descrição: " . $produtoNovo['pd_desc']. "\n";
			$lg_obs .= "Custo: " . $produtoNovo['pd_custo']. " Preço a Vista: " . $produtoNovo['pd_vista'] . "Preço a Prazo". $produtoNovo['pd_prazo'] . " Markup %: " . $produtoNovo['pd_markup'] . "\n";
			$lg_obs .= "Código Interno: " . $produtoNovo['pd_codinterno'] . " Unidade: ". $produtoNovo['pd_un']. " Lança Site: " . $produtoNovo['pd_lanca_site'] . " Ativo: ".$produtoNovo['pd_ativo']." Localização: " . $produtoNovo['pd_localizacao'] . "\n";
			$lg_obs .= "Subgrupo: ".$rowNomeSubgrupo['sbp_descricao']. " Marca: " . $produtoNovo['pd_marca']. " Grade: " . $produtoNovo['pd_grade']. "\n";
			$lg_obs .= "NCM: ".$produtoNovo['pd_ncm']. " CSOSN: ". $produtoNovo['pd_csosn']. " EAN: " .$produtoNovo['pd_ean']."\n";
			$lg_obs . "Estoque: " . $produtoNovo['es_est']. " Entrega: " . $produtoNovo['pd_disk'];
			$lg_obs .= "Imagem Produto: ".$produtoNovo['pd_foto_url'] . "\n";
			$lg_obs .= "Observações: " .$produtoNovo['pd_observ'];

			
			$sql = "INSERT into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
			lg_matriz,lg_sistema, lg_func_cod, lg_obs
			) VALUE($data, '$hora', '$ip', (SELECT us_nome FROM usuarios where us_id= $us_id), '$msg', $empresa, $matriz,'N',
			(SELECT us_cod FROM usuarios where us_id=$us_id),'". utf8_decode($lg_obs)."')";

			$query = mysqli_query($conexao, $sql);

			

			
		}
		else if($cadastrar_alterar == 'E'){

			$buscarSubgrupo = "SELECT * from subgrupo_prod where sbp_codigo = ".$produtoAntigo['pd_subgrupo']." and  sbp_matriz=$matriz;";
			$querySubgrupo = mysqli_query($conexao, $buscarSubgrupo);

			$rowNomeSubgrupo = mysqli_fetch_assoc($querySubgrupo);
			
			$lg_obs = "Editado Produto \n";

			$lg_obs .= "Dados Anteriores \n";

			$lg_obs .= "Codigo: ". $produtoAntigo['pd_cod'] . " Descrição: " . $produtoAntigo['pd_desc']. "\n";
			$lg_obs .= "Custo: " . $produtoAntigo['pd_custo']. " Preço a Vista: " . $produtoAntigo['pd_vista'] . " Preço a Prazo". $produtoAntigo['pd_prazo'] . " Markup %: " . $produtoAntigo['pd_markup'] . "\n";
			$lg_obs .= "Código Interno: " . $produtoAntigo['pd_codinterno'] . " Unidade: ". $produtoAntigo['pd_un']. " Lança Site: " . $produtoAntigo['pd_lanca_site'] . " Ativo: ".$produtoAntigo['pd_ativo']." Localização: " . $produtoAntigo['pd_localizacao'] . "\n";
			$lg_obs .= "Subgrupo: ".$rowNomeSubgrupo['sbp_descricao']. " Marca: " . $produtoAntigo['pd_marca']. " Grade: " . $produtoAntigo['pd_grade']. "\n";
			$lg_obs .= "NCM: ".$produtoAntigo['pd_ncm']. " CSOSN: ". $produtoAntigo['pd_csosn']. " EAN: " .$produtoAntigo['pd_ean']."\n";
			$lg_obs . "Entrega: " . $produtoAntigo['pd_disk'];
			$lg_obs .= "Imagem Produto: ".$produtoAntigo['pd_foto_url'] . "\n";
			$lg_obs .= "Observações: " .$produtoAntigo['pd_observ'] . "\n";


			$buscarSubgrupo = "SELECT * from subgrupo_prod where sbp_codigo = ".$produtoAntigo['pd_subgrupo']." and  sbp_matriz=$matriz;";
			$querySubgrupo = mysqli_query($conexao, $buscarSubgrupo);

			$rowNomeSubgrupo = mysqli_fetch_assoc($querySubgrupo);

			$lg_obs .= "=======================================================================\n";
			
			$lg_obs .= "Dados Novos \n";

			$lg_obs .= "Codigo: ". $produtoNovo['pd_cod'] . " Descrição: " . $produtoNovo['pd_desc']. "\n";
			$lg_obs .= "Custo: " . $produtoNovo['pd_custo']. " Preço a Vista: " . $produtoNovo['pd_vista'] . " Preço a Prazo". $produtoNovo['pd_prazo'] . " Markup %: " . $produtoNovo['pd_markup'] . "\n";
			$lg_obs .= "Código Interno: " . $produtoNovo['pd_codinterno'] . " Unidade: ". $produtoNovo['pd_un']. " Lança Site: " . $produtoNovo['pd_lanca_site'] . " Ativo: ".$produtoNovo['pd_ativo']." Localização: " . $produtoNovo['pd_localizacao'] . "\n";
			$lg_obs .= "Subgrupo: ".$rowNomeSubgrupo['sbp_descricao']. " Marca: " . $produtoNovo['pd_marca']. " Grade: " . $produtoNovo['pd_grade']. "\n";
			$lg_obs .= "NCM: ".$produtoNovo['pd_ncm']. " CSOSN: ". $produtoNovo['pd_csosn']. " EAN: " .$produtoNovo['pd_ean']."\n";
			$lg_obs . "Estoque: " . $produtoNovo['es_est']. " Entrega: " . $produtoNovo['pd_disk'];
			$lg_obs .= "Imagem Produto: ".$produtoNovo['pd_foto_url'] . "\n";
			$lg_obs .= "Observações: " .$produtoNovo['pd_observ'];

		}
		
		//var_dump($lg_obs);

		$sql = "INSERT into log (lg_data, lg_hora, lg_ip, lg_func_nome, lg_hist, lg_empresa,
			lg_matriz,lg_sistema, lg_func_cod, lg_obs
			) VALUE($data, '$hora', '$ip', (SELECT us_nome FROM usuarios where us_id= $us_id), '$msg', $empresa, $matriz,'N',
			(SELECT us_cod FROM usuarios where us_id=$us_id),'". utf8_decode($lg_obs)."')";

			$query = mysqli_query($conexao, $sql);
		


	}

	

?>