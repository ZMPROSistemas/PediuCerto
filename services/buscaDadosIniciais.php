<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $method = $_SERVER['REQUEST_METHOD'];

    if($method == 'GET'){
    
        $retorno = json_encode(buscarDadosIniciais($pdo, $dados));
    
        echo $retorno;
    
    }

    function buscarDadosIniciais($pdo, $dados){
            
        $retorno = array();

        if(empty($dados['empresa'])){
            array_push($retorno , array(
                'ERRO' => 'Empresa deve ser informada',
                'return' => false
            ));

            return $retorno;
        }

        $sql = "SELECT em_entrega1, em_entrega2, em_retira, em_aberto, em_hora_abertura, em_razao, em_fanta, em_nome_resumido, em_end, em_end_num, em_bairro, em_cid, em_uf FROM zmpro.empresas where em_cod = :empresa";

        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":empresa", $dados['empresa']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);

        array_push($retorno , array(
            'SUCCESS' => 'SUCCESS',
            'em_entrega1' => $rowCaixa[0]['em_entrega1'],
            'em_entrega2' => $rowCaixa[0]['em_entrega2'],
            'em_retira' => $rowCaixa[0]['em_retira'],
            'em_hora_abertura' => $rowCaixa[0]['em_hora_abertura'],
            'em_aberto' => $rowCaixa[0]['em_aberto'],
            'em_razao' => $rowCaixa[0]['em_razao'],
            'em_fanta' => $rowCaixa[0]['em_fanta'],
            'em_nome_resumido' => $rowCaixa[0]['em_nome_resumido'],
            'em_end' => $rowCaixa[0]['em_end'],
            'em_end_num' => $rowCaixa[0]['em_end_num'],
            'em_bairro' => $rowCaixa[0]['em_bairro'],
            'em_cid' => $rowCaixa[0]['em_cid'], 
            'em_uf' => $rowCaixa[0]['em_uf'],
            'return' => true
        ));
        return $retorno;

    }

 