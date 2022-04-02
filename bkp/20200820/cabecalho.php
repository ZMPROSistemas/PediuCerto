<!DOCTYPE html>
<?php
// modificado 04/06/2020 :: 16:16:52 - Diogo Cesar
$usuario1 = base64_encode($usuario);
$senha1 = base64_encode($senha);

$dados_usuario = buscaDadosLogin($conexao, $usuario, $senha); #busca-dados-login.php
if ($dados_usuario['us_email'] != $usuario) {
	header("Location: login.php?login_invalido=true&usuario_ativo=true&empresa_ativa=true"); #redireciona para a pagina
	die();
}

if ($dados_usuario['us_status'] != 'S') {
	header("Location: login.php?login_invalido=false&usuario_ativo=false&empresa_ativa=true"); #redireciona para a pagina
	die();
}

if ($dados_usuario['us_empresa_acesso'] == 0) {
	$dados_empresa = buscaDadosEmpresa($conexao, $dados_usuario['us_empresa']); #busca-dados-login.php
} else {
	$dados_empresa = buscaDadosEmpresa($conexao, $dados_usuario['us_empresa_acesso']); #busca-dados-login.php
}

$avisos = avisos($conexao, $dados_usuario['us_empresa']);

if($avisos['av_tipo'] == 1){
    $tipo = 'alert-success';
}
else if($avisos['av_tipo'] == 2){
    $tipo = 'alert-info';
}
else if($avisos['av_tipo'] == 3){
    $tipo = 'alert-warning';
}
else if($avisos['av_tipo'] == 4){
    $tipo = 'alert-danger';
}

$cnpj_matriz = base64_encode($dados_empresa['em_cnpj_matriz']);
$nomeEmp = utf8_encode($dados_empresa['em_razao']);
$nomeEmpFanta = utf8_encode($dados_empresa['em_fanta']);
$em_ramo = base64_encode($dados_empresa['em_ramo']);
$token = $dados_empresa['em_token'];
$logoEmp = $dados_empresa['em_logo'];
$em_cod = base64_encode($dados_empresa['em_cod']);

if ($dados_empresa['em_ativo'] != 'S') {
	header("Location: login.php?login_invalido=false&usuario_ativo=true&empresa_ativa=false"); #redireciona para a pagina
	die();
}

$empresa = base64_encode($dados_usuario['us_empresa']);
$empresa_acesso = base64_encode($dados_usuario['us_empresa_acesso']);
$us_id = base64_encode($dados_usuario['us_id']);
$us = base64_encode($dados_usuario['us_nome']);
$us_cod = base64_encode($dados_usuario['us_cod']);

$dados_perfil = buscaDadosPerfil($conexao, $dados_usuario['us_empresa'], $dados_usuario['us_nivel']); #busca-dados-login.php

$me_empresa = $dados_perfil['cadempresa'] . $dados_perfil['cadempresa_i'] . $dados_perfil['cadempresa_a'] . $dados_perfil['cadempresa_e'];

$me_empresa1 = base64_encode($me_empresa);

$me_venda = $dados_perfil['vendlanctovenda'] . $dados_perfil['vendlanctovenda_i'] . $dados_perfil['vendlanctovenda_c'] . $dados_perfil['vendlanctovenda_e'];
$me_venda1 = base64_encode($me_venda);

$me_produtos = $dados_perfil['cadprod'] . $dados_perfil['cadprod_i'] . $dados_perfil['cadprod_a'] . $dados_perfil['cadprod_e'];
$me_produtos1 = base64_encode($me_produtos);

$me_ralatorio = $dados_perfil['relrelacvd'] . $dados_perfil['relrankprod'] . $dados_perfil['relrelaccontas'] . $dados_perfil['relposvd'] . $dados_perfil['relposfinest'] . $dados_perfil['relcontest'] . $dados_perfil['relexclusoes'] . $dados_perfil['movrel_er'];
$me_ralatorio1 = base64_encode($me_ralatorio);

