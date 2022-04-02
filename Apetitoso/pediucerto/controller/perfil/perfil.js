angular.module("PediuCerto",['ngMessages','ngMaterial','money-mask','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.perfil = $localStorage.get('perfil');
    $scope.empresa = $localStorage.get('empresa');
    $scope.page = $localStorage.get('page');
   

    $scope.signOut = function() {
       /* alert();
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            $localStorage.remove('perfil');

           
        });*/

        $localStorage.remove('perfil');
        $localStorage.remove('sacola');
        $localStorage.remove('formaPagamento');
        $localStorage.remove('adicionais');
        $sessionStorage.remove('fPagamento');
        $sessionStorage.remove('numero');
        $sessionStorage.remove('countNew');
        
        window.location.href = "<?=$urlAssets?>estabelecimento/"+$scope.empresa[0].em_cod+"/"+$scope.empresa[0].em_token
    }

    $scope.meusPedidos = function(){
        $localStorage.remove('page');
        $localStorage.put('page','<?=$urlAssets?>'+$scope.perfil[0].pe_site);
        window.location.href ="<?=$urlAssets?>meus_pedidos/"+$scope.perfil[0].pe_site;
    }

    $scope.meusEndereco = function(){
        $localStorage.remove('page');
        
        $localStorage.put('page','<?=$urlAssets?>'+$scope.perfil[0].pe_site);

        window.location.href = "<?=$urlAssets?>endereco/lista/"+$scope.perfil[0].pe_site
    }
})