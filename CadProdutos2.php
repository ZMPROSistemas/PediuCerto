<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

if (isset($_GET['me'])) {
    $modo_edicao =base64_decode($_GET['me']);
}else{
    $modo_edicao="SSSS";
}

setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");



// Variaveis da listaPadrao.php
$tabela = "produtos"; // tabela do banco de dados
$title_nome1 = "Produtos"; // Primeiro nome no Title
$title_nome2 = "Cadastro"; // Segundo nome no Title


// Rotina de criação da grid
$json_str = '{"grid": '. 
    '[{"cabecalho":"Código","campo":"pd_cod","alinhamento":"left","mascara":"","prefixo":""},
      {"cabecalho":"Descrição","campo":"pd_desc","alinhamento":"left","mascara":"","prefixo":""},
      {"cabecalho":"Marca","campo":"pd_marca","alinhamento":"left","mascara":"","prefixo":""},
      {"cabecalho":"SubGrupo","campo":"sbp_descricao","alinhamento":"left","mascara":"","prefixo":""},
      {"cabecalho":"Val.Vista","campo":"pd_vista","alinhamento":"right","mascara":"currency","prefixo":"R$ "},
      {"cabecalho":"Ação","campo":":","alinhamento":"center"}]}';  // ação ":" = criar menu 

$jsonObj = json_decode($json_str);
$itens_grid = $jsonObj->grid;
// Final - Rotina de criação da grid

// Açoes dos itens da grid
$json_str = '{"opcoes": '. 
    '[{"item":"Visualizar","modo_edicao":""},
      {"item":"Editar"    ,"modo_edicao":"'.substr($modo_edicao, 2, 1).'"},
      {"item":"Excluir"   ,"modo_edicao":"'.substr($modo_edicao, 3, 1).'"}]}';

      
      
$jsonObj = json_decode($json_str);
$menu_grid = $jsonObj->opcoes;
// Final - Açoes dos itens da grid



 
// Final - Variaveis da listaPadrao.php

include 'listaPadrao.php';


?>