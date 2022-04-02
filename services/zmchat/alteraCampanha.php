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
            $sql="update campanhas set campanhas.ca_nome=:nome, ";
            $sql=$sql.'campanhas.ca_ramo=:ramo, ';
            $sql=$sql.'campanhas.ca_usuario=:usuario, ';
            $sql=$sql.'campanhas.ca_genero=:genero, ';
            $sql=$sql.'campanhas.ca_cod_cli1=:cod_cli1, ';
            $sql=$sql.'campanhas.ca_cod_cli2=:cod_cli2, ';
            $sql=$sql.'campanhas.ca_cidade=:cidade, ';
            $sql=$sql.'campanhas.ca_uf=:uf, ';
            $sql=$sql.'campanhas.ca_imagem=:imagem, ';
            $sql=$sql.'campanhas.ca_mensagem=:mensagem ';
            $sql=$sql.'where campanhas.ca_id=:id';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":nome", $dados['nome']);
            $pedido->bindValue(":ramo", $dados['ramo']);
            $pedido->bindValue(":usuario",  $dados['usuario']);
            $pedido->bindValue(":genero", $dados['genero']);
            $pedido->bindValue(":cod_cli1", $dados['cod_cli1']);
            $pedido->bindValue(":cod_cli2", $dados['cod_cli2']);
            $pedido->bindValue(":cidade", $dados['cidade']);
            $pedido->bindValue(":uf", $dados['uf']);
            $pedido->bindValue(":imagem", $dados['imagem']);
            $pedido->bindValue(":mensagem", $dados['mensagem']);
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

