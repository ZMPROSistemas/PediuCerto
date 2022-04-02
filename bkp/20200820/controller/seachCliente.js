$scope.buscaCliente = [];
$scope.contasCliente=[];
var buscarContasReceberCliente = function(pe_cod){
    $http({
        url:$scope.urlBase + 'contas.php?buscaContasClientes=S&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=base64_decode($empresa_acesso)?>&token=<?=$token?>&cliente_fornecedor=pe_cliente&pe_cod='+pe_cod+'&RecPag=R&quitado=N&ct_receber_pagar=R'
    }).then(function onSuccess(response){
        if($scope.contasCliente.length  > 1 ){
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Cliente não possui débitos!";
            chamarAlertaBuscaCliente();
        }else{
            $scope.contasCliente = response.data.result[0];
        }

       
    }).catch(function onError(response){

    })
}

$scope.seachClienteByCod = function(pe_cod){
    $scope.buscaCliente = [];
    $scope.contasCliente=[];
    $http({
        url: $scope.urlBase+ 'ConsultaClienteFornecedor.php?buscaCliente=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&pe_cod='+pe_cod
    }).then(function onSuccess(response){
        $scope.buscaCliente = response.data.result[0];

        if($scope.buscaCliente.length  > 1 ){
            $('#selecionaCliente').modal();
            
        }
        else if($scope.buscaCliente.length  < 1 ){
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Cliente não foi encontrado";
            chamarAlertaBuscaCliente();
        }else{
            $scope.codCliente =  $scope.buscaCliente[0].pe_cod;
            $scope.nomeCliente =  $scope.buscaCliente[0].pe_nome;
            buscarContasReceberCliente($scope.codCliente);
        }
        
    }).catch(function onError(response){
      
    });
};

$scope.seachClienteByNome = function(pe_nome){
    $scope.buscaCliente = [];
    $scope.contasCliente=[];
    console.log(pe_nome);
    if(pe_nome ==  undefined){
        pe_nome = '';
    }

        $http({
            url: $scope.urlBase+ 'ConsultaClienteFornecedor.php?buscaCliente=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&cliente_fornecedor='+$scope.cliente_fornecedor+'&pe_nome='+pe_nome
        }).then(function onSuccess(response){
            $scope.buscaCliente = response.data.result[0];
            if($scope.buscaCliente.length  > 1 ){
                $('#selecionaCliente').modal();
                
            }else if($scope.buscaCliente.length  < 1 ){
                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Cliente não foi encontrado";
                chamarAlertaBuscaCliente();
            }else{
                $scope.codCliente =  $scope.buscaCliente[0].pe_cod;
                $scope.nomeCliente =  $scope.buscaCliente[0].pe_nome;
                buscarContasReceberCliente($scope.codCliente);
            }
        }).catch(function onError(response){
      
        });
    
};

$scope.clienteSelecionado=[];

$scope.selectCliente = function(buscaCliente){
  
        $scope.clienteSelecionado = buscaCliente;
          
}
$scope.selectClienteOK = function(clienteSelecionado){
    $scope.buscaCliente = [];
    $scope.contasCliente=[];
    
    if ($scope.clienteSelecionado.length < 1) {
        $scope.tipoAlerta = "alert-warning";
        $scope.alertMsg = "Um Cliente Teve Ser Selecionado!";
        chamarAlertaBuscaCliente();
    }else{
         
        $scope.codCliente =  $scope.clienteSelecionado[0].pe_cod;
        $scope.nomeCliente =  $scope.clienteSelecionado[0].pe_nome;
        buscarContasReceberCliente($scope.codCliente);
        $('#selecionaCliente').modal('hide');
        $scope.pesquisaCliente='';
    }
}
$scope.clienteSelecionadoOK = function(ct_cod,ct_nome){
    $scope.codCliente =  ct_cod;
    $scope.nomeCliente =  ct_nome;
    buscarContasReceberCliente(ct_cod);
     $('#baixarContaReceber').modal();  
}

$scope.contasReceberSelect=[];
$scope.totalParcela = 0;
$scope.totalJuros = 0.00;
$scope.descto = 0;
$scope.saldoDevedor = ($scope.totalParcela - $scope.descto) + (($scope.totalJuros/100) * $scope.totalParcela);
$scope.totalPago = $scope.saldoDevedor;


var somaContasValores = function(){
    $scope.totalParcela = $scope.contasReceberSelect.reduce(function(acumulador, total){return acumulador + total.ct_valor},0);
    $scope.totalPagar = $scope.totalParcela;
    $scope.saldoDevedor = ($scope.totalParcela - $scope.descto) + (($scope.totalJuros/100) * $scope.totalParcela);
    $scope.totalPago = $scope.saldoDevedor;

}

$scope.recalcular = function(){
    $scope.saldoDevedor = $scope.totalParcela - $scope.descto;
    $scope.saldoDevedor = ($scope.totalParcela - $scope.descto) + (($scope.totalJuros/100) * $scope.totalParcela);
    $scope.totalPago = $scope.saldoDevedor;

       
}
$scope.valorTotalDInheiroCartaoCheque = 0;

