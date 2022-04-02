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
        if($dados['email']=='' || $dados['senha']==''){ // || = ou
            $passou='F';
            $retorno='{"status":"ERRO","mensagem":"faltam parametros"}';
        }
        
        if ($passou=='T'){
            $sql = "select us_id, us_nome, us_ativo, us_nivel, us_depto, us_empresa from usuarios where us_email=:email and us_senha=:senha";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":email", $dados['email']);
            $pedido->bindValue(":senha", $dados['senha']);
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $retorno='{"status":"ERRO","mensagem":"usuario nao encontrado"}';
            } else {
                $retorno='{"status":"OK","id":"'.$row[0]['us_id'].'",
                    "nome":"'.$row[0]['us_nome'].'",
                    "ativo":"'.$row[0]['us_ativo'].'",                                        
                    "nivel":"'.$row[0]['us_nivel'].'",
                    "depto":"'.$row[0]['us_depto'].'",
                    "empresa":"'.$row[0]['us_empresa'].'"}';
            }
        }
        return $retorno;
    }

