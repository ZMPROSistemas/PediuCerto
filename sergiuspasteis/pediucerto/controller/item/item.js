angular.module("PediuCerto",['ngMessages','ngMaterial','money-mask','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.produtos=[];
    $scope.empresa = $localStorage.get('empresa');
    $scope.perfil = $localStorage.get('perfil');
    $urlBase = '<?=$api?>'; 

    <?php
        include_once('controller/app/sacola.js');
    ?>

    verSacolaCache();

    <?php
        include_once('api/cache.js');
    ?>

    
    $scope.item = [];
    
    var produto_select = function() {
        $scope.item = $scope.sacola.find(item => item.item === <?=$route['item']?>);
    }
    produto_select();

    $scope.adicionaisExecoes = [];

    var adicionais_execoes = function(){
        if($scope.item != undefined){

            var item_id = $scope.item.pd_id;
            var token =  $scope.empresa[0].em_token;
           
            $http({
                method:'POST',
                headers: {
                    'Content-Type':'application/json'
                },
                cache: false,
                data:JSON.stringify({
                    item:item_id,
                    token:token
                }),
                url:'<?=$api?>itens'
            }).then(function onSuccess(response){
                $scope.adicionaisExecoes = response.data;
                atualizarItemAdicional();
            }).catch(function onError(response){

            });
        }
        
    }

    adicionais_execoes();

    <?php
        include_once('controller/app/adicional.js');
    ?>
    
    $scope.addObs = function(obs){
        $localStorage.remove('sacola');
        var key = $scope.sacola.indexOf($scope.item);

        $scope.sacola[key].pd_obs = obs;

        $localStorage.put('sacola', $scope.sacola,30);
        console.log($scope.sacola[key]);
    }
    $scope.btnDisable = true;
    $scope.addItem = function(){
        $scope.btnDisable = false;
    }
});