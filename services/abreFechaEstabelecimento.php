<?php
    include 'conectaPDO.php';
    
    date_default_timezone_set('America/Bahia');

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
  $method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
    
    $retorno = json_encode(abreFechaEstabelecimento($pdo, $dados));
    
    echo $retorno;
    
}

function abreFechaEstabelecimento($pdo, $dados){
        
    $retorno = array();

    if(empty($dados['empresa'])){
        array_push($retorno , array(
            'ERRO' => 'Empresa deve ser informada',
            'return' => false
        ));

        return $retorno;
    }

    if(empty($dados['aberto'])){
        array_push($retorno , array(
            'ERRO' => 'Aberto deve ser informado',
            'return' => false
        ));

        return $retorno;
    }
    if ($dados['aberto']=='S'){
        $sql = "update empresas set em_aberto=:aberto, em_data_abertura=:data, em_hora_abertura=:hora where em_cod = :empresa";
    }else{
        $sql = "update empresas set empresas.em_aberto=:aberto where em_cod = :empresa";
    }
    $pedido =$pdo->prepare($sql);
    $pedido->bindValue(":aberto", $dados['aberto']);
    if ($dados['aberto']=='S'){
        $pedido->bindValue(":data", date('Y-m-d'));
        $pedido->bindValue(":hora", date('H:i:s'));
    }
    $pedido->bindValue(":empresa", $dados['empresa']);
    try {
        $pedido->execute();
        $rowCaixa = $pedido->rowCount();
        array_push($retorno , array(
            'SUCCESS' => 'SUCCESS',
            'return' => true
        ));
        return $retorno;
    } catch(PDOException $e) {
        array_push($retorno , array(
            'ERRO' => $e->getMessage(),
            'return' => false
        ));
        return $retorno;
    }
}

 