$me_contaReceber = $dados_perfil['vendcontasreceber'] . $dados_perfil['vendcontasreceber_i'] . $dados_perfil['vendcontasreceber_a'] . $dados_perfil['vendcontasreceber_e'];
$me_contaReceber1 = base64_encode($me_contaReceber);

$me_contaRecebidas = $dados_perfil['vendcontasrecebidas'] . $dados_perfil['vendcontasrecebidas_i'] . $dados_perfil['vendcontasrecebidas_a'] . $dados_perfil['vendcontasrecebidas_e'];
$me_contaRecebidas1 = base64_encode($me_contaReceber);

$me_compraA_Pagar = $dados_perfil['compracontapagar'] . $dados_perfil['compracontapagar_i'] . $dados_perfil['compracontapagar_a'] . $dados_perfil['compracontapagar_e'];
$me_compraA_Pagar1 = base64_encode($me_compraA_Pagar);

$me_compra_Pagas = $dados_perfil['compracontapaga'] . $dados_perfil['compracontapaga_i'] . $dados_perfil['compracontapaga_a'] . $dados_perfil['compracontapaga_e'] ;
$me_compra_Pagas1 = base64_encode($me_compra_Pagas);

$me_caixa_ab = $dados_perfil['movlanctoscaixaab'] . $dados_perfil['movlanctoscaixaab_i'] . $dados_perfil['movlanctoscaixaab_a'] . $dados_perfil['movlanctoscaixaab_e'];
$me_caixa_ab1 = base64_encode($me_caixa_ab);

$me_caixa_fc = $dados_perfil['movlanctoscaixafc'] . $dados_perfil['movlanctoscaixafc_i'] . $dados_perfil['movlanctoscaixafc_a']. $dados_perfil['movlanctoscaixafc_e'];
$me_caixa_fc1 = base64_encode($me_caixa_fc);

 
$display = false;

$UF = array(
	array("sigla" => "AC", "nome" => "Acre"),
	array("sigla" => "AL", "nome" => "Alagoas"),
	array("sigla" => "AM", "nome" => "Amazonas"),
	array("sigla" => "AP", "nome" => "Amapá"),
	array("sigla" => "BA", "nome" => "Bahia"),
	array("sigla" => "CE", "nome" => "Ceará"),
	array("sigla" => "DF", "nome" => "Distrito Federal"),
	array("sigla" => "ES", "nome" => "Espírito Santo"),
	array("sigla" => "GO", "nome" => "Goiás"),
	array("sigla" => "MA", "nome" => "Maranhão"),
	array("sigla" => "MT", "nome" => "Mato Grosso"),
	array("sigla" => "MS", "nome" => "Mato Grosso do Sul"),
	array("sigla" => "MG", "nome" => "Minas Gerais"),
	array("sigla" => "PA", "nome" => "Pará"),
	array("sigla" => "PB", "nome" => "Paraíba"),
	array("sigla" => "PR", "nome" => "Paraná"),
	array("sigla" => "PE", "nome" => "Pernambuco"),
	array("sigla" => "PI", "nome" => "Piauí"),
	array("sigla" => "RJ", "nome" => "Rio de Janeiro"),
	array("sigla" => "RN", "nome" => "Rio Grande do Norte"),
	array("sigla" => "RO", "nome" => "Rondônia"),
	array("sigla" => "RS", "nome" => "Rio Grande do Sul"),
	array("sigla" => "RR", "nome" => "Roraima"),
	array("sigla" => "SC", "nome" => "Santa Catarina"),
	array("sigla" => "SE", "nome" => "Sergipe"),
	array("sigla" => "SP", "nome" => "São Paulo"),
	array("sigla" => "TO", "nome" => "Tocantins"),
)
;

?>

<html lang="pt-br" ng-app="ZMPro" ng-cloak>

    <head>

        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=0.75">
        <meta name="msapplication-square310x310logo" content="icon_largetile.png">
        <meta name="msapplication-TileImage" content="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-270x270.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>ZM Pro - Administrativo</title>

        <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-180x180.png" />
        <link rel="stylesheet" href="css/angular-material.min.css">
        <link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/mCustomScrollbar.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.css" rel="stylesheet"/> 
       
