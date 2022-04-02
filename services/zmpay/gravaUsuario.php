<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    //print_r($dados);
    $retorno = gravaDados($pdo, $dados);
    echo $retorno;

    function gravaDados($pdo, $dados){
        //$codigo = buscaCodigo($pdo,$dados['cod_empresa']);
        // echo $dados['email'].' ';
        // echo $dados['senha'].' ';
        // echo $dados['nome'].' ';
        // echo $dados['depto'].' ';
        // echo $dados['nivel'].' ';
        // echo $dados['ativo'].' ';
        // echo $dados['tela_inicio'].' ';
        // echo $dados['tela_config'].' ';
        // echo $dados['tela_usuarios'].' ';
        // echo $dados['tela_transacoes'].' ';
        // echo $dados['tela_saque'].' ';

        
        $sql="insert into usuarios ( us_email, us_senha, us_nome, us_depto, us_nivel, us_ativo, us_tela_inicio, us_tela_config, us_tela_usuarios, us_tela_transacoes, us_tela_saque, us_empresa)";
        $sql=$sql.        ' values (:us_email,:us_senha,:us_nome,:us_depto,:us_nivel,:us_ativo,:us_tela_inicio,:us_tela_config,:us_tela_usuarios,:us_tela_transacoes,:us_tela_saque,:us_empresa)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":us_email", $dados['email']);
        $pedido->bindValue(":us_senha", $dados['senha']);
        $pedido->bindValue(":us_nome", $dados['nome']);
        $pedido->bindValue(":us_depto", $dados['depto']);
        $pedido->bindValue(":us_nivel", $dados['nivel']);
        $pedido->bindValue(":us_ativo", $dados['ativo']);
        $pedido->bindValue(":us_tela_inicio", $dados['tela_inicio']);
        $pedido->bindValue(":us_tela_config", $dados['tela_config']);
        $pedido->bindValue(":us_tela_usuarios", $dados['tela_usuarios']);
        $pedido->bindValue(":us_tela_transacoes", $dados['tela_transacoes']);
        $pedido->bindValue(":us_tela_saque", $dados['tela_saque']);
        $pedido->bindValue(":us_empresa", $dados['empresa']);
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

    