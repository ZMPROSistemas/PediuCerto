<?php
include 'conecta.php';
include 'log.php';
include 'ocorrencia.php';
include 'getIp.php';
include 'atualizaCache.php';

date_default_timezone_set('America/Bahia');

$us_id = base64_decode($_GET['us_id']);
$empresa = base64_decode($_GET['e']);
$empresaAcesso = base64_decode($_GET['eA']);

$data = date('Y-m-d'); 
$hora = date('H:i:s');
$ip = get_client_ip();

if(isset($_GET['SalvarProduto'])){

	$cadastrar_alterar = $_GET['cadastrar_alterar'];
	$array = json_decode(file_get_contents("php://input"), true);

	$pd_empresa = $empresaAcesso;
	$pd_matriz = $empresa;
	$produto = $array['prod'][0];
	
	if (array_key_exists('pd_st', $produto)) {
		
		if ($produto['pd_st']== true) {
			$produto['pd_csosn']= 500;
		}else{
			$produto['pd_csosn']= 102;
		}
	}else{
		$produto['pd_csosn']= 102;
	}

	if(!array_key_exists('pd_prazo', $produto)){
		$produto['pd_prazo']=0;
	}
	
	
	if ($cadastrar_alterar == 'N') {
		//echo 'N';
		codProduto($conexao, $pd_matriz,$pd_empresa);

		adicionarProduto ($conexao, $pd_empresa, $pd_matriz, $produto['pd_cod'], ucwords(strtolower($produto['pd_desc'])), $produto['pd_marca'], $produto['pd_custo'], $produto['pd_vista'], 
						$produto['pd_ean'], $produto['pd_codinterno'], $produto['pd_un'], $produto['pd_lanca_site'], $produto['pd_disk'], $produto['pd_subgrupo'], 
						$produto['pd_localizacao'], $produto['pd_prazo'], $produto['pd_ncm'], $produto['pd_csosn'], $produto['pd_markup'], $produto['pd_grade'], 
						$produto['pd_observ'], $produto['es_est'], trim($produto['pd_foto_url']), $produto['pd_composicao'], $us_id, $data, $hora, $ip, $produto, $cadastrar_alterar);
	}
	else if ($cadastrar_alterar == 'E'){
		//echo 'E';
		editarProduto ($conexao, $pd_empresa, $pd_matriz, $produto['pd_id'], $produto['pd_desc'], $produto['pd_codinterno'], $produto['pd_csosn'], $produto['pd_custo'], $produto['pd_ean'], trim($produto['pd_foto_url']),
						$produto['pd_grade'], $produto['pd_marca'], $produto['pd_markup'], $produto['pd_ncm'], $produto['pd_observ'], $produto['pd_prazo'], $produto['pd_subgrupo'],
						$produto['pd_un'], $produto['pd_vista'], $produto['pd_composicao'], $us_id, $data, $hora, $ip, $produto, $cadastrar_alterar, $produto['pd_lanca_site']);
	
	}

}

if(isset($_GET['deletarProduto'])){
	$prodCod = base64_decode($_GET['prodCod']);
	deletarProduto($conexao, $prodCod, $empresa, $empresaAcesso);
}


/*if (isset($_GET['estoque'])){

	$es_est = $_GET['estoque'];

	if ($es_est =! 'undefined'){

		//editarDispesa($conexao, $editarConta['ct_id'], $editarConta['parc'], $editarConta['mudarVencimento'], $editarConta['mudarValor'], $editarConta['mudarTipoDocto'], $editarConta['ct_docto'], $editarConta['ct_obs'], $editarConta['ct_cliente_forn'], $id, $empresa, $data, $hora, $ip);
	}
}*/
	
