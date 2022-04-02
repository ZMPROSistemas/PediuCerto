angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.produtos=[];
    $scope.empresa = $localStorage.get('empresa');
    $scope.subGrupo = [];
    $scope.retorno = [];
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $urlBase = '<?=$api?>';


    $scope.sendSMS = function(numero){

        $sessionStorage.remove('numero');

        if(numero == undefined){
            swal({
                title: "ERROR",
                text: "Informe o número de telefone válido",
                icon: "warning",
                
                
              })
        }else{

            numero = numero.replace('(','');
            numero = numero.replace(')','');
            numero = numero.replace('-','');
            numero = numero.replace(' ','');
            
            if (numero.length < 11) {
                swal({
                    title: "ERROR",
                    text: "Informe o número de telefone válido",
                    icon: "warning",
                    
                    
                  })
            }else{
                $http({
                 method:'POST',
                    url: '<?=$api?>sendsms/'+numero
                }).then(function onSuccess(response){

                    $scope.retorno = response.data;
                    //console.log($scope.retorno.situacao);

                    if($scope.retorno.situacao == 'OK'){
                        $sessionStorage.put('numero', numero)

                        window.location.href = '<?=$urlAssets?>codigo/numero='+ numero;
                    }

                    console.log( $sessionStorage.get('numero'));
                    console.log($scope.retorno.situacao);
                    
                }).catch(function onError(response){

                });
            }
            
        }

    }


    <?php
    include_once('controller/app/sacola.js');
?>

verSacolaCache();


});