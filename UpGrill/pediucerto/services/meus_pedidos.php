<?php
    session_name('http://localhost/pediucerto');
    session_start();

    require_once 'conn.php';

   $user = $_GET['user'];
   $token = $_GET['token'];

   $retorno =json_encode(pedidos($conexao, $user, $token));

    echo $retorno;
  
   function pedidos($conexao, $user, $token){

        $pedidos = array();

        $sql = "SELECT * FROM zmpro.pedido_food where ped_empresa = (select em_cod from empresas where em_token='$token') and ped_cliente_cod = $user";
        $query = mysqli_query($conexao, $sql);

        while ($row = mysqli_fetch_assoc($query)){
            array_push($pedidos, array(
                'ped_id' => $row['ped_id'],
                'ped_doc' => $row['ped_doc'],
                'ped_emis' => $row['ped_emis'],
                'ped_hora_entrada' => $row['ped_hora_entrada'],
                'ped_valor' => $row['ped_valor'],
                'ped_val_entrega' => $row['ped_val_entrega'],
                'ped_total' => $row['ped_total'],
                'ped_status' => utf8_encode($row['ped_status']),
                'ped_confirmado' => utf8_encode($row['ped_confirmado']),
                'ped_finalizado' => utf8_encode($row['ped_finalizado']),
                'pedidos_item' => pedidos_item($conexao , $row['ped_id']),

            ));
        };

        return $pedidos;
   }

   function pedidos_item($conexao , $idPedido){

        $pedidos_item = array();

        $sql = "SELECT pdi_id, pdi_emis, pdi_produto, pdi_descricao, pdi_quantidade, pdi_total, pdi_obs, pdi_status
         FROM zmpro.pedido_item_food where pdi_empresa = 15 and pdi_idprim = $idPedido;";

         $query = mysqli_query($conexao, $sql);

         while ($row = mysqli_fetch_assoc($query)){

            array_push($pedidos_item, array(
                'pdi_id' => $row['pdi_id'], 
                'pdi_emis' => $row['pdi_emis'], 
                'pdi_produto' => $row['pdi_produto'], 
                'pdi_descricao' => utf8_encode($row['pdi_descricao']), 
                'pdi_quantidade' => $row['pdi_quantidade'], 
                'pdi_total' => $row['pdi_total'], 
                'pdi_obs' => $row['pdi_obs'], 
                'pdi_status' => $row['pdi_status'],

            ));
         }
         return $pedidos_item;
   }