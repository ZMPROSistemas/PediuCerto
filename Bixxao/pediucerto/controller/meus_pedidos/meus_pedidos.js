angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $mdDialog, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
    
    $scope.empresa = $localStorage.get('empresa');
    $scope.page = $localStorage.get('page');
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.meusPedidos = [];
   
    var meuspedidos = function(){
        $http({
            method:'POST',
            headers: {
                'Content-Type':'application/json'
            },
            cache: false,
            data:JSON.stringify({

            }),
            url: '<?=$api?>meus_pedidos?user='+$scope.perfil[0].pe_id+'&token='+$scope.empresa[0].em_token
    
        }).then(function onSuccess(response){

            $scope.meusPedidos = response.data;
        }).catch(function onError(response){

        });
    }

    meuspedidos();

    $scope.navPage = function () {
        $localStorage.remove('page');
        window.location.href = $scope.page;
    }
})