<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);
    // if($dados == ''){
    //     $dados = $_REQUEST;
    // }

     //print_r($dados);
    // print_r($dados['TransactionStatus']['Id'].' ');
    // print_r($dados['TransactionStatus']['Code'].' ');
    // print_r($dados['TransactionStatus']['Name'].' ');
    // print_r($dados['CheckingAccounts'][0]['Description'].' ');
    // print_r($dados['CheckingAccounts'][0]['Amount'].' ');
    // print_r($dados['CheckingAccounts'][0]['Tax'].' ');
    // // for ($i = 1; $i <= count($dados['CheckingAccounts']); $i++) {
    // //     print_r($dados['CheckingAccounts'][$i-1]['Tax'].' ');
    // // };
    // print_r($dados['PaymentMethod']['Name'].' ');
    // print_r($dados['Application'].' ');
    // print_r($dados['Amount'].' ');
    // print_r($dados['TaxValue'].' ');
    // print_r($dados['NetValue'].' ');
    // print_r($dados['PaidValue'].' ');
    // print_r($dados['AdditionValue'].' ');
    // print_r($dados['DiscountValue'].' ');
    // print_r($dados['Reference'].' ');
    // print_r($dados);
    // echo $dados['IdTransaction'].' ';
    // echo $dados['TransactionStatus']['Id'].' ';
    // echo $dados['TransactionStatus']['Code'].' '; relacao de codigos em https://developers.safe2pay.com.br/references/Overview/transaction_info 
    // echo $dados['TransactionStatus']['Name'].' ';
    // echo $dados['CheckingAccounts'][0]['Description'].' ';
    // echo $dados['CheckingAccounts'][0]['Amount'].' ';
    // echo $dados['CheckingAccounts'][0]['Tax'].' ';
    // echo $dados['PaymentMethod']['Name'].' ';
    // echo $dados['Application'].' ';
    // echo $dados['Amount'].' ';        // 3 primeiros digitos é o sistema, 4 digitos é o codigo do cliente, ultimos 6 digitos numero randomico
     //echo $dados['Reference'].'   ';   //0010001000085
    $sc=substr($dados['Reference'], 0, 3);
    $cl=substr($dados['Reference'], 3, 4);
    $docto=substr($dados['Reference'], 7, 6);
    $sc=intval($sc);
    $cl=intval($cl);
    $docto=intval($docto);
    //print_r('la vai '.$dados['IdTransaction']);
    //echo $sc.' '.$cl.' '.$docto.' ';
    if ($sc==1){
        //echo 'SCL ';
        //print_r('baixaDocto1   ');
        baixaDocto1($pdo1,$cl,$dados);
    }elseif ($sc==2){
        //echo 'ZMChat ';
        //print_r('baixaDocto2   ');
        baixaDocto2($pdo2,$cl,$dados);
    }

    function baixaDocto2($pdo,$cli,$doctoRef){
        echo $doctoRef;
        return '0';
    }
    
    function baixaDocto1($pdo1,$cl,$dados){
        
        $sql = "update contas set contas.ct_status_cod=:ct_status_cod, contas.ct_status_nome=:ct_status_nome, contas.ct_idtransaction=:ct_idtransaction where ct_referencia=:ct_referencia";

        $pedido =$pdo1->prepare($sql);
        $pedido->bindValue(":ct_status_cod", $dados['TransactionStatus']['Code']);
        $pedido->bindValue(":ct_status_nome", $dados['TransactionStatus']['Name']);
        $pedido->bindValue(":ct_idtransaction", $dados['IdTransaction']);
        $pedido->bindValue(":ct_referencia", $dados['Reference']);
        $pedido->execute();
        $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        //echo $dados['PaymentMethod']['Code'].'  '.$dados['TransactionStatus']['Code'];
        //if ($dados['PaymentMethod']['Code']=='6' && $dados['TransactionStatus']['Code']=='3'){
        //print_r('Codigo '.$dados['TransactionStatus']['Code'].'   ');
        if ($dados['TransactionStatus']['Code']=='3'){
// Baixar Conta
            //echo 'Vai baixar a conta  '; 
            $sql = "update contas set contas.ct_quitado=:ct_quitado, contas.ct_pagto=:ct_pagto, contas.ct_valorpago=:ct_valorpago, contas.ct_taxa=:ct_taxa where ct_referencia=:ct_referencia";
            $pedido =$pdo1->prepare($sql);
            $pedido->bindValue(":ct_quitado", "S");
            $pedido->bindValue(":ct_pagto", substr($dados['PaymentDate'], 0, 10));
            $pedido->bindValue(":ct_valorpago", $dados['CheckingAccounts'][0]['Amount']);
            $pedido->bindValue(":ct_taxa", $dados['CheckingAccounts'][0]['Tax']);
            $pedido->bindValue(":ct_referencia", $dados['Reference']);
            $pedido->execute();
            $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);

        // Altera data de utilização do sistema
            //$id_cliente=buscaCodigo($pdo1, $dados['Reference']);
            //print_r( 'id_cliente: '.$cl);
            //if ($id_cliente!='0'){
            if($cl!=0){ 
                //echo '  update na tabela seguranca ';
                $sql="update seguranca set seguranca.SE_ATIVO=:ativo, seguranca.SE_LIBERADO_ATE=ADDDATE(seguranca.SE_LIBERADO_ATE, INTERVAL 1 MONTH) where seguranca.SE_ID=:id";
                $pedido =$pdo1->prepare($sql);
                $pedido->bindValue(":ativo", "S");
                //$pedido->bindValue(":id", $id_cliente);
                $pedido->bindValue(":id", $cl);
                $pedido->execute();
                $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
            } 
        }elseif ($dados['TransactionStatus']['Code']=='7'){
            $sql = "update contas set contas.ct_canc=:ct_canc where ct_referencia=:ct_referencia";
            $pedido =$pdo1->prepare($sql);
            $pedido->bindValue(":ct_canc", "S");
            $pedido->bindValue(":ct_referencia", $dados['Reference']);
            $pedido->execute();
            $rowCaixa = $pedido->fetchAll(PDO::FETCH_ASSOC);
        }
        return '0';
    }

    function buscaCodigo($pdo1, $ref){
        $sql="select ct_cliente_forn from contas where ct_referencia=:ct_referencia";
        $pedido =$pdo1->prepare($sql);
        $pedido->bindValue(":ct_referencia", $ref);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $retorno='0';
        } else {
            $retorno=$row[0]['ct_cliente_forn'];
        }
        return $retorno;
    }

