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

        $sql="insert into perfil (pe_empresa, pe_cod, pe_descricao,";
                      $sql=$sql.'pe_ramo, pe_ramo_i, pe_ramo_a, pe_ramo_e,';
                      $sql=$sql.'pe_mensagem, pe_mensagem_i, pe_mensagem_a, pe_mensagem_e,';
                      $sql=$sql.'pe_usuario, pe_usuario_i, pe_usuario_a, pe_usuario_e,';
                      $sql=$sql.'pe_perfil, pe_perfil_i, pe_perfil_a, pe_perfil_e,';
                      $sql=$sql.'pe_campanha, pe_campanha_i, pe_campanha_a, pe_campanha_e,';
                      $sql=$sql.'pe_depto, pe_depto_i, pe_depto_a, pe_depto_e,';
                      $sql=$sql.'pe_cliente, pe_cliente_i, pe_cliente_a, pe_cliente_e,';
                      $sql=$sql.'pe_chatbot, pe_log_mens)';

        $sql=$sql.' values (:pe_empresa, :pe_cod, :pe_descricao,';
                  $sql=$sql.':pe_ramo, :pe_ramo_i, :pe_ramo_a, :pe_ramo_e,';
                  $sql=$sql.':pe_mensagem, :pe_mensagem_i, :pe_mensagem_a, :pe_mensagem_e,';
                  $sql=$sql.':pe_usuario, :pe_usuario_i, :pe_usuario_a, :pe_usuario_e,';
                  $sql=$sql.':pe_perfil, :pe_perfil_i, :pe_perfil_a, :pe_perfil_e,';
                  $sql=$sql.':pe_campanha, :pe_campanha_i, :pe_campanha_a, :pe_campanha_e,';
                  $sql=$sql.':pe_depto, :pe_depto_i, :pe_depto_a, :pe_depto_e,';
                  $sql=$sql.':pe_cliente, :pe_cliente_i, :pe_cliente_a, :pe_cliente_e,';
                  $sql=$sql.':pe_chatbot, :pe_log_mens)';
        
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":pe_empresa", $dados['cod_empresa']);
        $pedido->bindValue(":pe_cod", $codigo);
        $pedido->bindValue(":pe_descricao", $dados['descricao']);
        $pedido->bindValue(":pe_ramo",   $dados['ramo']);
        $pedido->bindValue(":pe_ramo_i", $dados['ramo_i']);
        $pedido->bindValue(":pe_ramo_a", $dados['ramo_a']);
        $pedido->bindValue(":pe_ramo_e", $dados['ramo_e']);
        $pedido->bindValue(":pe_mensagem",   $dados['mensagem']);
        $pedido->bindValue(":pe_mensagem_i", $dados['mensagem_i']);
        $pedido->bindValue(":pe_mensagem_a", $dados['mensagem_a']);
        $pedido->bindValue(":pe_mensagem_e", $dados['mensagem_e']);
        $pedido->bindValue(":pe_usuario",   $dados['usuario']);
        $pedido->bindValue(":pe_usuario_i", $dados['usuario_i']);
        $pedido->bindValue(":pe_usuario_a", $dados['usuario_a']);
        $pedido->bindValue(":pe_usuario_e", $dados['usuario_e']);
        $pedido->bindValue(":pe_perfil",   $dados['perfil']);
        $pedido->bindValue(":pe_perfil_i", $dados['perfil_i']);
        $pedido->bindValue(":pe_perfil_a", $dados['perfil_a']);
        $pedido->bindValue(":pe_perfil_e", $dados['perfil_e']);
        $pedido->bindValue(":pe_campanha",   $dados['campanha']);
        $pedido->bindValue(":pe_campanha_i", $dados['campanha_i']);
        $pedido->bindValue(":pe_campanha_a", $dados['campanha_a']);
        $pedido->bindValue(":pe_campanha_e", $dados['campanha_e']);
        $pedido->bindValue(":pe_depto",   $dados['depto']);
        $pedido->bindValue(":pe_depto_i", $dados['depto_i']);
        $pedido->bindValue(":pe_depto_a", $dados['depto_a']);
        $pedido->bindValue(":pe_depto_e", $dados['depto_e']);
        $pedido->bindValue(":pe_cliente",   $dados['cliente']);
        $pedido->bindValue(":pe_cliente_i", $dados['cliente_i']);
        $pedido->bindValue(":pe_cliente_a", $dados['cliente_a']);
        $pedido->bindValue(":pe_cliente_e", $dados['cliente_e']);
        $pedido->bindValue(":pe_chatbot",   $dados['chatbot']);
        $pedido->bindValue(":pe_log_mens",   $dados['log_mens']);
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
        $sql="select max(pe_cod) as ultimo from perfil where pe_empresa=:empresa";
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

    