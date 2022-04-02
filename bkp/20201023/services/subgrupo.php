<?php
require_once 'conecta.php';


if (isset($_GET['matriz'])) {
	$empresaMatriz = base64_decode($_GET['matriz']);
}

if (isset($_GET['empresa'])) {
	$empresaAcesso = base64_decode($_GET['empresa']);
}

if (isset($_GET['subgrupo'])) {
	
	$lista = '{"result":[' . json_encode(subgrupo($conexao, $empresaMatriz)) . ']}';
	echo $lista;
}

if (isset($_GET['subgrupoFoods'])) {

	$array = json_decode(file_get_contents("php://input"), true);

	$token= $array['token'];
	$lista = json_encode(subgrupoFoods($conexao, $token));
	echo $lista;
}



function subgrupo($conexao, $empresaMatriz) {
	$resultado = array();

	$sql = "SELECT sbp_id, min(sbp_codigo) as sbp_codigo, sbp_empresa, sbp_descricao, sbp_grupo FROM subgrupo_prod  
			where sbp_matriz = $empresaMatriz and sbp_deletado <> 'S' group by sbp_descricao;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'sbp_id' => $row['sbp_id'],
			'sbp_codigo' => $row['sbp_codigo'],
			'sbp_empresa' => $row['sbp_empresa'],
			'sbp_descricao' => ucwords(utf8_decode($row['sbp_descricao'])),
			'sbp_grupo' => $row['sbp_grupo'],
		));

	}

	//echo $sql;
	return $resultado;
}

function subgrupoFoods($conexao, $token) {
	$resultado = array();

	$sql = "SELECT * from subgrupo_prod where sbp_empresa = (SELECT em_cod FROM zmpro.empresas where em_token = '$token') 
	and sbp_lanca_site = 'S' and sbp_deletado <> 'S' ORDER BY sbp_destaca_site desc, sbp_descricao;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'sbp_id' => $row['sbp_id'],
			'sbp_empresa' => $row['sbp_empresa'],
			'sbp_matriz' => $row['sbp_matriz'],
			'sbp_codigo' => $row['sbp_codigo'],
			'sbp_descricao' => ucwords(strtolower(utf8_encode($row['sbp_descricao']))),
			'sbp_grupo' => $row['sbp_grupo'],
			'sbp_impressora' => $row['sbp_impressora'],
			'sbp_grade' => $row['sbp_grade'],
			'sbp_tipo' => $row['sbp_tipo'],
			'sbp_desc' => $row['sbp_desc'],
			'sbp_comis' => $row['sbp_comis'],
			'sbp_imagem' =>utf8_encode($row['sbp_imagem']),

		));

	}

	//echo $sql;
	return $resultado;
}

?>
