<?php
    date_default_timezone_set('America/Bahia');
    require_once 'conecta.php';
    include 'log.php';
    include 'getIp.php';
    include 'ocorrencia.php';

    $ip = get_client_ip();
    $data = date('Y-m-d');
    $hora = date('H:i:s');
    
    $matriz= base64_decode($_GET['matriz']);
    $empresa=base64_decode($_GET['empresa']);
    if ($empresa == 0){
        $empresa = $matriz;
    }
    $us_id = base64_decode($_GET['us_id']);
    $token= $_GET['token'];

    $array = json_decode(file_get_contents("php://input"), true);

    $contasReceber = $array['contasReceber'];
    $formaPagamento = $array['formaPagamento'];
    $lancarCaixa = $array['lancarCaixa'];
    $totalConta = count($contasReceber);
    $retorno = array();

    //var_dump($array);

    $descto = $array['descto'];

    if($descto == ''){
        $descto = 0;
    }
    //echo $descto;

    $saldoDevedorDinheiro = $formaPagamento['totalDinheiro']; // pegar o valor total em dinheiro
    $saldoDevedorCartao = $formaPagamento['totalCartao']; // pegar o valor total em dinheiro
    $saldoDevedorCheque = $formaPagamento['totalCheque']; // pegar o valor total em dinheiro

    $tipdocto = 1; //tipo de pagamento 1 - Dinheiro, 2- Cheque, 4 - Cartão
    
    $salDevedor = $saldoDevedorDinheiro+$saldoDevedorCartao+$saldoDevedorCheque;   

    $ArrayLog = array(
        'dataPagto' => $array['dataPagto'],
        'caixa' => $array['caixa'],
        'totalJuros' => $array['totalJuros'],
        'descto' => $array['descto'],
        'saldoDevedor' => $array['saldoDevedor'],
        'formaPagamento' => $formaPagamento,
        'parcelas' => $contasReceber
    );

    $ultimoValor = 0;
    
    /*
        $ct_valor = 0;
        if ($saldoDevedorDinheiro > 0) {
        $ct_valor_pago = "ct_valpago_dn = ". $ct_valor.", ct_valpago_ca = 0, ct_valpago_ch = 0";
        $salDevedor = $saldoDevedorDinheiro;
        }
        else if($saldoDevedorCartao > 0){
            $ct_valor_pago = "ct_valpago_dn = 0, ct_valpago_ca = ". $ct_valor.", ct_valpago_ch = 0";
            $salDevedor = $saldoDevedorCartao;
        }
        else if($saldoDevedorCheque > 0){
            $ct_valor_pago = "ct_valpago_dn = 0, ct_valpago_ca = 0, ct_valpago_ch = ". $ct_valor."";
            $salDevedor = $saldoDevedorCheque;
        }
    */

    $ct_nome = $contasReceber[0]['ct_nome'];
    $ct_docto = $contasReceber[0]['ct_docto'];
    $msg = 'Parcelas Baixadas N '.$contasReceber[0]['ct_docto']; 
    
    ocorrencia ($conexao, $matriz, $empresa);

    $numeroOcorrencia = getOcorrencia($conexao, $matriz, $empresa);
    $getOcorrencia = $numeroOcorrencia['dc_ocorrencia'];

    $troco = ($saldoDevedorDinheiro + $saldoDevedorCartao+$saldoDevedorCheque) - $array['saldoDevedor'];
   

    if (isset($_GET['caixaContasReceber'])) {
       
        foreach ($contasReceber as $contasReceber){
           //$ct_valor = $contasReceber['ct_valor'];
           
            if ( ($salDevedor+$descto) >= $contasReceber['ct_valor']) {
                
              $baixaParcela = baixarContaReceber(
                    $conexao, $array['dataPagto'], $contasReceber['ct_valor'] ,$descto, $array['caixa'], $contasReceber['ct_id'],$matriz, $ArrayLog, $data, $hora,$empresa, $getOcorrencia, $totalConta, $us_id
                );
                array_push($retorno, array(
                    $baixaParcela
                ));
            }else{
               
              $baixaParcela = baixarContaReceber(
                    $conexao, $array['dataPagto'], $salDevedor ,$descto, $array['caixa'], $contasReceber['ct_id'],$matriz, $ArrayLog, $data, $hora,$empresa, $getOcorrencia, $totalConta, $us_id
               );

               $criarConta = criarConta(
                   $conexao, $contasReceber['ct_id'], $salDevedor, $ArrayLog, $data, $hora, $empresa, $matriz,$getOcorrencia, $totalConta, $us_id
               );
               array_push($retorno, array(
                $baixaParcela
               ));

            }
           
            $salDevedor -= $contasReceber['ct_valor'];

            /* usar lógica depois
                if ($saldoDevedorDinheiro != 0) {
                    $saldoDevedorDinheiro -=  $contasReceber['ct_valor'];
                    $salDevedor = $saldoDevedorDinheiro;
                    $ct_valor_pago = "ct_valpago_dn = ". $contasReceber['ct_valor'].", ct_valpago_ca = 0, ct_valpago_ch = 0";
                }

                else if($saldoDevedorCartao != 0){
                    $saldoDevedorCartao -=$contasReceber['ct_valor'];
                    $salDevedor = $saldoDevedorCartao;
                    $ct_valor_pago = "ct_valpago_dn = 0, ct_valpago_ca = ". $contasReceber['ct_valor'].", ct_valpago_ch = 0";
                }

                else if($saldoDevedorCheque != 0){
                    $saldoDevedorCheque -= $contasReceber['ct_valor;'];
                    $salDevedor = $saldoDevedorCheque;
                    $ct_valor_pago = "ct_valpago_dn = 0, ct_valpago_ca = 0, ct_valpago_ch = ". $contasReceber['ct_valor']."";
                }else{
                    $salDevedor = 0;
                }
                echo $ct_valor_pago.'<br>';
            */
            //montar array para salvar no banco log;
            $ultimoValor = $contasReceber['ct_valor'];

        }

        if($saldoDevedorDinheiro > 0){
            
            if (($saldoDevedorDinheiro + $saldoDevedorCartao) > $salDevedor) {
                
                $diferenca = ($saldoDevedorDinheiro + $saldoDevedorCartao) - $array['saldoDevedor'];

               //echo '1 '. $saldoDevedorDinheiro . '+'. $saldoDevedorCartao.'-'.$array['saldoDevedor'] . '='. $diferenca.'<br />';

                $saldoDevedorDinheiro -= $diferenca;

               // echo '3 '.$saldoDevedorDinheiro;

                $retornoCaixa =  lancarCaixa($conexao, $empresa, $matriz, $ct_docto, $data, 1, $ct_nome,$saldoDevedorDinheiro, $array['caixa'], 'Dinheiro', $getOcorrencia);

            }else{
                $retornoCaixa =  lancarCaixa($conexao, $empresa, $matriz, $ct_docto, $data, 1, $ct_nome,$saldoDevedorDinheiro, $array['caixa'], 'Dinheiro', $getOcorrencia);
                //echo '2 '. $saldoDevedorDinheiro;
            }

           array_push($retorno, array(
            $retornoCaixa
           ));
        }
    
        if ($saldoDevedorCartao > 0) {
            $retornoCaixa =  lancarCaixa($conexao, $empresa, $matriz, $ct_docto, $data, 4, $ct_nome,$saldoDevedorCartao, $array['caixa'], 'Cartão', $getOcorrencia);
            array_push($retorno, array(
                $retornoCaixa
            ));
        }
        if ($saldoDevedorCheque > 0) {
            $retornoCaixa =  lancarCaixa($conexao, $empresa, $matriz, $ct_docto, $data, 2, $ct_nome, $saldoDevedorCheque, $array['caixa'], 'Cheque', $getOcorrencia);
            
            array_push($retorno,  array(
                $retornoCaixa
            ));
        }
        
       

        logSistemaBaixaContaReceber($conexao, $data, $hora, $ip, $us_id, $msg, $empresa, $matriz, $ArrayLog, $getOcorrencia);

        $lista = '{"result":[' . json_encode(retorno($retorno, $getOcorrencia,$troco)).']}';
        echo $lista;
        //print_r($retorno);

        //echo "<p>======================================</p>";
        //retorno($retorno);

    }


    function baixarContaReceber($conexao,$dataPagto, $ct_valor,$descto, $caixa,$ct_id, $matriz, $ArrayLog, $data, $hora, $empresa, $getOcorrencia, $totalConta, $us_id){

        $retorno = array();
        $i = 1;

        //MONTAR ARRAY PARA O ct_obs
        $buscarNomeCaixa = "SELECT bc_descricao FROM zmpro.bancos where bc_codigo =". $ArrayLog['caixa'] ." and bc_empresa = $empresa and bc_matriz = $matriz;";
		$queryCaixa = mysqli_query($conexao, $buscarNomeCaixa);
        $rowNomeCaixa = mysqli_fetch_assoc($queryCaixa);

        $buscarNomeUsuario = "SELECT us_nome FROM usuarios where us_id = $us_id;";        
		$query = mysqli_query($conexao, $buscarNomeUsuario);
        $rowNomeUsuario = mysqli_fetch_assoc($query);
		
		$buscarNomeEmpresa = "SELECT em_fanta FROM zmpro.empresas where em_cod = $empresa;";
		$queryCaixa = mysqli_query($conexao, $buscarNomeEmpresa);
		$rowNomeEmpresa = mysqli_fetch_assoc($queryCaixa);

        $lg_obs = "Ocorrencia: ".$getOcorrencia. "\n";
        $lg_obs .= "Data e Hora de Emissão: ".$data." ".$hora. "\n";
        $lg_obs .= "Data de Pagamento: ".$ArrayLog['dataPagto']. "\n";
        $lg_obs .= "Caixa: " . $ArrayLog['caixa'] ." - ".$rowNomeCaixa['bc_descricao']."\n";
        $lg_obs .= "Conta(s) baixada(s) por: " . $rowNomeUsuario['us_nome']."\n";
        $dinheiro = $ArrayLog['formaPagamento']['totalDinheiro'];
        $cartao = $ArrayLog['formaPagamento']['totalCartao'];
        $cheque = $ArrayLog['formaPagamento']['totalCheque'];
        $saldo = $ArrayLog['saldoDevedor'];
        $saldo = $saldo - ($dinheiro+$cartao+$cheque);

 		foreach($ArrayLog['parcelas'] as $parcelas){
			$lg_obs .= "\n";
            if ($totalConta > 1) {
                $lg_obs .= "Baixa Agrupada " .$i." de ".$totalConta. "\n";
            } else {
                $lg_obs .= "Baixa " .$i." de ".$totalConta. "\n";
            }
            $lg_obs .= "----------------------------------------------------------------------------------------\n";
            $lg_obs .= "Cliente: ". $parcelas['ct_cliente_forn_id'] . " - " . $parcelas['ct_nome']. "\n";
            $lg_obs .= "Empresa: ".$empresa . " - ". $rowNomeEmpresa['em_fanta']. "\n";
			$lg_obs .= "ID: ". $parcelas['ct_id'] . " - ID Local: " .$parcelas['ct_idlocal'] . "\n";
			$lg_obs .= "Documento: " . $parcelas['ct_docto'] . "\n";
			$lg_obs .= "Parcela: ".$parcelas['ct_parc']. "\n";
			$lg_obs .= "Vencimento: " .$parcelas['ct_vencto'] . "\n";
            $lg_obs .= "Valor da Parcela: ". $parcelas['ct_valor']."\n";
            $i++;
        }
        
        $lg_obs .= "\n";
        $lg_obs .= "Valores\n";
        $lg_obs .= "----------------------------------------------------------------------------------------\n";
        $lg_obs .= "Valor dos Juros: ". number_format($ArrayLog['totalJuros'],2). "\n";  
		$lg_obs .= "Valor do Desconto: ". number_format($ArrayLog['descto'],2). "\n";  
		$lg_obs .= "Total a Pagar: ". number_format($ArrayLog['saldoDevedor'],2). "\n";  
        $lg_obs .= "\n";
		$lg_obs .= "Pagamento em Dinheiro: " .number_format($ArrayLog['formaPagamento']['totalDinheiro'],2) . "\n";
        $lg_obs .= "Pagamento em Cartão: ".number_format($ArrayLog['formaPagamento']['totalCartao'],2) . "\n";
        $lg_obs .= "Pagamento em Cheque: ".number_format($ArrayLog['formaPagamento']['totalCheque'],2)."\n";        
        $lg_obs .= "Total Pago: " .number_format(($dinheiro+$cartao+$cheque),2)."\n";  
        if ($saldo > 0) {
            $lg_obs .= "Valor Lançado a Receber: " .number_format($saldo,2)."\n";  
        } elseif ($saldo < 0){
            $lg_obs .= "Troco: " .number_format(($saldo*(-1)),2)."\n";  
        }
        $lg_obs .= "----------------------------------------------------------------------------------------\n";
        //finalizarPedidoSemSistema
              
        $sql = "UPDATE contas SET ct_tipdoc = 1, ct_pagto = '$dataPagto', ct_valorpago = $ct_valor, ct_descto = $descto, ct_caixa =  $caixa, 
                ct_valpago_dn = 0, ct_valpago_ca = 0, ct_valpago_ch = 0 , ct_ocorrencia=$getOcorrencia , ct_quitado ='S', ct_obs='".utf8_decode($lg_obs)."' 
                WHERE ct_id = $ct_id and ct_matriz = $matriz";

        $query = mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) <= 0) {
            array_push($retorno, array(
                'retorno'=>'Parcela',
                'id' => $ct_id,
                'status'=> 'ERROR',
                'tipo'=>'Não Recebido'
            ));

        }else{
            array_push($retorno, array(
                'retorno'=>'Parcela',
                'id' => $ct_id,
                'status'=> 'SUCCESS',
                'tipo'=>'Recebido'
            ));

        }

        /*
        array_push($retorno, array(
            'retorno'=>'Parcela',
            'id' => 86876,
            'status'=> 'SUCCESS',
            'tipo'=>'Recebido'
        ));
        */
        return $retorno;
        //echo $sql;
    }

    function criarConta($conexao, $ct_id, $salDevedor, $ArrayLog, $data, $hora, $empresa, $matriz, $getOcorrencia, $totalConta, $us_id){

        $i = 1;
        //MONTAR ARRAY PARA O ct_obs
        
        $buscarNomeCaixa = "SELECT bc_descricao FROM zmpro.bancos where bc_codigo =". $ArrayLog['caixa'] ." and bc_empresa = $empresa and bc_matriz = $matriz;";
		$queryCaixa = mysqli_query($conexao, $buscarNomeCaixa);
		$rowNomeCaixa = mysqli_fetch_assoc($queryCaixa);
		
        $buscarNomeUsuario = "SELECT us_nome FROM usuarios where us_id = $us_id;";        
		$query = mysqli_query($conexao, $buscarNomeUsuario);
        $rowNomeUsuario = mysqli_fetch_assoc($query);

        $buscarNomeEmpresa = "SELECT em_fanta FROM zmpro.empresas where em_cod = $empresa;";
		$queryCaixa = mysqli_query($conexao, $buscarNomeEmpresa);
        $rowNomeEmpresa = mysqli_fetch_assoc($queryCaixa);
        
        $lg_obs = "Nº De Ocorrencia: ".$getOcorrencia. "\n";
        $lg_obs .= "Data e Hora de Emissão: ".$data." ".$hora. "\n";
        $lg_obs .= "Data de Pagamento: ".$ArrayLog['dataPagto']. "\n";
        $lg_obs .= "Caixa: " . $ArrayLog['caixa'] ." - ".$rowNomeCaixa['bc_descricao']."\n";
        $lg_obs .= "Conta(s) baixada(s) por: " . $rowNomeUsuario['us_nome']."\n";

        foreach($ArrayLog['parcelas'] as $parcelas){
            $lg_obs .= "\n";
            if ($totalConta > 1) {
                $lg_obs .= "Baixa Agrupada " .$i." de ".$totalConta. "\n";
            } else {
                $lg_obs .= "Baixa " .$i." de ".$totalConta. "\n";
            }
            $lg_obs .= "----------------------------------------------------------------------------------------\n";
            $lg_obs .= "Cliente: ". $parcelas['ct_cliente_forn_id'] . " - " . $parcelas['ct_nome']. "\n";
            $lg_obs .= "Empresa: ".$empresa . " - ". $rowNomeEmpresa['em_fanta']. "\n";
			$lg_obs .= "ID: ". $parcelas['ct_id'] . " - ID Local: " .$parcelas['ct_idlocal'] . "\n";
			$lg_obs .= "Documento: " . $parcelas['ct_docto'] . "\n";
			$lg_obs .= "Parcela: ".$parcelas['ct_parc']. "\n";
			$lg_obs .= "Vencimento: " .$parcelas['ct_vencto'] . "\n";
            $lg_obs .= "Valor da Parcela: ". $parcelas['ct_valor']."\n";
            $i++;
        }

        $dinheiro = str_replace('R','',$ArrayLog['formaPagamento']['totalDinheiro']);
        $dinheiro = str_replace('$','', $dinheiro);
        $dinheiro = str_replace(',','.', $dinheiro);

        $cartao = str_replace('R','',$ArrayLog['formaPagamento']['totalCartao']);
        $cartao = str_replace('$','', $cartao);
        $cartao = str_replace(',','.', $cartao);

        $cheque = str_replace('R','',$ArrayLog['formaPagamento']['totalCheque']);
        $cheque = str_replace('$','', $cheque);
        $cheque = str_replace(',','.', $cheque);
        $saldo = $ArrayLog['saldoDevedor'];
        $saldo = $saldo - ($dinheiro+$cartao+$cheque);
        
        $lg_obs .= "\n";
        $lg_obs .= "Valores\n";
        $lg_obs .= "----------------------------------------------------------------------------------------\n";
        $lg_obs .= "Valor dos Juros: ". number_format($ArrayLog['totalJuros'],2). "\n";  
		$lg_obs .= "Valor do Desconto: ". number_format($ArrayLog['descto'],2). "\n";  
		$lg_obs .= "Total a Pagar: ". number_format($ArrayLog['saldoDevedor'],2). "\n";  
        $lg_obs .= "\n";
		$lg_obs .= "Pagamento em Dinheiro: " .number_format($ArrayLog['formaPagamento']['totalDinheiro'],2) . "\n";
        $lg_obs .= "Pagamento em Cartão: ".number_format($ArrayLog['formaPagamento']['totalCartao'],2) . "\n";
        $lg_obs .= "Pagamento em Cheque: ".number_format($ArrayLog['formaPagamento']['totalCheque'],2)."\n";        
        $lg_obs .= "Total Pago: " .number_format(($dinheiro+$cartao+$cheque),2)."\n";  
        if ($saldo > 0) {
            $lg_obs .= "Valor Lançado a Receber: " .number_format($saldo,2)."\n";  
        } elseif ($saldo < 0){
            $lg_obs .= "Troco: " .number_format(($saldo*(-1)),2)."\n";  
        }
        $lg_obs .= "----------------------------------------------------------------------------------------\n";
        //fim
        
        $sql = "INSERT INTO contas (ct_idlocal, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_vendedor, ct_emissao, ct_vencto,
                ct_valor, ct_parc, ct_nome, ct_canc, ct_tipdoc, ct_loccob, ct_tipo_ocorrencia, ct_quitado, ct_receber_pagar, ct_ocorrencia ,ct_obs)
                SELECT ct_idlocal, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_vendedor, ct_emissao, ct_vencto,
                (ct_valor-$salDevedor), ct_parc, ct_nome, ct_canc, ct_tipdoc, ct_loccob, ct_tipo_ocorrencia, 'N', ct_receber_pagar, $getOcorrencia , '".utf8_decode($lg_obs)."'
                FROM contas WHERE ct_id = $ct_id;";
        
        $query = mysqli_query($conexao, $sql);
    }

    function lancarCaixa($conexao, $empresa, $matriz, $ct_docto, $data, $ct_tpdocto, $ct_nome, $valorPagamento, $caixa, $check, $getOcorrencia){
        $retorno = array();
        
        $sql = "INSERT caixa_aberto (cx_empresa, cx_matriz, cx_docto, cx_emissao, cx_historico, cx_tpdocto, cx_dc, cx_nome,
                cx_valor, cx_banco, cx_canc, cx_ocorrencia, cx_empr, cx_deletado) value ($empresa,$matriz, $ct_docto, '$data', 502, $ct_tpdocto, 'C', '$ct_nome', $valorPagamento, $caixa,'N', $getOcorrencia,  $empresa, 'N')";
        
        $query = mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) <= 0) {
            $id =0;
            array_push($retorno, array(
                'retorno'=>'Lancar_Caixa',
                'id' => $id,
                'status'=> 'ERROR',
                'tipo'=> $check
            ));
            
        }else{
            $id = mysqli_insert_id($conexao);

            array_push($retorno, array(
                'retorno'=>'Lancar_Caixa',
                'id' => $id,
                'status'=> 'SUCCESS',
                'tipo'=> $check
            ));

          
        }
/*
        array_push($retorno, array(
            'retorno'=>'Lancar_Caixa',
            'id' => 417822,
            'status'=> 'SUCCESS',
            'tipo'=> $check
        ));
*/
        return $retorno;
        //echo $sql;
    }

    function retorno($retorno, $getOcorrencia, $troco){
        $result = array(
            'ocorrencia' => $getOcorrencia,
            'troco' => $troco
        );
        foreach ($retorno as $retorno){
            foreach ($retorno[0] as $retorno){
                
               array_push($result, array(
                    'retorno' => $retorno['retorno'],
                    'id' => $retorno['id'],
                    'status' => $retorno['status'],
                    'tipo' => $retorno['tipo'],

                ));
            }
            
        }
        //print_r($result);

        return $result;
    }