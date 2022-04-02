<style>
body{
    background-color: rgb(189, 196, 199);

}
*{
    font-family: Arial, Helvetica, sans-serif;
    font-size:0.95em;
}
	.print{ color:#000;}
.pagePrint{
    margin:0 auto; 
    padding-top:10px;
    padding-left: 5px; 
    width:80mm; 
    height:100%; 
    background:rgb(255,255,255);
    box-shadow: -3px 5px 3px 3px rgba(0,0,0, 0.2);
}
@page {
    size:  80mm 297mm;
    margin: 10px;
    padding:0;
}
.print{
    width: 80mm;
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


<?php

    include '../services/conecta.php';
    include '../services/api/valorPorExtenso.php';
    
    $matriz= base64_decode($_GET['matriz']);
    $empresa_filial=base64_decode($_GET['empresa_filial']);

    if ($empresa_filial == 0){
        $empresa_filial = $matriz;
    }
    $us_id = base64_decode($_GET['us_id']);
    $token= $_GET['token'];
    $cod_cliente = $_GET['cod_cliente'];
    $nomeCliente = utf8_encode($_GET['nomeCliente']);
    $ocorrencia = $_GET['ocorrencia'];
    $valorParcelas = $_GET['valorParcelas'];
    $totalJuros = $_GET['totalJuros'];
    $descto = $_GET['descto'];
    $saldoDevedor = number_format($_GET['saldoDevedor'],2);
    $totalPago = $_GET['totalPago'];
    $troco = $_GET['troco'];
    
    $din = str_replace('R','', $_GET['din']);
    $din = str_replace('$', '',$din);
    $din = str_replace(',', '.',$din);

    $cart = str_replace('R', '', $_GET['cart']);
    $cart = str_replace('$', '',$cart);
    $cart = str_replace(',', '.',$cart);

    $cheq = str_replace('R', '', $_GET['cheq']);
    $cheq = str_replace('$', '',$cheq);
    $cheq = str_replace(',', '.',$cheq);

    $troco = number_format($_GET['troco'],2);

    $valorPago = $din + $cart + $cheq;

    $empresa = empresa($conexao, $matriz, $empresa_filial);
    $usuario = usuario($conexao, $matriz, $empresa_filial, $us_id);
    $conta = conta($conexao, $matriz, $empresa_filial, $ocorrencia, $cod_cliente);

    $valorPorExtenso = valorPorExtenso($totalPago, true, false );

    $recibo ='<body onload="ClosePrint()">';
    $recibo .= '<div style="" class="pagePrint">';
    $recibo .= '<div style="text-align:center; margin-bottom:15px;"><font class="f0"><b>RECIBO</b></font></div>';

    $recibo .= '<font style="text-align:center;">-----------------------------------------------------------------</font><br>';
    $recibo .= '<div style="text-align: center;"><b>'.utf8_encode($empresa['em_fanta']) . '</b></div>';
    $recibo .= '<div style="text-align: center;"><b>'.utf8_encode($empresa['em_end']) .', '.$empresa['em_end_num']. '</b></div>';
    $recibo .= '<div style="text-align: center;"><b>'.$empresa['em_fone'] . ' '.utf8_encode($empresa['em_cid']).' - '.utf8_encode($empresa['em_uf']). '</b></div>';
    $recibo .= '<font style="text-align:center;">-----------------------------------------------------------------</font><br>';
    
    $recibo .= '<div style="">Valor Pago: <b>R$'. number_format($valorPago,2).'</b></div>';
    $recibo .='<br>';
    $recibo .= '<div style="">Recebi(emos) de <b>'.$nomeCliente.'</b></div>';
    $recibo .= '<div style="">Código <b>'.$cod_cliente.'</b></div>';
    $recibo .= '<div style="">a importância supra de R$ <b>'. $totalPago.'</b></div>';
    $recibo .= '<div style=""> <b>'.strtoupper($valorPorExtenso). '</b></div>';
    $recibo .= '<div style="">Referente a(s) seguinte(s) parcela(s): </div>';
    $recibo .= '<table style="margin-top:15px; width:100%;">';
    $recibo .= '<thead class="thead-dark" border="1">';

    $recibo .= '<tr style="font-size: 0.9em !important;">';

    $recibo .= '<th scope="col" style="text-align: left;">Docto</th>';
    $recibo .= '<th scope="col" style="text-align: left;">Parcela</th>';
    $recibo .= '<th scope="col" style="text-align: left;">Vencto</th>';
    $recibo .= '<th scope="col" style="text-align: left;">Valor</th>';
    $recibo .= '<th scope="col" style="text-align: left;">Val. Pago</th>';
    
    $recibo .= '</tr>';

    $recibo .= '</thead>';
    
    $recibo .= '<tbody style="font-size: 0.8em">';
    foreach($conta as $conta){
        
        $recibo .= '<tr>';

        $recibo .= '<td style="text-align: center;">'. $conta['ct_docto']. '</td>';
        $recibo .= '<td>'. $conta['ct_parc']. '</td>';
        $recibo .= '<td>'. date('d/m/Y', strtotime($conta['ct_vencto'])). '</td>';
        $recibo .= '<td>'. $conta['ct_valor']. '</td>';
        $recibo .= '<td style="text-align: center;">'. $conta['ct_valorpago']. '</td>';

        $recibo .= '</tr>';
        
    }
    $recibo .= '</tbody>';
    $recibo .= '</table>';

    $recibo .= '<table style="margin-top:15px; margin-right:10px;" align="right">';
    $recibo .= '<tbody style="font-size: 0.8em">';
    $recibo .= '<tr>';
    $recibo .= '<td style="width:100px;">Pago Em Dinheiro: </td>';
    $recibo .= '<td style="text-align: right;">R$ '. number_format($din,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Pago Em Cartão: </td>';
    $recibo .= '<td style="text-align: right;">R$ '. number_format($cart,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Pago Em Cheque: </td>';
    $recibo .= '<td style="text-align: right;">R$ '. number_format($cheq,2) .'</td>';
    $recibo .= '</tr>';

    if ($troco < 0) {
        $recibo .= '<tr>';
        $recibo .= '<td>Saldo Devedor: </td>';
        $recibo .= '<td style="text-align: right;">R$ '. $saldoDevedor .'</td>';
        $recibo .= '</tr>';
    }else{
        $recibo .= '<tr>';
        $recibo .= '<td>Troco: </td>';
        $recibo .= '<td style="text-align: right;">'. $troco .'</td>';
        $recibo .= '</tr>';
    }
    $recibo .= '</tbody>';
    $recibo .= '</table>';
   
    $recibo .= '<p style="color:#ffffff;">___________________________</p>';

    $recibo .= '<div style="text-align: center; margin-top: 25px;">Para maior clareza firmo o presente recibo de acordo com a lei. </div>';
    $recibo .= '<p></p>';

    $recibo .= '<div style="text-align: center; margin-top: 30px;">_______________________________</div>';
    $recibo .= '<div style="text-align: center;"><b>'.utf8_encode($empresa['em_razao']) . '</b></div>';
 
    $recibo .= '</div>';

    $recibo .= '</body>';

    echo $recibo;
 ?>
    
    <script type="text/javascript">
/*
        window.print();
        window.addEventListener("afterprint", function(event) { window.close(); });
        window.onafterprint();
       */
      LimparBaixa();

    </script>
    <?php
    function empresa($conexao, $matriz, $empresa){
        
        $sql = "SELECT em_fanta, em_end, em_end_num, em_fone, em_cid, em_uf, em_razao FROM empresas where em_cod =  $empresa;";
        $query = mysqli_query($conexao, $sql);

        $row = mysqli_fetch_assoc($query);

        return $row;
    }

    function usuario($conexao, $matriz, $empresa, $us_id){
        $sql = "SELECT * FROM zmpro.usuarios where us_cod = $us_id and us_empresa=$empresa;";
        $query = mysqli_query($conexao, $sql);

        $row = mysqli_fetch_assoc($query);

        return $row;
    }

    function conta($conexao, $matriz, $empresa, $ocorrencia, $cod_cliente){
        $result = array();
        $sql = "SELECT * FROM contas where ct_empresa = $empresa and ct_receber_pagar='R' and ct_quitado = 'S' and ct_ocorrencia = $ocorrencia and ct_cliente_forn=$cod_cliente order by ct_parc;";
        $query = mysqli_query($conexao, $sql);

        while ($row = mysqli_fetch_assoc($query)){
            array_push($result, array(
                'ct_id' => $row['ct_id'],
                'ct_docto' => $row['ct_docto'],
                'ct_cliente_forn' => $row['ct_cliente_forn'],
                'ct_emissao' => $row['ct_emissao'],
                'ct_vencto' => $row['ct_vencto'],
                'ct_valor' => $row['ct_valor'],
                'ct_parc' => $row['ct_parc'],
                'ct_nome' => $row['ct_nome'],
                'ct_pagto' => $row['ct_pagto'],
                'ct_valorpago' => $row['ct_valorpago'],
                'ct_descto' => $row['ct_descto'],
                'ct_caixa' => $row['ct_caixa'],
                'ct_ocorrencia' => $row['ct_ocorrencia'],
                'ct_quitado' => $row['ct_quitado'],
                'ct_historico' => $row['ct_historico'],
                'ct_desc_hist' => $row['ct_desc_hist'],
                
            ));
        };
        return $result;
    }
