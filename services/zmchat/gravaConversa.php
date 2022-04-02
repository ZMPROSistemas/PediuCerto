<?php
    include 'conectaPDO.php';
    
    date_default_timezone_set('America/Sao_Paulo');

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
            $sql="insert into conversa (cv_empresa, cv_data, cv_hora, cv_numero, cv_nome, cv_usuario, cv_enviado_por, cv_mensagem)";
            $sql=$sql.' values (:cv_empresa, :cv_data, :cv_hora, :cv_numero, :cv_nome, :cv_usuario, :cv_enviado_por, :cv_mensagem)';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue("cv_empresa", $dados['cod_empresa']);
            $pedido->bindValue("cv_data", date('Y-m-d'));
            $pedido->bindValue("cv_hora", date('H:i:s'));
            $pedido->bindValue("cv_numero", $dados['numero']);
            $pedido->bindValue("cv_nome", $dados['nome']);
            $pedido->bindValue("cv_usuario", $dados['usuario']);
            $pedido->bindValue("cv_enviado_por", $dados['enviado_por']);
            $pedido->bindValue("cv_mensagem", $dados['mensagem']);
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
        }
        return $resultado;
    }

    