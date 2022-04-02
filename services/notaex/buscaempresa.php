<?php

include 'conecta.php';

$email = $_GET['email'];

$lista = '{"result":' . json_encode(getDados($conexao,$email)) . '}';
echo $lista;

function getDados($conexao,$email) {
	$retorno = array();

	$sql = "select * from empresas where em_email='$email'";

	$resultado = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($resultado)) {
		array_push($retorno, array(
			'em_cod' => $row['em_cod'],
			'em_razao' => utf8_decode($row['em_razao']),
			'em_fanta' => utf8_decode($row['em_fanta']),
			'em_nome_resumido' => utf8_decode($row['em_nome_resumido']),
			'em_end' => utf8_decode($row['em_end']),
			'em_end_num' => $row['em_end_num'],
			'em_bairro' => utf8_decode($row['em_bairro']),
			'em_cid' => utf8_decode($row['em_cid']),
			'em_uf' => utf8_decode($row['em_uf']),
			'em_senha' => utf8_decode($row['em_senha']),
		));
	}

	return $retorno;
}