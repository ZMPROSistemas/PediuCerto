<!DOCTYPE html>

<?php

/*
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');
*/
    include_once ("services/conn.php");
    include_once("confg/conf.php");

     $url= str_replace('/pediucerto/','', $_SERVER['REQUEST_URI']);
    
     //$route = array();

     $route1 = explode('/',$url);

     if (!array_key_exists(1, $route1)) {
        $route1[1] = 0;
     }
     if (!array_key_exists(2, $route1)) {
        $route1[2] = 0;
     }


     $route = array(
         'page' => $route1[0],
         'id' => $route1[1],
         'token' => $route1[2],
     );

     $empresa = buscaDadosEmpresa($conexao,$route['id']);

     function buscaDadosEmpresa($conexao,$id){
        $dados = array();
        $resultado = mysqli_query($conexao,"select * from empresas where em_cod=$id");
        $dados = mysqli_fetch_assoc($resultado);
        return $dados;
    }

     ?>

<html lang="pt-br" ng-app="PediuCerto" ng-cloak>
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=0.75">
        <meta name="msapplication-square310x310logo" content="icon_largetile.png">
        <meta name="msapplication-TileImage" content="" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Pedidos Delivery Pediu Certo - <?=$empresa['em_fanta']?>">
        <meta name="author" content="ZM Sistemas">
        <meta name="keywords" content="App, Delivery, Sistemas">
        <meta name="robot" content="index, follow" >


        <meta property="og:title" content="Pedidos Delivery Pediu Certo - <?=$empresa['em_fanta']?>" />
        <meta property="og:type" content="Pedidos Delivery Pediu Certo" />
        <meta property="og:url" content="http://sistema.zmpro.com.br/pediucerto" />
        <meta property="og:image" content="http://sistema.zmpro.com.br/pediucerto/images/LogoZMPro11.png" />

        <title>Pediu Certo - <?=$empresa['em_fanta']?></title>  

        <link rel="icon" href="" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="" />
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.24/angular-material.min.css">
        <link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>
        
        
        <style>
            .container-app{
                background-color: rgb(255,255,255) !important;
            }
            @media (min-width: 992px) {
                body{
                    background-color: rgb(215,215,215) !important;
                }
                .container-app{
                    margin:0 auto;
                    width:400px;
                }
            }
        </style>


    </head>
    <body>

<?php

     if($route['page'] == ''){
       include_once "./resources/views/Splash.html";
     }
     else if($route['page'] == 'estabelecimento'){
         
        include_once "controller/estabelecimento/estabelecimento.php";
        
     }
?>