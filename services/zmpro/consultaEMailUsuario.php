<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = buscaDados($pdo, $dados);
    echo $retorno;

    function buscaDados($pdo, $dados){
        $passou = 'T';
        if($dados['email']==''){
        //if(!(isset($_GET['email']))){
            $passou='F';
            $retorno='{"status":"ERRO","mensagem":"nenhum parametro informado"}';
        }
        
        if ($passou=='T'){
            $sql = "select us_id from usuarios where us_emial=:email";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":email", $dados['email']);
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $retorno='{"status":"OK","mensagem":"email nao encontrado"}';
            } else {
                $retorno='{"status":"OK","mensagem":"email encontrado"}';
            }
        }
        return $retorno;
    }
    