<!--
        <script src=“js/angular.min.js”></script>
-->
        <script src="js/solid.js"></script>
        <script src="js/fontawesome.min.js"></script>


        <style>

            .btnCancelar:hover{
                background-color: #bf0000 !important;
                color:#fff;
            }

            .btnSalvar:hover{
                background-color: #279B2D !important;
                color:#fff;
            }

            /* alerta*/

            .alert{display: none;}

        .campoObrigatorio {
             background-color: rgba(250, 227, 195,1) !important;
        }
        .capoTexto{
            text-transform: capitalize;
        }
     
        .pagination>li>a, .pagination>li>span {
        position: relative;
        float: left;
        padding: 6px 12px;
        line-height: 1.42857143;
        text-decoration: none;
        color: white;
        background-color: rgba(0, 0, 0, 0.1);
        border: 1px solid transparent;
        margin-left: -1px;
    }
        md-table-pagination{
            color:#fff;
            display: flex;
        }

        md-select{
            display: block;
            margin-top: 1px;
        }
       .md-button.md-icon-button md-icon, button.md-button.md-fab md-icon {
        color: #fff;
       }
       md-table-pagination .label.ng-binding{
        display: none;
       }

       md-datepicker {
            background-color: #fff !important;
            border-radius: 5px;
            padding: -15px;
            margin-left: 10px !important;
            margin-right: 15px !important;

       }


/*
       md-datepicker, input{
        color: #fff !important;

       }
       md-datepicker, input::placeholder{
        color: #fff !important;
       }
    */
        </style>
        <!-- Fim -->

    </head>

<body media-styles>
    
    <?php if($avisos['av_mostrar']== 'S'){ ?>

    <div class="alert <?=$tipo?> col-lg-4  md-fab-bottom-right" role="alert" style="bottom:0; left: 0; width:250px; position: fixed; display: block; z-index: 9999">
        <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i>  <?=utf8_encode($avisos['av_titulo'])?></h5>
        <hr>
            <?=utf8_encode($avisos['av_descricao'])?>
    </div>

    <?php } ?>
    
    <div class="wrapper" >
    <!-- Sidebar  -->

   
        <nav id="sidebar" class="noPrint">
<!--            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>-->
            <div class="sidebar-header" style="text-align: center; background-color: transparent !important;">
               <img class="img-fluid" width="90%" src="images/LogoZMPro11.png">
            </div>
            <div class="accordion" id="acordiao">
                <ul class="list-unstyled components">
                    <li>
                        <a href="CadClientes.php?u=<?=$usuario1?>&s=<?=$senha1?>">
                            <i class="fas fa-user-friends"></i>
                            <span style="padding-left: 10px !important">Clientes</span>
                        </a>
                        <a href="CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>">
                            <i class="fas fa-user-tie"></i>
                            <span style="padding-left: 15px !important">Fornecedores</span>
                        </a>
                        <a href="#produtosSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" data-target="#produtosSubmenu" aria-controls="produtosSubmenu">
                            <i class="fas fa-box-open"></i>
                            <span style="padding-left: 10px !important">Produtos</span>
                        </a>
                        <ul class="collapse list-unstyled" id="produtosSubmenu" data-parent="#acordiao">
                            <?php
