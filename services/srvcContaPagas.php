<?php

require_once 'conectaPDO.php';
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
    $ct_empresa = '';
}

if(isset($_GET['listaContasPagas'])){

    $empresaMatriz = base64_decode($_GET['e']);
    $empresaFilial = base64_decode($_GET['eA']);

    //$retorno = array();

    $empresa_filial = $_GET['empresa'];
    $filtroNome = $_GET['buscaNome'];
    $dataI = $_GET['dataI'];
    $dataF = $_GET['dataF'];
    $ct_pagto = ' and ct_pagto between "'. $dataI .'" and "'. $dataF .'"';

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

    $lista = json_encode(listaContasPagas($pdo, $empresa, $ct_nome, $ct_pagto));
    echo $lista;
}

function listaContasPagas($pdo, $empresa, $ct_nome, $ct_pagto) {

    $sql = "SELECT ct_id, ct_empresa, (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, ct_rateia, ct_historico, 
            ct_matriz, ct_docto, ct_parc, ct_cliente_forn, UPPER(ct_nome) as ct_nome, ct_vencto, ct_valor, ct_pagto, ct_valorpago, ct_tipdoc, 
	        (SELECT dc_sigla FROM tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_matriz) as dc_sigla,
            (SELECT ht_descricao FROM historico where ht_cod = ct_historico and ht_empresa = ct_matriz) as ht_descricao,
            (select em_cod_local FROM empresas where em_cod = ct_empresa) as em_cod_local 
            from contas where $empresa $ct_nome $ct_pagto and ct_quitado  = 'S' and ct_receber_pagar = 'P' order by ct_pagto;";
 
    $contas =$pdo->prepare($sql);
    $contas->execute();
    $retorno = $contas->fetchAll(PDO::FETCH_ASSOC);
    //print_r ($retorno);   
	return $retorno;

}

?>