<?php

    include '../services/conecta.php';
    $empresaMatriz = base64_decode($_GET['empresa_matriz']);

    $empresaAcesso = base64_decode($_GET['empresa_filial']);

    if($empresaAcesso == 0){
        $empresaAcesso = $empresaMatriz;
    }

    $cliente = utf8_decode($_GET['cliente']);
    $endCliente= utf8_decode($_GET['endCliente']);
    $pedidoTipoEnt = $_GET['pedidoTipo'];
    if($pedidoTipoEnt == 'S'){
        $pedidoTipo = 'Entrega';
    }
    else if($pedidoTipoEnt =='N'){
        $pedidoTipo = 'Retirar';
    }

    $idPedido = base64_decode($_GET['pd_id']);
    
    $pedidoN = $_GET['pedidoN'];
    $data = date('d/m/Y', strtotime($_GET['dataPedido']));
    $hora = $_GET['horaPedido'];

    $dadosEmpresa = dadosEmpresa($conexao, $empresaAcesso);
    $descricaoPedido = descricaoPedido($conexao, $idPedido);
    $pedidoItens = descricaoItens($conexao, $empresaMatriz, $empresaAcesso, $pedidoN);

    function mascara_string($mask,$str){

        $str = str_replace(" ","",$str);
    
        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }
    
        return $mask;
    
    }

    function dadosEmpresa($conexao, $empresaAcesso) {
            
        $sql = "select * from empresas where em_cod = $empresaAcesso;";
    
        $resultado = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_assoc($resultado);
    
        return $row;
    }

    function descricaoPedido($conexao, $id) {

        $sql = "SELECT * FROM zmpro.pedido_food where ped_id = $id";
    
        $query = mysqli_query($conexao, $sql);
    
        $row = mysqli_fetch_assoc($query);
        return $row;
    }


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

.itens table tr td{
  
  border-bottom: 1px dotted #858585;
  font-size:12px;
  
}
.itens table thead tr th {
  border-bottom: 1px dotted #858585;
  font-size:12px;
}

.total{
margin: 0 auto;
margin-top:15px;
width:65mm;
align-items: center;
display: flex;
flex-direction: row;
flex-wrap: wrap;
justify-content: center;
border: 1px dotted #000;
}
.dadosCliente {
    font-size:14px;
    margin-left: 8px;
}
.dadosEmpresa {
    font-size:14px;
}

</style>

<body onload="ClosePrint()">
    
    <div class="printCozinha print">
        <CENTER>
        
        <b>Pediu Certo App</b>
        </CENTER>
    
        <div class="dadosEmpresa">
            <CENTER>
            <span>------------------------------------------------</span><br>
            <span><?=utf8_encode($dadosEmpresa['em_fanta'])?></span><br>
            <span><?=utf8_encode($dadosEmpresa['em_end'])?></span><br>
            <span><?=utf8_encode($dadosEmpresa['em_cid'])?></span><br>
            <span>Data e Hora: <?=$data?> <?=$hora?></span><br>
            
            </CENTER>
            <br>
            <b style="margin-left:8px;"><?=$pedidoTipo?> N:<?=$pedidoN?></b><br>

        </div>
        <span>------------------------------------------------</span><br>

        <div class="dadosCliente">
            <span>Fone: <?=$descricaoPedido['ped_cliente_fone']?></span><br>
            <span style="margin-top:40px;">Nome: <?=utf8_encode($descricaoPedido['ped_cliente_nome'])?></span><br>
            <span>End.: <?=utf8_encode($descricaoPedido['ped_cliente_end_entrega']).', '. $descricaoPedido['ped_cliente_end_num_entrega']?></span><br>
            <span>Bairro: <?=utf8_encode($descricaoPedido['ped_cliente_bairro_entrega'])?></span><br>
            <br>
            <span>Ref.: <?=utf8_encode($descricaoPedido['ped_cliente_compl_entrega'])?></span><br>
        
        </div>
    <?php

    ?>
        <span>------------------------------------------------</span><br>

        <div class="itens">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left; font-weight: normal;">QNT</th>
                        <th style="text-align: left; font-weight: normal;">Descrição</th>
                        <th style="text-align: left; font-weight: normal;">V. Unit.</th>
                        <th style="text-align: left; font-weight: normal;">V. Total.</th>
                    </tr>
                </thead>
                
                <tbody>

                    <?php
                    
                        foreach($pedidoItens as $pedidoItens){?>
                            <tr>
                            <td valign="top" style="text-align: right;"><?=number_format($pedidoItens['pdi_quantidade'],0)?></td>
                            <td>
                                <?=utf8_encode($pedidoItens['pdi_descricao'])?><br>
                                <?php
                                    if ($pedidoItens['pdi_obs'] != null){ ?>
                                    Obs: <?=utf8_encode($pedidoItens['pdi_obs'])?>
                                <?php
                                    }
                                ?>
                                
                            </td>
                            <td valign="top" align="right"><?=$pedidoItens['pdi_preco_total_item']?><br></td>
                            <td valign="top" align="right"><?=$pedidoItens['pdi_total']?><br></td>
                            
                            </tr>
                    <?php
                        }
                    ?>
                        
                </tbody>
            </table>
        </div>

