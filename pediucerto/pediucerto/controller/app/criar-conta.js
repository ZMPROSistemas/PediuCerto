
   
    $scope.numero = $sessionStorage.get('numero');
    $scope.aguardeTest = "Criando Conta aguarde";
    $scope.pe_foto_perfil = null;
    $scope.msg = false;
    $scope.msgNome=false;
    $scope.msgEmail=false;
    $scope.pass = false;
    $scope.msgPass = false;
    $scope.msgPass2 = false;
    $scope.msgAdress = false;
    $scope.msgBairro = false;
    $scope.msgCidade = false;
    $scope.msgNumero = false;
    $scope.msgUf = false;

    $scope.user = false;
    $scope.email=false;

    $scope.cadastrar = false;

    $scope.msgStyle='';
    $scope.userMsg ='';

    /*
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
*/
  $scope.verPAss = function(pass1 , pass2){
    $scope.msgPass2 = false;
    $scope.cadastrar = false;

        if(pass1 != pass2){
            $scope.msgStyle='color: #f70b0b;';
            $scope.userMsgPass2 ='Essas senhas não coincidem. Tente novamente.';
            $scope.msgPass2 = true;
        }else{
            $scope.cadastrar = true;
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
            $sessionStorage.remove('countNew');
            $sessionStorage.put('countNew', 'true');
            
            setTimeout(function(){
                window.location.href = "<?=$urlAssets?>endereco/local_entrega/"+ $scope.perfil[0].pe_site
            },1000);
            
        }).catch(function onError(response){

        });
    }


    $scope.criarPerfil = function(perfil){
        $scope.aguardeTest = "Criando Conta aguarde";
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
        /*
        if(perfil.user == undefined){
            $scope.msgStyle='color: #f70b0b;';
            $scope.userMsg ='Você precisa de um nome de usuário.';
            $scope.msg = true;
        }*/
        /*
        if(perfil.email == undefined){
            $scope.msgStyleEmail='color: #f70b0b;';
            $scope.userMsgEmail ='Informe seu email.';
            $scope.msgEmail = true;
        }*/
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
        /*
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
        }*/

        //if(perfil.nome && perfil.user && perfil.pass && perfil.pass2){
        if(perfil.nome && perfil.pass && perfil.pass2){

            var empresa = $scope.empresa;
            var dados = perfil;
            var telefone = $scope.numero.replace('(','');
            telefone = telefone.replace(')','');
            telefone = telefone.replace('-','');
            telefone = telefone.replace(' ','');

            $scope.user = true; //não valida mais usuário 04-11-2020
            if($scope.user == true){
                $scope.disabled = true;
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
                        $scope.disabled = false;
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
                        $scope.disabled = false;
                    }
                }).catch(function onError(response){
                    $scope.disabled = false;
                });
            }else{
                swal({
                    title: "ATENÇÃO",
                    text: "Nome de usuário ou senha incorreto verifica",
                    icon: "warning",
                    button: null
                  });
            }
        
        }
    }
/*
    $scope.userValida = function(user){

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
  
                  swal({
                      title: "ERROR",
                      text: 'Usuário já cadastrado',
                      icon: "ERROR",
                      button: 'OK'
                  });
  
              }
              
  
          }).catch(function onError(response){
  
          });
        }
        
    }
*/

$scope.verificar =  function(perfil, codigo){

    $scope.msg=false;
    var num = $scope.numero;
    var ID = 0;
    $scope.aguardeTest = "Aguarde";
    $scope.disabled = true;
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

            $scope.enviarCodigo = false;
            $scope.validaCodigo = false;
            $scope.pass = true;
            $scope.disabled = false;


            /*
            swal({
                title: "VERIFICADO",
                text: "CÓDIGO VERIFICADO, AGUARDE VOCÊ SERÁ REDIRECIONADO PARA SEU PERFIL",
                icon: "success",
                buttons: null
            });
            */
           
        }else if($scope.retorno[0].result == 'ERROR'){
            $scope.disabled = false;
            swal({
                title: "ERROR",
                text: "CÓDIGO INCORRETO",
                icon: "warning",
            })
        }

      }).catch(function onError(response){
        $scope.disabled = false;
    });


    /*
    var verUser = perfil.user.split(' ');
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
                user: perfil.user,
               
            }),
                url: '<?=$api?>valida-user'
            }).then(function onSuccess(response){
                var retorno = response.data;
              
              if(retorno[0].return == 'true'){
                  $scope.msgStyle='color: #168202;';
                  $scope.userMsg ='Usuario OK.';
                  $scope.msg = true;
                  $scope.user = true;

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

                        $scope.criarPerfil(perfil);

                        /*
                        swal({
                            title: "VERIFICADO",
                            text: "CÓDIGO VERIFICADO, AGUARDE VOCÊ SERÁ REDIRECIONADO PARA SEU PERFIL",
                            icon: "success",
                            buttons: null
                        });
                        */
                       /*
                    }else if($scope.retorno[0].result == 'ERROR'){
                        swal({
                            title: "ERROR",
                            text: "CÓDIGO INCORRETO",
                            icon: "warning",
                        })
                    }

                  }).catch(function onError(response){

                });

                 
              }
  
              if(retorno[0].return == 'false'){
                  $scope.msgStyle='color: #f70b0b;';
                  $scope.userMsg ='Usuário já sendo utilizado.';
                  $scope.msg = true;
                  $scope.user=false;
  
                  swal({
                      title: "ERROR",
                      text: 'Usuário já cadastrado',
                      icon: "ERROR",
                      button: 'OK'
                  });
  
              }
              
            }).catch(function onError(response){
  
            });
            
    }
  */
    
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
