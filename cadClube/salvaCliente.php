<?php
    include '../services/conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    $cod_empresa = $_GET['cod_empresa'];

    $dados['nome'] =ucwords(strtolower($dados['nome']));
    $dados['email']=strtolower($dados['email']);

    // echo $dados['cpf'].'  ';
    // echo $dados['nome'].'  ';
    // echo $dados['celular'].'  ';
    // echo $dados['email'].'  ';
    // echo $cod_empresa;


    $retorno = gravaDados($pdo, $dados,$cod_empresa);
    echo $retorno;

    function gravaDados($pdo, $dados, $cod_empresa){
        $sql="select pe_id from pessoas where pe_cpfcnpj='".$dados['cpf']."' and pe_empresa=".$cod_empresa;
        $pedido =$pdo->prepare($sql);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $resultado='0';
        } else {
           $resultado='{"status":"JATEM","mensagem":"Cliente já cadastrado"}';
        }
        if ($resultado=='0'){
            $codigo=buscaCodigo($pdo,$cod_empresa);
            //$codigo='0';
            $sql="insert into pessoas (pe_cod, pe_empresa, pe_matriz, pe_nome, pe_fanta, pe_cpfcnpj, pe_email, pe_situacao, pe_celular, pe_cadastro)";
            $sql=$sql." values (:pe_cod, :pe_empresa, :pe_matriz, :pe_nome, :pe_fanta, :pe_cpfcnpj, :pe_email, :pe_situacao, :pe_celular, :pe_cadastro)";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":pe_cod", $codigo);
            $pedido->bindValue(":pe_empresa", $cod_empresa);
            $pedido->bindValue(":pe_matriz", $cod_empresa);
            $pedido->bindValue(":pe_nome", $dados['nome']);
            $pedido->bindValue(":pe_fanta", $dados['nome']);
            $pedido->bindValue(":pe_cpfcnpj", $dados['cpf']);
            $pedido->bindValue(":pe_email", $dados['email']);
            $pedido->bindValue(":pe_situacao", "1");
            $pedido->bindValue(":pe_celular", $dados['celular']);
            $pedido->bindValue(":pe_cadastro", date('Y-m-d'));
            try {
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                if ($pedido->rowCount()== 0 ){
                    $gravou = false;
                    $resultado='{"status":"ERRO","mensagem":"insercao nao executada"}';
                } else {
                    $resultado='{"status":"OK"}';
                    $gravou = true;
                }
            } catch(PDOException $e) {
                $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
                $gravou = false;
            }
        };
        
        return $resultado;
    };


    function buscaCodigo($pdo, $empresa){
        $sql="select max(pe_cod) as ultimo from pessoas where pe_empresa=:empresa";
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



    

