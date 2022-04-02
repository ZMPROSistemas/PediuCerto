$scope.buscaCliente = [];
$scope.contasCliente = [];
$scope.clienteSelecionado = [];
$scope.contasReceberSelect = [];
$scope.contasBaixadas = [];
$scope.filtro = 'Recebido';
$scope.ocorrencia = '';
$scope.totalParcela = 0.00;
$scope.totalJuros = 0.00;
$scope.descto = 0.00;
$scope.saldoDevedor = 0.00;
$scope.Dinheiro = 0.00;
$scope.Cheque = 0.00;
$scope.Cartao = 0.00;
$scope.totalPago = 0.00;
$scope.totalAPagar = 0.00;
$scope.troco = 0.00;

var buscarContasReceberCliente = function(pe_cod) {
    $http({
        url: $scope.urlBase + 'contas.php?buscaContasClientes=S&us_id=<?=$us_id?>&empresa_matriz=<?=$empresa?>&empresa_filial=<?=base64_decode($empresa_acesso)?>&token=<?=$token?>&cliente_fornecedor=pe_cliente&pe_cod=' + pe_cod + '&RecPag=R&quitado=N&ct_receber_pagar=R'
    }).then(function onSuccess(response) {
        if ($scope.contasCliente.length > 1) {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Cliente não possui débitos!";
            chamarAlertaBuscaCliente();
        } else {
            $scope.contasCliente = response.data.result[0];
        }


    }).catch(function onError(response) {

    })
}

var buscarContasReceberID = function(ct_id) {
    $scope.contasCliente = [];
    $http({
        url: $scope.urlBase + 'contas.php?buscarContasPorID=S&ct_id=' + ct_id
    }).then(function onSuccess(response) {
        $scope.contasCliente = response.data.result[0];
        $('#baixarContaReceber').modal().show;
    }).catch(function onError(response) {

    })
}

$scope.seachClienteByCod = function(pe_cod) {
    $scope.buscaCliente = [];
    $scope.contasCliente = [];
    $http({
        url: $scope.urlBase + 'ConsultaClienteFornecedor.php?buscaCliente=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&cliente_fornecedor=' + $scope.cliente_fornecedor + '&pe_cod=' + pe_cod
    }).then(function onSuccess(response) {
        $scope.buscaCliente = response.data.result[0];

        if ($scope.buscaCliente.length > 1) {
            $('#selecionaCliente').modal();

        } else if ($scope.buscaCliente.length < 1) {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Cliente não foi encontrado";
            chamarAlertaBuscaCliente();
        } else {
            $scope.IdCliente = $scope.buscaCliente[0].pe_id;
            $scope.codCliente = $scope.buscaCliente[0].pe_cod;
            $scope.nomeCliente = $scope.buscaCliente[0].pe_nome;
            buscarContasReceberCliente($scope.codCliente);
        }

    }).catch(function onError(response) {

    });
};

$scope.seachClienteByNome = function(pe_nome) {
    $scope.buscaCliente = [];
    $scope.contasCliente = [];
    console.log(pe_nome);
    if (pe_nome == undefined) {
        pe_nome = '';
    }

    $http({
        url: $scope.urlBase + 'ConsultaClienteFornecedor.php?buscaCliente=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>&cliente_fornecedor=' + $scope.cliente_fornecedor + '&pe_nome=' + pe_nome
    }).then(function onSuccess(response) {
        $scope.buscaCliente = response.data.result[0];
        if ($scope.buscaCliente.length > 1) {
            $('#selecionaCliente').modal();

        } else if ($scope.buscaCliente.length < 1) {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Cliente não foi encontrado";
            chamarAlertaBuscaCliente();
        } else {
            $scope.IdCliente = $scope.buscaCliente[0].pe_id;
            $scope.codCliente = $scope.buscaCliente[0].pe_cod;
            $scope.nomeCliente = $scope.buscaCliente[0].pe_nome;
            buscarContasReceberCliente($scope.codCliente);
        }
    }).catch(function onError(response) {

    });

};

$scope.selectCliente = function(buscaCliente) {

    $scope.clienteSelecionado = buscaCliente;

}

