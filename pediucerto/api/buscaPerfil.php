<?php

include 'conn.php';

$id = $_GET['ID'];

$perfil = array();

$sqlPerfil = "SELECT 
    pe_id,
    pe_nome,
    pe_email,
    pe_celular,
    pe_site,
    pe_id_rede_social,
    pe_cep,
    pe_endereco,
    pe_end_num,
    pe_end_comp,
    pe_bairro,
    pe_cidade,
    pe_uf,
    pe_cep_trab,
    pe_endtrab,
    pe_end_num_trab,
    pe_end_comp_trab,
    pe_bairro_trab,
    pe_end_cid_trab,
    pe_uf_trab,
    pe_foto_perfil
FROM
    pessoas
WHERE
    pe_id =  $id";

 $queryPerfil = mysqli_query($conexao, $sqlPerfil);

 while ($row = mysqli_fetch_assoc($queryPerfil)){

    array_push($perfil, array(
        'pe_id' => $row['pe_id'],
        'pe_nome' => utf8_encode($row['pe_nome']),
        'pe_email' => utf8_encode($row['pe_email']),
        'pe_celular' => utf8_encode($row['pe_celular']),
        'pe_site'=> utf8_encode($row['pe_site']),
        'pe_id_rede_social' => utf8_encode($row['pe_id_rede_social']),
        'pe_cep' => utf8_encode($row['pe_cep']),
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

 echo json_encode($perfil);