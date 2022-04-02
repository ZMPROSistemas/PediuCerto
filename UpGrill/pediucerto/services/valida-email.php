<?php
    
    session_name('http://localhost/pediucerto');
    session_start();
    require_once 'conn.php';

    $url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
    $route = explode('/',$url);

    $array = json_decode(file_get_contents("php://input"), true);

    $retorno = array();
    //var_dump($array);

    $verif = count($array);

    //echo $verif;

    if($verif > 0){
        
        $sql = "SELECT * FROM  pessoas where pe_email = '".$array['email']."'";
        $query = mysqli_query($conexao, $sql);
        $row = mysqli_num_rows($query);
        
        //echo $sql;
        if($row == 0){
            
            array_push($retorno, array(
                'return' => 'true'
            ));

        }else{
            array_push($retorno, array(
                'return' => 'false'
            ));
        }
    }else{

        array_push($retorno, array(
            'return' => 'ERROR'
        ));
    }

    echo json_encode($retorno);

    