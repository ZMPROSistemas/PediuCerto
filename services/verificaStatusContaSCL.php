<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $method = $_SERVER['REQUEST_METHOD'];

    $retorno = json_encode(buscarDados($pdo1, $dados));
    
    echo $retorno;

    function buscarDados($pdo1, $dados){
            
        $retorno = array();

        if(empty($dados['ref'])){
            array_push($retorno , array(
                'status' => 'ERRO',
                'mensagem' => 'Referencia deve ser informada',
                'return' => false
            ));

            return $retorno;
        }
        $sql = "select ct_status_cod, ct_status_nome from contas where ct_referencia = :referencia";

        $pedido =$pdo1->prepare($sql);
        $pedido->bindValue(":referencia", $dados['ref']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            array_push($retorno , array(
                'status' => 'NAO ENCONTRADO',
                'ct_status_cod' => '',
                'ct_status_nome' => ''
            ));
        } else {
            array_push($retorno , array(
                'status' => 'OK',
                'ct_status_cod' => $rowCaixa[0]['ct_status_cod'],
                'ct_status_nome' => $rowCaixa[0]['ct_status_nome']
            ));
        }
        return $retorno;

    }