function adicionarProduto ($conexao, $pd_empresa, $pd_matriz, $pd_cod, $pd_desc, $pd_marca, $pd_custo, $pd_vista, $pd_ean, $pd_codinterno, $pd_un, 
							$pd_lanca_site, $pd_disk, $pd_subgrupo, $pd_localizacao, $pd_prazo, $pd_ncm, $pd_csosn, $pd_markup, $pd_grade, $pd_observ, 
							$es_est, $pd_foto_url, $pd_composicao, $us_id, $data, $hora, $ip, $produto, $cadastrar_alterar) {

	if ($pd_empresa == 0) {
		$pd_empresa = $pd_matriz;
	}
	$cod_produto = getCodProduto($conexao, $pd_matriz,$pd_empresa);
	$pd_cod = $cod_produto['dc_produto'];
	
	$retorno = array();
	
	$pd_custo = str_replace('R', '', $pd_custo);
	$pd_custo = str_replace('$', '', $pd_custo);
	$pd_custo = str_replace (',','.', $pd_custo);

	$pd_prazo = str_replace ('R','', $pd_prazo);
    $pd_prazo = str_replace ('$', '', $pd_prazo);
	$pd_prazo = str_replace (',','.', $pd_prazo);

	$pd_vista = str_replace('R', '', $pd_vista);
	$pd_vista = str_replace('$', '', $pd_vista);
	$pd_vista = str_replace (',','.', $pd_vista);

	$st1=0;
	$st2=00;

	if($pd_csosn == 500){
		$st2=60;
	}
	
		$pd_ativo = 'S';
		$pd_deletado = 'N';
		$pd_pascomis = 'S';
		$pd_comis = 0.00;
		$pd_promocao = 0.00;
		$pd_desc1 = 0.00;
		$pd_desc2 = 0.00;
		$pd_desc3 = 0.00;
		$pd_valorant = 0; 
		$pd_frete = 0; 
		$pd_ipi =  0;
		$pd_encargos = 0; 
		$pd_tempocobert = 0; 
		$pd_alterado = 0 ; 
		$pd_peso =0 ;
		$pd_m3 = 0;
		$pd_customedio = 0;
		$pd_icmscompra = 0;
		$pd_icmsvenda = 0;
		$pd_volume = 0;
		$pd_origemfab = 'T';
		$pd_monofasico = 'N';

		$pd_indiceun = 0;
		$pd_margsubtrib = 0; 
		$pd_codgrade = 0; 
		$pd_serv = 0;

		$pd_valatacado = 0 ;
		$pd_aliq_pis_cp = 0;
		$pd_aliq_cofins_vd= 0 ;
		$pd_aliq_cofins_cp = 0;
		$pd_qntemb = 0;
		$pd_confsaida = 'N';

		$pd_perc_st = 0;
		$pd_perc_frete = 0;
		$pd_dimen1 = 0;
		$pd_dimen2 = 0; 
		$pd_dimen3 = 0; 
		$pd_icmsval = 0; 
		$pd_ipival = 0; 
		$pd_cofinsval = 0; 
		$pd_iival = 0; 
		$pd_perc = 0; 
		$pd_destaquesite ='N';
		$pd_st_empr_st = 'N';
		$pd_reducao = 0; 
		$pd_atualizast = 'N';
		$pd_quantfixa = 0; 
		$pd_sobre_encomenda = 'N';

		$pd_fcp = 0; 
		$pd_qnt_trib= 0; 
		$pd_bcstret = 0; 
		$pd_pstret = 0;
		$pd_icmsstret = 0; 
		$pd_icmssubstituto = 0; 
		$pd_pmc = 0; 
		$pd_impressora =0;

		$pd_aliq_pis_vd = 0;

		//$getImage = trim($_GET['imageSub']);
        $pd_foto_url = strstr($pd_foto_url, 'imag');
		//echo $pd_foto_url;

	
		$sql = "insert into produtos (pd_empresa, pd_matriz, pd_cod, pd_desc, pd_marca, pd_custo, pd_vista, pd_ean, pd_codinterno, pd_un, pd_lanca_site, 
									pd_disk, pd_subgrupo, pd_localizacao, pd_prazo, pd_ncm, pd_csosn, pd_markup, pd_grade, pd_observ, pd_foto_url, 
									pd_datacad, pd_ativo, pd_deletado, pd_pascomis, pd_comis, pd_promocao, pd_st1, pd_st2, pd_desc1, pd_desc2, pd_desc3,
									pd_valorant, pd_frete, pd_ipi, pd_encargos, pd_tempocobert, pd_alterado, pd_peso, pd_m3,
									pd_customedio, pd_icmscompra, pd_icmsvenda, pd_volume, pd_origemfab, pd_monofasico, pd_indiceun, pd_margsubtrib, 
									pd_codgrade, pd_serv, pd_valatacado, pd_aliq_pis_cp, pd_aliq_cofins_vd, pd_aliq_cofins_cp, pd_qntemb, pd_confsaida, 
									pd_perc_st, pd_perc_frete, pd_dimen1,pd_dimen2,pd_dimen3, pd_icmsval, pd_ipival, pd_cofinsval, pd_iival, pd_perc, pd_destaquesite, pd_st_empr_st,
									pd_reducao, pd_atualizast,  pd_quantfixa, pd_sobre_encomenda,
									pd_fcp,pd_qnt_trib, pd_bcstret, pd_pstret,pd_icmsstret, pd_icmssubstituto, pd_pmc,pd_impressora, pd_aliq_pis_vd, pd_composicao) 

						values ($pd_matriz, $pd_matriz, '$pd_cod', '".utf8_decode($pd_desc)."', '$pd_marca', '$pd_custo', '$pd_vista', '$pd_ean', '$pd_codinterno', 
								'$pd_un', '$pd_lanca_site', '$pd_disk', '$pd_subgrupo', '$pd_localizacao', '$pd_prazo', '$pd_ncm', '$pd_csosn', 
								'$pd_markup', '$pd_grade', '$pd_observ', '$pd_foto_url', '$data', '$pd_ativo', '$pd_deletado','$pd_pascomis', '$pd_comis', 
								'$pd_promocao', $st1, $st2, '$pd_desc1','$pd_desc2','$pd_desc3',
								'$pd_valorant','$pd_frete','$pd_ipi','$pd_encargos','$pd_tempocobert','$pd_alterado','$pd_peso','$pd_m3','$pd_customedio',
								'$pd_icmscompra','$pd_icmsvenda','$pd_volume', '$pd_origemfab', '$pd_monofasico', '$pd_indiceun', '$pd_margsubtrib', 
								'$pd_codgrade', '$pd_serv', '$pd_valatacado', '$pd_aliq_pis_cp', '$pd_aliq_cofins_vd', '$pd_aliq_cofins_cp', '$pd_qntemb', '$pd_confsaida',
								'$pd_perc_st', '$pd_perc_frete', '$pd_dimen1', '$pd_dimen2','$pd_dimen3', '$pd_icmsval', '$pd_ipival', '$pd_cofinsval', '$pd_iival', '$pd_perc', '$pd_destaquesite', '$pd_st_empr_st',
								'$pd_reducao', '$pd_atualizast', '$pd_quantfixa', '$pd_sobre_encomenda',
								'$pd_fcp', '$pd_qnt_trib', '$pd_bcstret', '$pd_pstret', '$pd_icmsstret', '$pd_icmssubstituto', '$pd_pmc', '$pd_impressora', $pd_aliq_pis_vd, '". utf8_decode($pd_composicao)."');";

	//echo $sql;

	$inserir = mysqli_query($conexao, $sql);
	
	$pd_id = mysqli_insert_id($conexao);

	if (mysqli_affected_rows($conexao) <= 0) {
	
		array_push($retorno, array(
                'status'=> $row = 'ERROR',
            ));
	
	} else {

		array_push($retorno, array(
            'status'=> $row = 'SUCCESS',
			'pd_cod' => $pd_cod,
			'pd_id' => $pd_id,
		));
		
		$produtoAntigo=array();
		$msg = "Produto novo adicionado ";
		if ($us_id != 0) {
			logProdutos($conexao, $data, $hora, $ip, $us_id, $msg, $pd_empresa, $pd_matriz, $produto, $produtoAntigo, $cadastrar_alterar);
			
			//atualizaCache($conexao, $pd_matriz, $pd_empresa, 'produto');
		}
		

       

	}

	//echo $sql;

	echo '{"result":[' . json_encode($retorno). ']}';

	return $retorno;

	
}

