<?php

require_once 'conecta.php';
require_once 'conectaPDO.php';

if (isset($_GET['e'])){
	$empresaMatriz = base64_decode($_GET['e']);
}


if (isset($_GET['eA'])) {
	$empresaAcesso = base64_decode($_GET['eA']);
}


if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$empresa = '';

	} else {
		$empresa = ' and pd_empresa= ' . $empresa;
	} 

} else {
	$empresa = '';
}

if (isset($_GET['produtos'])) {

	$produtos = $_GET['produtos'];

	if ($produtos == null) {
		$pd_id = '';
	} else {
		$pd_id = '  and pd_id= ' . $produtos;
	}
} else {
	$pd_id = '';
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

//$EditarCadastrarExcluir = $_GET['EditarCadastrarExcluir'];


//$array = json_decode(file_get_contents("php://input"), true);

//$id = $_GET['id'];

if (isset($_GET['dadosProdutosSimplificado'])) {

	$pageNum = $_GET['page'];
	$pagesize = $_GET['size'];
	$offset = ($pageNum - 1) * $pagesize;
	$searchCodigo = $_GET['searchCodigo'];
	$searchNome = $_GET['searchNome'];
	$searchMarca = $_GET['searchMarca'];
	$searchSubGrupo = $_GET['searchSubGrupo'];
	$ordenar = " pd_desc ";

	if ($searchNome != "") {
		$andNome = " AND pd_desc LIKE '%" . $searchNome . "%'";
	} else {
		$andNome = "";
	}

	if ($searchCodigo != "") {
		$andCodigo = " AND pd_cod LIKE '%" . $searchCodigo . "%'";
		$ordenar = " pd_cod ";
	} else {
		$andCodigo = "";
	}

	if ($searchMarca != "") {
		$andMarca = " AND pd_marca LIKE '%" . $searchMarca . "%'";
	} else {
		$andMarca = "";
	}

	if ($searchSubGrupo != "") {
		$andSubGrupo = " AND pd_subgrupo = (select sbp_codigo from subgrupo_prod where sbp_id = " . $searchSubGrupo . ")";
	} else {
		$andSubGrupo = "";
	}

	$lista = json_encode(dadosProdutosSimplificado($conexao, $empresaMatriz, $andCodigo, $andNome, $andMarca, $andSubGrupo, $offset, $pagesize, $ordenar));
	echo $lista;

}

if (isset($_GET['perfilCompletoEmpresa'])) {

	$lista = '{"result":[' . json_encode(perfilCompletoEmpresa($conexao, $empresa)) . ']}';
	echo $lista;

}

if(isset($_GET['visualizarProdutos'])){
	$pd_id = $_GET['pd_id'];
	$lista = '{"result":[' . json_encode(getProduto($conexao, $empresaMatriz, $pd_id)) . ']}';
	echo $lista;
}

if(isset($_GET['consultaProduto'])){
	$pd_cod = $_GET['pd_cod'];
	$lista = '{"result":[' . json_encode(consultaProduto($conexao, $empresaMatriz, $pd_cod)) . ']}';
	echo $lista;
}

if(isset($_GET['verificarCodigo'])){
	
	$campo = $_GET['campo'];
	$valor = $_GET['valor'];
	$lista = '{"result":[' . json_encode(procurarCodigo($conexao, $empresaMatriz, $campo, $valor, $empresa)) . ']}';
	echo $lista;
}

if(isset($_GET['buscarProdutosFoods'])){

	$array = json_decode(file_get_contents("php://input"), true);
	
	$id = $array['id'];
	$token = $array['token'];
	$subGroup = $array['subgrupo'];

	$lista = json_encode(produtosAplicativo($conexao, $pdo, $id, $token));
	echo $lista;
}

function dadosProdutosSimplificado($conexao, $empresaMatriz, $andCodigo, $andNome, $andMarca, $andSubGrupo, $offset, $pagesize, $ordenar) {


	$sql = "SELECT COUNT(*) AS count FROM produtos where pd_deletado <> 'S' and pd_matriz = $empresaMatriz $andCodigo $andNome $andMarca $andSubGrupo;";
	//$result = $conexao->query($sql);
	//$row = $result->fetch(PDO::FETCH_ASSOC);
	//echo $sql;

	$result = mysqli_query($conexao, $sql);
	$row = mysqli_fetch_assoc($result);
	$count = $row['count'];

	$query = "SELECT pd_id, pd_cod, pd_desc, pd_marca, pd_vista, pd_prazo, 
	(select min(sbp_descricao) from subgrupo_prod where sbp_codigo = pd_subgrupo and sbp_matriz = pd_matriz) as sbp_descricao
	from produtos where (pd_deletado <> 'S' or pd_deletado is null) 
	and pd_matriz = $empresaMatriz $andCodigo $andNome $andMarca $andSubGrupo ORDER BY $ordenar LIMIT $offset, $pagesize;";

	$result = mysqli_query($conexao, $query);

	//echo $query;

	while ($row = mysqli_fetch_assoc($result)) {
		$retorno[] = array(
			'pd_id' => $row['pd_id'],
			'pd_cod' => $row['pd_cod'],
			'pd_desc' => ucwords(utf8_encode($row['pd_desc'])),
			'sbp_descricao' => utf8_encode($row['sbp_descricao']),
			'pd_marca'=> utf8_encode($row['pd_marca']),
			'pd_vista' => utf8_encode($row['pd_vista']),
			'pd_prazo' => utf8_encode($row['pd_prazo']),
			);
	}

	$myData = array('listaProdutos' => $retorno, 'totalCount' => $count);

	return $myData;

}

function procurarCodigo ($conexao, $empresaMatriz, $campo, $valor, $empresa) {

	$retorno = array();

	$sql = "select max(pd_cod) as pd_cod from produtos where pd_matriz = $empresaMatriz  $empresa";

	//echo $sql;

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($retorno, array(
				'pd_cod' => (float)$row['pd_cod'],
		));
	}

	
	return $retorno;
}

