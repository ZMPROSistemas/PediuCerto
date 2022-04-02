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
    $scope.numero = $sessionStorage.get('numero');

    var atualizaPerfil = function(){
        $http({
            method:'GET',
            url:'<?=$api?>buscaPerfil?perfil=' + $scope.perfil[0].pe_site + '&ID=' + $scope.perfil[0].pe_id
        }).then(function onSuccess(response){

            $scope.perfil = response.data;
            $localStorage.remove('perfil');
            $localStorage.put('perfil',$scope.perfil);

            setTimeout(function(){ 
                window.location.href = '<?=$urlAssets?>endereco/cadastrar/'+$scope.perfil[0].pe_site
            }, 3000);
            
        }).catch(function onError(response){

        });
    }

    $scope.verificar =  function(codigo){
        var num = $scope.numero;
        var ID = $scope.perfil[0].pe_id;
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
            url: '<?=$api?>validaCodigo'
        }).then(function onSuccess(response){
            
            $scope.retorno = response.data;

            
            if ($scope.retorno[0].result == 'verificado') {
                
                swal({
                    title: "VERIFICADO",
                    text: "CÓDIGO VERIFICADO, AGUARDE VOCÊ SERÁ REDIRECIONADO PARA SEU PERFIL",
                    icon: "success",
                    buttons: null
                  });

                  atualizaPerfil();
                  //console.log($scope.perfil);
                  
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