angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.empresa = $localStorage.get('empresa');
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.numero = $sessionStorage.get('numero');

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
                    url: '<?=$urlAssets?>services/sendsms/'+numero+'/conta=S'
                }).then(function onSuccess(response){

                    $scope.retorno = response.data;
                    //console.log($scope.retorno.situacao);

                    if($scope.retorno.situacao == 'OK'){
                        $sessionStorage.put('numero', numero)

                        window.location.href = '<?=$urlAssets?>codigo-verifica/numero='+ numero;
                    }
                    else if($scope.retorno.situacao == 'conta_existe'){
                        
                        swal({
                            title: "Conta Existente",
                            text: "Telefone já esta vinculado em uma conta, efetue login!",
                            icon: "info",
                            buttons: {
                                confirm:"Login!",
                            }
                        }).then(confirm=>{
                            window.location.href = "<?=$urlAssets?>login/"+$scope.empresa[0].em_cod+"/"+$scope.empresa[0].em_token})  
                    }

                    //console.log( $sessionStorage.get('numero'));
                    console.log($scope.retorno.situacao);
                    
                }).catch(function onError(response){

                });
            }
            
        }

    }

});