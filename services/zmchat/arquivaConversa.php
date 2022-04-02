<?php
    include 'conectaPDO.php';
    
    date_default_timezone_set('America/Sao_Paulo');

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = buscaConversa($pdo, $dados);
    
    echo $retorno;

    function buscaConversa($pdo, $dados){
        $passou = 'T';
        // if( (!isset($_POST['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $sql="select * from conversa where cv_empresa=".$dados['cod_empresa']." and cv_numero=".$dados['numero'];
            $pedido =$pdo->prepare($sql);
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pdo->query($sql) as $row) {
                if ($row['cv_usuario']=='0'){
                    $nome='';
                }else{
                    $nome = busca_nome($pdo,$row['cv_usuario']);
                }
                grava($pdo,$row,$nome);
            }
            return '{"status":"OK"}';
        }
    }

    function grava($pdo,$row,$nome){
        $sql="insert into conversa_arquivada (cv_id,cv_empresa,cv_data,cv_hora,cv_numero,cv_nome,cv_usuario,cv_enviado_por,cv_mensagem,cv_nome_atendente)";
        $sql=$sql.' values (:cv_id,:cv_empresa,:cv_data,:cv_hora,:cv_numero,:cv_nome,:cv_usuario,:cv_enviado_por,:cv_mensagem,:cv_nome_atendente)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":cv_id", $row['cv_id']);
        $pedido->bindValue(":cv_empresa", $row['cv_empresa']);
        $pedido->bindValue(":cv_data", $row['cv_data']);
        $pedido->bindValue(":cv_hora", $row['cv_hora']);
        $pedido->bindValue(":cv_numero", $row['cv_numero']);
        $pedido->bindValue(":cv_nome", $row['cv_nome']);
        $pedido->bindValue(":cv_usuario", $row['cv_usuario']);
        $pedido->bindValue(":cv_enviado_por", $row['cv_enviado_por']);
        $pedido->bindValue(":cv_mensagem", $row['cv_mensagem']);
        $pedido->bindValue(":cv_nome_atendente", $nome);
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

    function busca_nome($pdo, $codigo){
        $sql="select us_nome from usuarios where us_id=".$codigo;
        $pedido =$pdo->prepare($sql);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        return $row[0]['us_nome'];     
    }