<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = gravaDados($pdo, $dados);
    echo $retorno;

    function gravaDados($pdo, $dados){
        $sql="insert into usuarios (us_email,us_senha,us_nome,us_depto,us_nivel,us_empresa)";
        $sql=$sql.' values (:us_email,:us_senha,:us_nome,:us_depto,:us_nivel,:us_empresa)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":us_email", $dados['email']);
        $pedido->bindValue(":us_senha", $dados['senha']);
        $pedido->bindValue(":us_nome", $dados['nome']);
        $pedido->bindValue(":us_depto", $dados['depto']);
        $pedido->bindValue(":us_nivel", $dados['nivel']);
        $pedido->bindValue(":us_empresa", $dados['cod_empresa']);
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
    