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
            $sql="update clientes set clientes.cl_nome=:nome, ";
            $sql=$sql.'clientes.cl_ramo=:ramo, ';
            $sql=$sql.'clientes.cl_whats=:whats, ';
            $sql=$sql.'clientes.cl_usuario=:usuario, ';
            $sql=$sql.'clientes.cl_genero=:genero, ';
            $sql=$sql.'clientes.cl_cep=:cep, ';
            $sql=$sql.'clientes.cl_end=:end, ';
            $sql=$sql.'clientes.cl_end_num=:end_num, ';
            $sql=$sql.'clientes.cl_bairro=:bairro, ';
            $sql=$sql.'clientes.cl_cid=:cid, ';
            $sql=$sql.'clientes.cl_uf=:uf ';
            $sql=$sql.'where clientes.cl_id=:id';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":nome", $dados['nome']);
            $pedido->bindValue(":ramo", $dados['ramo']);
            $pedido->bindValue(":whats", $dados['whats']);
            $pedido->bindValue(":usuario",  $dados['usuario']);
            $pedido->bindValue(":genero", $dados['genero']);
            $pedido->bindValue(":cep", $dados['cep']);
            $pedido->bindValue(":end", $dados['end']);
            $pedido->bindValue(":end_num", $dados['end_num']);
            $pedido->bindValue(":bairro", $dados['bairro']);
            $pedido->bindValue(":cid", $dados['cid']);
            $pedido->bindValue(":uf", $dados['uf']);
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

