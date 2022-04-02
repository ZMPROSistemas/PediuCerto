<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    
    $retorno = alteraDados($pdo,$dados);
    //$retorno = '{"saudacao":"123","menu_departamentos":"'.$dados['departamentos'].'"}'; 
    echo $retorno;

    function alteraDados($pdo, $dados){
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $sql="update mensagens_whats set mensagens_whats.mw_saudacao=:saudacao, mensagens_whats.mw_menu_departamentos=:departamentos, mensagens_whats.mw_principal=:mensagem where mensagens_whats.mw_id=:id";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":saudacao", $dados['saudacao']);
            $pedido->bindValue(":departamentos", $dados['departamentos']);
            $pedido->bindValue(":mensagem", $dados['mensagem']);
            $pedido->bindValue(":id", $dados['id']);
            try {
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                $resultado='{"status":"OK"}';
            } catch(PDOException $e) {
                $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            }
        }
        return $resultado;
    }