$scope.selectContas = function(contas,selectConta){

    if(selectConta == true){
        $scope.contasReceberSelect.push(contas);
    }
    if(selectConta == false){
        var index = $scope.contasReceberSelect.indexOf(contas);
        $scope.contasReceberSelect.splice(index,1);
        //console.log(index);
    }
    //console.log($scope.contasReceberSelect); 
    //console.log(selectConta); 
    somaContasValores(); 
}

$scope.troco=0;
$scope.Dinheiro = 0;
$scope.Cheque = 0;
$scope.Cartao = 0;
$scope.contasBaixadas=[];

$scope.enviarBaixarContaReceber = function(totalDinheiro,totalCartao,totalCheque,lancarCxDinheiro,lancarCxCartao,lancarCxCheque,dataPagto,caixa,totalJuros,descto){
        
    if ($scope.contasReceberSelect.length < 1) {
        $scope.tipoAlerta = "alert-warning";
        $scope.alertMsg = "Selecione uma parcela a ser baixada!";
        chamarAlertaBuscaCliente();
    }else{
        
        if (totalDinheiro == undefined) {
            totalDinheiro = 0;
        }else if (totalDinheiro == 'R$0,00'){
            totalDinheiro = 0;
        }else if (totalDinheiro == '$0,00'){
            totalDinheiro = 0;
        }

        if (totalCheque == undefined) {
            totalCheque = 0;
        }else if (totalCheque == 'R$0,00'){
            totalCheque = 0;
        }else if (totalCheque == '$0,00'){
            totalCheque = 0;
        }

        if (totalCartao == undefined) {
            totalCartao = 0;
        }else if (totalCartao == 'R$0,00'){
            totalCartao = 0;
        }else if (totalCartao == '$0,00'){
            totalCartao = 0;
        }

        
        if (lancarCxCartao == undefined) {
            lancarCxCartao = false;
        }
        if (lancarCxCheque == undefined) {
            lancarCxCheque = false;
        }
        if (caixa == undefined) {
            caixa = 0;
        }

        var contasReceber = $scope.contasReceberSelect;
        $scope.Total = totalDinheiro + totalCartao + totalCheque;
        var totalDinheiro = totalDinheiro;
        var totalCheque = totalCheque;
        var totalCartao = totalCartao;
        var lancarCxDinheiro = lancarCxDinheiro;
        var lancarCxCartao = lancarCxCartao;
        var lancarCxCheque = lancarCxCheque;
        var saldoDevedor =  $scope.saldoDevedor;
        $scope.Dinheiro = totalDinheiro;
        $scope.Cheque = totalCheque;
        $scope.Cartao = totalCartao;

        $scope.valorTotal = $scope.Total.replace("R$","");
        $scope.valorTotal = $scope.valorTotal.replace("$","");
        $scope.valorTotal = $scope.valorTotal.replace(",",".");

        if ($scope.valorTotal == 0) {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Insira uma forma de pagamento";
            chamarAlertaBuscaCliente();
        }
        else if ($scope.valorTotal == '') {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Insira uma forma de pagamento";
            chamarAlertaBuscaCliente();
        }
        if(caixa == 0){
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Selecione um caixa";
            chamarAlertaBuscaCliente();
        }else{
            
            $http({
                method:'POST',
                headers:{
                    'Content-Type':'application/json'
                },
                data:{
                    dataPagto : dataPagto,
                    caixa : caixa,
                    totalJuros : totalJuros,
                    descto : descto,
                    saldoDevedor : saldoDevedor,
                    contasReceber : contasReceber,
                    formaPagamento : {
                        totalDinheiro:totalDinheiro,
                        totalCheque:totalCheque,
                        totalCartao:totalCartao,
                    },
                    lancarCaixa:{
                        lancarCxDinheiro : true,
                        lancarCxCartao : true,
                        lancarCxCheque : true,
                    },
                },

                url: $scope.urlBase +'baixar_conta_receber.php?caixaContasReceber=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>'
            }).then(function onSuccess(response){
                $scope.contasBaixadas = response.data.result[0];

                
                for (let index = 0; index <  $scope.contasBaixadas.length; index++) {
                    
                    if ($scope.contasBaixadas.status == "ERROR") {
                        console.log('ERRO ID '+$scope.contasBaixadas[index].id)
                    }else{
                        console.log('SUCCESS ID '+$scope.contasBaixadas[index].id)
                    }
                    
                }
                
                $scope.troco =$scope.contasBaixadas.troco;
                $('#baixarContaReceber').modal('hide');
                $('#reciboContasBaixadas').modal();

              
                restContasReceber();
            }).catch(function onError(response){

            })
        }

    }
 
}

$scope.imprimirRecibo = function(){

    
    window.open('./pages/printContasReceber.php?printer=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&token=<?=$token?>&cod_cliente='+$scope.codCliente+'&nomeCliente='+$scope.nomeCliente+'&ocorrencia='+$scope.contasBaixadas.Ocorrencia+
    '&valorParcelas='+$scope.totalParcela+'&totalJuros='+$scope.totalJuros+'&descto='+$scope.descto+'&saldoDevedor='+$scope.saldoDevedor+'&totalPago='+$scope.totalPago+
    '&din='+$scope.Dinheiro+'&cart='+$scope.Cartao+'&cheq='+$scope.Cheque+'&troco='+$scope.troco);
    $('#reciboContasBaixadas').modal('hide');
}

