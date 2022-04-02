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
            $sql="update perfil set perfil.pe_descricao=:descricao, ";
            $sql=$sql.'perfil.pe_ramo=:ramo, ';
            $sql=$sql.'perfil.pe_ramo_i=:ramo_i, ';
            $sql=$sql.'perfil.pe_ramo_a=:ramo_a, ';
            $sql=$sql.'perfil.pe_ramo_e=:ramo_e, ';
            $sql=$sql.'perfil.pe_mensagem=:mensagem, ';
            $sql=$sql.'perfil.pe_mensagem_i=:mensagem_i, ';
            $sql=$sql.'perfil.pe_mensagem_a=:mensagem_a, ';
            $sql=$sql.'perfil.pe_mensagem_e=:mensagem_e, ';
            $sql=$sql.'perfil.pe_usuario=:usuario, ';
            $sql=$sql.'perfil.pe_usuario_i=:usuario_i, ';
            $sql=$sql.'perfil.pe_usuario_a=:usuario_a, ';
            $sql=$sql.'perfil.pe_usuario_e=:usuario_e, ';
            $sql=$sql.'perfil.pe_perfil=:perfil, ';
            $sql=$sql.'perfil.pe_perfil_i=:perfil_i, ';
            $sql=$sql.'perfil.pe_perfil_a=:perfil_a, ';
            $sql=$sql.'perfil.pe_perfil_e=:perfil_e, ';
            $sql=$sql.'perfil.pe_campanha=:campanha, ';
            $sql=$sql.'perfil.pe_campanha_i=:campanha_i, ';
            $sql=$sql.'perfil.pe_campanha_a=:campanha_a, ';
            $sql=$sql.'perfil.pe_campanha_e=:campanha_e, ';
            $sql=$sql.'perfil.pe_depto=:depto, ';
            $sql=$sql.'perfil.pe_depto_i=:depto_i, ';
            $sql=$sql.'perfil.pe_depto_a=:depto_a, ';
            $sql=$sql.'perfil.pe_depto_e=:depto_e, ';
            $sql=$sql.'perfil.pe_cliente=:cliente, ';
            $sql=$sql.'perfil.pe_cliente_i=:cliente_i, ';
            $sql=$sql.'perfil.pe_cliente_a=:cliente_a, ';
            $sql=$sql.'perfil.pe_cliente_e=:cliente_e, ';
            $sql=$sql.'perfil.pe_chatbot=:chatbot, ';
            $sql=$sql.'perfil.pe_log_mens=:log_mens ';
            $sql=$sql.'where perfil.pe_id=:id';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":descricao", $dados['descricao']);
            $pedido->bindValue(":ramo", $dados['ramo']);
            $pedido->bindValue(":ramo_i",  $dados['ramo_i']);
            $pedido->bindValue(":ramo_a", $dados['ramo_a']);
            $pedido->bindValue(":ramo_e", $dados['ramo_e']);
            $pedido->bindValue(":mensagem", $dados['mensagem']);
            $pedido->bindValue(":mensagem_i", $dados['mensagem_i']);
            $pedido->bindValue(":mensagem_a", $dados['mensagem_a']);
            $pedido->bindValue(":mensagem_e", $dados['mensagem_e']);
            $pedido->bindValue(":usuario", $dados['usuario']);
            $pedido->bindValue(":usuario_i", $dados['usuario_i']);
            $pedido->bindValue(":usuario_a", $dados['usuario_a']);
            $pedido->bindValue(":usuario_e", $dados['usuario_e']);
            $pedido->bindValue(":perfil", $dados['perfil']);
            $pedido->bindValue(":perfil_i", $dados['perfil_i']);
            $pedido->bindValue(":perfil_a", $dados['perfil_a']);
            $pedido->bindValue(":perfil_e", $dados['perfil_e']);
            $pedido->bindValue(":campanha", $dados['campanha']);
            $pedido->bindValue(":campanha_i", $dados['campanha_i']);
            $pedido->bindValue(":campanha_a", $dados['campanha_a']);
            $pedido->bindValue(":campanha_e", $dados['campanha_e']);
            $pedido->bindValue(":depto", $dados['depto']);
            $pedido->bindValue(":depto_i", $dados['depto_i']);
            $pedido->bindValue(":depto_a", $dados['depto_a']);
            $pedido->bindValue(":depto_e", $dados['depto_e']);
            $pedido->bindValue(":cliente", $dados['cliente']);
            $pedido->bindValue(":cliente_i", $dados['cliente_i']);
            $pedido->bindValue(":cliente_a", $dados['cliente_a']);
            $pedido->bindValue(":cliente_e", $dados['cliente_e']);
            $pedido->bindValue(":chatbot", $dados['chatbot']);
            $pedido->bindValue(":log_mens", $dados['log_mens']);
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

