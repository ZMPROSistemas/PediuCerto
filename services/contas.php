<?php


include 'conecta.php';
include 'conectaPDO.php';
include 'log.php';
include 'ocorrencia.php';
include 'lancarCaixa.php';
include 'getIp.php';

date_default_timezone_set('America/Bahia');

$ip = get_client_ip();

$data = date('Y-m-d');
$hora = date('H:i:s');

    if (isset($_GET['empresa_matriz'])) {
        $empresa_matriz =base64_decode($_GET['empresa_matriz']);
    }else{
        $empresa_matriz=0;
    }

    if (isset($_GET['empresa_filial'])) {
        $empresa_filial= $_GET['empresa_filial'];
        if ($empresa_filial != '') {
            $empresa_filial= $_GET['empresa_filial'];
            if($empresa_filial == 0){
                $empresa_filial =  $empresa_matriz;
            }
            $ct_empresa = '  and ct_empresa = ' . $empresa_filial;
        }else{
            $ct_empresa = ' ';
        }
        
    }else{
        $empresa_filial = 0;
        $ct_empresa = ' ';
    }
    //echo $ct_empresa;
    if (isset($_GET['canc'])) {
       $canc = $_GET['canc'];

       if ($canc != '') {
            $ct_canc = " and ct_canc = '". $canc. "'";
       }else{
            $ct_canc = '';
       }

    }else{
        $ct_canc = '';
    }

    if (isset($_GET['cliente'])) {
        $cliente = $_GET['cliente'];
         if ($cliente != null) {
             $ct_cliente_forn = ' and ct_cliente_forn= '. $cliente;
         }else{
             $ct_cliente_forn = '';
         }
    }else{
        $ct_cliente_forn='';
    }

    if (isset($_GET['us_id'])) {
        $us_id = $_GET['us_id'];
    }else{
        $us_id = null;
    }
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
    }

    if (isset($_GET['quitado'])) {

        $quitado = $_GET['quitado'];

        if(isset($_GET['dataI']) or isset($_GET['dataF'])){
            $dataI = $_GET['dataI'];
            $dataF = $_GET['dataF'];
            if($dataI == ''){
                $ct_vencto = "";
            }else{
                if ($quitado == 'N') {
                   $ct_vencto = " and ct_vencto between '".$dataI . "' and '". $dataF."'";
                }
                else if ($quitado == 'S'){
                    $ct_vencto = " and ct_pagto between '".$dataI . "' and '". $dataF."'";
                }
                //echo 'Data '. $dataI;
            }
            
        }else{
            $ct_vencto = "";
        }
    
    
    }

    if (isset($_GET['ct_id'])) {
        $conta_id = $_GET['ct_id'];

        if ($conta_id == '') {
            $ct_id='';
        }else {
            $ct_id = ' and ct_id = '.$conta_id;
        }
    }else {
        $ct_id='';
    }

    if (isset($_GET['receber'])) {

        $ct_receber_pagar = 'R';

        if (isset($_GET['listaContasReceber'])) {
           
            if(isset($_GET['buscarConta'])){
                $select = "(SELECT pe_id FROM pessoas WHERE pe_cod = ct_cliente_forn and pe_empresa = ct_empresa  and pe_fornecedor = 'S') as ct_cliente_fornecedor_id,";
            }else{
                $select = '';
            }

            $lista = '{"result":[' . json_encode(contasReceberPagarLista($conexao, $select, $empresa_matriz, $ct_empresa, $ct_vencto, $ct_canc, $ct_cliente_forn, $ct_receber_pagar, $quitado, $ct_id)) . ']}';
            echo $lista;
        }

        if(isset($_GET['listaContaRecFast'])){
            $dataI = $_GET['dataI'];
            $dataF = $_GET['dataF'];
            $empresaFilial = $_GET['empresa_filial'];
            $empresaMatriz = $empresa_matriz;
            $ct_pagto = 'and ct_pagto between "'. $dataI .'" and "'. $dataF .'"';

            if ($empresa_filial == '') {
                $empresa = 'ct_matriz = ' . $empresaMatriz;
            } else {   
                $empresa = 'ct_empresa = ' . $empresaFilial;
            }    

            if ($cliente != ''){
                $ct_nome = 'and ct_nome like "%' . $cliente .'%"';
            } else {
                $ct_nome = '';
            }

            $lista = '{"result":[' . json_encode(listaContasRecebidas($conexao, $empresa, $ct_pagto, $ct_nome, $quitado)). ']}';
            echo $lista;

        }

        if(isset($_GET['totalContaRecFast'])){
            $empresaFilial = $_GET['empresa_filial'];
            $empresaMatriz = $empresa_matriz;
            $dataI = $_GET['dataI'];
            $dataF = $_GET['dataF'];
            $ct_pagto = 'and ct_pagto between "'. $dataI .'" and "'. $dataF .'"';

            if ($empresa_filial == '') {
                $empresa = 'ct_matriz = ' . $empresaMatriz;
            } else {   
                $empresa = 'ct_empresa = ' . $empresaFilial;
            }    

            if ($cliente != ''){
                $ct_nome = 'and ct_nome like "%' . $cliente .'%"';
            } else {
                $ct_nome = '';
            }

            $lista = '{"result":[' . json_encode(totalContasRecebidas($conexao, $empresa, $ct_pagto, $ct_nome, $quitado)). ']}';
            echo $lista;

        }

        if(isset($_GET['listaContaReceberFast'])){
            $vencida = $_GET['vencida'];
            $empresaFilial = $_GET['empresa_filial'];
            $empresaMatriz = $empresa_matriz;
            $cliente = $_GET['cliente'];
            $ct_vencto = 'and ct_vencto between "'. $dataI .'" and "'. $dataF .'"';

            if ($empresa_filial == '') {
                $empresa = 'ct_matriz = ' . $empresaMatriz;
            } else {   
                $empresa = 'ct_empresa = ' . $empresaFilial;
            }    

            if ($vencida == 'TRUE') {
                $vencida = 'and ct_vencto < current_date()';
            } else {   
                $vencida = '';
            }    

            if ($cliente != ''){
                $ct_nome = 'and ct_nome like "%' . $cliente .'%"';
            } else {
                $ct_nome = '';
            }

            $lista = '{"result":[' . json_encode(listaContaReceberFast($conexao, $empresa, $vencida, $ct_nome, $ct_vencto, $quitado)). ']}';
            echo $lista;

        }

        if(isset($_GET['totalContaReceberFast'])){
            $empresaFilial = $_GET['empresa_filial'];
            $empresaMatriz = $empresa_matriz;
            $dataI = $_GET['dataI'];
            $dataF = $_GET['dataF'];
            $ct_vencto = 'and ct_vencto between "'. $dataI .'" and "'. $dataF .'"';

            if ($empresa_filial == '') {
                $empresa = 'ct_matriz = ' . $empresaMatriz;
            } else {   
                $empresa = 'ct_empresa = ' . $empresaFilial;
            }    

            if ($cliente != ''){
                $ct_nome = 'and ct_nome like "%' . $cliente .'%"';
            } else {
                $ct_nome = '';
            }

            $lista = '{"result":[' . json_encode(totalContaReceberFast($conexao, $empresa, $ct_nome, $ct_vencto, $quitado)). ']}';
            echo $lista;

        }


        if ($quitado == 'N') {

            if(isset($_GET['totalContasReceber'])){
                $lista = '{"result":[' . json_encode(totalContasReceberPagar($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado)). ']}';
                echo $lista;
            }
        }

        if ($quitado == 'S') {
            if(isset($_GET['totalContasReceber'])){
                $lista = '{"result":[' . json_encode(totalContasRecebidasPagas($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado)). ']}';
                echo $lista;
            }
        }
        
    }

    if (isset($_GET['pagar'])) {

        $ct_receber_pagar = 'P';

        if(isset($_GET['listaContasPagasFast'])){
            $dataI = $_GET['dataI'];
            $dataF = $_GET['dataF'];
            $empresaFilial = $_GET['empresa_filial'];
            $empresaMatriz = $empresa_matriz;

            if ($empresa_filial == '') {
                $empresa = 'ct_matriz = ' . $empresaMatriz;
            } else {   
                $empresa = 'ct_empresa = ' . $empresaFilial;
            }    

            $lista = '{"result":[' . json_encode(listaContasPagas($conexao, $empresa, $dataI, $dataF, $quitado)). ']}';
            echo $lista;

        }

        if (isset($_GET['proximoDocto'])) {

            $empresa = base64_decode($_GET['empresa_matriz']);

            $docto = $pdo->prepare("SELECT max(ct_docto) + 1 as ct_docto FROM contas where ct_matriz = $empresa;");
            $docto->execute();
            $retorno = $docto->fetch();
            print_r($retorno[0]);
            return $retorno[0];

        }
        
        if (isset($_GET['listaContasPagar'])) {


            if(isset($_GET['buscarConta'])){
                $select = "(SELECT pe_id FROM pessoas WHERE pe_cod = ct_cliente_forn and pe_empresa = ct_empresa  and pe_fornecedor = 'S') as ct_cliente_fornecedor_id,";
            }else{
                $select = '';
            }

            $lista = '{"result":[' . json_encode(contasReceberPagarLista($conexao, $select, $empresa_matriz, $ct_empresa, $ct_vencto, $ct_canc, $ct_cliente_forn, $ct_receber_pagar, $quitado, $ct_id)) . ']}';
            echo $lista;
        }
        if ($quitado == 'N') {
            if(isset($_GET['totalContasPagar'])){
            $lista = '{"result":[' . json_encode(totalContasReceberPagar($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado)). ']}';
            echo $lista;
            }
        }
        if ($quitado == 'S') {
            if(isset($_GET['totalContasPagar'])){
                $lista = '{"result":[' . json_encode(totalContasRecebidasPagas($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto,  $ct_receber_pagar, $quitado)). ']}';
                echo $lista;
            }
        }
    }

    if (isset($_GET['buscarConta'])) {

        $ct_receber_pagar = $_GET['RecPag'];

        if(isset($_GET['buscarConta'])){
            $select = "(SELECT pe_id FROM pessoas WHERE pe_cod = ct_cliente_forn and pe_empresa = ct_empresa  and pe_fornecedor = 'S') as ct_cliente_fornecedor_id,";
        
        }else{
            $select = '';
        }

        $lista = '{"result":[' . json_encode(contasReceberPagarLista($conexao, $select, $empresa_matriz, $ct_empresa, $ct_vencto, $ct_canc, $ct_cliente_forn, $ct_receber_pagar, $quitado, $ct_id)) . ']}';
        echo $lista;
    }

    if (isset($_GET['buscarContaID'])) {

        $ct_id = $_GET['ct_id'];
        $lista = '{"result":[' . json_encode(buscarContaId($conexao, $ct_id)) . ']}';
        echo $lista;
    }

    if (isset($_GET['buscarContaPagarID'])) {

        $ct_id = $_GET['ct_id'];
        $lista = '{"result":[' . json_encode(buscarContaPagarId($conexao, $ct_id)) . ']}';
        echo $lista;
    }

    if (isset($_GET['buscarContasPorID'])) {

        $ct_id = $_GET['ct_id'];
        $lista = '{"result":[' . json_encode(buscarContasPorId($conexao, $ct_id)) . ']}';
        echo $lista;
    }

    if (isset($_GET['editarContaID'])) {
 
        $array = json_decode(file_get_contents("php://input"), true); 
        $id = base64_decode($_GET['us_id']);
        $empresa = base64_decode($_GET['e']);

        $editarConta = $array['editarConta'][0];
            
        editarContaID($conexao, $editarConta['ct_id'], $editarConta['ct_docto'], $editarConta['ct_empresa'], $editarConta['ct_matriz'], $editarConta['ct_parc'], date('Y-m-d', strtotime($editarConta['ct_vencto'])), $editarConta['ct_valor'], $editarConta['ct_tipdoc'], $editarConta['ct_obs'], $editarConta['ct_cliente_forn'], $id, $empresa, $data, $hora, $ip);

    }

    if (isset($_GET['baixarConta'])) {
        $array = json_decode(file_get_contents("php://input"), true);

        $conta = $array['contas'][0];
        $lancaCaixa = $array['lancaCaixa'];
        $valData = $array['valData'];
        

        if ($lancaCaixa['statusCheck'] == true) {
           //print_r($lancaCaixa);
        }
        
        if($lancaCaixa['caixa'] != 0){
            $caixa = ', ct_caixa= ' . $lancaCaixa['caixa'];
        }else{
            $caixa ='';
        }
        $dc ='D';
        baixarConta($conexao, $data, $hora, $ip, date('Y-m-d', strtotime($valData['dataBaixa'])), $conta['ct_valor'], $us_id, $caixa, $empresa_matriz, $token, $conta['ct_id'], $lancaCaixa['statusCheck'], $dc, $valData['tipoDoctos'],$empresa_filial);
        
    }

    if(isset($_GET['excluir'])){
        $ct_id = $_GET['ct_id'];
        excluir($conexao, $ct_id, $token);
    }

    if (isset($_GET['buscaContasClientes'])) {
        
        if (isset($_GET['pe_cod'])) {
            $ct_cliente = $_GET['pe_cod'];
        }
        if (isset($_GET['cliente_fornecedor'])) {
            $clienteFornecedor = $_GET['cliente_fornecedor'];
        }
        if (isset($_GET['RecPag'])) {
            $ct_receber_pagar = $_GET['ct_receber_pagar'];
        }
        if (isset($_GET['quitado'])) {
            $ct_quitado = $_GET['quitado'];
        }
        $lista = '{"result":[' . json_encode(buscarContasClientes($conexao, $empresa_matriz, $ct_cliente, $clienteFornecedor, $ct_receber_pagar, $ct_quitado)) . ']}';
        echo $lista;
    }

    function contasReceberPagarLista($conexao, $select, $empresa_matriz, $ct_empresa, $ct_vencto, $ct_canc, $ct_cliente_forn, $ct_receber_pagar, $quitado, $ct_id){
        $retorno = array();

        $sql = "SELECT ct_id, ct_idlocal, ct_empresa, em_fanta, ct_matriz, ct_docto, ct_cliente_forn,
        $select
        ct_vendedor, pe_nome vendedor, ct_emissao,
        ct_vencto, ct_valor, ct_parc, ct_nome, ct_canc, ct_tipdoc, 
        (SELECT dc_descricao FROM tipo_docto where dc_empr = ct_empresa and dc_codigo = ct_tipdoc) as dc_descricao,
        (SELECT dc_sigla FROM tipo_docto where dc_empr = ct_empresa and dc_codigo = ct_tipdoc) as dc_sigla,
        ct_pagto, ct_valorpago, ct_tipo_ocorrencia, ct_receber_pagar, ct_quitado, ct_obs
         FROM zmpro.contas 
         left join empresas on(ct_empresa = em_cod) 
         left join pessoas on (ct_vendedor = (select pe_cod where pe_vendedor = 'S' and pe_empresa = ct_empresa))
         where ct_matriz = $empresa_matriz $ct_empresa $ct_canc $ct_cliente_forn and ct_receber_pagar = '$ct_receber_pagar' and ct_quitado= '$quitado' $ct_vencto $ct_id order by ct_vencto;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            if ($select != null) {
               array_push($retorno, array(
                    'ct_id' => $row['ct_id'],
                    'ct_idlocal' => $row['ct_idlocal'],
                    'ct_empresa' => $row['ct_empresa'],
                    'em_fanta' => utf8_encode($row['em_fanta']),
                    'ct_matriz' => $row['ct_matriz'],
                    'ct_docto' => $row['ct_docto'],
                    'ct_cliente_forn' => $row['ct_cliente_forn'],            
                    'ct_cliente_fornecedor_id'=> $row['ct_cliente_fornecedor_id'],
                    'ct_vendedor' => $row['ct_vendedor'],
                    'vendedor' => utf8_encode($row['vendedor']),
                    'ct_emissao' => utf8_encode($row['ct_emissao']),
                    'ct_vencto' => utf8_encode($row['ct_vencto']),
                    'ct_vencta' => verVencimento($row['ct_vencto']),
                    'ct_pagto'=> utf8_encode($row['ct_pagto']),
                    'ct_valorpago' => $row['ct_valorpago'],
                    'ct_valor' => $row['ct_valor'],
                    'ct_parc' => utf8_encode($row['ct_parc']),
                    'ct_nome' => utf8_encode($row['ct_nome']),
                    'ct_canc' => utf8_encode($row['ct_canc']),
                    'ct_tipdoc' => $row['ct_tipdoc'],
                    'dc_descricao' => utf8_encode($row['dc_descricao']),
                    'dc_sigla' => utf8_encode($row['dc_sigla']),
                    'ct_tipo_ocorrencia' => utf8_encode($row['ct_tipo_ocorrencia']),
                    'ct_receber_pagar' => utf8_encode($row['ct_receber_pagar']),
                    'ct_quitado' => utf8_encode($row['ct_quitado']),
                    'ct_obs' => utf8_encode($row['ct_obs']),
            
                ));
            }else{
                array_push($retorno, array(
                    'ct_id' => $row['ct_id'],
                    'ct_idlocal' => $row['ct_idlocal'],
                    'ct_empresa' => $row['ct_empresa'],
                    'em_fanta' => utf8_encode($row['em_fanta']),
                    'ct_matriz' => $row['ct_matriz'],
                    'ct_docto' => $row['ct_docto'],
                    'ct_cliente_forn' => $row['ct_cliente_forn'],            
                    //'ct_cliente_fornecedor_id'=> $row['ct_cliente_fornecedor_id'],
                    'ct_vendedor' => $row['ct_vendedor'],
                    'vendedor' => utf8_encode($row['vendedor']),
                    'ct_emissao' => utf8_encode($row['ct_emissao']),
                    'ct_vencto' => utf8_encode($row['ct_vencto']),
                    'ct_vencta' => verVencimento($row['ct_vencto']),
                    'ct_pagto'=> utf8_encode($row['ct_pagto']),
                    'ct_valorpago' => $row['ct_valorpago'],
                    'ct_valor' => $row['ct_valor'],
                    'ct_parc' => utf8_encode($row['ct_parc']),
                    'ct_nome' => utf8_encode($row['ct_nome']),
                    'ct_canc' => utf8_encode($row['ct_canc']),
                    'ct_tipdoc' => $row['ct_tipdoc'],
                    'dc_descricao' => utf8_encode($row['dc_descricao']),
                    'dc_sigla' => utf8_encode($row['dc_sigla']),
                    'ct_tipo_ocorrencia' => utf8_encode($row['ct_tipo_ocorrencia']),
                    'ct_receber_pagar' => utf8_encode($row['ct_receber_pagar']),
                    'ct_quitado' => utf8_encode($row['ct_quitado']),
                    'ct_obs' => utf8_encode($row['ct_obs']),
            
                ));
            }
           
        }
        //echo $sql;
        return $retorno;
    }

    function listaContasPagas($conexao, $empresa, $dataI, $dataF, $quitado){
        
        $retorno = array();

        $sql = "SELECT ct_id, (select em_fanta from empresas where em_cod = ct_empresa) as em_fanta, ct_empresa, ct_docto, ct_cliente_forn, ct_valor, ct_pagto,
        (select dc_sigla from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa) as ct_tipdoc, ct_valorpago, ct_canc, ct_vencto, ct_parc, ct_nome, ct_historico,  
        (SELECT ht_descricao FROM historico where ht_cod = ct_historico and ht_empresa = ct_matriz) as ht_descricao
        FROM contas where $empresa and ct_receber_pagar = 'P' and ct_pagto is not null and ct_canc <> 'S' and ct_quitado = 'S'
        and ct_pagto between '$dataI' and '$dataF';";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
 
            array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'ct_empresa' => utf8_encode($row['ct_empresa']),
                'em_fanta' => utf8_encode($row['em_fanta']),
                'ct_docto' => $row['ct_docto'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],            
                'ct_vencto' => utf8_encode($row['ct_vencto']),
                'ct_pagto'=> utf8_encode($row['ct_pagto']),
                'ct_valorpago' => $row['ct_valorpago'],
                'ct_valor' => $row['ct_valor'],
                'ct_parc' => utf8_encode($row['ct_parc']),
                'ct_nome' => utf8_encode($row['ct_nome']),
                'ct_tipdoc' => utf8_encode($row['ct_tipdoc']),

            ));
             
        }
        //echo $sql;
        return $retorno;
    }


    function listaContasRecebidas($conexao, $empresa, $ct_pagto, $cliente, $quitado){
        
        $retorno = array();

        $sql = "SELECT ct_id, (select em_fanta from empresas where em_cod = ct_empresa) as ct_empresa, ct_docto, ct_cliente_forn, 
        (select pe_nome from pessoas where pe_vendedor = 'S' and pe_empresa = ct_empresa and pe_cod = ct_vendedor) as ct_vendedor,
        ct_emissao, ct_vencto, ct_valor, ct_parc, ct_nome, ct_valorpago, ct_pagto,
        (SELECT dc_sigla FROM tipo_docto where dc_empr = ct_empresa and dc_codigo = ct_tipdoc) as ct_tipdoc
        FROM contas where $empresa $ct_pagto $cliente and ct_receber_pagar = 'R' and ct_pagto is not null and ct_canc <> 'S' and ct_quitado = 'S';";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
 
            array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'ct_empresa' => utf8_encode($row['ct_empresa']),
                'ct_docto' => $row['ct_docto'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],            
                'ct_vendedor' => utf8_encode($row['ct_vendedor']),
                'ct_emissao' => utf8_encode($row['ct_emissao']),
                'ct_vencto' => utf8_encode($row['ct_vencto']),
                'ct_pagto'=> utf8_encode($row['ct_pagto']),
                'ct_valorpago' => $row['ct_valorpago'],
                'ct_valor' => $row['ct_valor'],
                'ct_parc' => utf8_encode($row['ct_parc']),
                'ct_nome' => utf8_encode($row['ct_nome']),
                'ct_tipdoc' => utf8_encode($row['ct_tipdoc']),
            ));
             
        }
        //echo $sql;
        return $retorno;
    }

    function totalContasRecebidas($conexao, $empresa, $ct_pagto, $cliente, $quitado){
        
        $retorno = array();

        $sql = "select (select sum(ct_valorpago) FROM contas where $empresa $ct_pagto $cliente and ct_receber_pagar = 'R' and ct_pagto is not null and ct_canc <> 'S' and ct_quitado = 'S') as total,
        (select sum(ct_valorpago) FROM contas where $empresa $ct_pagto $cliente and ct_receber_pagar = 'R' and ct_pagto is not null and ct_canc <> 'S' and ct_quitado = 'S' and ct_tipdoc = 1) as dinheiro,
        (select sum(ct_valorpago) FROM contas where $empresa $ct_pagto $cliente and ct_receber_pagar = 'R' and ct_pagto is not null and ct_canc <> 'S' and ct_quitado = 'S' and ct_tipdoc = 4) as cartao;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
 
            array_push($retorno, array(
                'total' => $row['total'],
                'dinheiro' => $row['dinheiro'],
                'cartao' => $row['cartao'],
                'outros' => ($row['total'] - $row['dinheiro'] - $row['cartao']),
            ));
             
        }
        //echo $sql;
        return $retorno;
    }

    function listaContaReceberFast($conexao, $empresa, $vencidas, $ct_nome, $ct_vencto, $quitado){
        
        $retorno = array();

        $sql = "SELECT ct_id, (select em_fanta from empresas where em_cod = ct_empresa) as em_fanta, ct_empresa, ct_docto, ct_valor,
        (select dc_sigla from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa) as ct_tipdoc, ct_cliente_forn,
        (select pe_nome from pessoas where pe_cod = ct_cliente_forn and pe_empresa = ct_empresa and pe_cliente = 'S') as ct_nome, ct_canc,
        (select pe_nome from pessoas where pe_cod = ct_vendedor and pe_empresa = ct_empresa and pe_vendedor = 'S') as ct_vendedor, ct_vencto, ct_parc  
        FROM contas where $empresa $vencidas $ct_nome $ct_vencto and ct_receber_pagar = 'R' and ct_quitado = 'N' order by ct_vencto;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
 
            array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'em_fanta' => utf8_encode($row['em_fanta']),
                'ct_empresa' => $row['ct_empresa'],
                'ct_docto' => $row['ct_docto'],
                'ct_canc' => $row['ct_canc'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],
                'ct_valor' => $row['ct_valor'],
                'ct_nome' => utf8_encode($row['ct_nome']),            
                'ct_vendedor' => utf8_encode($row['ct_vendedor']),
                'ct_vencto' => utf8_encode($row['ct_vencto']),
                'ct_parc' => utf8_encode($row['ct_parc']),
                'ct_tipdoc' => utf8_encode($row['ct_tipdoc']),
            ));
             
        }
        //echo $sql;
        return $retorno;
    }

    function totalContaReceberFast($conexao, $empresa, $ct_nome, $ct_vencto, $quitado){
        
        $retorno = array();

        $sql = "select (select sum(ct_valor) FROM contas where ct_vencto < current_date() and $empresa $ct_nome $ct_vencto and ct_receber_pagar = 'R' and ct_quitado = 'N') as vencidas,
        (select sum(ct_valor) FROM contas where ct_vencto = current_date() and $empresa $ct_nome $ct_vencto and ct_receber_pagar = 'R' and ct_quitado = 'N') as vencendo,
        (select sum(ct_valor) FROM contas where ct_vencto > current_date() and $empresa $ct_nome $ct_vencto and ct_receber_pagar = 'R' and ct_quitado = 'N') as a_vencer;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
 
            array_push($retorno, array(
                'vencidas' => $row['vencidas'],
                'vencendo' => $row['vencendo'],
                'a_vencer' => $row['a_vencer'],
            ));
             
        }
        //echo $sql;
        return $retorno;
    }


    function buscarContasClientes($conexao, $matriz, $ct_cliente, $clienteFornecedor, $ct_receber_pagar, $ct_quitado){
        $retorno = array();
        $sql ="SELECT ct_id, ct_idlocal, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn,
        (SELECT pe_id FROM pessoas where pe_cod = ct_cliente_forn and pe_empresa = ct_empresa and $clienteFornecedor = 'S') as ct_cliente_forn_id,
         ct_vendedor, ct_nome, ct_vencto, ct_valor, ct_parc, ct_canc, ct_tipdoc,
         (SELECT dc_sigla FROM tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa ) as ct_tipdoc_sigla,
        ct_receber_pagar, ct_quitado
        from contas where ct_matriz = $matriz and ct_cliente_forn = $ct_cliente and ct_quitado  = '$ct_quitado' and ct_receber_pagar = '$ct_receber_pagar'
        order by ct_vencto;";

        $query = mysqli_query($conexao, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
            
               array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'ct_idlocal' => $row['ct_idlocal'],
                'ct_empresa' => $row['ct_empresa'],
                'ct_matriz' => $row['ct_matriz'],
                'ct_docto' => $row['ct_docto'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],
                'ct_cliente_forn_id' => $row['ct_cliente_forn_id'],
                'ct_vendedor' => $row['ct_vendedor'],
                'ct_nome' => utf8_encode($row['ct_nome']),
                'ct_vencto' => $row['ct_vencto'],
                'ct_valor' => number_format($row['ct_valor'], 2, ',', '.'),
                'ct_parc' => $row['ct_parc'],
                'ct_canc' => utf8_encode($row['ct_canc']),
                'ct_tipdoc' => $row['ct_tipdoc'],
                'ct_tipdoc_sigla' => utf8_encode($row['ct_tipdoc_sigla']),
                'ct_receber_pagar' => utf8_encode($row['ct_receber_pagar']),
                'ct_quitado' => utf8_encode($row['ct_quitado']),
               
               ));
        };
        
        //echo $sql;
        return $retorno;

    }

    function buscarContaID($conexao, $ct_id){
        $retorno = array();
        $sql =  "SELECT  ct_id, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_nome, ct_vencto, ct_valor, ct_parc,
                (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, ct_pagto, ct_valorpago, ct_emissao, 
                (select pe_nome from pessoas where pe_cod = ct_vendedor and pe_empresa = ct_empresa and pe_vendedor = 'S') as ct_vendedor,
                (SELECT pe_id FROM pessoas where pe_cod = ct_cliente_forn and pe_empresa = ct_empresa and pe_cliente = 'S') as ct_cliente_forn_id,
                (select dc_descricao from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa) as ct_tipdoc, ct_obs
                from    contas      where ct_id = $ct_id;";

        $query = mysqli_query($conexao, $sql);
        
        while ($row = mysqli_fetch_assoc($query)) {
               array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'ct_empresa' => $row['ct_empresa'],
                'em_fanta' => utf8_encode($row['em_fanta']),
                'ct_matriz' => $row['ct_matriz'],
                'ct_emissao' => utf8_encode($row['ct_emissao']),
                'ct_vendedor' => utf8_encode($row['ct_vendedor']),
                'ct_docto' => $row['ct_docto'],
                'ct_pagto' =>  utf8_encode($row['ct_pagto']),
                'ct_valorpago' => number_format($row['ct_valorpago'], 2),
                'ct_cliente_forn' => $row['ct_cliente_forn'],
                'ct_cliente_forn_id' => $row['ct_cliente_forn_id'],
                'ct_nome' => utf8_encode($row['ct_nome']),
                'ct_vencto' => utf8_encode($row['ct_vencto']),
                'ct_valor' => number_format($row['ct_valor'], 2),
                'ct_parc' => $row['ct_parc'],
                'ct_tipdoc' => utf8_encode($row['ct_tipdoc']),
                'ct_obs' =>  utf8_encode($row['ct_obs']),
               ));
        };
        
        //echo $sql;
        return $retorno;
    }
    
    
    function buscarContaPagarID($conexao, $ct_id){
        $retorno = array();
        $sql =  "SELECT  ct_id, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, ct_nome, ct_vencto, 
                FORMAT(ct_valor,2,'pt_BR') as ct_valor, ct_parc,
                (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, DATE_FORMAT(ct_pagto, '%d/%m/%Y') as ct_pagto, 
                FORMAT(ct_valorpago,2,'pt_BR') as ct_valorpago, DATE_FORMAT(ct_emissao, '%d/%m/%Y') as ct_emissao, 
                (select pe_nome from pessoas where pe_cod = ct_vendedor and pe_empresa = ct_empresa and pe_vendedor = 'S') as ct_vendedor,
                (SELECT pe_id FROM pessoas where pe_cod = ct_cliente_forn and pe_empresa = ct_empresa and pe_cliente = 'S') as ct_cliente_forn_id, 
                (select dc_descricao from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa) as ct_tipdoc, ct_obs
                from    contas      where ct_id = $ct_id;";

        $query = mysqli_query($conexao, $sql);
        
        while ($row = mysqli_fetch_assoc($query)) {
               array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'ct_empresa' => $row['ct_empresa'],
                'em_fanta' => utf8_encode($row['em_fanta']),
                'ct_matriz' => $row['ct_matriz'],
                'ct_emissao' =>utf8_encode($row['ct_emissao']),
                'ct_vendedor' => utf8_encode($row['ct_vendedor']),
                'ct_docto' => $row['ct_docto'],
                'ct_pagto' => utf8_encode($row['ct_pagto']),
                'ct_valorpago' => $row['ct_valorpago'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],
                'ct_cliente_forn_id' => $row['ct_cliente_forn_id'],
                'ct_nome' => utf8_encode($row['ct_nome']),
                'ct_vencto' => utf8_encode($row['ct_vencto']),
                'ct_valor' => $row['ct_valor'],
                'ct_parc' => $row['ct_parc'],
                'ct_tipdoc' => utf8_encode($row['ct_tipdoc']),
                'ct_obs' =>  utf8_encode($row['ct_obs']),
               ));
        };
        
        //echo $sql;
        return $retorno;
    }

    function buscarContasPorID($conexao, $ct_id){
        $retorno = array();
        $sql =  "SELECT ct_id, ct_empresa, (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, 
                ct_matriz, ct_docto, ct_cliente_forn, ct_idlocal, ct_nome, ct_vencto, ct_valor, ct_parc, ct_tipdoc, ct_obs, 
                (SELECT pe_id FROM pessoas where pe_cod = ct_cliente_forn and pe_empresa = ct_empresa and pe_cliente = 'S') as ct_cliente_forn_id,
                (select dc_sigla from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa) as dc_sigla
                from contas where (ct_nome, ct_matriz) in (select ct_nome, ct_matriz from contas where ct_id = $ct_id) 
                and ct_receber_pagar = 'R' and ct_quitado = 'N' order by ct_vencto;";

        $query = mysqli_query($conexao, $sql);
        
        while ($row = mysqli_fetch_assoc($query)) {
               array_push($retorno, array(
                'ct_id' => $row['ct_id'],
                'ct_empresa' => $row['ct_empresa'],
                'em_fanta' => utf8_encode($row['em_fanta']),
                'ct_matriz' => $row['ct_matriz'],
                'ct_docto' => $row['ct_docto'],
                'ct_idlocal' => $row['ct_idlocal'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],
                'ct_cliente_forn_id' => $row['ct_cliente_forn_id'],
                'ct_nome' => utf8_encode($row['ct_nome']),
                'ct_vencto' => $row['ct_vencto'],
                'ct_valor' => $row['ct_valor'],
                'ct_parc' => $row['ct_parc'],
                'ct_tipdoc' => $row['ct_tipdoc'],
                'ct_obs' => utf8_encode($row['ct_obs']),
                'dc_sigla' => utf8_encode($row['dc_sigla']),
               ));
        };
        
        //echo $sql;
        return $retorno;
    }

    function totalContasReceberPagar($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado){

        
        $retorno = array();

        array_push($retorno, array(
            'ct_valorVencida'=> totalContasReceberVencidas($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado),
            'ct_valorHoje' => totalContasReceberVencidasHoje($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado),
            'ct_valorAvencer' => totalContasReceber_A_Vencer($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado)
        ));

        return $retorno;
    }

    function totalContasRecebidasPagas($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto,  $ct_receber_pagar, $quitado){
        $retorno = array();

        array_push($retorno, array(
            'ct_valorpago'=> totalContasRecebidasList($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto,  $ct_receber_pagar, $quitado),
            
        ));

        return $retorno;
    }

    function totalContasReceberVencidas($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado){
        //$retorno = array();

        $sql = "SELECT sum(ct_valor) as ct_valorVencida FROM zmpro.contas where ct_matriz = $empresa_matriz $ct_empresa $ct_canc $ct_cliente_forn  $ct_vencto and ct_receber_pagar = '$ct_receber_pagar' and ct_quitado= '$quitado' and ct_vencto < current_date();";
        
        $query = mysqli_query($conexao,$sql);

        $row = mysqli_fetch_assoc($query);

        $ct_valorVencida = $row['ct_valorVencida'];

        if ($ct_valorVencida == null) {
            $ct_valorVencida = 0.00;
        }
        return $ct_valorVencida;
    }

    function totalContasReceberVencidasHoje($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado){
        //$retorno = array();

        $sql = "SELECT sum(ct_valor) as ct_valorHoje FROM zmpro.contas where ct_matriz = $empresa_matriz $ct_empresa $ct_canc $ct_cliente_forn  $ct_vencto and ct_receber_pagar = '$ct_receber_pagar' and ct_quitado= '$quitado' and ct_vencto = current_date();";

        $query = mysqli_query($conexao,$sql);

        $row = mysqli_fetch_assoc($query);

        $ct_valor= $row['ct_valorHoje'];

        if ($ct_valor == null) {
            $ct_valor= 0.00;
        }
        return  $ct_valor;
    }

    function totalContasReceber_A_Vencer($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto, $ct_receber_pagar, $quitado){
        //$retorno = array();

        $sql = "SELECT sum(ct_valor) as ct_valorAvencer FROM zmpro.contas where ct_matriz = $empresa_matriz $ct_empresa $ct_canc $ct_cliente_forn  $ct_vencto and ct_receber_pagar = '$ct_receber_pagar' and ct_quitado= '$quitado' and ct_vencto > current_date();";

        $query = mysqli_query($conexao,$sql);

        $row = mysqli_fetch_assoc($query);

        $ct_valorAvencer = $row['ct_valorAvencer'];

        if ($ct_valorAvencer == null) {
            $ct_valorAvencer = 0.00;
        }
        return $row['ct_valorAvencer'];
    }

    function totalContasRecebidasList($conexao, $empresa_matriz, $ct_empresa, $ct_canc, $ct_cliente_forn, $ct_vencto,  $ct_receber_pagar, $quitado){
        //$retorno = array();

        $sql = "SELECT sum(ct_valorpago) as ct_valorpago FROM zmpro.contas where ct_matriz =  $empresa_matriz $ct_empresa $ct_canc $ct_cliente_forn  $ct_vencto and ct_receber_pagar = '$ct_receber_pagar' and ct_quitado= '$quitado'";

        $query = mysqli_query($conexao,$sql);

        $row = mysqli_fetch_assoc($query);

        $ct_valorVencida = $row['ct_valorpago'];

        if ($ct_valorVencida == null) {
            $ct_valorVencida = 0.00;
        }
        //echo $sql;
        return $ct_valorVencida;
    }

    /*

    baixar contas

    */

    function baixarConta($conexao, $data, $hora, $ip, $dataBaixa, $ct_valor, $us_id, $caixa, $empresa_matriz, $token, $ct_id, $lancaCaixa,$dc, $tipoDoctos,$empresa_filial){
        
        $retorno = array();

        $valor = str_replace('R','',$ct_valor);
        $valor = str_replace('$','',$valor); 
        $valor = number_format(str_replace(",",".",str_replace(".","","$valor")), 2, '.', ''); 

        $ocorrencia = ocorrencia($conexao, $empresa_matriz, $empresa_filial);

        $sql="update contas set ct_pagto = '$dataBaixa', ct_valorpago= '$valor', ct_vendbaixa = (SELECT us_cod FROM usuarios where us_id=$us_id), 
        ct_quitado = 'S' $caixa, ct_tipdoc=$tipoDoctos, ct_ocorrencia=(SELECT max(dc_ocorrencia) FROM doctos where dc_matriz =$empresa_matriz)
        where ct_matriz=(SELECT em_cod FROM empresas where em_token='$token') and ct_id = $ct_id;";

        $query=mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) <= 0) {
            array_push($retorno, array(
                'status'=> $row = 'ERROR',
                'lancaCaixa' => false
            ));

        } else {
            
            $sqlOcorrencis = 'concat("'.'Conta Baixada Ocorrencia"'. ",(SELECT max(dc_ocorrencia) FROM doctos where dc_matriz =".$empresa_matriz.')';

            if($lancaCaixa == true){
                array_push($retorno, array(
                    'status'=> $row = 'SUCCESS',
                    'lancaCaixa' => $row = lancaCaixa($conexao, $empresa_matriz, $ct_id, $dc)
                ));
                
            }else{
            
                array_push($retorno, array(
                    'status'=> $row = 'SUCCESS',
                    'lancaCaixa' => false
                ));
            }
            logSistema_Baixar_Conta_Pagar_forOcorrencia($conexao, $data, $hora, $ip, $us_id, 'Conta Baixada Ocorrencia N ', $empresa_matriz , $empresa_matriz);
        }
        //echo $sql;
    
        echo '{"result":[' . json_encode($retorno). ']}';
        
    }

    function editarContaID($conexao, $ct_id, $ct_docto, $ct_empresa, $ct_matriz, $ct_parc, $ct_vencto, $ct_valor, $ct_tipdoc, $ct_obs, $ct_cliente_forn, $id, $empresa, $data, $hora, $ip) {

        $retorno = array();

        $valor = number_format(str_replace(",",".",str_replace(".","","$ct_valor")), 2, '.', '');

        $sql = "update contas set ct_docto = '$ct_docto', ct_empresa = $ct_empresa, ct_matriz = $ct_matriz, ct_parc = '$ct_parc', ct_nome = (select pe_nome from pessoas where pe_cod = '$ct_cliente_forn' and pe_fornecedor = 'S' and pe_matriz = $ct_matriz and pe_empresa = $ct_matriz), ct_vencto = '$ct_vencto', ct_valor = '$valor', ct_obs = '$ct_obs', ct_cliente_forn = '$ct_cliente_forn' where ct_id = $ct_id;";
             
        //echo $sql;
  
        $query = mysqli_query($conexao, $sql);
        
         //echo mysqli_affected_rows($conexao);
        

        if (mysqli_affected_rows($conexao) <= 0) {
            array_push($retorno, array(
            'status'=> $row = 'ERROR',

            ));

        } else {
        
            array_push($retorno, array(
            'status'=> $row = 'SUCCESS',   
            ));

            $msg = "Conta editada N Docto. ". $ct_id;

            logSistema_forID($conexao, $data, $hora, $ip, $id, $msg, $empresa, $empresa);
 
        }

        echo '{"result":[' . json_encode($retorno). ']}';
       
    }

    function excluir($conexao, $ct_id, $token){

        $retorno = array();
        $sql="DELETE FROM contas where ct_matriz = (SELECT em_cod FROM empresas where em_token='$token') and ct_id = $ct_id;";
        $query=mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) <= 0) {
            array_push($retorno, array(
                'status'=> $row = 'ERROR',
                
            ));
            echo '{"result":[' . json_encode($retorno). ']}';
        }
        else{
            array_push($retorno, array(
                'status'=> $row = 'SUCCESS',
                
            ));
            echo '{"result":[' . json_encode($retorno). ']}';
        }

    }
      

    function verVencimento($e){
        $data = date('Y-m-d');
        $retorno =''; 
        if($e == $data){
            $retorno = 'Hoje';
        }
        else if($e < $data){
            $retorno = 'Vencido';
        }else{
            $retorno = "A Vencer";
        }
        return $retorno ;
    }
?>