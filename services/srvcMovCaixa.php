<?php

require_once 'conectaPDO.php';

date_default_timezone_set('America/Bahia');

$empresaMatriz = base64_decode($_GET['e']);
$empresaFilial = base64_decode($_GET['eA']);

$empresa_Filial = $_GET['empresa'];

if ($empresa_Filial == '') {
    $empresa = ' cx_matriz = ' . $empresaMatriz;
} else {   
    $empresa = ' cx_empresa = ' . $empresa_Filial;
}    

if(isset($_GET['bc_id'])){
    $bcaixa_id = base64_decode($_GET['bc_id']);

    if($bcaixa_id == null or $bcaixa_id == '' or $bcaixa_id == 0){
        $bc_id='';
    }else{
        $bc_id = ' and bc_id= ' .$bcaixa_id;
    }
}else{
    $bc_id='';
}

if (isset($_GET['bc_cod_func'])) {

    $bc_cod_func = base64_decode($_GET['bc_cod_func']);

    // EM 10/11/2020, MICHEL DISSE PARA NÃO FAZER FILTRO PELO FUNCIONÁRIO PARA NÃO DAR PROBLEMA COM O SINCRONIZA

    /*if ($bc_cod_func == '' or $bc_cod_func == null) {
        $cod_func = '';
    }
    else if($empresaAcesso == 0){
        $cod_func = " and bc_cod_func = " . $bc_cod_func;
    } else {
        $cod_func = " and bc_cod_func = " . $bc_cod_func . ' and bc_empresa = ' . $empresaAcesso;
    }
} else {*/
    $cod_func = '';
}

if (isset($_GET['listaCaixas'])) {

    if ($empresa_Filial == '') {
        $empresa = ' bc_matriz = ' . $empresaMatriz;
    } else {   
        $empresa = ' bc_empresa = ' . $empresa_Filial;
    } 

    $lista = '{"result":[' . json_encode(listaCaixas($pdo, $empresa)) . ']}';
    echo $lista;

}



if (isset($_GET['movCaixaAberto'])) {
    if ($empresa_Filial == '') {
        $empresa = ' cx_matriz = ' . $empresaMatriz;
    } else {   
        $empresa = ' cx_empresa = ' . $empresa_Filial;
    } 
    $caixa = $_GET['caixa'];
    $cx_banco = ' and cx_banco = ' . $caixa;
	
    $lista = '{"result":[' . json_encode(listaMovCaixaAberto($pdo, $empresa, $cx_banco)) . ']}';
    echo $lista;

}

if (isset($_GET['movCaixaFechado'])) {

    $caixa = $_GET['caixa'];
    $dataI = $_GET['dataI'];
    $dataF = $_GET['dataF'];
    $cx_emissao = ' and cx_emissao between "'. $dataI .'" and "'. $dataF .'"';
    $cx_banco = ' and cx_banco = ' . $caixa;
	
    $lista = '{"result":[' . json_encode(listaMovCaixaFechado($pdo, $empresa, $cx_banco, $cx_emissao)) . ']}';
    echo $lista;

}

if (isset($_GET['verificaCaixa'])) {
    
    $empresa_Filial = $_GET['empresa'];
    $situacao = $_GET['situacao'];
    if ($situacao == 'A') { $situacao = '  and bc_situacao = "Aberto"';} 
    else if ($situacao == 'F') { $situacao = ' and bc_situacao = "Fechado"';}
    else { $situacao = '';}

    if ($empresa_Filial == '') {
        $empresa = ' bc_matriz = ' . $empresaMatriz;
    } else {   
        $empresa = ' bc_empresa = ' . $empresa_Filial;
    }  
    $lista = '{"result":[' . json_encode(caixasAbertos($pdo, $empresa, $situacao)) . ']}';
    echo $lista;

}

function listaCaixas($pdo, $empresa) {

	$retornoLC = array();

		$sqlLista = "SELECT bc_id, bc_codigo, bc_empresa, (select UPPER(em_fanta) FROM empresas where em_cod = bc_empresa) as em_fanta, 
                    bc_matriz, bc_cod_func, UPPER(bc_descricao) as bc_descricao, UPPER(bc_situacao) as bc_situacao, bc_data, bc_caixa 
	                FROM bancos where $empresa and bc_caixa = 'S' order by em_fanta;";

        $listacx =$pdo->prepare($sqlLista);
        $listacx->bindValue(":empresa", $empresa);
        $listacx->execute();
        $retornoLC = $listacx->fetchAll(PDO::FETCH_ASSOC);

    return $retornoLC;
	
}


function listaMovCaixaAberto($pdo, $empresa, $cx_banco) {
    
    $retornoMCA = array();
    
    $sqlMCA="SELECT cx_id, cx_docto, cx_emissao, cx_historico, (select ht_descricao from historico where ht_cod = cx_historico and ht_empresa = cx_empresa) as ht_descricao, 
    cx_tpdocto, (select dc_sigla from tipo_docto where dc_codigo = cx_tpdocto and dc_empr = cx_empresa) as dc_sigla, 
    cx_dc, cx_nome, cx_obs, cx_valor, cx_banco FROM caixa_aberto where $empresa $cx_banco order by cx_id;";
    
        $cxaberto =$pdo->prepare($sqlMCA);
        //echo $sqlMCA;
        $cxaberto->bindValue(":empresa", $empresa);
        $cxaberto->execute();
        $retornoMCA = $cxaberto->fetchAll(PDO::FETCH_ASSOC);
   
	return $retornoMCA;
}

function listaMovCaixaFechado($pdo, $empresa, $cx_banco, $cx_emissao) {
    
    $retorno = array();
    
    $sql = "SELECT cx_id, cx_docto, cx_emissao, cx_historico, (select ht_descricao from historico where ht_cod = cx_historico and ht_empresa = cx_empresa) as ht_descricao, 
            cx_tpdocto, (select dc_sigla from tipo_docto where dc_codigo = cx_tpdocto and dc_empr = cx_empresa) as dc_sigla, 
            cx_dc, cx_nome, cx_obs, cx_valor, cx_banco FROM caixa_fechado where $empresa $cx_emissao $cx_banco order by cx_id; ";
    
    $excecao =$pdo->prepare($sql);
        //echo $sql;
        $excecao->bindValue(":empresa", $empresa);
        $excecao->execute();
        $retorno = $excecao->fetchAll(PDO::FETCH_ASSOC);
   
	return $retorno;
}

function caixasAbertos($pdo, $empresa, $situacao) {
    
    $caixas = array();
    
    $sql="SELECT bc_codigo, bc_empresa, bc_descricao, bc_saldo, bc_saldoanterior, bc_saldocontabil 
    FROM bancos where $empresa and bc_caixa = 'S' $situacao;";
    
        $caixasAbertos =$pdo->prepare($sql);
        //echo $empresa;
        //$caixasAbertos->bindValue(":situacao", $situacao);
        $caixasAbertos->execute();
        $caixas = $caixasAbertos->fetchAll(PDO::FETCH_ASSOC);
   
	return $caixas;
}

?>
