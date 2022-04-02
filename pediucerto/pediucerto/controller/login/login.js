angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.produtos=[];
    $scope.empresa = [];
    $scope.subGrupo = [];
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');;
    $urlBase = '<?=$api?>';
    
    function onSignIn(googleUser) {
        
        var profile = googleUser.getBasicProfile();
       
        var IdConta = profile.getId();
        var nome = profile.getName();
        var image = profile.getImageUrl();
        var email =  profile.getEmail();
        // Recuperando o token do usuario. Essa informação você necessita passar para seu backend
        var id_token = googleUser.getAuthResponse().id_token;
        
        
        $http({
            method:'POST',
            headers: {
                'Content-Type':'application/json'
            },
            cache: false,
            data:JSON.stringify({
                id: "<?=$route['id']?>",
                token: "<?=$route['token']?>",
                IdConta: IdConta,
                nome : nome,
                image : image,
                email : email,
                id_token : id_token

            }),
                url: '<?=$api?>valida/social/google'
            }).then(function onSuccess(response){

                $scope.perfil = response.data;
                $localStorage.remove('perfil');
                $localStorage.put('perfil',$scope.perfil);

                if ($scope.perfil[0].pe_celular == null) {
                   window.location.href = '<?=$urlAssets?>verifica/'+ $scope.perfil[0].pe_site;
                }
                else if($scope.perfil[0].pe_celular == ''){
                    window.location.href = '<?=$urlAssets?>verifica/'+ $scope.perfil[0].pe_site;
                }
                else{
                    window.location.href = "<?=$urlAssets?>sacola/<?=$route['id']?>/<?=$route['token']?>"
                }
                
               
            }).catch(function onError(response){

            });
    }

    window.onSignIn = onSignIn;
    <?php
        include_once('controller/app/sacola.js');
    ?>

    verSacolaCache();

    <?php
        include_once('api/cache.js');
    ?>

    $scope.entrar = function(emailUser, senha){
        $http({
            method:'POST',
            headers: {
                'Content-Type':'application/json'
            },
            cache: false,
            data:JSON.stringify({
                user:emailUser,
                pass: btoa(senha)
            }),
            url: '<?=$api?>login'
        }).then(function onSuccess(response){
            $scope.retorno = response.data;
            if($scope.retorno[0].return == 'ERROR'){
                
                swal({
                    title: "ERROR",
                    text: "Usuário E Senha Incorreto",
                    icon: "warning",
                    button: "OK"
                });
            }
            else if($scope.retorno[0].return == 'SUCCESS'){
                $scope.perfil = [];
                $scope.perfil.push($scope.retorno[1])
                $localStorage.remove('perfil');
                $localStorage.put('perfil', $scope.perfil);

                swal({
                    title: "Sucesso",
                    text: "Login Efetuado com sucesso",
                    icon: "success",
                    button: null
                });
                setTimeout(function(){
                    window.location.href = "<?=$urlAssets?>sacola/<?=$route['id']?>/<?=$route['token']?>"
                },2000);
            }
        }).catch(function onError(response){

        });
    }
})