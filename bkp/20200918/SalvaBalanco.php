<?php

/*
	CRIADO POR KLEYTHON EM 03/08/2020
	ULTIMA ATIALIZACAO EM 07/08/2020
*/

include 'conecta.php';
include 'log.php';
include 'ocorrencia.php';
include 'getIp.php';

date_default_timezone_set('America/Bahia');


$empresa = base64_decode($_GET['e']);
$empresaAcesso = ($_GET['eA']);

$data = date('Y-m-d'); 
$hora = date('H:i:s');
$ip = get_client_ip();

if(isset($_GET['salvarBalanco'])){

    $array = json_decode(file_get_contents("php://input"), true);
    
    $produto = $array['listaProdutos'];

	$cei_empresa = $empresaAcesso;
    $cei_matriz = $empresa;
    $cei_data = $data;
	//print_r($produto);
    
    $cei_idprim = verificaBalancoAberto($conexao, $cei_empresa, $cei_matriz);

    if ($cei_idprim == null) {

        $cei_idprim = AbreBalanco($conexao, $cei_empresa, $cei_matriz, $cei_data);
		
		//echo $cei_idprim;
	} 

    $i=1;

	foreach ($produto as $produto) {
    
    		LancarEstoque ($conexao, $cei_empresa, $cei_matriz, $cei_data, $cei_idprim, $produto['cei_prod'], $produto['cei_desc'], $produto['cei_un'], $produto['cei_custo'], $produto['cei_desc_sub_grupo'], $produto['cei_qntcontado']);
		$i++;
	};
}

if(isset($_GET['fecharBalancoSemZerar'])){

	$balanco = $_GET['ce_id'];
	$lista = '{"result":[' . json_encode(fecharBalancoSemZerar($conexao, $balanco)) . ']}';
	echo $lista;

}

if(isset($_GET['fecharBalancoZerando'])){

	$balanco = $_GET['ce_id'];
	$lista = '{"result":[' . json_encode(fecharBalancoZerando($conexao, $balanco)) . ']}';
	echo $lista;

}

function LancarEstoque ($conexao, $cei_empresa, $cei_matriz, $cei_data, $cei_idprim, $cei_prod, $cei_desc, $cei_un, $cei_custo, $cei_desc_sub_grupo, $cei_qntcontado) {

	$retorno = array();

	$sql = "insert into cons_est_item (cei_empresa, cei_matriz, cei_data, cei_idprim, cei_prod, cei_desc, cei_un, cei_custo, cei_desc_sub_grupo, cei_qntcontado) 
						values ($cei_empresa, $cei_matriz, '$cei_data', $cei_idprim, $cei_prod, '$cei_desc', '$cei_un', '$cei_custo', $cei_desc_sub_grupo, $cei_qntcontado);";

	//echo $sql;

	$query = mysqli_query($conexao, $sql);
	
	if (mysqli_affected_rows($conexao) <= 0) {
	
		array_push($retorno, array(
                'status'=> 'ERROR',
            ));
	
	} else {

		array_push($retorno, array(
            'status'=> 'SUCCESS',
           
        ));

        echo '{"result":[' . json_encode($retorno). ']}';

	}

	return $retorno;

}

function verificaBalancoAberto($conexao, $cei_empresa, $cei_matriz) {

    $sql = "SELECT ce_id 
            FROM cons_est where ce_matriz = $cei_matriz and ce_empresa = $cei_empresa and ce_aberto = 'S';";
	
	$query = mysqli_query($conexao, $sql);

	$return = mysqli_fetch_assoc($query);

	return $return['ce_id'];

}

function AbreBalanco($conexao, $cei_empresa, $cei_matriz, $cei_data) {

    $sql = "insert into cons_est (ce_empresa, ce_matriz, ce_data, ce_aberto) 
                        values ($cei_empresa, $cei_matriz, '$cei_data', 'S');";

    //echo $sql;

 	$query = mysqli_query($conexao, $sql);
	
	$return = mysqli_insert_id($conexao);

	return $return;

}

function fecharBalancoSemZerar($conexao, $balanco) {

/*

Funcao para alimentar quantidade anterior na cons_est_item: agora é uma PROCEDURE no MySQL

*/

	$sql = "call FecharBalancoSemZerar($balanco);";
	
	//echo $sql;
	
	$query = mysqli_query($conexao, $sql);

	return $query;
}

function fecharBalancoZerando($conexao, $balanco) {

	/*
	
	Funcao para alimentar quantidade anterior na cons_est_item: agora é uma PROCEDURE no MySQL
	
	*/
	
		$sql = "call FecharBalancoZerando($balanco);";
		
		//echo $sql;
		
		$query = mysqli_query($conexao, $sql);
	
		return $query;
	}

?>