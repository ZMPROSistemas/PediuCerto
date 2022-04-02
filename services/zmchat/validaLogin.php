<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    //$method = $_SERVER['REQUEST_METHOD'];
   
    $retorno = json_encode(validaLogin($pdo, $dados));
    echo $retorno;


    function validaLogin($pdo, $dados){
        
        $retorno = array();
    
        if(empty($dados['empresa'])){
            array_push($retorno , array(
                'ERRO' => 'Empresa deve ser informada',
                'return' => false
            ));
    
            return $retorno;
        }
    
        if(empty($dados['matriz'])){
            array_push($retorno , array(
                'ERRO' => 'Matriz deve ser informada',
                'return' => false
            ));
    
            return $retorno;
        }
    
        $sql = "SELECT count(ped_id) as total FROM pedido_food where ped_matriz = :matriz and ped_empresa= :empresa and 
                ped_status = 'Novo' and ped_confirmado = 'N';";
        // $sql = "SELECT count(ped_id) as total FROM pedido_food where ped_empresa= :empresa and 
        // ped_status = 'Novo' and ped_confirmado = 'N';";
    
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":matriz", $dados['empresa']);
        $pedido->bindValue(":empresa", $dados['empresa']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
    
        array_push($retorno , array(
            'SUCCESS' => 'SUCCESS',
            'total_pedidos' => $rowCaixa[0]['total'],
            'return' => true
        ));
        return $retorno;
    
      }
    
