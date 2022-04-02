<?php

require_once 'conectaPDO.php';
//include 'log.php';
//include 'ocorrencia.php';
//include 'getIp.php';

date_default_timezone_set('America/Bahia');

//$ip = get_client_ip();
//$data = date('Y-m-d');
$hora = date('H:i:s');
$empresaMatriz = base64_decode($_GET['e']);
$empresaFilial = base64_decode($_GET['eA']);

if(isset($_GET['listaContasPagar'])){

    //$retorno = array();

    $empresa_filial = $_GET['empresa'];
    $filtro = $_GET['buscaNome'];

    if ($empresa_filial == '') {
        $empresa = 'ct_matriz = ' . $empresaMatriz;
    } else {   
        $empresa = 'ct_empresa = ' . $empresa_filial;
    }    

    if ($filtro == '') {
        $ct_nome = '';
    } else {   
        $ct_nome = ' and ct_nome like "%' . $filtro . '%"';
    }    

    $lista = json_encode(listaContasPagar($pdo, $empresa, $ct_nome));
    echo $lista;
}

function listaContasPagar($pdo, $empresa, $ct_nome) {

    $sql = "SELECT ct_id, ct_empresa, (select em_fanta FROM empresas where em_cod = ct_empresa) as em_fanta, 
            ct_matriz, ct_docto, ct_parc, ct_cliente_forn, UPPER(ct_nome) as ct_nome, ct_vencto, ct_valor, ct_tipdoc, 
	        (SELECT dc_sigla FROM tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa ) as dc_sigla
            from contas where $empresa $ct_nome and ct_quitado  = 'N' and ct_receber_pagar = 'P' and ct_canc <> 'S' order by ct_vencto;";
 
    $contas =$pdo->prepare($sql);
    $contas->execute();
    $retorno = $contas->fetchAll(PDO::FETCH_ASSOC);
    //print_r ($retorno);   
	return $retorno;

}


?>