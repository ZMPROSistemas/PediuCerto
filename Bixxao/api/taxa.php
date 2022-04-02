<?php
    session_name('http://localhost/pediucerto');
    session_start();
    date_default_timezone_set('America/Sao_Paulo');


    require_once 'conn.php';
    //require_once 'conectaPDO.php';

    $conexao->set_charset("utf8");

    $date = date('H:i');
    $array = json_decode(file_get_contents("php://input"), true);

    $resultado = array();

// Conexao MYSQL
     $sql = "SELECT * FROM bairro_atendido where ba_empresa = (SELECT em_cod from empresas where em_token='".$array['token']."')
             and ba_codcidade=(SELECT em_cod_cid from empresas where em_token='".$array['token']."') and ba_nomebairro like '%". $array['bairro']."%';";

    $query = mysqli_query($conexao, $sql);
   
    while ($row = mysqli_fetch_assoc($query)){
        
        array_push($resultado, array(
            'ba_id' => $row['ba_id'],
            'ba_codcidade' => $row['ba_codcidade'],
            'ba_codbairro' => $row['ba_codbairro'],
            'ba_nomebairro' => $row['ba_nomebairro'],
            'ba_taxa' => (float)$row['ba_taxa'],
        ));
    }
// Final - Conexao MYSQL

    // $sql = "SELECT * FROM bairro_atendido where ba_empresa = (SELECT em_cod from empresas where em_token=:token)
    //         and ba_codcidade=(SELECT em_cod_cid from empresas where em_token=:token) and ba_nomebairro =:bairro";
    // $stmt =$pdo->prepare($sql);
    // $stmt->bindValue(":token", $array['token']);
    // $stmt->bindValue(":bairro", $array['bairro']);
    // $stmt->execute();
    // $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($row);
    // foreach ($row as $row){
    //     if($row['ex_id'] != null){
    //         array_push($retorno, array(
    //             'ba_id' => $row['ba_id'],
    //             'ba_codcidade' => $row['ba_codcidade'],
    //             'ba_codbairro'=> $row['ba_codbairro'],
    //             'ba_nomebairro' => utf8_encode($row['ba_nomebairro']),
    //             'ba_taxa' => (float)$row['ba_taxa'],
    //         ));
    //     }
       
    // }
   
    echo json_encode($resultado);