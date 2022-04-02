<?php
    session_name('http://localhost/pediucerto');
    session_start();

    require_once 'conn.php';

    $user = $_GET['user'];

    $result = array();

    $sql="SELECT * FROM ultima_entrega WHERE ul_idPessoa = $user";
    $sqlQuery = mysqli_query($conexao, $sql);

    while($row = mysqli_fetch_assoc($sqlQuery)){
        array_push($result, array(
            'ul_idPessoa' => $row['ul_idPessoa'],
            'ul_perfil' => utf8_encode($row['ul_perfil']),
            'ul_local' => utf8_encode($row['ul_local']),
            'ul_endereco' => utf8_encode($row['ul_endereco']),
            'ul_end_num' => $row['ul_end_num'],
            'ul_end_comp' => $row['ul_end_comp'],
            'ul_bairro' => utf8_encode($row['ul_bairro']),
            'ul_cidade' => utf8_encode($row['ul_cidade']),
            'ul_uf' => utf8_encode($row['ul_uf']),

        ));
    }

    echo json_encode($result);