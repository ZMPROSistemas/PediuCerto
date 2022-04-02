<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = gravaEmpresa($pdo, $dados);
    echo $retorno;

    function gravaEmpresa($pdo, $dados){
        $sql="insert into empresas (em_razao,em_fanta,em_cont_nome,em_fone,em_whats,em_cep,em_end,em_end_num,em_bairro,em_cid,em_uf,em_cod_cid,em_cnpj,em_cadastro,em_liberado_ate)";
        $sql=$sql.' values (:em_razao,:em_fanta,:em_cont_nome,:em_fone,:em_whats,:em_cep,:em_end,:em_end_num,:em_bairro,:em_cid,:em_uf,:em_cod_cid,:em_cnpj,:em_cadastro,:em_liberado_ate)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":em_razao", $dados['nome']);
        $pedido->bindValue(":em_fanta", $dados['fantasia']);
        $pedido->bindValue(":em_cont_nome", $dados['contato']);
        $pedido->bindValue(":em_fone", $dados['fone']);
        $pedido->bindValue(":em_whats", $dados['whats']);
        $pedido->bindValue(":em_cep", $dados['cep']);
        $pedido->bindValue(":em_end", $dados['endereco']);
        $pedido->bindValue(":em_end_num", $dados['numero']);
        $pedido->bindValue(":em_bairro", $dados['bairro']);
        $pedido->bindValue(":em_cid", $dados['cidade']);
        $pedido->bindValue(":em_uf", $dados['uf']);
        $pedido->bindValue(":em_cod_cid", $dados['cod_cid']);
        $pedido->bindValue(":em_cnpj", $dados['cpfcnpj']);
        $pedido->bindValue(":em_cadastro", date('Y-m-d'));
        $pedido->bindValue(":em_liberado_ate", date('Y-m-d', strtotime('+1 week')));
        //$resultado=$dados['nome'].' ';
        try {
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
            } else {
                //$resultado='{"status":"OK","codigo":"'.$row[0]['em_cod'].'"}';
                $resultado='{"status":"OK"}';
            }
            
        } catch(PDOException $e) {
            $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
            //$resultado='{"status":"ERRO","mensagem":"nao sei o q deu"}';
        }
        return $resultado;
    }
    