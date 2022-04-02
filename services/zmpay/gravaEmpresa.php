<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
   //print_r($dados);
    $retorno = gravaEmpresa($pdo, $dados);
    echo $retorno;

    function gravaEmpresa($pdo, $dados){
        $sql="insert into empresas ( em_razao, em_fanta, em_fone, em_whats, em_cep, em_end, em_end_num, em_bairro, em_cid, em_uf, em_cnpj, em_cadastro, em_liberado_ate, em_aceita_termos)";
        $sql=$sql.        ' values (:em_razao,:em_fanta,:em_fone,:em_whats,:em_cep,:em_end,:em_end_num,:em_bairro,:em_cid,:em_uf,:em_cnpj,:em_cadastro,:em_liberado_ate,:em_aceita_termos)';
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":em_razao", $dados['nome']);
        $pedido->bindValue(":em_fanta", $dados['fantasia']);
        $pedido->bindValue(":em_fone", $dados['fone']);
        $pedido->bindValue(":em_whats", $dados['whats']);
        $pedido->bindValue(":em_cep", $dados['cep']);
        $pedido->bindValue(":em_end", $dados['endereco']);
        $pedido->bindValue(":em_end_num", $dados['numero']);
        $pedido->bindValue(":em_bairro", $dados['bairro']);
        $pedido->bindValue(":em_cid", $dados['cidade']);
        $pedido->bindValue(":em_uf", $dados['uf']);
        $pedido->bindValue(":em_cnpj", $dados['cpfcnpj']);
        $pedido->bindValue(":em_cadastro", date('Y-m-d'));
        $pedido->bindValue(":em_liberado_ate", date('Y-m-d', strtotime('+1 month')));
        $pedido->bindValue(":em_aceita_termos", $dados['aceita_termos']);
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
    