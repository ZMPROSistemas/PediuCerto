<?php

include 'conecta.php';
include 'funcoes-inicio.php';
include 'services/log.php';
include 'services/getIp.php';

date_default_timezone_set('America/Bahia');

$data = date('Y-m-d'); 
$hora = date('H:i:s');
$ip = get_client_ip();


    if (array_key_exists("u", $_GET)){
        $usuario = base64_decode($_GET["u"]);
    }else{
        $usuario = $_POST["usuario"]; 
    }  
    if (array_key_exists("s", $_GET)){
        $senha = base64_decode($_GET["s"]);
    }else{
        $senha = $_POST["senha"]; 
    }

    $usuario1 = base64_encode($usuario);
    $senha1 = base64_encode($senha);
    
    $dados_usuario = buscaDadosLogin($conexao, $usuario, $senha); #busca-dados-login.php
    $us_cod = $dados_usuario['us_cod'];
    $matriz = $dados_usuario['us_empresa'];
    $empresa = $dados_usuario['us_empresa_acesso'];
    
    if ($dados_usuario['us_email'] != $usuario) {
        header("Location: login.php?login_invalido=true&usuario_ativo=true&empresa_ativa=true"); #redireciona para a pagina
        die();
    }
    else if($dados_usuario['us_email'] == $usuario){
        
        if ($dados_usuario['us_status'] != 'S') {
            header("Location: login.php?login_invalido=false&usuario_ativo=false&empresa_ativa=true"); #redireciona para a pagina
            die();
         }else{
            logSistemaLogin($conexao, $data, $hora, $ip, $us_cod, utf8_decode('Usuário Desconectado do sistema'), $empresa, $matriz);
            header("Location: login.php"); #redireciona para a pagina
         }
    }
    
    
  
?>