angular.module("PediuCerto",['ngMessages','ngMaterial','swxSessionStorage','swxLocalStorage','ngFileUpload', 'ngImgCrop']);
angular.module("PediuCerto").controller("PediuCertoCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage, $window) {

    $scope.empresa = $localStorage.get('empresa');
    $scope.perfil = $localStorage.get('perfil');
    $scope.cacheEmp = $localStorage.get('cacheEmp');
    $scope.cacheSubg = $localStorage.get('cacheSubg');;
    $scope.cacheProduto = $localStorage.get('cacheProduto');
    $scope.numero = $sessionStorage.get('numero');
    $scope.pe_foto_perfil = null;
    $scope.msg = false;
    $scope.msgNome=false;
    $scope.msgEmail=false;
    $scope.msgPass = false;
    $scope.msgPass2 = false;
    $scope.msgAdress = false;
    $scope.msgBairro = false;
    $scope.msgCidade = false;
    $scope.msgNumero = false;
    $scope.msgUf = false;

    $scope.user = false;
    $scope.email=false;

    $scope.msgStyle='';
    $scope.userMsg ='';
    <?php
        if (!isset($_SESSION['criarConta'])) { ?>
            
            if($scope.empresa == null){
                window.location.href = '<?=$urlAssets?>'
            }else{
                window.location.href = '<?=$urlAssets?>estabelecimento/'+$scope.empresa[0].em_cod+'/'+$scope.empresa[0].em_token;
            }
            
    <?php }
    ?>


    

  $scope.user = function(user){
      $scope.msg=false;
      
      var verUser = user.split(' ');
      if (verUser.length > 1) {
        $scope.msgStyle='color: #f70b0b;';
        $scope.userMsg ='Somente letras(a -z), numeros(0 - 9) e pontos(.) são permitidos.';
        $scope.msg = true;
      }else{
          $http({
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        cache: false,

        data:JSON.stringify({
            user: user,
           
        }),
            url: '<?=$api?>valida-user'
        }).then(function onSuccess(response){
            var retorno = response.data;
            
            if(retorno[0].return == 'true'){
                $scope.msgStyle='color: #168202;';
                $scope.userMsg ='Usuario OK.';
                $scope.msg = true;
                $scope.user = true;
            }

            if(retorno[0].return == 'false'){
                $scope.msgStyle='color: #f70b0b;';
                $scope.userMsg ='Usuário já sendo utilizado.';
                $scope.msg = true;
                $scope.user=false;
            }

        }).catch(function onError(response){

        });
      }
      
  }

  $scope.userEmail = function(email){
    $scope.msgEmail=false;
    
    $http({
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        cache: false,

        data:JSON.stringify({
            email: email,
           
        }),
            url: '<?=$api?>valida-email'
        }).then(function onSuccess(response){
            $scope.return = response.data;

            if($scope.return[0].return == 'true'){
                $scope.msgStyleEmail='color: #168202;';
                $scope.userMsgEmail ='Email OK.';
                $scope.msgEmail = true;
                $scope.email = true;
            }
            else if($scope.return[0].return == 'false'){
                $scope.msgStyleEmail='color: #f70b0b;';
                $scope.userMsgEmail ='Email já cadastrado tente efetuar o login.';
                $scope.msgEmail = true;
                $scope.email = false;
            }
            else if($scope.return[0].return == 'ERROR'){
                $scope.msgStyleEmail='color: #f70b0b;';
                $scope.userMsgEmail ='Email email incorreto.';
                $scope.msgEmail = true;
                $scope.email = false;
            }

        }).catch(function onError(response){

        });

  }

  $scope.verPAss = function(pass1 , pass2){
    $scope.msgPass2 = false;
    

        if(pass1 != pass2){
            $scope.msgStyle='color: #f70b0b;';
            $scope.userMsgPass2 ='Essas senhas não coincidem. Tente novamente.';
            $scope.msgPass2 = true;
        }
    }

    var atualizaPerfil = function(id){

        $http({
            method:'GET',
            url:'<?=$api?>buscaPerfil?ID=' + id
        }).then(function onSuccess(response){

            $scope.perfil = response.data;
            $localStorage.remove('perfil');
            $localStorage.put('perfil',$scope.perfil);
            
            setTimeout(function(){ 
                window.location.href = '<?=$urlAssets?>sacola/'+$scope.empresa[0].em_cod + '/'+$scope.empresa[0].em_token
            }, 3000);
            
        }).catch(function onError(response){

        });
    }


    $scope.criarPerfil = function(perfil){
       
        //$scope.msg = false;
        $scope.msgNome = false;
        //$scope.msgEmail = false;
        $scope.msgPass = false;
        //$scope.msgPass2 = false;
        $scope.msgAdress = false;
        $scope.msgBairro = false;
        $scope.msgCidade = false;
        $scope.msgNumero = false;
        $scope.msgUf = false;
        
        if(perfil.nome == undefined){
            $scope.msgStyleNome='color: #f70b0b;';
            $scope.userMsgNome ='Informe seu nome.';
            $scope.msgNome = true;
        }
        if(perfil.user == undefined){
            $scope.msgStyle='color: #f70b0b;';
            $scope.userMsg ='Você precisa de um nome de usuário.';
            $scope.msg = true;
        }
        if(perfil.email == undefined){
            $scope.msgStyleEmail='color: #f70b0b;';
            $scope.userMsgEmail ='Informe seu email.';
            $scope.msgEmail = true;
        }
        if(perfil.pass == undefined){
            $scope.msgStylePass='color: #f70b0b;';
            $scope.userMsgPass ='Informe uma senha.';
            $scope.msgPass = true;
        }
        if(perfil.pass2 == undefined){
            $scope.msgStylePass2='color: #f70b0b;';
            $scope.userMsgPass2 ='Repita sua senha.';
            $scope.msgPass2 = true;
        }
        if(perfil.adress == undefined){
            $scope.msgStyleAdress='color: #f70b0b;';
            $scope.userMsgAdress ='Informe sua senha.';
            $scope.msgAdress = true;
        }
        if(perfil.bairro == undefined){
            $scope.msgStyleBairro='color: #f70b0b;';
            $scope.userMsgBairro ='Informe o bairro.';
            $scope.msgBairro = true;
        }
        if(perfil.cidade == undefined){
            $scope.msgStyleCidade='color: #f70b0b;';
            $scope.userMsgCidade ='Informe a cidade.';
            $scope.msgCidade = true;
        }
        if(perfil.numero == undefined){
            $scope.msgStyleNumero='color: #f70b0b;';
            $scope.userMsgNumero ='Informe o numero.';
            $scope.msgNumero = true;
        }
        if(perfil.uf == undefined){
            $scope.msgStyleUf='color: #f70b0b;';
            $scope.userMsgUf ='Informe UF.';
            $scope.msgUf = true;
        }

        if(perfil.nome && perfil.user && perfil.email && perfil.pass
            && perfil.pass2 && perfil.adress && perfil.bairro
            && perfil.cidade && perfil.numero && perfil.uf){
            
            var empresa = $scope.empresa;
            var dados = perfil;
            var telefone = $scope.numero;

            if($scope.user == true &&  $scope.email == true){
                $http({
                    method: 'POST',
                    headers: {
                        'Content-Type':'application/json'
                    },
                    cache: false,
            
                    data:JSON.stringify({
                        empresa : empresa,
                        dados : dados,
                        telefone :telefone
                    }),
                    url: '<?=$api?>cria-conta'
                }).then(function onSuccess(response){
                    $scope.retorno = response.data;
                    console.log($scope.retorno);
                    console.log($scope.retorno[0].retorno);
                    if($scope.retorno[0].retorno == "SUCCESS"){
                        swal({
                            title: "Conta Criada",
                            text: "Conta Criada com sucesso",
                            icon: "success",
                            button: null
                        });
                        atualizaPerfil($scope.retorno[0].conta);
                    }
                    else if($scope.retorno[0].retorno == 'ERROR'){
                        swal({
                            title: "ERROR",
                            text: 'Não foi possivel criar conta',
                            icon: "ERROR",
                            button: null
                        });
                       
                    }
                }).catch(function onError(response){

                });
            }else{
                swal({
                    title: "ATENÇÃO",
                    text: "Nome de usuário ou senha incorreto verifica",
                    icon: "warning",
                    buttons: null
                  });
            }
                
        }
    }

    $scope.logradouro;
    $scope.pesquisarCEP = function(cep){

        var cep = cep.replace(/\D/g, '');
        $http({
            method: 'GET',
            url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/'
        }).then(function onSuccess(response){

            $scope.logradouro = response.data;
            $scope.perfil.adress = $scope.logradouro.logradouro;
            $scope.perfil.bairro = $scope.logradouro.bairro;
            $scope.perfil.cidade = $scope.logradouro.localidade;
            $scope.perfil.uf = $scope.logradouro.uf;
           console.log($scope.logradouro);
           
        }).catch(function onError(response){

        });

    };

    $scope.navPage = function () {
        window.location.href = "<?=$urlAssets?>sacola/"+$scope.empresa[0].em_cod + "/"+$scope.empresa[0].em_token;
    }

})