<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(empty($dados['SE_SISTEMA'])){
        $dados['SE_SISTEMA']='1';
    }
    if ($dados['SE_CNPJ']=='' and $dados['SE_RAZAO']==''){
        $retorno='{"status":"ERRO","mensagem":"dados em branco"}';
    }else{
        $retorno = gravaDados($pdo1, $dados);
    }
    echo $retorno;

    function gravaDados($pdo1, $dados){
        $passou = 'T';
        // if( (!isset($_POST['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $sql="insert into seguranca (SE_ID,SE_CNPJ,SE_ATIVO,SE_NOME,SE_RAZAO,SE_ENDERECO,SE_CIDADE,SE_UF,SE_BAIRRO,SE_FONE,SE_CONTATO,SE_EMAIL,SE_VENCTO,SE_LIBERADO_ATE,SE_VALOR,SE_ATRAZADO,SE_SISTEMA)";
            $sql=$sql.' values (:SE_ID,:SE_CNPJ,:SE_ATIVO,:SE_NOME,:SE_RAZAO,:SE_ENDERECO,:SE_CIDADE,:SE_UF,:SE_BAIRRO,:SE_FONE,:SE_CONTATO,:SE_EMAIL,:SE_VENCTO,:SE_LIBERADO_ATE,:SE_VALOR,:SE_ATRAZADO,:SE_SISTEMA)';
            $pedido =$pdo1->prepare($sql);
            $pedido->bindValue(":SE_ID", null);
            $pedido->bindValue(":SE_CNPJ", $dados['SE_CNPJ']);
            $pedido->bindValue(":SE_ATIVO", $dados['SE_ATIVO']);
            $pedido->bindValue(":SE_NOME", $dados['SE_NOME']);
            $pedido->bindValue(":SE_RAZAO", $dados['SE_RAZAO']);
            $pedido->bindValue(":SE_ENDERECO", $dados['SE_ENDERECO']);
            $pedido->bindValue(":SE_CIDADE", $dados['SE_CIDADE']);
            $pedido->bindValue(":SE_UF", $dados['SE_UF']);
            $pedido->bindValue(":SE_BAIRRO", $dados['SE_BAIRRO']);
            $pedido->bindValue(":SE_FONE", $dados['SE_FONE']);
            $pedido->bindValue(":SE_CONTATO", $dados['SE_CONTATO']);
            $pedido->bindValue(":SE_EMAIL", $dados['SE_EMAIL']);
            $pedido->bindValue(":SE_VENCTO", $dados['SE_VENCTO']);
            $pedido->bindValue(":SE_LIBERADO_ATE", $dados['SE_LIBERADO_ATE']);
            $pedido->bindValue(":SE_VALOR", $dados['SE_VALOR']);
            $pedido->bindValue(":SE_ATRAZADO", $dados['SE_ATRAZADO']);
            $pedido->bindValue(":SE_SISTEMA", $dados['SE_SISTEMA']);

            $result = $pedido->execute();
            if ( ! $result ){
                $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
            }else{
                $resultado='{"status":"OK"}';
            }

            // try {
            //     $pedido->execute();
            //     $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            //     if ($pedido->rowCount()== 0 ){
            //         $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
            //     } else {
            //         $resultado='{"status":"OK"}';
            //     }
            // } catch(PDOException $e) {
            //     $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            // }
        }
        return $resultado;
    }
    