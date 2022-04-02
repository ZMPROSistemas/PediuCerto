<?php
include 'conecta.php';
include 'log.php';
date_default_timezone_set('America/Bahia');

$us = base64_decode($_GET['us']);
$ip = get_client_ip();

$data = date('Y-m-d');
$hora = date('H:i:s');

$id = $_GET['id'];
$cliente = $_GET['cliente'];
$cliente_fornecedor = $_GET['cliente_fornecedor'];
 

excluirCliente($conexao, $id, $data, $hora, $ip, $us, $cliente, $cliente_fornecedor);

function excluirCliente($conexao, $id, $data, $hora, $ip, $us, $cliente, $cliente_fornecedor) {

	$sql = "update pessoas set $cliente_fornecedor = '' where pe_id = $id;";

	$query = mysqli_query($conexao, $sql);

	if (mysqli_affected_rows($conexao) <= 0) {
		echo 0;
	} else {
		echo 1;
		logSistema($conexao, $data, $hora, $ip, $us, 'Pessoas Deletada Nome - ' . $cliente . '');
	}

	//return $inserir;

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