<?php
$producao = true;
$estabelecimento = "sergiuspasteis";

if($producao == true){
    $urlBaseImg = 'https://zmsys.com.br/';
    $urlBase = 'https://zmsys.com.br/';
    $urlAssets = 'https://zmsys.com.br/sergiuspasteis/pediucerto/';
    $api = 'https://zmsys.com.br/pediucerto/api/';
}
else if($producao == false){
    $api = 'http://localhost/zmpro/pediucerto/api/';
    $urlBase = 'http://localhost/zmpro/';
    $urlAssets = 'http://localhost/zmpro/sergiuspasteis/pediucerto/';
}
