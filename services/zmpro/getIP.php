<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    $passou1='T';
    if(!isset($_GET['cod_empresa'])){
        if (!isset($_POST['cod_empresa'])){
            $passou1='F';
        }        
    }
    if ($passou1=='T'){
        $retorno = buscaDados($pdo,$dados);
    }else{
        $retorno = '{"status":"ERRO","mensagem":"faltam parametros"}';
    }
    echo $retorno;

    function buscaDados($pdo, $dados){
        $resultado = array();
        $passou = 'T';
        if( $dados['cod_empresa']=='' ){
            $passou='F';
            $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        }
        if ($passou=='T'){
            $sql = "select em_ip_bot from empresas where em_cod=:cod";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":cod", $dados['cod_empresa']);
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $resultado='{"status":"ERRO","mensagem":"empresa nao encontrada"}';
            } else {
                $resultado='{"status":"OK","ip_bot":"'.$row[0]['em_ip_bot'].'"}';
            }
        }
        return $resultado;
    }

    