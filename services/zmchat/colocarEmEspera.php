<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = buscaDados($pdo, $dados);
    if($retorno=='0'){
        $retorno = gravaEspera($pdo, $dados);
    }else{
        $retorno = alteraEspera($pdo, $dados);
    }  
    echo $retorno;

    function alteraEspera($pdo, $dados){
        $sql="update espera set espera.es_data=:es_data, espera.es_hora=:es_hora, espera.es_depto=:es_depto, espera.es_usuario=:es_usuario, espera.es_status=:es_status";    
        $sql=$sql." where es_numero=:es_numero and es_empresa=:es_empresa";
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":es_data", $dados['data']);
        $pedido->bindValue(":es_hora", $dados['hora']);
        $pedido->bindValue(":es_depto", $dados['depto']);
        $pedido->bindValue(":es_usuario", $dados['usuario']);
        $pedido->bindValue(":es_status", $dados['status']);
        $pedido->bindValue(":es_numero", $dados['numero']);
        $pedido->bindValue(":es_empresa", $dados['empresa']);
        try {
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $resultado='{"status":"ERRO","mensagem":"alteracao nao executada"}';
            } else {
                $resultado='{"status":"OK"}';
            }
        } catch(PDOException $e) {
            $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
        }
        return $resultado;
    }

    function buscaDados($pdo, $dados){
        //$sql="select * from espera where es_numero='".$dados['numero']."' and es_status='Em Espera' and es_empresa=".$dados['empresa'];
        $sql="select * from espera where es_numero='".$dados['numero']."' and es_empresa=".$dados['empresa'];
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":es_numero", $dados['numero']);
        $pedido->bindValue(":es_status", "Em Espera");
        $pedido->bindValue(":es_empresa", $dados['empresa']);
        $pedido->bindValue(":es_usuario", $dados['usuario']);
        try {
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $resultado='0';
            } else {
                $resultado='1';
            }
        } catch(PDOException $e) {
            $resultado='2';
        }
        
        return $resultado;
    }

    function gravaEspera($pdo, $dados){
        $sql="insert into espera (es_id,es_empresa,es_data,es_hora,es_numero,es_nome,es_foto,es_depto,es_usuario,es_status)";
        $sql=$sql.' values (:es_id,:es_empresa,:es_data,:es_hora,:es_numero,:es_nome,:es_foto,:es_depto,:es_usuario,:es_status)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":es_id", "null");
        $pedido->bindValue(":es_empresa", $dados['empresa']);
        $pedido->bindValue(":es_data", date('Y-m-d'));
        $pedido->bindValue(":es_hora", $dados['hora']);
        $pedido->bindValue(":es_numero", $dados['numero']);
        $pedido->bindValue(":es_nome", $dados['nome']);
        $pedido->bindValue(":es_foto", "");
        $pedido->bindValue(":es_depto", $dados['depto']);
        $pedido->bindValue(":es_usuario", $dados['usuario']);
        $pedido->bindValue(":es_status", $dados['status']);
        try {
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
            } else {
                $resultado='{"status":"OK"}';
            }
            
        } catch(PDOException $e) {
            $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
        }
        return $resultado;
    }
    