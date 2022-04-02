<?php
    include 'conectaPDO.php';
    include 'analisaToken.php';
    date_default_timezone_set('America/Bahia');
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
        $passou="N";
        $resultado='{"status":"ERRO","mensagem":"id do pedido nao informado"}';
        if(isset($_GET['id'])){
            $passou="S";    
        }
        if ($passou=="S"){
            if(isset($_GET['statusPedido'])){
                $passou="N";
                $resultado='{"status":"ERRO","mensagem":"tipo de status nao permitido"}';
                if($dados['statusPedido']=='Preparando'){
                    $passou="S"; 
                    $update = "update pedido_food set ped_status = :status, ped_hora_preparo = :hora where ped_empresa = :empresa and ped_id = :id";
                }
                if($dados['statusPedido']=='Transito'){
                    $passou="S"; 
                    $update = "update pedido_food set ped_status = :status, ped_hora_saida = :hora where ped_empresa = :empresa and ped_id = :id";
                }
                if($dados['statusPedido']=='Entregue'){
                    $passou="S"; 
                    $update = "update pedido_food set ped_status = :status, ped_hora_entrega = :hora, ped_finalizado='S' where ped_empresa = :empresa and ped_id = :id";
                }
                if($dados['statusPedido']=='Retornado'){
                    $passou="S"; 
                    $update = "update pedido_food set ped_status = :status, ped_hora_retornado = :hora where ped_empresa = :empresa and ped_id = :id";
                }
                if($dados['statusPedido']=='Cancelado'){
                    $passou="S"; 
                    $update = "update pedido_food set ped_status = :status, ped_hora_cancel = :hora where ped_empresa = :empresa and ped_id = :id";
                }
                if($dados['statusPedido']=='A Retirar'){
                    $passou="S"; 
                    $update = "update pedido_food set ped_status = :status, ped_hora_saida = :hora where ped_empresa = :empresa and ped_id = :id";
                }
            } else{
                $resultado='{"status":"ERRO","mensagem":"statusPedido nao informado"}';
                $passou="N";
            }
        }
        if($passou=='S'){
            $pedido =$pdo->prepare($update);
            $pedido->bindValue(":status", $dados['statusPedido']);
            $pedido->bindValue(":empresa", $retornoToken[0]['id']);
            $pedido->bindValue(":hora", date('H:i:s'));
            $pedido->bindValue(":id", $dados['id']);
            $pedido->execute();
            $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $resultado='{"status":"ERRO","mensagem":"pedido nao encontrado"}';
            } else {
                $resultado='{"status":"OK"}';
            }
        }
        echo $resultado;
    }
