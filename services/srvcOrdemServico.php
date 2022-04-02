<?php

require_once 'conectaPDO.php';

$empresaMatriz = base64_decode($_GET['e']);
$empresaFilial = base64_decode($_GET['eA']);

$empresa_Filial = $_GET['empresa'];

if ($empresa_Filial == '') {
    $empresa = $empresaMatriz;
} else {   
    $empresa = $empresa_Filial;
}    

if (isset($_GET['listaOS'])) {

    //$dataI = $_GET['dataI'];
    //$dataF = $_GET['dataF'];
    /*if ($dataI != '' && $dataF != '') {
        $os_data = ' and os_data between "'. $dataI .'" and "'. $dataF .'"';
    } else {*/
    //$os_data = '';
    //}

    $filtroNome = $_GET['nome'];
    if ($filtroNome != '') {
        $os_nome = ' and os_nome like "%' . $filtroNome . '%"';
    } else {
        $os_nome = '';
    }

    $filtroDocto = $_GET['pedido'];
    if ($filtroDocto != '') {
        $os_voltagem = ' and os_voltagem like "%' . $filtroDocto . '%"';
    } else {
        $os_voltagem = '';
    }

    /*$situacaoOS = $_GET['situacao'];
    if ($situacaoOS != '') {
        $os_voltagem = ' and os_voltagem like "%' . $filtroDocto . '%"';
    } else {
        $os_voltagem = '';
    }*/
    
    $lista = '{"result":[' . json_encode(listaOS($pdo, $empresa, $os_nome, $os_voltagem)) . ']}';
    echo $lista;

}

if (isset($_GET['listaContaReceber'])) {

    $fornecedor = $_GET['fornecedor'];
    if ($fornecedor != '') {
        $ct_cliente_forn = ' and ct_cliente_forn = '. $fornecedor;
    } else {
        $ct_cliente_forn = '';
    }

    $lista = '{"result":[' . json_encode(listaContasReceberFast($pdo, $empresa, $ct_cliente_forn)) . ']}'; 
    echo $lista;

}

function listaOS($pdo, $empresa, $os_nome, $os_voltagem) {
    
    $retorno = array();
    
    $sql = "SELECT t1.os_num, t1.os_voltagem, t1.os_data, t1.os_cliente, t1.os_nome, t1.os_total, t1.os_empresa, 'Aberta' as situacao,
            if ((select max(ct_bloq) from contas where ct_docto = t1.os_num and ct_empresa = t1.os_empresa) is null, (select max(ct_bloq) from contas where ct_docto = t1.os_num and ct_empresa = t1.os_empresa),
            (select max(ct_bloq) from contas where ct_docto = t1.os_num and ct_empresa = t1.os_empresa)) AS bloq,
            (select max(ct_quitado) from contas where ct_docto = t1.os_num and ct_empresa = t1.os_empresa) AS quitado,
            if((select min(ct_vencto) from contas where ct_docto = t1.os_num and ct_empresa = t1.os_empresa) < current_date(),'SIM','NÃO') AS atrasado
            from os_aberta t1 where t1.os_empresa = :empresa $os_nome $os_voltagem
            union all
            select t2.os_num, t2.os_voltagem, t2.os_data, t2.os_cliente, t2.os_nome, t2.os_total, t2.os_empresa, 'Fechada' as situacao,
            if((select max(ct_bloq) from contas where ct_docto = t2.os_num and ct_empresa = t2.os_empresa) is null, (select max(ct_bloq) from contas where ct_docto = t2.os_num and ct_empresa = t2.os_empresa),
            (select max(ct_bloq) from contas where ct_docto = t2.os_num and ct_empresa = t2.os_empresa)) AS bloq,
            (select max(ct_quitado) from contas where ct_docto = t2.os_num and ct_empresa = t2.os_empresa) AS quitado,
            if((select min(ct_vencto) from contas where ct_docto = t2.os_num and ct_empresa = t2.os_empresa) < current_date(),'SIM','NÂO') AS atrasado
            from os_fechada t2 where t2.os_empresa = :empresa $os_nome $os_voltagem order by 1,2;";
    
    $listaOS =$pdo->prepare($sql);
        //echo $sql;
        $listaOS->bindValue(":empresa", $empresa);
        $listaOS->execute();
        $retorno = $listaOS->fetchAll(PDO::FETCH_ASSOC);
   
	return $retorno;
}

function listaContasReceberFast($pdo, $empresa, $ct_cliente_forn){
        
    $lista = array();

    $sql = "SELECT ct_id, ct_empresa, ct_docto, ct_cliente_forn, ct_valor, ct_emissao, (select dc_sigla from tipo_docto where dc_codigo = ct_tipdoc and dc_empr = ct_empresa) as ct_tipdoc, UPPER(ct_nome) as ct_nome, ct_vencto, ct_parc FROM contas where ct_empresa = :empresa $ct_cliente_forn and ct_receber_pagar = 'R' and ct_quitado = 'N' and ct_tipolancto = 'OS' order by ct_vencto;";

    $contas=$pdo->prepare($sql);
    //echo $sql;
    $contas->bindValue(":empresa", $empresa);
    $contas->execute();
    $lista = $contas->fetchAll(PDO::FETCH_ASSOC);
         
    //echo $sql;
    return $lista;
}

?>
