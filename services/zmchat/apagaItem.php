<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    $arr1 = array();
    $arr2 = array();
    $arr1 = $dados['campos'];
    $arr2 = $dados['valores'];
    $total_elementos = count ($arr1);
    $sql = "delete from ".$dados['tabela']." where ".$arr1[0]."='$arr2[0]'";
    for ($f =1; $f <=$total_elementos -1; $f++) {
        $sql=$sql." and ".$arr1[$f]."='$arr2[$f]'";
    }
    //echo $sql;
    $retorno = apagaDados($pdo,$sql);
    echo $retorno;

    function apagaDados($pdo, $sql){
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $pedido =$pdo->prepare($sql);
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