function getProduto($conexao, $empresaMatriz, $pd_id){
	//função tem que terminar, não funcionando ainda
	$retorno = array();

	$sql = "select 	pd_id,
					pd_cod,
					pd_ean,
					pd_codinterno,
					pd_un,
					pd_lanca_site,
					pd_disk,
					pd_desc,
					pd_subgrupo,
					pd_marca,
					pd_localizacao,
					pd_ncm,
					pd_csosn,
					pd_custo,
					pd_vista,
					pd_prazo,
					pd_markup,
					pd_grade,
					pd_foto_url,
					pd_observ,
					pd_ativo,
					pd_composicao
			from produtos where pd_id = $pd_id;";
						
	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($retorno, array(
			'pd_id' => $row['pd_id'],
			'pd_cod' => $row['pd_cod'],
			'pd_ean'=> $row['pd_ean'],
			'pd_codinterno' => $row['pd_codinterno'],
			'pd_un'=>$row['pd_un'],
			'pd_lanca_site' => $row['pd_lanca_site'],
			'pd_disk' => $row['pd_disk'],
			'pd_desc' => ucwords(utf8_encode($row['pd_desc'])),
			'pd_subgrupo'=>$row['pd_subgrupo'],
			'pd_marca'=> ucwords(strtolower(utf8_decode($row['pd_marca']))),
			'pd_localizacao' => $row['pd_localizacao'],
			'pd_ncm' => $row['pd_ncm'],
			'pd_csosn' => utf8_encode($row['pd_csosn']),
			'pd_custo' => (float)$row['pd_custo'],
			'pd_vista' => (float)$row['pd_vista'],
			'pd_prazo' => (float)$row['pd_prazo'],
			'pd_markup' => (float)$row['pd_markup'],
			'pd_grade' => $row['pd_grade'],
			'pd_foto_url' => utf8_encode($row['pd_foto_url']),
			'pd_observ' => ucwords(strtolower(utf8_decode($row['pd_observ']))),
			'es_est' => estoque($conexao, $row['pd_id']),
			'pd_ativo' => utf8_encode($row['pd_ativo']),
			'pd_composicao' => utf8_encode($row['pd_composicao']),
			/*



			pd_cor
			pd_tam
			pd_pascomis


			pd_vista
			pd_datacad
			pd_comis
			pd_promocao
			pd_ultcompra
			pd_nota
			pd_custofab
			pd_subgrupo
			pd_desc1
			pd_desc2
			pd_desc3

			pd_un
			pd_cf

			pd_dtinp
			pd_dtfnp
			pd_vd1
			pd_vd2
			pd_vd3
			pd_dataalt
			pd_horaalt
			pd_valorant
			pd_frete
			pd_ipi
			pd_encargos
			pd_tempocobert
			pd_alterado
			pd_peso
			pd_ativo
			pd_ultvenda
			pd_m3
			pd_grade
			pd_tipoicm
			pd_customedio
			pd_icmscompra
			pd_icmsvenda
			pd_autor
			pd_nomecient
			pd_codfab
			pd_codorig
			pd_volume
			pd_origemfab

			pd_monofasico
			pd_codengenharia
			pd_tempoproducao
			pd_uncompra
			pd_indiceun
			pd_margsubtrib
			pd_codgrade
			pd_serv


			pd_valatacado
			pd_st1_cp
			pd_st2_cp
			pd_st_ipi
			pd_st_ipi_cp
			pd_st_pis
			pd_st_pis_cp
			pd_st_cofins
			pd_st_cofins_cp
			pd_codtab421
			pd_aliq_pis_vd
			pd_aliq_pis_cp
			pd_aliq_cofins_vd
			pd_aliq_cofins_cp
			pd_qntemb
			pd_confsaida
			pd_perc_st
			pd_perc_frete
			pd_lanca_site
			pd_dimen1
			pd_dimen2
			pd_dimen3
			pd_icmsval
			pd_ipival
			pd_pisval
			pd_cofinsval
			pd_iival
			pd_perc
			pd_destaquesite
			pd_st_empr_st
			pd_foto
			pd_observ
			pd_reducao
			pd_cfopdest
			pd_cfopfest
			pd_cod_codif
			pd_cod_anp
			pd_atualizast
			pd_val1
			pd_val2
			pd_val3
			pd_val4
			pd_val5
			pd_val6
			pd_val7
			pd_val8
			pd_val9
			pd_val10
			pd_val11
			pd_val12
			pd_val13
			pd_val14
			pd_val15
			pd_val16
			pd_val17
			pd_val18
			pd_valadd
			pd_cenqipi
			pd_cest
			pd_fcp
			pd_quantfixa
			pd_desc_anp
			pd_sobre_encomenda
			pd_un_trib
			pd_qnt_trib
			pd_bcstret
			pd_pstret
			pd_icmsstret
			pd_icmssubstituto
			pd_cod_anvisa
			pd_pmc
			pd_motivo_anvisa
			pd_garc_lanca
			pd_impressora
			pd_cod_benef
			pd_disk
			pd_salao
			pd_foto_url
			*/
		));
	}

	//echo $sql;

	return $retorno;

}

