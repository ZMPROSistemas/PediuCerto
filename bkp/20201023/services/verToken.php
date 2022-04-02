<?php

include 'conecta.php';

date_default_timezone_set('America/Bahia');

$retorno = array();

$empresa = $_GET['empresa'];

if(isset($_GET['verToken'])){
    $sql = "SELECT em_cod, em_razao, em_token  FROM zmpro.empresas where em_cod=$empresa";

    $query = mysqli_query($conexao, $sql);

    $row = mysqli_fetch_assoc($query);

    if ($row['em_token'] == null) {
        array_push($retorno, array(
            'token' => 'null'
        ));
    }else{
        array_push($retorno, array(
            'token' => $row['em_token'],
            'em_cod' => $row['em_cod'],
            'em_razao' => utf8_encode($row['em_razao']),
        ));
    }
    echo json_encode($retorno);
}

if(isset($_GET['geraToken'])) {

   // $emp = $_GET['empresa'];
	$guidCriete = str_replace('-','',getGUID());
	$guid = str_replace('{','',$guidCriete);
	$guid = str_replace('}','',$guid);
    
    
    //echo $guid;
	
	$sql = "update zmpro.empresas set em_token='$guid' where em_cod = $empresa;";
    $query = mysqli_query($conexao, $sql);
    
    $row = mysqli_affected_rows($conexao);

    if($row > 0 ){
        echo $guid;
    }
    





}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }
    else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}


