<?php

require_once 'conecta.php';

 



if (isset($_GET['listaBalanco'])) {

	$empresaMatriz = base64_decode($_GET['e']);
	$empresaAcesso = base64_decode($_GET['eA']);
	$empresa = $_GET['empresa'];
	$dataI = $_GET['dataI'];
	$dataF = $_GET['dataF'];

	if ($empresa == 0) {
		
		$lista = '{"result":[' . json_encode(listarTodosBalancos($conexao, $empresaMatriz, $dataI, $dataF)) . ']}';
		echo $lista;
	
	} else {
	
		$lista = '{"result":[' . json_encode(listarBalanco($conexao, $empresaMatriz, $empresa, $dataI, $dataF)) . ']}';
		echo $lista;
	}

}

if (isset($_GET['consultaBalanco'])) {

	$ce_id = $_GET['ce_id'];

	$lista = '{"result":[' . json_encode(consultarBalanco($conexao, $ce_id)) . ']}';
	echo $lista;

}

function listarTodosBalancos($conexao, $empresaMatriz, $dataI, $dataF) {
	$retorno = array();

	$sql = "select 	ce_id,
					ce_idlocal,
					ce_data,
					(select em_fanta from empresas where em_cod = ce_empresa) as ce_empresa,
					ce_matriz,
					ce_aberto
					from cons_est where ce_matriz = $empresaMatriz and ce_data between '$dataI' and '$dataF'
					order by ce_aberto, ce_id;";
	
	//echo $sql;
	
	$resultado = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($resultado)) {

        array_push($retorno, array(
			'ce_id' => $row['ce_id'],
			'ce_idlocal' => $row['ce_idlocal'],
			'ce_data' => utf8_encode($row['ce_data']),
			'ce_empresa' => ucwords(strtolower(utf8_encode($row['ce_empresa']))),
			'ce_matriz' => $row['ce_matriz'],
			'ce_aberto' => $row['ce_aberto'],

		));
    }
	
	return $retorno;
}

function listarBalanco($conexao, $empresaMatriz, $empresa, $dataI, $dataF) {
	$retorno = array();

	$sql = "select 	ce_id,
					ce_idlocal,
					ce_data,
					(select em_fanta from empresas where em_cod = ce_empresa) as ce_empresa,
					ce_matriz,
					ce_aberto
					from cons_est where ce_matriz = $empresaMatriz and ce_empresa = $empresa and ce_data between '$dataI' and '$dataF'
					ORDER BY ce_aberto, ce_id;";

	$resultado = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($resultado)) {

        array_push($retorno, array(
			'ce_id' => $row['ce_id'],
			'ce_idlocal' => $row['ce_idlocal'],
			'ce_data' => utf8_encode($row['ce_data']),
			'ce_empresa' => ucwords(strtolower(utf8_encode($row['ce_empresa']))),
			'ce_matriz' => $row['ce_matriz'],
			'ce_aberto' => $row['ce_aberto'],
	
		));
	}
	
	return $retorno;
}

function consultarBalanco($conexao, $ce_id){

	$retorno = array();

	$sql = "select 	cei_id,
					cei_prod,
					cei_desc,
					sum(cei_qntcontado) AS cei_qntcontado,
					cei_qntanterior
					from cons_est_item where cei_idprim = $ce_id group by cei_prod, cei_desc;";

	$resultado = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($resultado)) {

		array_push($retorno, array(

			'cei_id' => $row['cei_id'],
			'cei_prod' => $row['cei_prod'],
			'cei_desc' => ucwords(strtolower(utf8_encode($row['cei_desc']))),
			'cei_qntcontado' => $row['cei_qntcontado'],
			'cei_qntanterior' => $row['cei_qntanterior'],

		));
	}

	return $retorno;

}

?>