function consultaProduto($conexao, $empresaMatriz, $pd_cod){
	
	$retorno = array();

	$sql = "select 	pd_id,
					pd_cod,
					pd_ean,
					pd_codinterno,
					pd_un,
					pd_desc,
					pd_subgrupo,
					pd_marca,
					pd_custo,
					pd_vista,
					pd_observ,
					pd_composicao
			from produtos where pd_cod = $pd_cod and pd_matriz = $empresaMatriz;";
						
	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($retorno, array(
			'pd_id' => $row['pd_id'],
			'pd_cod' => $row['pd_cod'],
			'pd_ean'=> $row['pd_ean'],
			'pd_codinterno' => $row['pd_codinterno'],
			'pd_un'=>$row['pd_un'],
			'pd_desc' => ucwords(utf8_decode($row['pd_desc'])),
			'pd_subgrupo'=>$row['pd_subgrupo'],
			'pd_marca'=> ucwords(strtolower(utf8_decode($row['pd_marca']))),
			'pd_custo' => utf8_encode($row['pd_custo']),
			'pd_vista' => utf8_encode($row['pd_vista']),
			'pd_observ' => ucwords(strtolower(utf8_decode($row['pd_observ']))),
			'pd_composicao'=> utf8_encode($row['pd_composicao']),

		));
	}

	//echo $sql;

	return $retorno;

}

