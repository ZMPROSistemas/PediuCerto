angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
    
    $scope.empresa = $localStorage.get('empresa');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.numero = $sessionStorage.get('numero');


    $scope.verificar =  function(codigo){
        var num = $scope.numero;
        var ID = 0;
        $http({
            method:'POST',
            headers: {
                'Content-Type':'application/json'
            },
            cache: false,
            data:JSON.stringify({
                codigo: codigo,
                numero: num,
                ID:ID
               
            }),
            url: '<?=$urlAssets?>services/validaCodigo'
        }).then(function onSuccess(response){
            
            $scope.retorno = response.data;

            
            if ($scope.retorno[0].result == 'verificado') {
                
                swal({
                    title: "VERIFICADO",
                    text: "CÓDIGO VERIFICADO, AGUARDE VOCÊ SERÁ REDIRECIONADO PARA SEU PERFIL",
                    icon: "success",
                    buttons: null
                  });

                  setTimeout(function(){
                    window.location.href = '<?=$urlAssets?>criar-conta'
                    }, 2000);
                  
            }
            else if($scope.retorno[0].result == 'ERROR'){
                swal({
                    title: "ERROR",
                    text: "CÓDIGO INCORRETO",
                    icon: "warning",
                })
            }
        }).catch(function onError(response){

        });
    }

    $scope.nextPage = function(){
        
    }

})