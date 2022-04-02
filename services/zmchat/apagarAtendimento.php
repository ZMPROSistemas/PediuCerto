<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = apagar($pdo, $dados);
    echo $retorno;

    function apagar($pdo, $dados){
        $passou='T';
        $sql="delete from espera where es_numero=:numero";
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":numero", $dados['numero']);
        try {
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            $resultado='{"status":"OK"}';
        } catch(PDOException $e) {
            $passou='F';
            $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
        }
        if ($passou=='T'){
            $sql="delete from conversa where cv_numero=:numero";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":numero", $dados['numero']);
            try {
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                $resultado='{"status":"OK"}';
            } catch(PDOException $e) {                
                $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            }    
        }
        return $resultado;

    }