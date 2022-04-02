<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    //echo $dados['imagem'];
    
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
            
            $sql="insert into campanhas (ca_empresa,ca_cod,ca_nome,ca_ramo,ca_usuario,ca_genero,ca_cod_cli1,ca_cod_cli2,ca_cidade,ca_uf,ca_imagem,ca_mensagem)";
            $sql=$sql.' values (:ca_empresa,:ca_cod,:ca_nome,:ca_ramo,:ca_usuario,:ca_genero,:ca_cod_cli1,:ca_cod_cli2,:ca_cidade,:ca_uf,:ca_imagem,:ca_mensagem)';
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":ca_empresa", $dados['cod_empresa']);
            $pedido->bindValue(":ca_cod", $codigo);
            $pedido->bindValue(":ca_nome", $dados['nome']);
            $pedido->bindValue(":ca_ramo", $dados['ramo']);
            $pedido->bindValue(":ca_usuario", $dados['usuario']);
            $pedido->bindValue(":ca_genero", $dados['genero']);
            $pedido->bindValue(":ca_cod_cli1", $dados['cod_cli1']);
            $pedido->bindValue(":ca_cod_cli2", $dados['cod_cli2']);
            $pedido->bindValue(":ca_cidade", $dados['cidade']);
            $pedido->bindValue(":ca_uf", $dados['uf']);
            $pedido->bindValue(":ca_imagem", $dados['imagem']);
            $pedido->bindValue(":ca_mensagem", $dados['mensagem']);
            
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
        $sql="select max(ca_cod) as ultimo from campanhas where ca_empresa=:empresa";
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
    