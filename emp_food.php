<?php

include 'varInicio.php';
include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

setlocale(LC_ALL, 'pt_BR.utf-8');
date_default_timezone_set('America/Bahia');

$data = date("d/m/Y H:i:s");

?>

<style>


</style>

<div ng-controller="ZMProCtrl">	
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-0">
            <li class="breadcrumb-item"><a href="inicio.php?u=<?=$usuario1?>&s=<?=$senha1?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item" aria-current="page">Administrativo</li>
            <li class="breadcrumb-item active" aria-current="page">Colaboradores</li>
        </ol>
    </nav>
</div>