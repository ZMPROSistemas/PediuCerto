<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = gravaDados($pdo, $dados);
    echo $retorno;

    function gravaDados($pdo, $dados){
        $passou = 'T';
        // if( (!isset($_POST['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            
            $sql="update empresas set empresas.em_ip_bot=:ip_bot where empresas.em_cod=:cod";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":ip_bot", $dados['ip']);
            $pedido->bindValue(":cod", $dados['cod_empresa']);
            try {
                $pedido->execute();
                // $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                // if ($pedido->rowCount()== 0 ){
                //     $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
                // } else {
                    $resultado='{"status":"OK"}';
                // }
            } catch(PDOException $e) {
                $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            }
        }
        return $resultado;
    }
    