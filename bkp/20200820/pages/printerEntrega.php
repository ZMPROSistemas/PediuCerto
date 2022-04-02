<?php

include '../services/conecta.php';
    $empresaMatriz = base64_decode($_GET['empresa_matriz']);

    $empresaAcesso = base64_decode($_GET['empresa_filial']);

    $cliente = utf8_decode($_GET['cliente']);
    $endCliente= utf8_decode($_GET['endCliente']);
    $pedidoTipoEnt = $_GET['pedidoTipo'];
    if($pedidoTipoEnt == 'S'){
        $pedidoTipo = 'Entrega';
    }
    else if($pedidoTipoEnt =='N'){
        $pedidoTipo = 'Retirar';
    }

    $pedidoN = $_GET['pedidoN'];
    $data = date('d/m/Y', strtotime($_GET['dataPedido']));
    $hora = $_GET['horaPedido'];

    $pedidoItens = descricaoItens($conexao, $empresaMatriz, $empresaAcesso, $pedidoN);

    function descricaoItens($conexao, $empresaMatriz, $empresaAcesso, $ped_doc){

        $resultado = array();
    
        $sql= "SELECT * FROM pedido_item_food where pdi_matriz = $empresaMatriz and pdi_empresa = $empresaAcesso and pdi_doc = $ped_doc;";
    
        $query = mysqli_query($conexao, $sql);
    
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                //'pdi_id' => $row['pdi_id'],
                //'pdi_idprim' => $row['pdi_idprim'],
                'pdi_doc' => $row['pdi_doc'],
                //'pdi_empresa' => $row['pdi_empresa'],
                //'pdi_matriz' => $row['pdi_matriz'],
                //'pdi_emis' => utf8_encode($row['pdi_emis']),
                'pdi_produto' => $row['pdi_produto'],
                'pdi_descricao' => utf8_encode($row['pdi_descricao']),
                'pdi_quantidade' => $row['pdi_quantidade'],
                //'pdi_preco_base' => $row['pdi_preco_base'],
                //'pdi_val_desc' => $row['pdi_val_desc'],
                //'pdi_val_adicional' => $row['pdi_val_adicional'],
                'pdi_preco_total_item' => $row['pdi_preco_total_item'],
                'pdi_total' => $row['pdi_total'],
                'pdi_obs' => utf8_encode($row['pdi_obs']),
                //'pdi_status' => utf8_encode($row['pdi_status']),
    
            ));
        }
        
        //echo $sql;
        return $resultado;
    }

?>

<style>

*{
    font-family: Arial, Helvetica, sans-serif;
}
	.print{ color:#000;}

@page {
    size:  80mm 297mm;
    margin: 10px;
    padding:0;
}
.print{
    width: 80mm;
}

@media print {

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

<body onload="ClosePrint()">
    
    <div class="printCozinha print">
    <CENTER>
    <span>-------------------------------------------------</span><br>
    <b>ZM Foods</b>
    </CENTER>
    <br>
    <div>
        
    </div>

    <b><?=$pedidoTipo?> N:<?=$pedidoN?></b><br>

    <span style="margin-top:40px;">Nome: <?=$cliente?></span><br>
    <span>End.: <?=$endCliente?></span><br>
    <span>Data e Hora: <?=$data?> <?=$hora?></span><br>

    <span>-------------------------------------------------</span><br>

    <table>
        <thead>
            <tr>
                <th style="text-align: left;">QNT</th>
                <th style="text-align: left;">Descrição</th>
            </tr>
        </thead>
        
        <tbody>

            <?php
                foreach($pedidoItens as $pedidoItens){?>
                    <tr>
                    <td valign="top" style="text-align: right;"><?=strpos($pedidoItens['pdi_quantidade'],'.00')?></td>
                    <td>
                        <b><?=$pedidoItens['pdi_descricao']?></b><br>
                        <?=$pedidoItens['pdi_obs']?>
                    </td>
                    
                    </tr>
            <?php
                }
            ?>
                   
        </tbody>
    </table>

    <br>
    <center>***<b><?=$pedidoTipo?>***</b></center>
    </div>

    <script type="text/javascript">

   // window.print();
    //window.addEventListener("afterprint", function(event) { window.close(); });
    //window.onafterprint();
       

    </script>

</body>
