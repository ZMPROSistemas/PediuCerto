<?php
session_name('http://localhost/pediucerto');
session_start();

require_once 'conn.php';
require_once 'conectaPDO.php';

$array = json_decode(file_get_contents("php://input"), true);

if($array == null){
    $array = $_REQUEST;
}


$retorno = array();


    $stmt =$pdo->prepare("SELECT pde_id, pde_tipo, (SELECT ex_id from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_id,
    (SELECT ex_desc from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_desc,
    (SELECT ex_valor from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_valor,
    (SELECT ex_tipo from excecoes where ex_cod = pde_excecao and ex_empresa = pde_empresa) as ex_tipo
    FROM produtos_excecoes
    where pde_empresa = (SELECT em_cod from empresas where em_token = :token)
    and pde_produto = (SELECT pd_cod from produtos where pd_id= :pd_id) order by ex_desc asc;");
    $stmt->bindValue(":token", $array['token']);
    $stmt->bindValue(":pd_id", $array['item']);
    $stmt->execute();
    //$result = $adcionais_exec->fetchAll(PDO::FETCH_ASSOC);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //$id = $stmt->insertLastId();

    foreach ($row as $row){
        if($row['ex_id'] != null){
            array_push($retorno, array(
                'pde_id' => $row['pde_id'],
                'pde_tipo' => $row['pde_tipo'],
                'ex_id'=> $row['ex_id'],
                'ex_desc' => utf8_encode($row['ex_desc']),
                'ex_valor' => (float)$row['ex_valor'],
                'ex_qts' => 0,
                'ex_tipo' => $row['ex_tipo'],

            ));
        }
       
    }
   
   echo json_encode($retorno);
  /* echo '<pre>';
   print_r($retorno);
   echo '</pre>';*/
?>