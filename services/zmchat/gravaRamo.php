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
        if ($passou=='T'){
            $codigo = buscaCodigo($pdo,$dados['cod_empresa']);
            
            $sql="insert into ramos (rm_empresa,rm_cod,rm_descricao)";
            $sql=$sql.' values (:rm_empresa,:rm_cod,:rm_descricao)';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":rm_empresa", $dados['cod_empresa']);
            $pedido->bindValue(":rm_cod", $codigo);
            $pedido->bindValue(":rm_descricao", $dados['descricao']);
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

    function buscaCodigo($pdo, $empresa){
        $sql="select max(rm_cod) as ultimo from ramos where rm_empresa=:empresa";
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
    