<!-- Imprime Totais -->
        <div class="total">
            <table>
                <tbody>
                    <tr>
                        <td align="right">SubTotal</td>
                        <td width="90px" align="right">R$ <?=$descricaoPedido['ped_valor']?></td>
                    </tr>
                    <?php
                    if ($descricaoPedido['ped_val_entrega'] != null) { ?>
                        <tr>
                            <td align="right">Tx. Entrega</td>
                            <td width="90px" align="right">R$ <?=$descricaoPedido['ped_val_entrega']?></td>
                        </tr>
                    <?php        
                    }
                    if($descricaoPedido['ped_pago'] == 'N'){?>  
                        <tr style="border: 1px dotted #000 !important;">
                            <td align="right">Cobrar Do Cliente </td>
                            <td width="90px" align="right">R$ <?=$descricaoPedido['ped_total']?></td>
                        </tr>
                    <?php
                    }
                    if($descricaoPedido['ped_pago'] == 'S'){?>  
                        <tr style="border: 1px dotted #000 !important;">
                            <td align="right">Total </td>
                            <td width="90px" align="right">R$ <?=$descricaoPedido['ped_total']?></td>
                        </tr>
                    <?php
                    }
                    if($descricaoPedido['ped_troco_para'] != null and $descricaoPedido['ped_troco_para'] != 0.00){ 
                        $val_troco = $descricaoPedido['ped_troco_para']-$descricaoPedido['ped_total']; ?>
                        <tr style="border: 1px dotted #000 !important;">
                            <td align="right">Troco Para </td>
                            <td width="90px" align="right">R$ <?=$descricaoPedido['ped_troco_para']?></td>
                        </tr>
                        <tr style="border: 1px dotted #000 !important;">
                            <td align="right">Valor do Troco </td>
                            <td width="90px" align="right">R$ <?=number_format($val_troco,2,'.','')?></td>
                        </tr>
                    <?php
                    }?>
                </tbody>
            </table>
            <?php
            if($descricaoPedido['ped_pago'] == 'S'){?>
                <span style="padding:10px; font-size:14px;">PEDIDO PAGO PELO APLICATIVO</span>
            <?php
            }?>
        </div>
        <?php
        if ($descricaoPedido['ped_pago'] == 'N') { ?>
            <p></p>
            <center>
                <b>***Forma: 
                <?php
                    if($descricaoPedido['ped_val_pg_dn'] != null and $descricaoPedido['ped_val_pg_dn'] != 0.00){
                        echo "DINHEIRO";
                    }
                    if($descricaoPedido['ped_val_pg_ca'] != null and $descricaoPedido['ped_val_pg_ca'] != 0.00){
                        echo "CARTÃO";
                    }?>
                ***
            </b>
            </center>
        <?php 
        } ?>
        <p></p>
        <p></p>
        <p></p>
        <center><small style="font-size:8px;">Desenvolvido por Pediu Certo© <br>Aplicativo de pedidos - (43) 98426-1751</small></center>
    </div>



    <script type="text/javascript">

    window.print();
    window.addEventListener("afterprint", function(event) { window.close(); });
    window.onafterprint();
       

    </script>

</body>
