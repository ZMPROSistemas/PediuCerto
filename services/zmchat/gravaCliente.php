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
            $codigo = buscaCodigo($pdo,$dados['cod_empresa']);
            
            $sql="insert into clientes (cl_empresa,cl_cod,cl_nome,cl_whats,cl_ramo,cl_usuario,cl_genero,cl_cep,cl_end,cl_end_num,cl_bairro,cl_cid,cl_uf)";
            $sql=$sql.' values (:cl_empresa,:cl_cod,:cl_nome,:cl_whats,:cl_ramo,:cl_usuario,:cl_genero,:cl_cep,:cl_end,:cl_end_num,:cl_bairro,:cl_cid,:cl_uf)';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":cl_empresa", $dados['cod_empresa']);
            $pedido->bindValue(":cl_cod", $codigo);
            $pedido->bindValue(":cl_nome", $dados['nome']);
            $pedido->bindValue(":cl_whats", $dados['whats']);
            $pedido->bindValue(":cl_ramo", $dados['ramo']);
            $pedido->bindValue(":cl_usuario", $dados['usuario']);
            $pedido->bindValue(":cl_genero", $dados['genero']);
            $pedido->bindValue(":cl_cep", $dados['cep']);
            $pedido->bindValue(":cl_end", $dados['end']);
            $pedido->bindValue(":cl_end_num", $dados['end_num']);
            $pedido->bindValue(":cl_bairro", $dados['bairro']);
            $pedido->bindValue(":cl_cid", $dados['cid']);
            $pedido->bindValue(":cl_uf", $dados['uf']);
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
        $sql="select max(cl_cod) as ultimo from clientes where cl_empresa=:empresa";
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
    