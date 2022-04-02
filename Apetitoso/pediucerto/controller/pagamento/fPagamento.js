angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $mdDialog, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {
    
    $scope.empresa = $localStorage.get('empresa');
    $scope.retorno = [];
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');
    $scope.cacheProduto = $localStorage.get('cacheProduto');
   

})