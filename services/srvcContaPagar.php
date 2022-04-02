<?php

require_once 'conectaPDO.php';
include 'conecta.php';
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
        $ct_empresa = ' and ct_empresa = ' . $empresa_filial;
    }else{
        $ct_empresa = ' ';
    }
    
}else{
    $empresa_filial = 0;
    $ct_empresa = '';
}


if(isset($_GET['listaContasPagar'])){

    $empresaMatriz = base64_decode($_GET['e']);
    $empresaFilial = base64_decode($_GET['eA']);

    //$retorno = array();

    $empresa_filial = $_GET['empresa'];
    $filtroNome = $_GET['buscaNome'];
    $filtroDocto = $_GET['buscaDocto'];

    if ($empresa_filial == '') {
        $empresa = 'ct_matriz = ' . $empresaMatriz;
    } else {   
        $empresa = 'ct_empresa = ' . $empresa_filial;
    }    

    if ($filtroNome == '') {
        $ct_nome = '';
    } else {   
        $ct_nome = ' and ct_nome like "%' . $filtroNome . '%"';
    }    

    if ($filtroDocto == '') {
        $ct_docto = '';
    } else {   
        $ct_docto = ' and ct_docto like "%' . $filtroDocto . '%"';
    }    

    $lista = json_encode(listaContasPagar($pdo, $empresa, $ct_nome, $ct_docto));
    echo $lista;
}

if (isset($_GET['us_id'])) {
    $us_id = $_GET['us_id'];
}else{
    $us_id = null;
}
if (isset($_GET['token'])) {
    $token = $_GET['token'];
}

if (isset($_GET['proximoDocto'])) {

    $empresa = base64_decode($_GET['empresa_matriz']);

    $docto = $pdo->prepare("SELECT max(ct_docto) + 1 as ct_docto FROM contas where ct_matriz = $empresa;");
    $docto->execute();
    $retorno = $docto->fetch();
    print_r($retorno[0]);
    return $retorno[0];

}

if (isset($_GET['buscarContaPagarID'])) {

    $ct_id = $_GET['ct_id'];
    $lista = json_encode(buscarContaPagarId($pdo, $ct_id));
    echo $lista;
}

if (isset($_GET['baixarConta'])) {
    
    $array = json_decode(file_get_contents("php://input"), true);
    $conta = $array['contas'][0];
    $lancaCaixa = $array['lancaCaixa'];
    $valData = $array['valData'];
    
    if($lancaCaixa['caixa'] != 0){
        $caixa = ', ct_caixa= ' . $lancaCaixa['caixa'];
    }else{
        $caixa ='';
    }

    $dc ='D';
    
    baixarConta($conexao, $data, $hora, $ip, date('Y-m-d', strtotime($valData['dataBaixa'])), $conta['ct_valor'], $us_id, $caixa, $empresa_matriz, $token, $conta['ct_id'], $lancaCaixa['statusCheck'], $dc, $valData['tipoDoctos'], $empresa_filial, $conta['ct_rateia']);
    
}

if(isset($_GET['excluirConta'])){

    $empresa = base64_decode($_GET['empresa_matriz']);
    $ct_id = $_GET['ct_id'];
    $ct_rateia = $_GET['ct_rateia'];
    excluirContaPagar($conexao, $pdo, $ct_id, $ct_rateia, $data, $hora, $ip, $us_id, $empresa);
}

if(isset($_GET['dadosFornecedor'])){

    $empresa = base64_decode($_GET['e']);
    $fornecedor = $_GET['cliente_fornecedor'];

    if ($fornecedor == '') {
        $pe_cod = '';
    } else {   
        $pe_cod = ' and pe_cod = '. $fornecedor;
    }    
    $lista = json_encode(listaFornecedorEmpresa($pdo, $empresa, $pe_cod));
    echo $lista;

}

if (isset($_GET['editarConta'])) {
 
    $array = json_decode(file_get_contents("php://input"), true); 
    $id = base64_decode($_GET['us_id']);
    $empresa = base64_decode($_GET['e']);

    $editarConta = $array['editarConta'][0];
        
    editarContaID($conexao, $editarConta['ct_id'], $editarConta['ct_docto'], $editarConta['ct_empresa'], $editarConta['ct_matriz'], $editarConta['ct_parc'], date('Y-m-d', strtotime($editarConta['ct_vencto'])), $editarConta['ct_valor'], $editarConta['ct_obs'], $editarConta['ct_cliente_forn'], $id, $empresa, $data, $hora, $ip);

}

function listaContasPagar($pdo, $empresa, $ct_nome, $ct_docto) {

    $sql = "SELECT ct_id, ct_empresa, (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, ct_rateia, ct_historico,
            ct_matriz, ct_docto, ct_parc, ct_cliente_forn, UPPER(ct_nome) as ct_nome, ct_vencto, ct_valor, ct_tipdoc, 
	        (SELECT dc_sigla FROM tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_matriz ) as dc_sigla,
            (SELECT ht_descricao FROM historico where ht_cod = ct_historico and ht_empresa = ct_matriz) as ht_descricao,
            (select em_cod_local FROM empresas where em_cod = ct_empresa) as em_cod_local  
            from contas where $empresa $ct_nome $ct_docto and ct_quitado  = 'N' and ct_receber_pagar = 'P' and ct_canc <> 'S' order by ct_vencto;";
 
    $contas =$pdo->prepare($sql);
    $contas->execute();
    $retorno = $contas->fetchAll(PDO::FETCH_ASSOC);
    //print_r ($retorno);   
	return $retorno;

}

