$scope.validaCodigo = false;
$scope.enviarCodigo = true;
$scope.btnCodigo = "Enviar Código";
$scope.tempoCodigo = 30;


$scope.sendSMS = function(numero, nome){

    $scope.tempoCodigo = 30;
    $sessionStorage.remove('numero');
   
    if(nome == undefined){
        
        $scope.msgStyleNome='color: #f70b0b;';
        $scope.userMsgNome ='Informe seu nome.';
        $scope.msgNome = true;
        
    }else{
        $scope.msgNome = false;

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
                $scope.aguardeTest = "Aguarde";
                $scope.disabled = true;
                $http({
                method:'POST',
                    //url: '<?=$api?>sendsms/'+numero+'/conta=S'
                    url: '<?=$api?>sendsmsw/'+numero+'/conta=S'
                }).then(function onSuccess(response){

                    $scope.retorno = response.data;
                    
                    if($scope.retorno.situacao == 'OK'){
                        $scope.disabled = false;
                        $sessionStorage.put('numero', numero)
                        $scope.validaCodigo = true;
                        $scope.enviarCodigo = false;
                        
                        $scope.enviarCodigo = false;
                        $scope.validaCodigo = false;
                        $scope.pass = true;
                        $scope.disabled = false;

                        
                        $timeout(function(){
                            if ($scope.pass == false) {
                                $scope.btnCodigo = "Reenviar Código";
                                $scope.enviarCodigo = true;
                            }
                        
                        }, 30000);
                        
                    } else if($scope.retorno.situacao == 'conta_existe'){
                        $scope.disabled = false;
                        swal({
                            title: "Conta Existente",
                            text: "Telefone já esta vinculado em uma conta, efetue login!",
                            icon: "info",
                            buttons: {
                                confirm:"Login!",
                            }
                        }).then(confirm=>{
                            $('#cadastro').modal('hide');
                            $('#Login').modal('show');
                        }) 
                    } else if($scope.retorno.situacao == 'ERRO'){
                        $scope.disabled = false;
                        swal({
                            title: "ERROR "+ $scope.retorno.codigo,
                            text:  $scope.retorno.descricao,
                            icon: "info",
                            button:"OK"

                        }); 
                    }
                    
                }).catch(function onError(response){
                    $scope.disabled = false;
                });
            }
            
        }
    }
    

}