$scope.selectClienteOK = function(clienteSelecionado) {
    $scope.buscaCliente = [];
    $scope.contasCliente = [];

    if ($scope.clienteSelecionado.length < 1) {
        $scope.tipoAlerta = "alert-warning";
        $scope.alertMsg = "Um Cliente Teve Ser Selecionado!";
        chamarAlertaBuscaCliente();
    } else {
        $scope.IdCliente = $scope.clienteSelecionado[0].pe_id;
        $scope.codCliente = $scope.clienteSelecionado[0].pe_cod;
        $scope.nomeCliente = $scope.clienteSelecionado[0].pe_nome;
        buscarContasReceberCliente($scope.codCliente);
        $('#selecionaCliente').modal('hide');
        $scope.pesquisaCliente = '';
    }
}

$scope.clienteSelecionadoOK = function(ct_id, ct_cod, ct_nome) {

    $scope.buscaCliente = [];
    $scope.contasCliente = [];

    $scope.codConta = ct_id;
    $scope.codCliente = ct_cod;
    $scope.nomeCliente = ct_nome;
    buscarContasReceberID(ct_id);

}

var somaContasValores = function() {

    $scope.totalParcela = $scope.contasReceberSelect.reduce(function(acumulador, total) {
        return acumulador + parseFloat(total.ct_valor)
    }, 0);
    recalcularTudo();
    setarFoco("Dinheiro");
    /*$scope.totalPagar = parseFloat($scope.totalParcela);
    $scope.saldoDevedor = parseFloat($scope.totalParcela, 2) - parseFloat($scope.descto, 2) + parseFloat($scope.totalJuros, 2);
    $scope.totalPago = parseFloat($scope.saldoDevedor, 2);*/

}

$scope.validarJuros = function() {

    if ($scope.totalJuros == '' || $scope.totalJuros == undefined) {
        $scope.totalJuros = 0;
    } else {
        $scope.totalJuros = $scope.totalJuros.replace(",", ".");
    }
    recalcularTudo();
}

$scope.validarDescto = function() {
    if ($scope.descto == '' || $scope.descto == undefined) {
        $scope.descto = 0;
    } else {
        $scope.descto = $scope.descto.replace(",", ".");
    }
    recalcularTudo();
}

$scope.validarDinheiro = function() {
    if ($scope.Dinheiro == '' || $scope.Dinheiro == undefined) {
        $scope.Dinheiro = 0;
    } else {
        $scope.Dinheiro = $scope.Dinheiro.replace(",", ".");
    }
    recalcularTudo();
}

$scope.validarCheque = function() {
    if ($scope.Cheque == '' || $scope.Cheque == undefined) {
        $scope.Cheque = 0;
    } else {
        $scope.Cheque = $scope.Cheque.replace(",", ".");
    }
    recalcularTudo();
}

$scope.validarCartao = function() {
    if ($scope.Cartao == '' || $scope.Cartao == undefined) {
        $scope.Cartao = 0;
    } else {
        $scope.Cartao = $scope.Cartao.replace(",", ".");
    }
    recalcularTudo();
}

var recalcularTudo = function() {
    $scope.totalPago = parseFloat($scope.Dinheiro, 2) + parseFloat($scope.Cheque, 2) + parseFloat($scope.Cartao, 2);
    $scope.totalAPagar = parseFloat($scope.totalParcela, 2) + parseFloat($scope.totalJuros, 2) - parseFloat($scope.descto, 2);
    $scope.saldoDevedor = parseFloat($scope.totalAPagar, 2) - parseFloat($scope.totalPago, 2);
    if ($scope.saldoDevedor < 0) { $scope.saldoDevedor = 0 };
    $scope.troco = parseFloat($scope.totalPago, 2) - parseFloat($scope.totalAPagar, 2);
    if ($scope.troco < 0) { $scope.troco = 0 };
    //$scope.descto = $scope.descto.replace(",", ".");
    //$scope.totalPagar = parseFloat($scope.totalParcela);
    //$scope.saldoDevedor = parseFloat($scope.totalParcela, 2) - parseFloat($scope.descto, 2);
    //$scope.saldoDevedor = parseFloat($scope.totalParcela) - parseFloat($scope.descto) + parseFloat($scope.totalJuros);
    //$scope.totalPago = parseFloat($scope.saldoDevedor);
    //$scope.descto = parseFloat($scope.descto, 2);
    //$scope.totalJuros = parseFloat($scope.totalJuros, 2);
    //$scope.saldoDevedor = ($scope.totalParcela - $scope.descto) + (($scope.totalJuros / 100) * $scope.totalParcela);
    //$scope.totalPago = $scope.saldoDevedor;

}