if (substr($me_produtos, 0, 1) == 'S') {?>
                                <li><a href="CadProdutos.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_produtos1?>">Cadastro de Produtos</a></li>
                            <?php
}?>
                            <li><a href="CadGrupoProd.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_produtos1?>">Grupo de Produtos</a></li>
                            <li><a href="CadSubGrupoProd.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_produtos1?>">Subgrupo de Produtos</a></li>
                            <li><a href="ProdLancaEstoque.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_produtos1?>">Lançamento de Estoque</a></li>

                            <li><a href="#">Saída de Estoque</a></li>
                            <li><a href="Balancos.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_produtos1?>">Balanços</a></li>

                            <li><a href="ProdTransfEstoque.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_produtos1?>">Transferencia de Estoque</a></li>

                            <!--li><a href="#">Altera Preços</a></li>

                            <li><a href="#">Etiquetas</a></li-->
                           
                        </ul>
                        <a href="#financeiroSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#financeiroSubmenu" aria-controls="financeiroSubmenu">
                            <i class="fas fa-chart-line"></i>
                            <span style="padding-left: 10px !important">Financeiro</span>
                        </a>
                        <ul class="collapse list-unstyled" id="financeiroSubmenu" data-parent="#acordiao">
                            <li><a href="CaixaAbrir.php?u=<?=$usuario1?>&s=<?=$senha1?>">Caixas</a></li>

<?php if (substr($me_contaReceber, 0,1) == 'S') {?>
                            <li><a href="FinLancaDespesa.php?u=<?=$usuario1?>&s=<?=$senha1?>">Lançar Despesas</a></li>
<?php } ?>

<?php if (substr($me_contaReceber, 0,1) == 'S') {?>
                            <!--li><a href="DreSimplific.php?u=<?=$usuario1?>&s=<?=$senha1?>">DRE Simplificado</a></li-->
<?php } ?>

 <?php if (substr($me_contaReceber, 0,1) == 'S') {?>
                            <li><a href="FinReceber.php?u=<?=$usuario1?>&s=<?=$senha1?>">Contas a Receber</a></li>
 <?php } ?>

 <?php if (substr($me_contaRecebidas, 0,1) == 'S') {?>                            
                            <li><a href="FinRecebidos.php?u=<?=$usuario1?>&s=<?=$senha1?>">Contas Recebidas</a></li>
<?php } ?>

<?php if (substr($me_compraA_Pagar, 0,1) == 'S') {?>
                            <li><a href="FinPagar.php?u=<?=$usuario1?>&s=<?=$senha1?>">Contas a Pagar</a></li>
<?php } ?>

<?php if (substr($me_compraA_Pagar,0,1) == 'S') {?>
                            <li><a href="FinPagas.php?u=<?=$usuario1?>&s=<?=$senha1?>">Contas Pagas</a></li>
<?php } ?>                            
                            <!--li><a href="CadCartao.php?u=<?=$usuario1?>&s=<?=$senha1?>">Cadastro de Cartões</a></li>
                            <li><a href="FinCardReceber.php?u=<?=$usuario1?>&s=<?=$senha1?>">Cartões a Receber</a></li>
                            <li><a href="FinCardRecebido.php?u=<?=$usuario1?>&s=<?=$senha1?>">Cartões Recebidos</a></li-->
                            <li><a href="historico_bancario.php?u=<?=$usuario1?>&s=<?=$senha1?>">Históricos Bancários</a></li>
                            <li><a href="despesasFixas.php?u=<?=$usuario1?>&s=<?=$senha1?>">Despesas Fixas</a></li>                            
                        </ul>
                    </li>
                    <li>
                        <a href="#caixaSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#caixaSubmenu" aria-controls="caixaSubmenu" style="display: none;">
                            <i class="fas fa-coins"></i>
                            <span style="padding-left: 10px !important">Caixa</span>
                        </a>
                        <ul class="collapse list-unstyled" id="caixaSubmenu" data-parent="#acordiao" style="display: none;">
                            <li><a href="CaixaAbrir.php?u=<?=$usuario1?>&s=<?=$senha1?>" style="display: none;">Abrir Caixa</a></li>
                            <li><a href="CaixaAbrir.php?u=<?=$usuario1?>&s=<?=$senha1?>" style="display: none;">Fechar Caixa</a></li>
                            <li><a href="#" style="display: none;">Fechamentos Realizados</a></li>
                            <li><a href="#" style="display: none;">Selecionar Caixa</a></li>
                            <li><a href="#" style="display: none;">Movimentar Caixa</a></li>
                            <li><a href="#" style="display: none;">Cadastro de Caixas</a></li>
                            <li><a href="historico.php?u=<?=$usuario1?>&s=<?=$senha1?>">Históricos Bancários</a></li>
                        </ul>
                        <a href="#faturamentoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#faturamentoSubmenu" aria-controls="faturamentoSubmenu">
                            <i class="fas fa-percent"></i>
                            <span style="padding-left: 10px !important">Faturamento</span>
                        </a>
                        <ul class="collapse list-unstyled" id="faturamentoSubmenu" data-parent="#acordiao">
                            <?php
