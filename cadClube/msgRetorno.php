<?php
$ID = $_GET['id'];
include '../services/conectaPDO.php';
?>

<!DOCTYPE html>
<html lang="pt-br" ng-app="msgRetorno">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../angular-material.min.js"></script>	
    <script type="text/javascript" src="../angular.min.js"></script>	

    <title>Cadastro</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <img src="./imagens/logo_<?=$ID?>.jpg" class="imagem">
        </div>
        <div class="mb-3">
            <h4>Cadastro efetuado com Sucesso!</h4>
            <p>Dados cadastrados no sistema de acordo com as leis de segurança.</p>
        </div>
    <div>
  </body>


  <style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

    html {
      display:inline !important;
      padding:0 !important;
      margin:0 !important;
    }

    body {
      background-color: #000;
      margin-top: 80px;
      height: 100%;
      overflow: hidden;
      color: #fff;
    }

    .container {
        position: relative;
        margin-left: auto;
        margin-right: auto;
        width: 1230px;
      }

    .imagem {
      margin: 0 auto 60px;
      width: 150px;
      height: auto;
    }

    h4 {
      text-align:center;
    }

    p {
        text-align:center;
        margin: 25px;
    }
    @media (max-width: 1920px){
        .container {
          width: 1230px;
        }
      }

      @media (max-width: 992px){
        .container {
          width: 960px;
          max-width: 100%;
        }
      }

      @media (max-width: 768px){
        .container {
          width: 720px;
          max-width: 100%;
        }
      }

      @media (max-width: 480px){
        .container {
          width: 360px;
          max-width: 100%;
        }
      }

      .container {
        position: relative;
        margin-left: auto;
        margin-right: auto;
      }


    

  </style>
  <script src="../js/angular.min.js"></script>
  <script src="../js/angular-animate.min.js"></script>
  <script src="../js/angular-messages.min.js"></script>
  <script src="../js/chart.min.js"></script>
  <script src="../js/angular-chart.min.js"></script>
  <script src="../js/jquery-3.4.1.slim.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/angular-match-media.js"></script>
  <script src="../js/angular-material.min.js"></script>
  <script src="../js/angular-aria.min.js"></script>
  <script src="../js/material-components-web.min.js"></script>
  
</html>