/*$scope.recalcularJuros = function() {

    $scope.totalJuros = $scope.totalJuros.replace(",", ".");
    $scope.totalPagar = parseFloat($scope.totalParcela);
    $scope.saldoDevedor = parseFloat($scope.totalParcela) - parseFloat($scope.descto) + parseFloat($scope.totalJuros);
    $scope.totalPago = parseFloat($scope.saldoDevedor);
    //$scope.saldoDevedor = parseFloat($scope.totalParcela, 2) - parseFloat($scope.descto, 2);
    //$scope.descto = parseFloat($scope.descto, 2);
    //$scope.totalJuros = parseFloat($scope.totalJuros, 2);
    //$scope.saldoDevedor = ($scope.totalParcela - $scope.descto) + (($scope.totalJuros / 100) * $scope.totalParcela);
    //$scope.totalPago = $scope.saldoDevedor;

}*/


$scope.selectContas = function(contas, selectConta) {

    if (selectConta == true) {

        $scope.contasReceberSelect.push(contas);
    }
    if (selectConta == false) {
        var index = $scope.contasReceberSelect.indexOf(contas);
        $scope.contasReceberSelect.splice(index, 1);
        //console.log(index);
    }
    //console.log($scope.contasReceberSelect); 
    //console.log(selectConta); 
    somaContasValores();
}

$scope.abrirModalRecibo = function() {

    $('#reciboContasBaixadas').modal().show;

}

$scope.enviarBaixarContaReceber = function(totalDinheiro, totalCartao, totalCheque, lancarCxDinheiro, lancarCxCartao, lancarCxCheque, dataPagto, caixa, totalJuros, descto) {

    if ($scope.contasReceberSelect.length < 1) {
        $scope.tipoAlerta = "alert-warning";
        $scope.alertMsg = "Selecione uma parcela a ser baixada!";
        chamarAlertaBuscaCliente();
    } else {

        if (totalDinheiro == undefined) {
            totalDinheiro = 0;
        } else if (totalDinheiro == 'R$0,00') {
            totalDinheiro = 0;
        } else if (totalDinheiro == '$0,00') {
            totalDinheiro = 0;
        }

        if (totalCheque == undefined) {
            totalCheque = 0;
        } else if (totalCheque == 'R$0,00') {
            totalCheque = 0;
        } else if (totalCheque == '$0,00') {
            totalCheque = 0;
        }

        if (totalCartao == undefined) {
            totalCartao = 0;
        } else if (totalCartao == 'R$0,00') {
            totalCartao = 0;
        } else if (totalCartao == '$0,00') {
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
        var totalDinheiro = totalDinheiro;
        var totalCheque = totalCheque;
        var totalCartao = totalCartao;
        var lancarCxDinheiro = lancarCxDinheiro;
        var lancarCxCartao = lancarCxCartao;
        var lancarCxCheque = lancarCxCheque;
        var saldoDevedor = $scope.totalAPagar;
        $scope.Dinheiro = totalDinheiro;
        $scope.Cheque = totalCheque;
        $scope.Cartao = totalCartao;

        if ($scope.totalPago == 0) {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Insira uma forma de pagamento";
            chamarAlertaBuscaCliente();
        } else if ($scope.totalPago == '') {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Insira uma forma de pagamento";
            chamarAlertaBuscaCliente();
        }
        if (caixa == 0) {
            $scope.tipoAlerta = "alert-warning";
            $scope.alertMsg = "Selecione um caixa";
            chamarAlertaBuscaCliente();
        } else {

            $http({
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    dataPagto: dataPagto,
                    caixa: caixa,
                    totalJuros: totalJuros,
                    descto: descto,
                    saldoDevedor: saldoDevedor,
                    contasReceber: contasReceber,
                    formaPagamento: {
                        totalDinheiro: totalDinheiro,
                        totalCheque: totalCheque,
                        totalCartao: totalCartao,
                    },
                    lancarCaixa: {
                        lancarCxDinheiro: true,
                        lancarCxCartao: true,
                        lancarCxCheque: true,
                    },
                },

                url: $scope.urlBase + 'baixar_conta_receber.php?caixaContasReceber=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa=<?=$empresa_acesso?>&token=<?=$token?>'

            }).then(function onSuccess(response) {
                $scope.contasBaixadas = response.data.result[0];

                for (let index = 0; index < $scope.contasBaixadas.length; index++) {

                    if ($scope.contasBaixadas.status == "ERROR") {
                        console.log('ERRO ID ' + $scope.contasBaixadas[index].id)
                    } else {
                        console.log('SUCCESS ID ' + $scope.contasBaixadas[index].id)
                    }

                }

                $('#baixarContaReceber').modal('hide');
                $('#reciboContasBaixadas').modal();
                restContasReceber();

            }).catch(function onError(response) {

                $scope.tipoAlerta = "alert-warning";
                $scope.alertMsg = "Ocorreu um Erro ao Baixar! Caso Persista, Contate o Suporte.";
                chamarAlertaNormal();

            })

        }

    }

}