function listaFornecedorEmpresa($pdo, $empresa, $pe_cod) {

    $sqlForn = "SELECT pe_id, pe_cod, pe_empresa, pe_matriz, UPPER(pe_nome) as pe_nome, pe_endereco  
                from pessoas where pe_fornecedor = 'S' and pe_ativo != 'N' 
                and pe_matriz = $empresa $pe_cod order by pe_nome;";
 
    $fornec =$pdo->prepare($sqlForn);
    //echo $sql;
    $fornec->execute();
    $retornoForn = $fornec->fetchAll(PDO::FETCH_ASSOC);
    //print_r ($retornoForn);   
	return $retornoForn;

}

function buscarContaPagarID($pdo, $ct_id) {

    $sqlID =  "SELECT  ct_id, ct_empresa, ct_matriz, ct_docto, ct_cliente_forn, UPPER(ct_nome) as ct_nome, ct_vencto, 
            FORMAT(ct_valor,2,'pt_BR') as ct_valor, ct_parc, ct_rateia,
            (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, DATE_FORMAT(ct_pagto, '%d/%m/%Y') as ct_pagto, 
            FORMAT(ct_valorpago,2,'pt_BR') as ct_valorpago, DATE_FORMAT(ct_emissao, '%d/%m/%Y') as ct_emissao, 
            (select pe_nome from pessoas where pe_cod = ct_vendedor and pe_empresa = ct_empresa and pe_vendedor = 'S') as ct_vendedor,
            (SELECT pe_id FROM pessoas where pe_cod = ct_cliente_forn and pe_empresa = ct_empresa and pe_cliente = 'S') as ct_cliente_forn_id, 
            (select dc_descricao from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_matriz) as ct_tipdoc, ct_obs
            from  contas where ct_id = $ct_id;";

    $contaID =$pdo->prepare($sqlID);
    $contaID->execute();
    $retorno = $contaID->fetchAll(PDO::FETCH_ASSOC);
    //print_r ($retorno);   
    return $retorno;

}

function baixarConta($conexao, $data, $hora, $ip, $dataBaixa, $ct_valor, $us_id, $caixa, $empresa_matriz, $token, $ct_id, $lancaCaixa, $dc, $tipoDoctos, $empresa_filial, $ct_rateia){
        
    $retorno = array();

    $valor = str_replace('R','',$ct_valor);
    $valor = str_replace('$','',$valor); 
    $valor = number_format(str_replace(",",".",str_replace(".","","$valor")), 2, '.', ''); 

    $ocorrencia = ocorrencia($conexao, $empresa_matriz, $empresa_filial);

    $sql="UPDATE contas set ct_pagto = '$dataBaixa', ct_valorpago= '$valor', ct_vendbaixa = (SELECT us_cod FROM usuarios where us_id = $us_id), 
        ct_quitado = 'S' $caixa, ct_tipdoc=$tipoDoctos, ct_ocorrencia=(SELECT max(dc_ocorrencia) FROM doctos where dc_matriz = $empresa_matriz)
        where ct_matriz=(SELECT em_cod FROM empresas where em_token ='$token') and ct_id = $ct_id;";

    $query=mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) <= 0) {
        array_push($retorno, array(
            'status'=> $row = 'ERROR',
            'lancaCaixa' => false
        ));

    } else {
        
        $sqlOcorrencis = 'concat("'.'Conta Baixada Ocorrencia"'. ",(SELECT max(dc_ocorrencia) FROM doctos where dc_matriz =".$empresa_matriz.')';

        if ($ct_rateia == 'S') {

            $sqlRateia = "UPDATE rateio_contas set rc_pagto = '$dataBaixa', rc_pago = 'S' where rc_idconta = $ct_id;";
            $queryRateia = mysqli_query($conexao, $sqlRateia);
        }

        if($lancaCaixa == true){
            array_push($retorno, array(
                'status'=> $row = 'SUCCESS',
                'lancaCaixa' => $row = lancaCaixa($conexao, $empresa_filial, $ct_id, $dc)
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

function excluirContaPagar($conexao, $pdo, $ct_id, $ct_rateia, $data, $hora, $ip, $us_id, $empresa_matriz){

    $sqlExcluir = "DELETE FROM contas where ct_id = $ct_id;";
    $queryPDO = $pdo->prepare($sqlExcluir);
    $queryPDO->execute();
    $retorno = $queryPDO->rowCount();

    if ($retorno > 0) {
        if ($ct_rateia == 'S') {
            $queryRateia = $pdo->prepare("DELETE FROM rateio_contas where rc_idconta = $ct_id;");
            $queryRateia->execute();
            $retorno = $queryRateia->rowCount();
        }
    }
    logSistema_Baixar_Conta_Pagar_forOcorrencia($conexao, $data, $hora, $ip, $us_id, 'Conta Excluida Ocorrencia N ', $empresa_matriz, $empresa_matriz);

    return $retorno;
}

function editarContaID($conexao, $ct_id, $ct_docto, $ct_empresa, $ct_matriz, $ct_parc, $ct_vencto, $ct_valor, $ct_obs, $ct_cliente_forn, $id, $empresa, $data, $hora, $ip) {

    $retorno = array();

    $valor = number_format(str_replace(",",".",str_replace(".","","$ct_valor")), 2, '.', '');

    $sql = "UPDATE contas set ct_docto = '$ct_docto', ct_empresa = $ct_empresa, ct_matriz = $ct_matriz, ct_parc = '$ct_parc', ct_nome = (select pe_nome from pessoas where pe_cod = '$ct_cliente_forn' and pe_fornecedor = 'S' and pe_matriz = $ct_matriz and pe_empresa = $ct_matriz), ct_vencto = '$ct_vencto', ct_valor = '$valor', ct_obs = '$ct_obs', ct_cliente_forn = '$ct_cliente_forn', ct_rateia = 'N' where ct_id = $ct_id;";
         
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

?>