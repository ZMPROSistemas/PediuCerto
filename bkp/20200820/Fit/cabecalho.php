<?php

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

$dados_empresa = buscaDadosEmpresa($conexao, $dados_usuario['us_empresa']); #busca-dados-login.php

if ($dados_empresa['em_ativo'] != 'S') {
    header("Location: login.php?login_invalido=false&usuario_ativo=true&empresa_ativa=false"); #redireciona para a pagina
    die();
}

$dados_perfil = buscaDadosPerfil($conexao, $dados_usuario['us_empresa'], $dados_usuario['us_nivel']); #busca-dados-login.php

$me_venda = $dados_perfil['vendlanctovenda'] . $dados_perfil['vendlanctovenda_i'] . $dados_perfil['vendlanctovenda_c'] . $dados_perfil['vendlanctovenda_e'];

$display = false;

?>
<!DOCTYPE html>

<html lang="pt-br" ng-app="ZMPro">

    <head>

        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-square310x310logo" content="icon_largetile.png">
        <meta name="msapplication-TileImage" content="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-270x270.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
 
        <title>ZM Pro - Administrativo</title>

        <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-180x180.png" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/mCustomScrollbar.min.css">

        <script src="js/solid.js"></script>
        <script src="js/fontawesome.min.js"></script>
    
    </head>

<body media-styles>

    <div class="wrapper">
    <!-- Sidebar  -->
        <nav id="sidebar">
<!--            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>-->
            <div class="sidebar-header" style="text-align: center;">
                    <img class="img-fluid" width="75%" src="images/LogoZMPro4.png">
            </div> 
            <div class="accordion" id="acordiao">
                <ul class="list-unstyled components">
                    <li>
                        <a href="#cadastroSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" data-target="#cadastroSubmenu" aria-controls="cadastroSubmenu">
                            <i class="fas fa-user-edit"></i>
                            <span>Cadastros</span>
                        </a>
                        <ul class="collapse list-unstyled" id="cadastroSubmenu" data-parent="#acordiao">
                            <li><a href="CadEmpresas.php?u=<?=$usuario1?>&s=<?=$senha1?>">Empresas</a></li>
                            <li><a href="CadFornecedores.php?u=<?=$usuario1?>&s=<?=$senha1?>">Fornecedores</a></li>
                            <li><a href="#">Históricos Bancários</a></li>
                            <li><a href="#">Cartões</a></li>
                            <li><a href="#">Impressoras</a></li>
                            <li><a href="CadColaboradores.php?u=<?=$usuario1?>&s=<?=$senha1?>">Colaboradores</a></li>
                            <li><a href="CadClientes.php?u=<?=$usuario1?>&s=<?=$senha1?>">Clientes</a></li>
                            <li><a href="CadProdutos.php?u=<?=$usuario1?>&s=<?=$senha1?>">Produtos</a></li> 
                        </ul>
                        <a href="#financeiroSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#financeiroSubmenu" aria-controls="financeiroSubmenu">
                            <i class="fas fa-chart-line"></i>
                            <span>Financeiro</span>
                        </a>
                        <ul class="collapse list-unstyled" id="financeiroSubmenu" data-parent="#acordiao">
                            <li><a href="#">Receber</a></li>
                            <li><a href="#">Recebido</a></li>
                            <li><a href="#">Pagar</a></li>
                            <li><a href="#">Pago</a></li>
                            <li><a href="#">Cartões a Receber</a></li>
                            <li><a href="#">Cartões Recebidos</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#caixaSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#caixaSubmenu" aria-controls="caixaSubmenu">
                            <i class="fas fa-coins"></i>
                            <span>Caixa</span>
                        </a>
                        <ul class="collapse list-unstyled" id="caixaSubmenu" data-parent="#acordiao">
                            <li><a href="#">Abrir Caixa</a></li>
                            <li><a href="#">Fechar Caixa</a></li>
                            <li><a href="#">Fechamentos Realizados</a></li>
                            <li><a href="#">Selecionar Caixa</a></li>
                            <li><a href="#">Movimentar Caixa</a></li>
                        </ul>
                        <a href="#faturamentoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#faturamentoSubmenu" aria-controls="faturamentoSubmenu">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Faturamento</span>
                        </a>
                        <ul class="collapse list-unstyled" id="faturamentoSubmenu" data-parent="#acordiao">
                            <?php
                            if (substr($me_venda, 0, 1) == 'S') {?>
                              <li><a href="FatVendas.php?u=<?=$usuario1?>&s=<?=$senha1?>">Vendas</a></li>
                            <?php
                            } ?>  
                            <li><a href="#">Nota de Saída</a></li>
                            <li><a href="#">Nota de Entrada</a></li>
                            <li><a href="#">CFOP</a></li>
                        </ul>                    
                        <a href="#ferramentasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#ferramentasSubmenu" aria-controls="ferramentasSubmenu">
                            <i class="fas fa-wrench"></i>
                            <span>Ferramentas</span>
                        </a>
                        <ul class="collapse list-unstyled" id="ferramentasSubmenu" data-parent="#acordiao">
                            <li><a href="#">Configurações</a></li>
                            <li><a href="#">Lançamento Estoque</a></li>
                            <li><a href="#">Perfil</a></li>
                            <li><a href="#">Saída de Estoque</a></li>
                            <li><a href="#">Usuários</a></li>
                        </ul>
                         <a href="#relatoriosSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed" data-target="#relatoriosSubmenu" aria-controls="relatoriosSubmenu">
                            <i class="fas fa fa-copy"></i>
                            <span>Relatórios</span>
                        </a>
                        <ul class="collapse list-unstyled" id="relatoriosSubmenu" data-parent="#acordiao">
                            <li><a href="#">Relação de Vendas</a></li>
                            <li><a href="#">Ranking de Produtos</a></li>
                            <li><a href="#">Relação de Contas</a></li>
                            <li><a href="#">Posição de Vendas</a></li>
                            <li><a href="#">Posição Estoque ($)</a></li>
                            <li><a href="#">Contagem de Estoque</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand navbar-dark sticky-top" style="background-color: black;">
                <div class="container-fluid">
                    <a class="navbar-brand mr-0 mr-md-2">
                        <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                            <i class="fas fa fa-bars"></i>
                        </button>
                    </a>
                    <div class="navbar-nav-scroll">
                        <div class="navbar-brand">
                            <span> <?=$dados_empresa["em_fanta"] ?></span>
                            <!-- <span><b>ZM </b></span>Pro -->
                        </div>
                    </div>
                    <ul class="navbar-nav flex-row ml-md-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-store"></i>
                                </button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-truck"></i>
                                </button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>">
                                <button type="button" id="sidebarCollapse" class="btn btn-outline-light btn-lg" style="border-width: 0;">
                                    <i class="fas fa fa-home"></i>
                                </button>
                             </a>
                        </li>
                    </ul>
                </div>
            </nav>