<?php

require_once 'conecta.php';
include 'log.php';

require_once 'atualizaCache.php';

date_default_timezone_set('America/Bahia');

if(isset($_GET['empresa_matriz'])){
	$empresaMatriz = base64_decode($_GET['empresa_matriz']);
}
if (isset($_GET['empresa_filial'])) {
	$empresaAcesso = base64_decode($_GET['empresa_filial']);	
}

if (isset($_GET['token'])) {
	$token =  $_GET['token'];
}
if(isset($_GET['us_id'])){
	$us_id = base64_decode($_GET['us_id']);
}
if(isset($_GET['nomeEmp'])){
	$em_razao = $_GET['nomeEmp'];
}

if(isset($_GET['us'])){
	$us = base64_decode($_GET['us']);
}
if(isset($_GET['status'])){
	$status = $_GET['status'];
}



$ip = get_client_ip();

$data = date('Y-m-d');
$hora = date('H:i:s');

/*
echo "Empresa Matriz: " . $empresaMatriz . "<br>";
echo "Empresa empresaAcesso: " . $empresaAcesso . "<br>";
echo "Usuário: " . $us_id . "<br>";
echo "Status: " . $status . "<br>";
 */
if (isset($_GET['verificaStatus'])) {

	$verificaStatus = '{"result":[' . json_encode(verificaStatus($conexao, $token)) . ']}';
	/*
		if ($verificaStatus['em_aberto'] == 'N') {

			$status = array('status' => 'Fechado',
							'dataAbertura'
							'statusCheck' => false);

		} else if ($verificaStatus['em_aberto'] == 'S') {
			$status = array('status' => 'Aberto',
				'statusCheck' => true);

		}

		$statusReturn = '{"result":[' . json_encode($status) . ']}';
	*/

	echo $verificaStatus;
}

if (isset($_GET['mudarStatusEmp'])) {
	if ($status == 'Aberto') {
		$status = 'N';
	} else if ($status == 'Fechado') {
		$status = 'S';
	}
	if(isset($_GET['cod_emp'])){
		$cod_emp = $_GET['cod_emp'];
	}else{
		$cod_emp = '';
	}
	
	$verificaPedidosAbertos = verificaPedidosAbertos($conexao, $empresaMatriz, $empresaAcesso, $status, $data, $hora, $ip, $us, $em_razao, $cod_emp, $token);
	//$mudarStatus = mudarStatus($conexao, $empresaMatriz, $empresaAcesso, $status, $data, $hora, $ip, $us, $em_razao);
}

if (isset($_GET['tokenEmpresa'])) {
	
	/*$better_token = md5(uniqid(rand(), true));
	echo $better_token;
*/	
	$emp = $_GET['empresa'];
	$guidCriete = str_replace('-','',com_create_guid());
	$guid = str_replace('{','',$guidCriete);
	$guid = str_replace('}','',$guid);
	echo $guid;
	
	$sql = "update empresas set em_token='$guid' where em_cod = $emp;";
	$query = mysqli_query($conexao, $sql);
	
}


if(isset($_GET['dadosEmpresa'])){
	
	
	$array = json_decode(file_get_contents("php://input"), true);

	$id = $array['id'];
	$token = $array['token'];
	
	$lista = json_encode(dadosEmpresa($conexao,$id,$token));
	echo $lista;
}

function dadosEmpresa($conexao,$id,$token){
	$result = array();
	$sql = "SELECT * FROM empresas where em_token = '$token';";
	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)){
		array_push($result, array(
			'em_cod' => $row['em_cod'],
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
			'em_foto_app_sacola' => utf8_encode($row['em_foto_app_sacola']),
			'em_token' => utf8_encode($row['em_token']),
			'em_taxa_entrega' => (double)$row['em_taxa_entrega'],
			'em_entrega1' => date("H:i", strtotime($row['em_entrega1'])),
			'em_entrega2' => date("H:i", strtotime($row['em_entrega2'])),
			'em_retira' => date("H:i", strtotime($row['em_retira'])),
		));
	}

	return $result;

}

function verificaStatus($conexao, $token) {

	$resultado = array();
	$sql = "SELECT em_aberto, em_data_abertura, em_hora_abertura FROM zmpro.empresas where em_token= '$token';";
	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'em_aberto' => utf8_encode(statusAbertoFechado($row['em_aberto'])),
			'em_data_abertura' => utf8_encode($row['em_data_abertura']),
			'em_hora_abertura' => utf8_encode($row['em_hora_abertura']),
			'statusCheck' => statusCheck(utf8_encode($row['em_aberto'])),

		));
	}
	//echo $sql;
	return $resultado;

}

function statusAbertoFechado($status) {

	if ($status == 'N') {

		$status = 'Fechado';

	} else if ($status == 'S') {
		$status = 'Aberto';

	}

	//echo $status;
	return $status;
}
function statusCheck($status) {

	if ($status == 'N') {

		$status = false;

	} else if ($status == 'S') {
		$status = true;

	}

	//echo $status;
	return $status;
}

function verificaPedidosAbertos($conexao, $empresaMatriz, $empresaAcesso, $status, $data, $hora, $ip, $us, $em_razao, $cod_emp, $token){

	if($empresaAcesso == 0){
		$empresaAcesso = $empresaMatriz;
	}
	$sql ="SELECT * FROM zmpro.pedido_food where ped_matriz = $empresaMatriz and ped_empresa = $empresaAcesso and ped_status= 'Novo';";

	$query = mysqli_query($conexao, $sql);

	//$row = mysqli_num_rows($query);

	mudarStatus($conexao, $empresaMatriz, $empresaAcesso, $status, $data, $hora, $ip, $us, $em_razao, $cod_emp, $token);
	
	//echo $sql;
	//return $row;
}

function mudarStatus($conexao, $empresaMatriz, $empresaAcesso, $status, $data, $hora, $ip, $us, $em_razao, $cod_emp, $token) {

	$sql = "update empresas set em_aberto='$status', em_data_abertura='$data', em_hora_abertura='$hora' where em_token= '$token' and em_cod <> 0;";

	$query = mysqli_query($conexao, $sql);

	//echo $sql;
	if (mysqli_affected_rows($conexao) <= 0) {
		echo 0;
	} else {
		echo 1;
		if ($status == 'S') {
			$statusFull = 'Aberta';
		} else if ($status == 'N') {
			$statusFull = 'Fechada';
		}
		atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'empresa');
		
		logSistema($conexao, $data, $hora, $ip, $us, 'Empresa ' . $statusFull . ' - ' . $em_razao . '', $empresaAcesso, $empresaMatriz);
	}
	
}

function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}
?>