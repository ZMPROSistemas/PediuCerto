<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = gravaDados($pdo, $dados);
    //$retorno = '{"cod_empresa":"'.$_POST['cod_empresa'].'","descricao":"'.$_POST['descricao'].'"}';
    echo $retorno;

    function gravaDados($pdo, $dados){
        $passou = 'T';
        // if( (!isset($_POST['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        $resultado='{"status":"ERRO","mensagem":"alteracao nao executada"}';
        if ($passou=='T'){

            $sql="update espera set espera.es_status=:status, espera.es_usuario=:usuario";    
            $sql=$sql." where es_numero=:numero and es_empresa=:empresa";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":status", $dados['status']);
            $pedido->bindValue(":usuario", $dados['usuario']);
            $pedido->bindValue(":numero", $dados['numero']);
            $pedido->bindValue(":empresa", $dados['cod_empresa']);
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
            
        }
        return $resultado;

    }

    