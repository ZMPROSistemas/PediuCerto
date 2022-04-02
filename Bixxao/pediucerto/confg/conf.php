<?php

$producao = true;

$estabelecimento = "Bixxao";

$urlBaseImg = 'https://zmsys.com.br/';

if($producao == true){
    $urlBase = 'https://zmsys.com.br/';
    $urlAssets = 'https://zmsys.com.br/Bixxao/pediucerto/';
    $api = 'https://zmsys.com.br/pediucerto/api/';
}
else if($producao == false){
    $api = 'http://localhost/zmpro/pediucerto/api/';
    $urlBase = 'http://localhost/zmpro/';
    $urlAssets = 'http://localhost/zmpro/Bixxao/pediucerto/';
}





