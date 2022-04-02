<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = buscaDados($pdo, $dados);
    echo $retorno;

    function buscaDados($pdo, $dados){
        $sql="select es_id from espera where es_numero=:numero and es_empresa=:empresa and es_status=:status";
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":numero", $dados['numero']);
        $pedido->bindValue(":empresa", $dados['cod_empresa']);
        $pedido->bindValue(":status", 'Em Espera');        
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $resultado='{"status":"VAZIO"}';
        } else {
            $resultado='{"status":"OK"}';
        }
      
        return $resultado;
    }

    