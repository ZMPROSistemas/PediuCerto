<?php
    session_name('http://localhost/pediucerto');
    session_start();

    require_once 'conn.php';

    $array = json_decode(file_get_contents("php://input"), true);

    $ID = $array['ID'];
    $perfil = $array['perfil'];
    $endereco = $array['endereco'][0];
    if(!isset($endereco['pe_end_comp'])){
        $endereco['pe_end_comp'] = null;
    }

    if(isset($endereco['pe_cep'])){
        $cep = $endereco['pe_cep'];
    }else{
        $cep = null;
    }

    $sqlLocal = "SELECT * FROM ultima_entrega where ul_idPessoa=$ID";
    $sqlLocalQuery = mysqli_query($conexao, $sqlLocal);
    $ultima_entrega = mysqli_fetch_assoc($sqlLocalQuery);
    $row = mysqli_num_rows($sqlLocalQuery);

    $retorno = array();

   if($row <= 0){
       $sqlInsertLocal = "INSERT ultima_entrega (ul_idPessoa, ul_perfil , ul_local, ul_endereco, ul_end_num, ul_end_comp, ul_bairro, ul_cidade, ul_uf, ul_cep)
                            value($ID, '$perfil', '". $endereco['local']."', '".utf8_decode($endereco['pe_endereco'])."', '".utf8_decode($endereco['pe_end_num'])."', '".utf8_decode($endereco['pe_end_comp'])."',
                            '".utf8_decode($endereco['pe_bairro'])."','".utf8_decode($endereco['pe_cidade'])."', '".$endereco['pe_uf']."', '$cep');";
       $sqlInsertLocalQuery = mysqli_query($conexao, $sqlInsertLocal);
        
       $response = mysqli_affected_rows($conexao);

       if($response > 0){
            array_push($retorno, array(
                'retorno' => 'SUCCESS'
            ));
       }else{
        array_push($retorno, array(
            'retorno' => 'ERROR'
        ));
       }

       echo json_encode($retorno);

   }
   else{
    
    $sqlUpdateLocal = "REPLACE INTO ultima_entrega 
        (id, 
        ul_idPessoa, 
        ul_perfil, 
        ul_local, 
        ul_endereco, 
        ul_end_num, 
        ul_end_comp, 
        ul_bairro, 
        ul_cidade, 
        ul_uf, 
        ul_cep)
        VALUE(
            ".$ultima_entrega['id'].",
            ".$ultima_entrega['ul_idPessoa'].",
            '".$ultima_entrega['ul_perfil']."',
            '".$endereco['local']."',
            '".utf8_decode($endereco['pe_endereco'])."',
            '".$endereco['pe_end_num']."',
            '".utf8_decode($endereco['pe_end_comp'])."',
            '".utf8_decode($endereco['pe_bairro'])."',
            '".utf8_decode($endereco['pe_cidade'])."',
            '".$endereco['pe_uf']."',
            '$cep'
        )";

    /*
       $sqlUpdateLocal = "UPDATE ultima_entrega 
       SET 
           ul_local = '".$endereco['local']."',
           ul_endereco = '".utf8_decode($endereco['pe_endereco'])."',
           ul_end_num = '".$endereco['pe_end_num']."',
           ul_end_comp = '".utf8_decode($endereco['pe_end_comp'])."',
           ul_bairro = '".utf8_decode($endereco['pe_bairro'])."',
           ul_cidade = '".utf8_decode($endereco['pe_cidade'])."',
           ul_uf = '".$endereco['pe_uf']."',
           ul_cep = '$cep'

       WHERE
           ul_idPessoa = $ID";
    */
        $sqlUpdateLocalQuery = mysqli_query($conexao, $sqlUpdateLocal);
        $response = mysqli_affected_rows($conexao);

        if($response > 0){
            array_push($retorno, array(
                'retorno' => 'SUCCESS'
            ));
       }else{
        array_push($retorno, array(
            'retorno' => 'ERROR'
        ));
       }
       //echo $sqlUpdateLocal;
       echo json_encode($retorno);
   }