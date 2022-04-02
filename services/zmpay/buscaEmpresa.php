<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    $method = $_SERVER['REQUEST_METHOD'];

    if($dados == ''){
        $dados = $_REQUEST;
    }
    if (!(array_key_exists("codigo", $dados))) {
        $dados['codigo']="";
    }
    if (!(array_key_exists("cpfcnpj", $dados))) {
        $dados['cpfcnpj']="";
    }

    $retorno = buscaEmpresa($pdo, $dados);
    echo $retorno;

    function buscaEmpresa($pdo, $dados){
        $passou = 'T';
        //if(!(isset($_GET['cpfcnpj']) or isset($_GET['codigo']))){
        if($dados['cpfcnpj']=='' and $dados['codigo']==''){  
            $passou='F';
            $retorno='{"status":"ERRO","mensagem":"nenhum parametro informado"}';
        }
        
        if ($passou=='T'){
            //if(isset($_GET['cpfcnpj'])){
            if($dados['cpfcnpj']<>''){    
                $sql = "select em_cod from empresas where em_cnpj = :cnpj"; 
                $pedido =$pdo->prepare($sql);
                $pedido->bindValue(":cnpj", $dados['cpfcnpj']);
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                if ($pedido->rowCount()== 0 ){
                    $retorno='{"status":"ERRO","mensagem":"cpf/cnpj nao encontrado"}';
                } else {
                    $retorno='{"status":"OK","codigo":"'.$row[0]['em_cod'].'"}';
                }
                //return $retorno;
            }else{
                $sql = "select * from empresas where em_cod = :codigo"; 
                $pedido =$pdo->prepare($sql);
                $pedido->bindValue(":codigo", $dados['codigo']);
                $pedido->execute();
                $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
                if ($pedido->rowCount()== 0 ){
                    $retorno='{"status":"ERRO","mensagem":"codigo nao encontrado"}';
                } else {
                    $retorno='{"status":"OK","codigo":"'.$row[0]['em_cod'].'",
                                             "razao":"'.$row[0]['em_razao'].'",
                                             "fantasia":"'.$row[0]['em_fanta'].'",                                        
                                             "fone":"'.$row[0]['em_fone'].'",
                                             "whats":"'.$row[0]['em_whats'].'",
                                             "cep":"'.$row[0]['em_cep'].'",
                                             "endereco":"'.$row[0]['em_end'].'",
                                             "numero":"'.$row[0]['em_end_num'].'",
                                             "bairro":"'.$row[0]['em_bairro'].'",
                                             "cidade":"'.$row[0]['em_cid'].'",
                                             "uf":"'.$row[0]['em_uf'].'",
                                             "aceita_termos":"'.$row[0]['em_aceita_termos'].'",
                                             "cnpj":"'.$row[0]['em_cnpj'].'",
                                             "data_cadastro":"'.$row[0]['em_cadastro'].'",
                                             "liberado_ate":"'.$row[0]['em_liberado_ate'].'"}';
                }
                //return $retorno;
            }
        }
        return $retorno;
    }
    