<!DOCTYPE html>

<?php

session_name('Apetitoso');

session_start();

$urlAssets = 'http://localhost/pediucerto/';

/*
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');
*/
    include_once("./pediucerto/services/conn.php");

    $empresa = buscaDadosEmpresa($conexao,15);
    
     function buscaDadosEmpresa($conexao,$id){
        $dados = array();
        $resultado = mysqli_query($conexao,"select * from empresas where em_cod=$id");
        $dados = mysqli_fetch_assoc($resultado);
        return $dados;
    }

     ?>

<html lang="pt-br" ng-app="PediuCerto">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=0.75">

        <meta name="msapplication-square310x310logo" content="./assets/images/Favicon.png">
        <meta name="msapplication-TileImage" content="./assets/images/Favicon.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="icon" href="./assets/images/Favicon.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="./assets/images/Favicon.png" />

        <meta name="google-signin-client_id" content="921121352932-alvivh8sthstjh4ia4c7crvdujrcum0t.apps.googleusercontent.com">

        <meta name="msapplication-square310x310logo" content="./assets/images/Favicon.png">
        
        <meta name="description" content="Pedidos Delivery Pediu Certo - '. <?=$empresa['em_fanta']?>.'">
     
       
        <meta name="author" content="ZM Sistemas">
        <meta name="keywords" content="App, Delivery, Sistemas">
        <meta name="robot" content="index, follow" >

       <meta property="og:title" content="Pedidos Delivery Pediu Certo - '. <?=$empresa['em_fanta']?>.'" />
        
        
        <meta property="og:type" content="Pedidos Delivery Pediu Certo" />
        <meta property="og:url" content="http://sistema.zmpro.com.br/pediucerto" />
        <meta property="og:image" content="http://sistema.zmpro.com.br/pediucerto/images/LogoZMPro11.png" />

        <title>Pediu Certo - UP Grill</title>
       
        <link rel="icon" href="" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="" />
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.24/angular-material.min.css">
        <!--link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet"-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        
        <!--script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgLml81x6vcnvePo90lmrKoeptkaKC2lY&callback=initMap&libraries=places&v=weekly" defer></script-->
        
            
        <style>
            .container-app{
                background-color: rgb(255,255,255) !important;
                overflow: hidden;
            }
            @media (min-width: 576px) and (max-width: 992px){
                body{
                    background-color: rgb(215,215,215) !important;
                }
                .container-app{
                    margin:0 auto;
                    width:450px;
                }
                .emp {
                    font-size: 27px !important;
                }
            }
            .md-button.md-default-theme.md-fab, .md-button.md-fab {
                background-color: rgba(152,152,152,1);
                color: rgb(0 0 0);
            }

            .md-button.md-default-theme.md-fab:not([disabled]).md-focused, .md-button.md-fab:not([disabled]).md-focused, .md-button.md-default-theme.md-fab:not([disabled]):hover, .md-button.md-fab:not([disabled]):hover {
                background-color:rgba(152,152,152,1);
            }
            .swal-modal {
                width: 30%;
                    
            }
            @media (max-width: 500px){
                .swal-modal {
                    width: 100%;
                   
                }
            }

            
        </style>
        


    </head>
    <body>
        
        <div ng-controller="PediuCertoCtrl" class="container-app">

                    
<?php
   
    include_once "Splash.html";

    include_once "footer.php";
            
?>