/*$scope.imprimirRecibo = function() {

    window.open('./pages/printContasReceber.php?printer=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&token=<?=$token?>&cod_cliente=' + $scope.codCliente + '&nomeCliente=' + $scope.nomeCliente + '&ocorrencia=' + $scope.contasBaixadas.ocorrencia + '&valorParcelas=' + $scope.totalParcela + '&totalJuros=' + $scope.totalJuros + '&descto=' + $scope.descto + '&saldoDevedor=' + $scope.saldoDevedor + '&totalPago=' + $scope.totalPago + '&din=' + $scope.Dinheiro + '&cart=' + $scope.Cartao + '&cheq=' + $scope.Cheque + '&troco=' + $scope.troco + '&totalAPagar=' + $scope.totalAPagar);
    $('#reciboContasBaixadas').modal('hide');
    LimparBaixa();

}*/

$scope.imprimirRecibo = function() {

    window.open('./pages/printContasReceber.php?printer=S&us_id=<?=$us_id?>&matriz=<?=$empresa?>&empresa_filial=<?=$empresa_acesso?>&token=<?=$token?>&cod_cliente=' + $scope.codCliente + '&nomeCliente=' + $scope.nomeCliente + '&ocorrencia=' + $scope.contasBaixadas.ocorrencia + '&valorParcelas=' + $scope.totalParcela + '&totalJuros=' + $scope.totalJuros + '&descto=' + $scope.descto + '&saldoDevedor=' + $scope.saldoDevedor + '&totalPago=' + $scope.totalPago + '&din=' + $scope.Dinheiro + '&cart=' + $scope.Cartao + '&cheq=' + $scope.Cheque + '&troco=' + $scope.troco + '&totalAPagar=' + $scope.totalAPagar);
    $('#reciboContasBaixadas').modal('hide');
    LimparBaixa();

}

$scope.impressaoRecibo = function(divNome) {

    var conteudoImpressao = document.getElementById(divNome).innerHTML;
    var windowPopup = window.open('', '_blank', 'width=600,height=600');
    windowPopup.document.open();
    windowPopup.document.write('<html><head><link rel="stylesheet" type="text/css" href="css/printrecibo"  type=\"text/css\" media=\"print\" /></head><body onload="window.print()">' + conteudoImpressao + '</body></html>');
    windowPopup.document.close();

}

$scope.LimparBaixa = function() {

    $scope.totalParcela = 0.00;
    $scope.totalJuros = 0.00;
    $scope.descto = 0.00;
    $scope.saldoDevedor = 0.00;
    $scope.Dinheiro = 0.00;
    $scope.Cheque = 0.00;
    $scope.Cartao = 0.00;
    $scope.totalPago = 0.00;
    $scope.totalAPagar = 0.00;
    $scope.troco = 0.00;

}