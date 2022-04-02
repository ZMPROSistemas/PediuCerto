<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    
    $retorno = alteraDados($pdo,$dados);
    echo $retorno;

    function alteraDados($pdo, $dados){
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $sql="update departamentos set departamentos.dp_nome=:nome where departamentos.dp_id=:id";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":nome", $dados['nome']);
            $pedido->bindValue(":id", $dados['id']);
            try {
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                $resultado='{"status":"OK"}';

                // if ($pedido->rowCount()== 0 ){
                //     $resultado='{"status":"ERRO","mensagem":"alteracao nao executada"}';
                // } else {
                //     $resultado='{"status":"OK"}';
                // }
            } catch(PDOException $e) {
                $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            }
        }
        return $resultado;
    }

