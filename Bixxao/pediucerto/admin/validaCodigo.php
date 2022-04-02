<?php
    session_name('http://localhost/pediucerto');
    session_start();

    require_once 'conn.php';

    $url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
    $route = explode('/',$url);

    $array = json_decode(file_get_contents("php://input"), true);

    $retorno = array();

    //var_dump($array);
    //$array['codigo'] = 70170;
    //echo $array['codigo'];

    //$_SESSION['cod'] = 1234;
    if($array['codigo'] == $_SESSION['cod']){
        $sqlPerfil = "UPDATE pessoas set pe_celular= '".$array['numero']."' where  pe_id = ".$array['ID'].";";
        $queryPerfil = mysqli_query($conexao, $sqlPerfil);

        array_push($retorno, array(
            'result'=> 'verificado',
            'cod'=> 1

        ));
        unset($_SESSION['cod']);

    }else{
        
        array_push($retorno, array(
            'result'=> 'ERROR',
            'cod'=> 1
        ));
    }

    echo json_encode($retorno);
  