if (substr($me_venda, 0, 1) == 'S') {?>
                              <li><a href="FatVendas.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_venda1?>">Vendas</a></li>
                              <li><a href="FatCondic.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_venda1?>">Condicionais</a></li>
                            <?php
}?>
                            <li><a href="FatNotaSaida.php?u=<?=$usuario1?>&s=<?=$senha1?>">Nota de Saída</a></li>
                            <li><a href="FatNotaEntrada.php?u=<?=$usuario1?>&s=<?=$senha1?>">Compras</a></li>
                            <!--li><a href="#">CFOP</a></li>
                            <li><a href="#">NCM</a></li-->
                        </ul>
                        <a href="#ferramentasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#ferramentasSubmenu" aria-controls="ferramentasSubmenu">
                            <i class="fas fa-wrench"></i>
                            <span style="padding-left: 10px !important">Administrativo</span>
                        </a>
                        <ul class="collapse list-unstyled" id="ferramentasSubmenu" data-parent="#acordiao">
                            <?php
if (substr($me_empresa, 0, 1) == 'S') {?>
                                <li><a href="CadEmpresas.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Empresas</a></li>
                            <?php
}?>
                            <li><a href="CadColaboradores.php?u=<?=$usuario1?>&s=<?=$senha1?>">Colaboradores</a></li>
                            <li><a href="#">Usuários do Sistema</a></li>

                            <li><a href="AdmPerfil.php?u=<?=$usuario1?>&s=<?=$senha1?>">Perfil</a></li>
                            <li><a href="#">Impressoras</a></li>
                            <li><a href="#">Log do Sistema</a></li>
                            <!--li><a href="#">Ajuda</a></li-->
                        </ul>
                         <a href="#relatoriosSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#relatoriosSubmenu" aria-controls="relatoriosSubmenu">
                            <i class="fas fa fa-copy"></i>
                            <span style="padding-left: 10px !important">Relatórios</span>
                        </a>
                        <ul class="collapse list-unstyled" id="relatoriosSubmenu" data-parent="#acordiao">

