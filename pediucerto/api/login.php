<?php

session_name('http://localhost/pediucerto');
session_start();
require_once 'conn.php';

$array = json_decode(file_get_contents("php://input"), true);

$retorno = array();
 //var_dump($array);

 $sqlCelular = "SELECT  pe_id,
 pe_nome,
 pe_email,
 pe_celular,
 pe_site,
 pe_id_rede_social,
 pe_endereco,
 pe_end_num,
 pe_end_comp,
 pe_bairro,
 pe_cidade,
 pe_uf,
 pe_cep,
 pe_cep_trab,
 pe_endtrab,
 pe_end_num_trab,
 pe_end_comp_trab,
 pe_bairro_trab,
 pe_end_cid_trab,
 pe_uf_trab,
 pe_foto_perfil FROM  pessoas where pe_celular = '".$array['user']."' and pe_senhaApp ='".base64_decode($array['pass'])."';";

$EmailQuery = mysqli_query($conexao, $sqlCelular);
 $rowEmail = mysqli_num_rows($EmailQuery);

 if($rowEmail == 0){

    $sqluser = "SELECT  pe_id,
    pe_nome,
    pe_email,
    pe_celular,
    pe_site,
    pe_id_rede_social,
    pe_endereco,
    pe_end_num,
    pe_end_comp,
    pe_bairro,
    pe_cidade,
    pe_uf,
    pe_cep,
    pe_cep_trab,
    pe_endtrab,
    pe_end_num_trab,
    pe_end_comp_trab,
    pe_bairro_trab,
    pe_end_cid_trab,
    pe_uf_trab,
    pe_foto_perfil FROM  pessoas where pe_site= 'perfil/".$array['user']."' and pe_senhaApp ='".base64_decode($array['pass'])."';";
    
    $userQuery = mysqli_query($conexao, $sqluser);

    $rowUser = mysqli_num_rows($userQuery);

    if($rowUser == 0){
        array_push($retorno, array(
            'return' => 'ERROR'
        ));
    }else{
        array_push($retorno, array(
            'return' =>'SUCCESS'
        ));
        while ($row = mysqli_fetch_assoc($userQuery)){
            array_push($retorno,  array(
                'pe_id' => $row['pe_id'],
                'pe_nome' => utf8_encode($row['pe_nome']),
                'pe_email' => utf8_encode($row['pe_email']),
                'pe_celular' => utf8_encode($row['pe_celular']),
                'pe_site'=> utf8_encode($row['pe_site']),
                'pe_id_rede_social' => utf8_encode($row['pe_id_rede_social']),
                'pe_endereco'=> utf8_encode($row['pe_endereco']),
                'pe_end_num'=> $row['pe_end_num'],
                'pe_end_comp' => utf8_encode($row['pe_end_comp']),
                'pe_bairro' => utf8_encode($row['pe_bairro']),
                'pe_cidade' => utf8_encode($row['pe_cidade']),
                'pe_uf' => $row['pe_uf'],
                'pe_cep' => $row['pe_cep'],
                
                'pe_cep_trab' => utf8_encode($row['pe_cep_trab']),
                'pe_endtrab' => utf8_encode($row['pe_endtrab']), 
                'pe_end_num_trab' => utf8_encode($row['pe_end_num_trab']),
                'pe_end_comp_trab' => utf8_encode($row['pe_end_comp_trab']),
                'pe_bairro_trab' => utf8_encode($row['pe_bairro_trab']),
                'pe_end_cid_trab' => utf8_encode($row['pe_end_cid_trab']),
                'pe_uf_trab' => utf8_encode($row['pe_uf_trab']),
                'pe_foto_perfil' => utf8_encode($row['pe_foto_perfil']),
            ));
        }
    }
 }else{
    array_push($retorno, array(
        'return' =>'SUCCESS'
    ));
    while ($row = mysqli_fetch_assoc($EmailQuery)){
        array_push($retorno,  array(
            'pe_id' => $row['pe_id'],
            'pe_nome' => utf8_encode($row['pe_nome']),
            'pe_email' => utf8_encode($row['pe_email']),
            'pe_celular' => utf8_encode($row['pe_celular']),
            'pe_site'=> utf8_encode($row['pe_site']),
            'pe_id_rede_social' => utf8_encode($row['pe_id_rede_social']),
            'pe_endereco'=> utf8_encode($row['pe_endereco']),
            'pe_end_num'=> $row['pe_end_num'],
            'pe_end_comp' => utf8_encode($row['pe_end_comp']),
            'pe_bairro' => utf8_encode($row['pe_bairro']),
            'pe_cidade' => utf8_encode($row['pe_cidade']),
            'pe_uf' => $row['pe_uf'],
            'pe_cep' => $row['pe_cep'],
            
            'pe_cep_trab' => utf8_encode($row['pe_cep_trab']),
            'pe_endtrab' => utf8_encode($row['pe_endtrab']), 
            'pe_end_num_trab' => utf8_encode($row['pe_end_num_trab']),
            'pe_end_comp_trab' => utf8_encode($row['pe_end_comp_trab']),
            'pe_bairro_trab' => utf8_encode($row['pe_bairro_trab']),
            'pe_end_cid_trab' => utf8_encode($row['pe_end_cid_trab']),
            'pe_uf_trab' => utf8_encode($row['pe_uf_trab']),
            'pe_foto_perfil' => utf8_encode($row['pe_foto_perfil']),
        ));
    }
 }

echo json_encode($retorno);
 