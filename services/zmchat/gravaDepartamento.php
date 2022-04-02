<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = gravaDados($pdo, $dados);
    echo $retorno;

    function gravaDados($pdo, $dados){
        $codigo = buscaCodigo($pdo,$dados['cod_empresa']);

        $sql="insert into departamentos (dp_cod,dp_nome,dp_empresa)";
        $sql=$sql.' values (:dp_cod,:dp_nome,:dp_empresa)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":dp_cod", $codigo);
        $pedido->bindValue(":dp_nome", $dados['nome']);
        $pedido->bindValue(":dp_empresa", $dados['cod_empresa']);
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

    function buscaCodigo($pdo, $empresa){
        $sql="select max(dp_cod) as ultimo from departamentos where dp_empresa=:empresa";
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":empresa", $empresa);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $retorno='1';
        } else {
            $retorno=$row[0]['ultimo']+1;
        }
        return $retorno;
    }

    