<?php if (substr($me_ralatorio, 0, 1) == 'S') {?>

                            <li><a href="relatorioVendas.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Relação de Vendas</a></li>
<?php }?>
<?php if (substr($me_ralatorio, 1, 1) == 'S') {?>
                            <li><a href="relatorio_ranking_produto.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Ranking de Produtos</a></li>
<?php }?>
<?php if (substr($me_ralatorio, 2, 1) == 'S') 
if(base64_decode($empresa) == 1){ {?>

                            <li><a href="#">Relação de Contas</a></li>
<?php }}?>
<?php if (substr($me_ralatorio, 3, 1) == 'S') {?>

                            <li><a href="relatorioPosicao_vendas.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Posição de Vendas</a></li>
<?php }?>
<?php if (substr($me_ralatorio, 4, 1) == 'S')
if(base64_decode($empresa) == 1){ {?>
    
                            <li><a href="relatorioPosicao_estoque.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Posição Estoque ($)</a></li>
<?php }}?>
<?php if (substr($me_ralatorio, 5, 1) == 'S') 
    if(base64_decode($empresa) == 1){ {?>
                            <li><a href="relatorioContagem_estoque.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Contagem de Estoque</a></li>
<?php }}?>
<?php if (substr($me_ralatorio, 6, 1) == 'S') {?>
                            <li><a href="relatorioExclusoes_sistema.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Exclusões do Sistema</a></li>
<?php }?>
<?php if (substr($me_ralatorio, 7, 1) == 'S') {?>
                            <li><a href="relatorioResultados.php?u=<?=$usuario1?>&s=<?=$senha1?>&me=<?=$me_empresa1?>">Relatório de Resultados</a></li>
<?php }?>
                        </ul> 
                    </li>
                </ul>
                <a style="padding-left: 10px !important" href="logout.php?u=<?=$usuario1?>&s=<?=$senha1?>&login=true">
                    <i class="fas fa-power-off"></i>
                    <span style="padding-left: 10px !important">Desconectar</span>
                </a>
            </div>
        </nav>

        <div id="content">

            <div show-on-mobile class="noPrint">
                <md-content>
                    <md-toolbar class="md-hue-2 site-content-toolbar"  layout="row" md-theme="site-toolbar" style="background-color: black;">
                        <div class="md-toolbar-tools">
                            <a class="navbar-brand">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-bars"></i>
                                </button>
                            </a>
                            <h2 flex md-truncate><span> <?=utf8_encode($dados_empresa["em_fanta"])?></span></h2>
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline-light btn-lg p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="">PDV</a>
                                    <a class="dropdown-item" href="">Pedidos</a>
                                    <a class="dropdown-item" href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>">Início</a>
                                </div>
                            </div>
                        </div>
                    </md-toolbar>
                </md-content>
            </div>

            <div show-on-tablet class="noPrint">
                <md-content>
                    <md-toolbar class="md-hue-2 site-content-toolbar"  layout="row" md-theme="site-toolbar" style="background-color: black;">
                        <div class="md-toolbar-tools">
                            <a class="navbar-brand">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-bars"></i>
                                </button>
                            </a>
                            <h2 flex md-truncate><span> <?=utf8_encode($dados_empresa["em_fanta"])?></span></h2>
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline-light btn-lg p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-width: 0;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="">PDV</a>
                                    <a class="dropdown-item" href="">Pedidos</a>
                                    <a class="dropdown-item" href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>">Início</a>
                                </div>
                            </div>
                        </div>
                    </md-toolbar>
                </md-content>
            </div>

            <div show-on-laptop class="noPrint">
                <md-content>
                    <md-toolbar class="md-hue-2 site-content-toolbar"  layout="row" md-theme="site-toolbar" style="background-color: black;">
                        <div class="md-toolbar-tools">
                            <a class="navbar-brand">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-bars"></i>
                                </button>
                            </a>
                            <h2 flex md-truncate><span> <?=utf8_encode($dados_empresa["em_fanta"])?></span></h2>
                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                <i class="fas fa fa-store"></i>
                            </a>
                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                <i class="fas fa fa-truck"></i>
                            </a>
                            <a type="button" href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                <i class="fas fa fa-home"></i>
                            </a>
                        </div>
                    </md-toolbar>
                </md-content>
            </div>

            <div show-on-desktop class="noPrint">
                <md-content>
                    <md-toolbar class="md-hue-2 site-content-toolbar"  layout="row" md-theme="site-toolbar" style="background-color: black;">
                        <div class="md-toolbar-tools">
                            <a class="navbar-brand">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-bars"></i>
                                </button>
                            </a>
                            <h2 flex md-truncate><span> <?=utf8_encode($dados_empresa["em_fanta"])?></span></h2>
                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                <i class="fas fa fa-store"></i>
                            </a>
                            <a type="button" href="#" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                <i class="fas fa fa-truck"></i>
                            </a>
                            <a type="button" href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>&login=true" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                <i class="fas fa fa-home"></i>
                            </a>
                        </div>
                    </md-toolbar>
                </md-content>
            </div>
            <div class="float-right noPrint" style="margin-right: 15px; color:#D8D8D8FF; margin-bottom: -20px; top; font-size: 0.8em;">Bem vindo <b><?=utf8_encode($dados_usuario['us_fantasia'])?></b></div>
