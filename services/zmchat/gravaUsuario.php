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

        $sql="insert into usuarios (us_email,us_senha,us_nome,us_depto,us_nivel,us_empresa,us_ativo,us_cod)";
        $sql=$sql.' values (:us_email,:us_senha,:us_nome,:us_depto,:us_nivel,:us_empresa,:us_ativo,:us_cod)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":us_email", $dados['email']);
        $pedido->bindValue(":us_senha", $dados['senha']);
        $pedido->bindValue(":us_nome", $dados['nome']);
        $pedido->bindValue(":us_depto", $dados['depto']);
        $pedido->bindValue(":us_nivel", $dados['nivel']);
        $pedido->bindValue(":us_empresa", $dados['cod_empresa']);
        $pedido->bindValue(":us_ativo", $dados['ativo']);
        $pedido->bindValue(":us_cod", $codigo);
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
        $sql="select max(us_cod) as ultimo from usuarios where us_empresa=:empresa";
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

    