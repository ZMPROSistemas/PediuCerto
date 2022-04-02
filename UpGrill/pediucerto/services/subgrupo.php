<?php
require_once 'conn.php';


if (isset($_GET['subgrupoFoods'])) {

	$array = json_decode(file_get_contents("php://input"), true);

	$token= $array['token'];
	$lista = json_encode(subgrupoFoods($conexao, $token));
	echo $lista;
}

function subgrupoFoods($conexao, $token) {
	$resultado = array();

	$sql = "SELECT * from subgrupo_prod where sbp_empresa = (SELECT em_cod FROM zmpro.empresas where em_token = '$token') and sbp_lanca_site = 'S';";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'sbp_id' => $row['sbp_id'],
			'sbp_empresa' => $row['sbp_empresa'],
			'sbp_matriz' => $row['sbp_matriz'],
			'sbp_codigo' => $row['sbp_codigo'],
			'sbp_descricao' => ucwords(strtolower(utf8_decode($row['sbp_descricao']))),
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