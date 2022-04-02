<?php

require_once 'conectaPDO.php';
include 'log.php';

date_default_timezone_set('America/Bahia');

$empresaMatriz = base64_decode($_GET['e']);
$empresaFilial = base64_decode($_GET['eA']);
$ip = get_client_ip();
$data = date('Y-m-d');
$hora = date('H:i:s');
$agora = date('Y-m-d H:i:s');
$empresa = $empresaMatriz;

if (isset($_GET['listaPRC'])) {
	
    $lista = '{"result":[' . json_encode(listaPRC($pdo, $empresa)) . ']}';
    echo $lista;

}

if (isset($_GET['calcularPRC'])) {

    $dataI = $_GET['dataI'];
    $dataF = $_GET['dataF'];
    $vd_emis = 'and vd_emis between "'. $dataI .'" and "'. $dataF .'"';
    
    $lista = '{"result":[' . json_encode(calcularPRC($pdo, $empresa, $vd_emis)) . ']}';
    echo $lista;

}

if (isset($_GET['gravarPRC'])) {

    $somaSelecionados = $_GET['somaPeriodo'];
    $obs = $_GET['obs'];
    $array = json_decode(file_get_contents("php://input"), true);
    $arrayPRC = $array['calculados'];

    //Ver se há registro anterior
    $existe =$pdo->prepare("SELECT * from perc_rateio_contas where prc_matriz = $empresa ;");
    $existe->execute();
    $count = $existe->rowCount();

    // Se não há, fazer um Insert
    if ($count == 0) {

        $sql = "INSERT INTO perc_rateio_contas (prc_empresa, prc_matriz, prc_perc_anterior, prc_data_anterior, prc_percentual, prc_data, prc_obs) VALUES ";
        $novaArray = array();

        foreach($arrayPRC as $prc){
            $sql .= '(?,?,?,?,?,?,?),';
            array_push($novaArray, $prc['vd_empr'], $prc['vd_matriz'], '0', '0', (($prc['vd_total'] * 100) / $somaSelecionados), $agora, $obs);
        }

        $sql = trim($sql, ','); //remover a última vírgula

        $query = $pdo->prepare($sql);
        if(!$query->execute($novaArray)){
            echo "<pre>";
            print_r($query->errorInfo());
        }

    // Se há, fazer Update
    } else {
        
        $sql = "INSERT INTO perc_rateio_contas (prc_empresa, prc_matriz, prc_perc_anterior, prc_data_anterior, prc_percentual, prc_data, prc_obs) VALUES ";
        $novaArray = array();
        $campo1 = 'prc_percentual';
        $campo2 = 'prc_data';
        $query = $pdo->prepare($sql);
        //echo $sql;

        foreach($arrayPRC as $prc){
            $sql .= '(?,?,?,?,?,?,?),';
            array_push($novaArray, $prc['vd_empr'], $prc['vd_matriz'], pegarValorAnterior($pdo, $prc['vd_empr'], $campo1), pegarValorAnterior($pdo, $prc['vd_empr'], $campo2), (($prc['vd_total'] * 100) / $somaSelecionados), $agora, $obs);
        }

        $sql = trim($sql, ','); //remover a última vírgula

        $query = $pdo->prepare($sql);
        if(!$query->execute($novaArray)){
            echo "<pre>";
            print_r($query->errorInfo());
        }
        $delete=$pdo->prepare("DELETE A1 from perc_rateio_contas A1 inner join perc_rateio_contas A2 on A1.prc_data < A2.prc_data where A1.prc_matriz = $empresa;");
        $delete->execute();
        //print_r($delete);
    }

    return $delete->rowCount(); 

}

function pegarValorAnterior($pdo, $empresa, $campo){

        $valor =$pdo->prepare("SELECT min($campo) as $campo from perc_rateio_contas where prc_empresa = $empresa;");
        $valor->execute();
        $retorno2 = $valor->fetch();
        //print_r($retorno2);
   
	return $retorno2[$campo];
    
}

function listaPRC($pdo, $empresa) {
    
    $retorno = array();
    
    $sql="SELECT prc_empresa, (select em_fanta from empresas where em_cod = prc_empresa) as em_fanta, prc_matriz, prc_percentual, DATE_FORMAT (prc_data,'%d/%m/%Y %Hh%i') as prc_data, prc_obs from perc_rateio_contas where prc_matriz = :empresa ; ";
    
    $listaPRC =$pdo->prepare($sql);
        //echo $sql;
        $listaPRC->bindValue(":empresa", $empresa);
        $listaPRC->execute();
        $retorno = $listaPRC->fetchAll(PDO::FETCH_ASSOC);
   
	return $retorno;
}

function calcularPRC($pdo, $empresa, $vd_emis){
        
    $lista = array();

    /*$sql = "SELECT ct_id, sum(ct_valorpago) as ct_valorpago, ct_empresa, (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, ct_matriz, (select sum(ct_valorpago) from contas where ct_matriz = :empresa and ct_receber_pagar = 'P' and ct_quitado = 'S' and ct_canc = 'N' $ct_pagto) as ct_somaperiodo
    from contas where ct_matriz = :empresa and ct_receber_pagar = 'P' and ct_quitado = 'S' and ct_canc = 'N' $ct_pagto group by ct_empresa;";*/

    $sql = "SELECT vd_id, vd_empr, vd_matriz, sum(vd_total) as vd_total, (select em_fanta from empresas where em_cod = vd_empr) as em_fanta, (select sum(vd_total) FROM vendas where vd_matriz = :empresa and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D'	$vd_emis) as vd_somaperiodo	
    FROM vendas where vd_matriz = :empresa and vd_canc<>'S' and vd_pgr<>'D' and vd_canc<>'S' and vd_pgr<>'D' $vd_emis group by vd_empr;";

    $vendas=$pdo->prepare($sql);
    //echo $sql;
    $vendas->bindValue(":empresa", $empresa);
    $vendas->execute();
    $lista = $vendas->fetchAll(PDO::FETCH_ASSOC);
         
    //echo $sql;
    return $lista;
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