function editarProduto ($conexao, $pd_empresa, $pd_matriz, $pd_id, $pd_desc, $pd_codinterno, $pd_csosn, $pd_custo, $pd_ean, $pd_foto_url, $pd_grade, $pd_marca, $pd_markup, $pd_ncm,
	$pd_observ, $pd_prazo, $pd_subgrupo, $pd_un, $pd_vista, $pd_composicao, $us_id, $data, $hora, $ip, $produto, $cadastrar_alterar, $pd_lanca_site) {


	$st1=0;
	$st2=00;

	if($pd_csosn == 500){
		$st2=60;
	}
	//$produtoAntigo = array();
	//=========================================================================

	$buscarProduto = "SELECT * from produtos where pd_id = $pd_id";
	$queryProduto= mysqli_query($conexao, $buscarProduto);

	$produtoAntigo = mysqli_fetch_assoc($queryProduto);

	//=====================================================================

	$pd_custo = str_replace('R', '', $pd_custo);
	$pd_custo = str_replace('$', '', $pd_custo);
	//$pd_custo = str_replace ('.','', $pd_custo);
	$pd_custo = str_replace (',','.', $pd_custo);

	$pd_prazo = str_replace ('R','', $pd_prazo);
    $pd_prazo = str_replace ('$', '', $pd_prazo);
	//$pd_prazo = str_replace ('.','', $pd_prazo);
	$pd_prazo = str_replace (',','.', $pd_prazo);

	$pd_vista = str_replace('R', '', $pd_vista);
	$pd_vista = str_replace('$', '', $pd_vista);
	//$pd_vista = str_replace ('.','', $pd_vista);
	$pd_vista = str_replace (',','.', $pd_vista);

	if($pd_markup == ''){
		$pd_markup = 0;
	}
	$pd_foto_url = strstr($pd_foto_url, 'imag');
	
	$retorno = array();
	
	$sql = "UPDATE produtos set 
	pd_ativo = 'S',
	pd_codinterno = '$pd_codinterno',
	pd_csosn = '$pd_csosn',
	pd_custo = $pd_custo,
	pd_desc =  '". utf8_decode($pd_desc)."',
	pd_ean = '$pd_ean',
	pd_foto_url = '$pd_foto_url',
	pd_grade = '$pd_grade',
	pd_marca = '$pd_marca',
	pd_markup = $pd_markup,
	pd_ncm = '$pd_ncm',
	pd_observ =  '". utf8_decode($pd_observ)."',
	pd_prazo = '$pd_prazo',
	pd_subgrupo = $pd_subgrupo,
	pd_un = '$pd_un',
	pd_st1 = '$st1', 
	pd_st2 = '$st2',
	pd_lanca_site = '$pd_lanca_site',
	pd_composicao = '" . utf8_decode($pd_composicao)."',
	pd_vista = $pd_vista where pd_matriz = $pd_matriz and pd_id = $pd_id";

	//echo $sql;

	$inserir = mysqli_query($conexao, $sql);
	
	$pd_id = mysqli_insert_id($conexao);

	
	if (mysqli_affected_rows($conexao) < 0) {
	
		array_push($retorno, array(
                'status'=> $row = 'ERROR',
            ));
		$msg = "Produto Editado ";
		if ($us_id != 0) {
			logProdutos($conexao, $data, $hora, $ip, $us_id, $msg, $pd_empresa, $pd_matriz, $produto, $produtoAntigo, $cadastrar_alterar);
			atualizaCache($conexao, $pd_matriz, $pd_empresa, 'produto');
		}

	} else {

		array_push($retorno, array(
            'status'=> $row = 'SUCCESS',
		));
		
		$msg = "Produto Editado ";
		if ($us_id != 0) {
			logProdutos($conexao, $data, $hora, $ip, $us_id, $msg, $pd_empresa, $pd_matriz, $produto, $produtoAntigo, $cadastrar_alterar);
			atualizaCache($conexao, $pd_matriz, $pd_empresa, 'produto');
		}
        

	}
	echo '{"result":[' . json_encode($retorno). ']}';
		
		

	return $retorno;

	
}

function deletarProduto ($conexao, $prodCod, $matriz, $empresa){

	$retorno = array();

	$sql = "UPDATE produtos set pd_deletado = 'S' where pd_id = $prodCod";
	$query = mysqli_query($conexao, $sql);

	if (mysqli_affected_rows($conexao) <= 0) {
	
		array_push($retorno, array(
                'status'=> $row = 'ERROR',
            ));
		//$msg = "Produto Editado ";
		//logProdutos($conexao, $data, $hora, $ip, $us_id, $msg, $pd_empresa, $pd_matriz, $produto, $produtoAntigo, $cadastrar_alterar);

	} else {

		array_push($retorno, array(
            'status'=> $row = 'SUCCESS',
			
        ));
			//atualizaCache($conexao, $matriz, $empresa, 'produto');
	}
	//echo $sql;
	echo '{"result":[' . json_encode($retorno). ']}';
	
	return $retorno;

}

?>