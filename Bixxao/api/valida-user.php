<?php

    session_name('http://localhost/pediucerto');
    session_start();
    require_once 'conn.php';

    $url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
    $route = explode('/',$url);

    $array = json_decode(file_get_contents("php://input"), true);

    $retorno = array();

    $sql = "SELECT * FROM  pessoas where pe_site = 'perfil/".$array['user']."'";
    $query = mysqli_query($conexao, $sql);
    $row = mysqli_num_rows($query);

    if($row == 0){
        array_push($retorno, array(
            'return' => 'true'
        ));
    }else{
        array_push($retorno, array(
            'return' => 'false'
        ));
    }

    echo json_encode($retorno);