function estoque($conexao, $id){

	$sql="select es_est from estoque where es_prod = (select pd_cod from produtos where pd_id = $id);";

	$query = mysqli_query($conexao, $sql);

	$return = mysqli_fetch_assoc($query);

	return $return['es_est'];
	
}

function produtosAplicativo($conexao, $pdo, $id, $token) {
	$resultado = array();

	$sql = "SELECT sbp_id, sbp_codigo, sbp_descricao, sbp_grupo from subgrupo_prod where 
	sbp_empresa = (SELECT em_cod FROM zmpro.empresas where em_token = '$token') 
	and sbp_lanca_site = 'S' ORDER BY sbp_destaca_site desc, sbp_descricao;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'sbp_descricao' => ucwords(strtolower(utf8_encode($row['sbp_descricao']))),
			'produto' => buscarProdutosAplicativo($conexao, $pdo, $id, $token, $row['sbp_codigo'])
			
		));

	}

	//echo $sql;
	return $resultado;
}

function buscarProdutosAplicativo($conexao, $pdo, $id, $token, $subGroup) {

	$retorno = array();
		//$sql = "call SelecionarProdutosAplicativo($token);";

		$sql = "SELECT pd_id, pd_cod, pd_desc, pd_vista, pd_subgrupo, pd_destaquesite, pd_foto_url, pd_disk, pd_composicao, pd_atualizast, pd_codgrade  
		from produtos where pd_matriz=(select em_cod from empresas where em_token = '$token')
		and pd_lanca_site = 'S' and pd_subgrupo=$subGroup and (pd_deletado is null or pd_deletado <> 'S') order by pd_desc asc;";
		
		$query = mysqli_query($conexao, $sql);

		while ($row = mysqli_fetch_assoc($query)) {
			array_push($retorno, array(
				'pd_id' => $row['pd_id'],
				'pd_cod' => $row['pd_cod'],
				'pd_desc' => ucwords(strtolower(utf8_encode($row['pd_desc']))),
				'pd_vista' => (float)$row['pd_vista'],
				'pd_subgrupo' => $row['pd_subgrupo'],
				'pd_destaquesite' =>utf8_encode($row['pd_destaquesite']),
				'pd_foto_url' =>utf8_encode($row['pd_foto_url']),
				'pd_disk'=> utf8_encode($row['pd_disk']),
				'pd_composicao'=>utf8_encode($row['pd_composicao']),
				'pd_atualizast' => utf8_encode($row['pd_atualizast']), 
				'pd_codgrade' =>  $row['pd_codgrade'],
				'pd_quantidade' => 0,
				'adicionais' => adcionais_exec($pdo, $row['pd_id'], $token)

				
			));
			
		};
		return $retorno;
	
	
	}

	function adcionais_exec($pdo, $pd_id, $token){

		$result = array();
		$adcionais_exec =$pdo->prepare("SELECT pde_id, pde_tipo, (SELECT ex_id from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_id,
		(SELECT ex_desc from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_desc,
		(SELECT ex_valor from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_valor,
		(SELECT ex_tipo from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_tipo
		FROM produtos_excecoes
		 where pde_empresa = (SELECT em_cod from empresas where em_token = :token)
		 and pde_produto = (SELECT pd_cod from produtos where pd_id= :pd_id) order by ex_desc asc;");
		$adcionais_exec->bindValue(":token", $token);
		$adcionais_exec->bindValue(":pd_id", $pd_id);
        $adcionais_exec->execute();
		$result = $adcionais_exec->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	function apagar_depois($e){
		$return = 0;
		 
		if($e == 126189){
			$return = 1;
		 }

		 return $return;
	}

?>
