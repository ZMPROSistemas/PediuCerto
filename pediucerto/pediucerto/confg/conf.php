<?php

$producao = true;

$estabelecimento = "pediucerto";

$urlBaseImg = 'https://zmsys.com.br/';

if($producao == true){
    $urlBase = 'https://zmsys.com.br/';
    $urlAssets = 'https://zmsys.com.br/pediucerto/pediucerto/';
    $api = 'https://zmsys.com.br/pediucerto/api/';
}
else if($producao == false){
    $api = 'http://localhost/zmpro/pediucerto/api/';
    $urlBase = 'http://localhost/zmpro/';
    $urlAssets = 'http://localhost/zmpro/pediucerto/pediucerto/';
}





