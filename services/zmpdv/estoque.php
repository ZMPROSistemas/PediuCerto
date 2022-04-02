<?php

include 'conecta.php';

$codprod   = $_GET['codprod'];
$idempresa = $_GET['idempresa'];
$idmatriz  = $_GET['idmatriz'];

$lista = '{"result":' . json_encode(getEstoque($conexao,$codprod,$idempresa,$idmatriz)) . '}';
echo $lista;


function getEstoque($conexao,$codprod,$idempresa,$idmatriz) {
	$retorno = array();
	$sql = "select es_prod, es_empr, es_matriz, es_est, empresas.em_fanta FROM estoque";
	$sql = $sql . " inner join empresas on estoque.es_empr=empresas.em_cod"; 
	if ($idempresa==0) {
		$sql = $sql . " where es_prod=$codprod and es_matriz=$idmatriz order by es_empr";
	} else {
	    $sql = $sql . " where es_prod=$codprod and es_matriz=$idmatriz and es_empr=$idempresa";
	}
	$resultado = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($resultado)) {
		array_push($retorno, array(
			'es_empr' => $row['es_empr'],
			'es_matriz' => $row['es_matriz'],
			'es_est' => $row['es_est'],
			'em_fanta' => $row['em_fanta'],
		));
	}

	return $retorno;
}

