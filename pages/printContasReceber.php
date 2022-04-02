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
.print{ 
    width: 78mm;
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
    
    date_default_timezone_set('America/Bahia');

    $matriz= base64_decode($_GET['matriz']);
    $empresa_filial=base64_decode($_GET['empresa_filial']);

    $data = date('d/m/Y');
    $hora = date('H:i:s');

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
    $totalAPagar = number_format($_GET['totalAPagar'], 2);
    $totalPago = number_format($_GET['totalPago'], 2);
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

    $valorPago = number_format(($din + $cart + $cheq),2);

    $empresa = empresa($conexao, $matriz, $empresa_filial);
    $usuario = usuario($conexao, $matriz, $empresa_filial, $us_id);
    $conta = conta($conexao, $matriz, $empresa_filial, $ocorrencia, $cod_cliente);

    $valorPorExtenso = valorPorExtenso($valorPago, true, false );

    $recibo ='<body onload="ClosePrint()">';
    $recibo .= '<div style="" class="pagePrint">';
    $recibo .= '<div style="text-align:center; margin-bottom:10px;font-size: 1.2em !important;"><b>RECIBO</b></div>';

    $recibo .= '<hr>';
    $recibo .= '<div style="text-align: center;"><b>'.utf8_encode($empresa['em_fanta']) . '</b></div>';
    $recibo .= '<div style="text-align: center;"><b>'.utf8_encode($empresa['em_end']) .', '.$empresa['em_end_num']. '</b></div>';
    $recibo .= '<div style="text-align: center;"><b>'.$empresa['em_fone'] . ' '.utf8_encode($empresa['em_cid']).' - '.utf8_encode($empresa['em_uf']). '</b></div>';
    $recibo .= '<hr>';
    $recibo .= '<div style="text-align: left;">Recebi(emos) de: <b>'.$nomeCliente.'</b></div>';
    $recibo .= '<div style="text-align: left;">Código do Cliente: <b>'.$cod_cliente.'</b></div>';
    $recibo .= '<div style="text-align: left;">Valor: <b>R$ '. $valorPago.' ('.strtoupper($valorPorExtenso). ')</b></div>';
    $recibo .= '<div style="text-align: left;">Referente a(s) seguinte(s) parcela(s):</div>';
    
    $recibo .= '<table style="margin-top:15px; width:100%;">';
    $recibo .= '<thead class="thead-dark" border="1">';
    $recibo .= '<tr style="font-size: 0.9em !important;">';

    $recibo .= '<th scope="col" style="text-align: left;">Docto</th>';
    $recibo .= '<th scope="col" style="text-align: center;">Parcela</th>';
    $recibo .= '<th scope="col" style="text-align: center;">Vencto</th>';
    $recibo .= '<th scope="col" style="text-align: right;">Valor</th>';
    $recibo .= '<th scope="col" style="text-align: center;">Pagto</th>';

    $recibo .= '</tr>';
    $recibo .= '</thead>';
    
    $recibo .= '<tbody style="font-size: 0.8em">';

    foreach($conta as $conta){
        $recibo .= '<tr>';
        $recibo .= '<td style="text-align: left;">'. $conta['ct_docto']. '</td>';
        $recibo .= '<td style="text-align: center;">'. $conta['ct_parc']. '</td>';
        $recibo .= '<td style="text-align: center;">'. date('d/m/Y', strtotime($conta['ct_vencto'])). '</td>';
        $recibo .= '<td style="text-align: right;">'. $conta['ct_valor']. '</td>';
        $recibo .= '<td style="text-align: center;">'.date('d/m/Y', strtotime( $conta['ct_pagto'])). '</td>';
        $recibo .= '</tr>';
    }

    $recibo .= '</tbody>';
    $recibo .= '</table>';

    $recibo .= '<table style="margin-top:15px; margin-right:10px;" align="right">';
    $recibo .= '<tbody style="font-size: 0.8em">';

    $recibo .= '<tr>';
    $recibo .= '<td style="width:100px;">Valor Principal: </td>';
    $recibo .= '<td style="text-align: right;"><b>R$ '. number_format($valorParcelas,2) .'</b></td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Desconto: </td>';
    $recibo .= '<td style="text-align: right;">(-) '. number_format($descto,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Juros: </td>';
    $recibo .= '<td style="text-align: right;">'. number_format($totalJuros,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Subtotal: </td>';
    $recibo .= '<td style="text-align: right;"><b>R$ '. number_format($totalAPagar,2) .'</b></td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Dinheiro: </td>';
    $recibo .= '<td style="text-align: right;">'. number_format($din,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Cartão: </td>';
    $recibo .= '<td style="text-align: right;">'. number_format($cart,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td>Cheque: </td>';
    $recibo .= '<td style="text-align: right;">'. number_format($cheq,2) .'</td>';
    $recibo .= '</tr>';

    $recibo .= '<tr>';
    $recibo .= '<td><b>Total Pago: </b></td>';
    $recibo .= '<td style="text-align: right;"><b>R$ '. number_format($valorPago,2) .'</b></td>';
    $recibo .= '</tr>';


    if ($saldoDevedor > 0) {
        $recibo .= '<tr>';
        $recibo .= '<td>Saldo Devedor: </td>';
        $recibo .= '<td style="text-align: right;"><b>R$ '. $saldoDevedor .'</b></td>';
        $recibo .= '</tr>';
    } elseif ($troco > 0){
        $recibo .= '<tr>';
        $recibo .= '<td>Troco: </td>';
        $recibo .= '<td style="text-align: right;"><b>R$ '. $troco .'</b></td>';
        $recibo .= '</tr>';
    }

    $recibo .= '</tbody>';
    $recibo .= '</table>';
   
    $recibo .= '<p style="text-align: center; color:#ffffff;">___________________________</p>';

    $recibo .= '<div style="text-align: center; margin-top: 10px;">Para maior clareza, firmo o presente. </div>';
    $recibo .= '<div style="text-align: center;">'.utf8_encode($empresa['em_cid']).', '.$data.' '.$hora.' </div>';

    $recibo .= '<p></p>';

    $recibo .= '<div style="text-align: center; margin-top: 30px;">_______________________________</div>';
    $recibo .= '<div style="text-align: center;"><b>'.utf8_encode($empresa['em_razao']) . '</b></div>';
 
    $recibo .= '</div>';

    $recibo .= '</body>';

    echo $recibo;
 ?>
    
    <script type="text/javascript">

        window.print();

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

    function cliente($conexao, $cod_cliente, $nomeCliente, $matriz, $empresa){

        $sql = "select pe_id, pe_endereco, pe_end_num, pe_cidade, pe_cpfcnpj from pessoas where pe_empresa = $empresa and pe_cod= $cod_cliente and pe_cliente = 'S';";

        $query = mysqli_query($conexao, $sql);

        $row = mysqli_fetch_assoc($query);
        
        return $row;
    }
    
    function conta($conexao, $matriz, $empresa, $ocorrencia, $cod_cliente){
        $result = array();
        $sql = "SELECT ct_id, ct_docto, ct_vencto, ct_valor, ct_parc, ct_valorpago, ct_pagto FROM contas where ct_matriz = $matriz and ct_receber_pagar='R' and ct_quitado = 'S' and ct_cliente_forn = $cod_cliente and ct_ocorrencia = $ocorrencia  order by ct_parc;";
        $query = mysqli_query($conexao, $sql);

        while ($row = mysqli_fetch_assoc($query)){
            array_push($result, array(
                'ct_id' => $row['ct_id'],
                'ct_docto' => $row['ct_docto'],
                'ct_vencto' => $row['ct_vencto'],
                'ct_valor' => $row['ct_valor'],
                'ct_parc' => $row['ct_parc'],
                'ct_valorpago' => $row['ct_valorpago'],
                'ct_pagto' => $row['ct_pagto'],
            ));
        };
        //echo $sql;
        return $result;
    }

?>
