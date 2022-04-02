<?php
$ID = $_GET['id'];
include '../services/conectaPDO.php';
?>

<!DOCTYPE html>
<html lang="pt-br" ng-app="cadClube">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <title>Cadastro</title>
  </head>
  <body>
  <style>
      @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

      html {
        display:inline !important;
        padding:0 !important;
        margin:0 !important;
        height: 100%;
      }

      body {        
        background-color: #000;
        padding-top: 80px;
        height: 100vh;
        overflow: hidden;
        color: #fff;
      }

      .container {
        position: relative;
        margin-left: auto;
        margin-right: auto;
        width: 1230px;
      }

      h2 {
        text-align: center;
        color: #fff;
      }

      .imagem {
        margin: 0 auto 60px;
        width: 150px;
        height: auto;
      }

      .alert{
        display: none;
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
    <div ng-controller="cadClubeCtrl">
      <div class="alert alert-danger" role="alert" style="position:fixed;right: 0;margin-top: 0px;">
        Cadastro efetuado Sucesso!
      </div>

      <div class="container">
        <div class="row">
          <img src="./imagens/logo_<?=$ID?>.jpg" class="imagem">
          <h2>Cadastro</h2>
          <form autocomplete="off">
            <div class="mb-3">
              <label class="form-label">CPF</label>
              <input type="text" ng-value="cpf" ng-model="cpf" class="form-control" id="cpfcnpj" name="cpfcnpj" placeholder="Digite seu CPF" onblur="verificaCliente(this.value)" onKeyUp="tabenter(event,getElementById('nome'))"required >
            </div>
            <div class="mb-3">
              <label class="form-label">Nome</label>
              <input type="text" ng-model="nome" ng-value="nome" class="form-control" id="nome" placeholder="Digite seu nome" required >
            </div>
            <div class="mb-3">
              <label class="form-label">Numero do Whatsapp</label>
              <input type="text" ng-model="celular" ng-value="celular" class="form-control" id="celular" name="celular" placeholder="Digite o Numero do seu Whatsapp" required >
            </div>
            <div class="mb-3">
              <label class="form-label">E-mail</label>
              <!-- <input type="email" ng-model="email" ng-value="email" class="form-control" id="email" placeholder="Digite seu E-mail" ng-pattern='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/' required > -->
              <input type="text" ng-model="email" ng-value="email" class="form-control" id="email" placeholder="Digite seu E-mail" required >
            </div>
            <div class="d-grid gap-2">
              <button type="submit" id="cadastrar" class="btn btn-primary" ng-click="cadastrar()">Cadastrar</button>
            </div>       
            
          </form>
        </div>
      <div>

      <script src="../js/angular.min.js"></script>
      <script src="../js/angular-animate.min.js"></script>
      <script src="../js/angular-messages.min.js"></script>
      <script src="../js/angular-chart.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>         
      <script src="../js/jquery-3.4.1.slim.min.js"></script>
      <script src="../js/jquery.mask.min.js"></script>
      <script src="../js/angular-match-media.js"></script>
      <script src="../js/angular-material.min.js"></script>
      <script src="../js/angular-aria.min.js"></script>
      <script src="../js/mCustomScrollbar.concat.min.js"></script>
      <script src="../js/material-components-web.min.js"></script>
      <script src="../js/dirPagination.js"></script>
      <script src="../js/mask/angular-money-mask.js"></script> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.0.4/ng-file-upload.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.js"></script>
      <script id="INLINE_PEN_JS_ID">

        angular.module("cadClube",['ngMessages','ngMatchMedia','ngMaterial','money-mask','ngFileUpload', 'ngImgCrop', 'angularUtils.directives.dirPagination']);
        angular.module("cadClube").controller("cadClubeCtrl", function ($scope, $http, $timeout, $mdSidenav, $log, $window) {
          
          function limpacampos(){
            $scope.cpf='';
            $scope.nome='';
            $scope.celular='';
            $scope.email='';
          };
          limpacampos();

          $scope.cadastrar = function(){
            $scope.cpfValido=validaCpfCnpj($scope.cpf);
            //alert('vai cadastrar');
            if(!$scope.cpfValido){
              alert('CPF Inválido !!!');
            }else{
              $http({
                method: 'POST',
                    headers: {
                    'Content-Type':'application/json' 
                    },
                    data: { 
                        cpf:$scope.cpf,
                        nome:$scope.nome,
                        celular:$scope.celular,
                        email:$scope.email
                    },
                    url: 'salvaCliente.php?cod_empresa='+<?=$ID?>
              }).then(function onSuccess(response){
                $scope.resultado=response.data;
                //alert($scope.resultado);
                if($scope.resultado.status=='ERRO'){                
                  alert($scope.resultado.mensagem);
                }else{
                  if($scope.resultado.status=='JATEM'){  
                    //alert('cpf ja cadastrado');
                    window.location.href = 'https://sistema.zmpay.com.br/cadClube/msgCadastrado.php?id=<?=$ID?>';
                  }else{
                    //alert('Deu certo o cadastro');
                    window.location.href = 'https://sistema.zmpay.com.br/cadClube/msgRetorno.php?id=<?=$ID?>';
                  }

                }

                //limpacampos();
                // MudarVisibilidadeLista(2);
                // buscaDados();
                // if (apagar=='S'){
                //     $scope.alertMsg = "Item Excluído com Sucesso !";
                // }else{
                //     if (idItem==''){
                //         $scope.alertMsg = "Item Incluído com Sucesso !";
                //     }else{
                //         $scope.alertMsg = "Item Alterado com Sucesso !";
                //     }
                // }
                // chamarAlerta();
                //$window.location.reload();
              }).catch(function onError(response){
                //LimparCampos();
                alert("Erro!");
              });
            }
          };


          function validaCpfCnpj(val) {
            if (val.length == 14) {
                var cpf = val.trim();
            
                cpf = cpf.replace(/\./g, '');
                cpf = cpf.replace('-', '');
                cpf = cpf.split('');
                
                var v1 = 0;
                var v2 = 0;
                var aux = false;
                
                for (var i = 1; cpf.length > i; i++) {
                    if (cpf[i - 1] != cpf[i]) {
                        aux = true;   
                    }
                } 
                
                if (aux == false) {
                    return false; 
                } 
                
                for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
                    v1 += cpf[i] * p; 
                } 
                
                v1 = ((v1 * 10) % 11);
                
                if (v1 == 10) {
                    v1 = 0; 
                }
                
                if (v1 != cpf[9]) {
                    return false; 
                } 
                
                for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
                    v2 += cpf[i] * p; 
                } 
                
                v2 = ((v2 * 10) % 11);
                
                if (v2 == 10) {
                    v2 = 0; 
                }
                
                if (v2 != cpf[10]) {
                    return false; 
                } else {   
                    return true; 
                }
            } else if (val.length == 18) {
                var cnpj = val.trim();
                
                cnpj = cnpj.replace(/\./g, '');
                cnpj = cnpj.replace('-', '');
                cnpj = cnpj.replace('/', ''); 
                cnpj = cnpj.split(''); 
                
                var v1 = 0;
                var v2 = 0;
                var aux = false;
                
                for (var i = 1; cnpj.length > i; i++) { 
                    if (cnpj[i - 1] != cnpj[i]) {  
                        aux = true;   
                    } 
                } 
                
                if (aux == false) {  
                    return false; 
                }
                
                for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
                    if (p1 >= 2) {  
                        v1 += cnpj[i] * p1;  
                    } else {  
                        v1 += cnpj[i] * p2;  
                    } 
                } 
                
                v1 = (v1 % 11);
                
                if (v1 < 2) { 
                    v1 = 0; 
                } else { 
                    v1 = (11 - v1); 
                } 
                
                if (v1 != cnpj[12]) {  
                    return false; 
                } 
                
                for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) { 
                    if (p1 >= 2) {  
                        v2 += cnpj[i] * p1;  
                    } else {   
                        v2 += cnpj[i] * p2; 
                    } 
                }
                
                v2 = (v2 % 11); 
                
                if (v2 < 2) {  
                    v2 = 0;
                } else { 
                    v2 = (11 - v2); 
                } 
                
                if (v2 != cnpj[13]) {   
                    return false; 
                } else {  
                    return true; 
                }
            } else {
                return false;
            }
        }

          
          
        
        });

        $(document).ready(function(){	
          
          $("form#cad").keypress(function(e){
            if((e.keyCode == 10)||(e.keyCode == 13)){
              e.preventDefault();
            }
          })
          var tamanho = $('#cpfcnpj').val().length;
          if(tamanho < 11){
            $("#cpfcnpj").mask("999.999.999-99");
          }
          $("#celular").mask("(00) 00000-0000");
         });

        function tabenter(event,campo){
          var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
          if (tecla==13) {
            campo.select();
          }
        };

      
      </script>
    </div>        
  </body>   
  
</html>