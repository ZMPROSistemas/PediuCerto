<?php

    include '../services/conecta.php';
    include '../services/api/valorPorExtenso.php';
    
    date_default_timezone_set('America/Bahia');

?>

<style>

body{
    background-color: rgb(189, 196, 199);

}

*{
    font-family: Arial, Helvetica, sans-serif;
    font-size:0.95em;
}

.print{ 
    width: 78mm;
    color:#000;
}

.pagePrint{
    margin:0 auto; 
    padding-top:10px;
    padding-left: 5px; 
    padding-right: 5px; 
    width:80mm; 
    height:100%; 
    background:rgb(255,255,255);
    box-shadow: -3px 5px 3px 3px rgba(0,0,0, 0.2);
}

@page {
    size:  78mm 297mm;
    margin: 10px;
    padding: 2px;
}

@media print {
    .pagePrint{
        height: auto;
        box-shadow: none;
        padding:auto;
    }
    .noPrint{
        display:none;
    }

    .print{
        margin: 0 auto;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}

table tr td{
  
  border-bottom: 1px dotted #858585;
}

</style>


<html>
    <body>
        <div class="pagePrint" id="reciboContaReceber">
            <div style="text-align:center; margin-bottom:10px;font-size: 1.2em !important;"><b>RECIBO</b></div>
            <hr>
            <div style="text-align: center;"><b>{{dadosEmpresa.em_fanta}}</b></div>
            <div style="text-align: center;"><b>{{dadosEmpresa.em_end}}, {{dadosEmpresa.em_end_num}}</b></div>
            <div style="text-align: center;"><b>{{dadosEmpresa.em_fone}} {{dadosEmpresa.em_cid}} - {{dadosEmpresa.em_uf}}</b></div>
            <hr>
            <div style="text-align: left;">Recebi(emos) de: <b>{{nomeCliente}}</b></div>
            <div style="text-align: left;">Código do Cliente: <b>{{codCliente}}</b></div>
            <div style="text-align: left;">Valor: <b>{{totalPago | currency: 'R$ '}} {{valorPorExtenso}}</b></div>
            <div style="text-align: left;">Referente a(s) seguinte(s) parcela(s):</div>
        
            <table style="margin-top:15px; width:100%;">
                <thead class="thead-dark" border="1">
                    <tr style="font-size: 0.9em !important;">
                        <th scope="col" style="text-align: left;">Docto</th>
                        <th scope="col" style="text-align: center;">Parcela</th>
                        <th scope="col" style="text-align: center;">Vencto</th>
                        <th scope="col" style="text-align: right;">Valor</th>
                        <th scope="col" style="text-align: center;">Pagto</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8em">
                    <tr ng-repeat="conta in contasReceberSelect">
                        <td style="text-align: left;">{{conta.ct_docto}}</td>
                        <td style="text-align: center;">{{conta.ct_parc}}</td>
                        <td style="text-align: center;">{{conta.ct_vencto | date: 'dd/MM/yyyy'}}</td>
                        <td style="text-align: right;">{{conta.ct_valor | currency: ' '}}</td>
                        <td style="text-align: center;">{{conta.ct_pagto | date: 'dd/MM/yyyy'}}</td>
                    </tr>
                </tbody>
            </table>

            <table style="margin-top:15px; margin-right:10px;" align="right">
                <tbody style="font-size: 0.8em">

                    <tr>
                        <td style="width:100px;">Valor Principal: </td>
                        <td style="text-align: right;"><b>{{totalParcela | currency: 'R$ '}}</b></td>
                    </tr>

                    <tr>
                        <td>Desconto: </td>
                        <td style="text-align: right;">(-) {{descto | currency: ' '}}</td>
                    </tr>

                    <tr>
                       <td>Juros: </td>
                        <td style="text-align: right;">{{totalJuros | currency: ' '}}</td>
                    </tr>

                    <tr>
                        <td>Subtotal: </td>
                        <td style="text-align: right;"><b>{{totalAPagar | currency: 'R$ '}}</b></td>
                    </tr>

                    <tr>
                        <td>Dinheiro: </td>
                        <td style="text-align: right;">{{Dinheiro | currency: ' '}}</td>
                    </tr>

                    <tr>
                        <td>Cartão: </td>
                        <td style="text-align: right;">{{Cartao | currency: ' '}}</td>
                    </tr>

                    <tr>
                        <td>Cheque: </td>
                        <td style="text-align: right;">{{Cheque | currency: ' '}}</td>
                    </tr>

                    <tr>
                        <td><b>Total Pago: </b></td>
                        <td style="text-align: right;"><b>{{totalPago | currency: 'R$ '}}</b></td>
                    </tr>


                    <tr ng-if="saldoDevedor > 0">
                        <td>Saldo Devedor: </td>
                        <td style="text-align: right;"><b>{{saldoDevedor | currency: 'R$ '}}</b></td>
                    </tr>

                    <tr ng-if="troco > 0">
                        <td>Troco: </td>
                        <td style="text-align: right;"><b>{{troco | currency: 'R$ '}}</b></td>
                    </tr>

                </tbody>
            </table>
            <hr>
            <div style="text-align: center; margin-top: 25px;">Para maior clareza, firmo o presente. </div>
            <div style="text-align: center;">{{dadosEmpresa.em_cid}}, {{dataHora}}</div>

            <p></p>

            <div style="text-align: center; margin-top: 30px;">_______________________________</div>
            <div style="text-align: center;"><b>{{dadosEmpresa.em_razao}}</b></div>
        </div>
    </body>
</html>
