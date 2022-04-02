<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

require_once 'conn.php';

date_default_timezone_set('America/Bahia');

if(isset($_GET['dadosEmpresa'])){
	
	
	$array = json_decode(file_get_contents("php://input"), true);

	$id = $array['id'];
	$token = $array['token'];
	
	$lista = json_encode(dadosEmpresa($conexao,$id,$token));
	echo $lista;
}


function dadosEmpresa($conexao,$id,$token){
	$result = array();
	$sql = "SELECT * FROM zmpro.empresas where em_token = '$token';";
	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)){
		array_push($result, array(
			'em_cod' => $row['em_cod'],
			'em_token' => utf8_encode($row['em_token']),
			'em_razao' =>utf8_encode($row['em_razao']),
			'em_fanta' => utf8_encode($row['em_fanta']),
			'em_nome_resumido' => utf8_encode($row['em_nome_resumido']),
			'em_end_num' => utf8_encode($row['em_end_num']),
			'em_end_num' => $row['em_end_num'],
			'em_bairro' => utf8_encode($row['em_bairro']),
			'em_cid' => utf8_encode($row['em_cid']),
			'em_uf' => utf8_encode($row['em_uf']),
			'em_cep' => utf8_encode($row['em_cep']),
			'em_cnpj' => utf8_encode($row['em_cnpj']),
			'em_fone' => utf8_encode($row['em_fone']),
			'em_email' => utf8_encode($row['em_email']),
			'em_logo' => utf8_encode($row['em_logo']),
			'em_ramo' => utf8_encode($row['em_ramo']),
			'em_ativo' => utf8_encode($row['em_ativo']),
			'em_aberto' => utf8_encode($row['em_aberto']),
			'em_data_abertura' => utf8_encode($row['em_data_abertura']),
			'em_hora_abertura' => utf8_encode($row['em_hora_abertura']),
			'em_foto_url'=> utf8_encode($row['em_foto_url']),

		));
	}

	return $result;

}
