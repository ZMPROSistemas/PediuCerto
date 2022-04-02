<?php
    include 'conectaPDO.php';
    include 'analisaToken.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $method = $_SERVER['REQUEST_METHOD'];
    //$retornoToken = array();
    $retornoToken = analisaToken($pdo, $dados);
    if($retornoToken[0]['status'] == 'ERRO'){
        echo  json_encode($retornoToken);
    }else{
        if ($method == 'GET'){
            $sql = "select * from cache ca_empresa = :empresa";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":empresa", $retornoToken[0]['id']);
            $pedido->execute();
            $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
            $passou='S';

            // if ($pedido->rowCount()== 0 ){
            //     // Insere registro 
            //     $passou='N';
            //     $insert = "insert into cache (ca_matriz, ca_empresa ,ca_produto, ca_grupo, ca_subgrupo, ca_info) values (:ca_matriz, :ca_empresa, :ca_produto, :ca_grupo, :ca_subgrupo, :ca_info)";
            //     $pedido =$pdo->prepare($insert);
            //     $pedido->bindValue(":ca_matriz",  $retornoToken[0]['id_matriz']);
            //     $pedido->bindValue(":ca_empresa", $retornoToken[0]['id']);
            //     $pedido->bindValue(":ca_produto", "0");
            //     $pedido->bindValue(":ca_grupo", "0");
            //     $pedido->bindValue(":ca_subgrupo", "0");
            //     $pedido->bindValue(":ca_info", "0");
            //     $pedido->execute();
            //     $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
            //     if ($pedido->rowCount()<> 0 ){
            //         $passou='S';
            //     }
            // } else {
            //     $passou='S';
            // }

            if ($passou=='S'){
                $cod = rand(1000,9999);
                $update = "BRANCO";
                if(isset($_GET['tabela'])){
                    if ($dados['tabela'] == 'produto') {
                        $update = "update cache set ca_produto = $cod where ca_empresa = :ca_empresa and ca_id > 0;";
                    }
                    if ($dados['tabela'] == 'grupo') {
                        $update = "update cache set ca_grupo = $cod where ca_empresa = :ca_empresa and ca_id > 0;";
                    }
                    if ($dados['tabela'] == 'subgrupo') {
                        $update = "update cache set ca_subgrupo = $cod where ca_empresa = :ca_empresa and ca_id > 0;";
                    }
                    if ($dados['tabela'] == 'empresa') {
                        $update = "update cache set ca_info = $cod where ca_empresa = :ca_empresa and ca_id > 0;";
                    }
                }                
                if ($update=="BRANCO"){
                    $resultado='{"status":"ERRO","mensagem":"tabela inexistente"}'; 
                } else {
                    $pedido =$pdo->prepare($update);
                    $pedido->bindValue(":ca_empresa", $retornoToken[0]['id']);
                    try {
                        $pedido->execute();
                        $resultado='{"status":"OK"}';
                    } catch(PDOException $e) {
                        $resultado='{"status":"ERRO","mensagem":'.$e->getMessage().'}';
                    }
                    // $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
                    // if ($pedido->rowCount()<> 0 ){
                    //     $resultado='{"status":"OK"}';
                    // } else {
                    //     $resultado='{"status":"ERRO","mensagem":""}'; 
                    // }
                }
                echo $resultado;
            }
        }
    }
