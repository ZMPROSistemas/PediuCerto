<?php

/*
	CRIADO POR KLEYTHON EM 14/08/2020

*/

require_once 'conecta.php';


$empresaAcesso = $_GET['empresa'];
$ano = $_GET['ano'];
$mes = $_GET['mes'];

if (isset($_GET['TotalVendas'])) {

	$lista = '{"result":[' . json_encode(TotalVendas($conexao, $empresaAcesso, $ano, $mes)) . ']}';
	echo $lista;

} 

if (isset($_GET['TotalCustoMercadorias'])) { 

	$lista = '{"result":[' . json_encode(TotalCustoMercadorias($conexao, $empresaAcesso, $ano, $mes)) . ']}';
	echo $lista;

}

if (isset($_GET['TotalCustosFixos'])) {

	$lista = '{"result":[' . json_encode(TotalCustosFixos($conexao, $empresaAcesso, $ano, $mes)) . ']}';
	echo $lista;

}

function TotalCustoMercadorias($conexao, $empresaAcesso, $ano, $mes){
    $dados = array();
	$resultado = mysqli_query($conexao,"call totalCustoMercadoriaMes($empresaAcesso,'$ano','$mes');");
    if ($resultado != null) {
        $dados = mysqli_fetch_assoc($resultado);
     } else {
        $dados = [''];
     }
	return $dados;
}

function TotalVendas($conexao, $empresaAcesso, $ano, $mes){
    $dados = array();
    $resultado = mysqli_query($conexao,"call totalVendasMes($empresaAcesso,'$ano','$mes');");
    
    if ($resultado != null) {
       $dados = mysqli_fetch_assoc($resultado);
    } else {
       $dados = [''];
    }
    
	return $dados;
}


function TotalCustosFixos($conexao, $empresaAcesso, $ano, $mes){

    $dados = array();
	$resultado = mysqli_query($conexao,"call totalCustosFixosMes($empresaAcesso,'$ano','$mes');");
    
    if ($resultado != null) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            array_push($dados, array(
                'ct_valor' => $row['ct_valor'],
                'ct_historico' => $row['ct_historico'],
                'ct_desc_hist' => ucwords(strtolower(utf8_encode($row['ct_desc_hist']))),
     
            ));
        } 
    } else {
        $dados = [''];
    }
    return $dados;
} 

/*function dadosCustosFixos($conexao, $token){

    $retorno = array();

    $query = $conexao -> query("call buscaCustosFixos('$token');", MYSQLI_STORE_RESULT);
    
    while ($row = $query -> fetch_array(MYSQLI_ASSOC)) {
        array_push($retorno, array(
            'cf_id' => $row['cf_id'],
            'cf_empresa' => $row['cf_empresa'],
            'em_fanta' => ucwords(strtolower(utf8_decode($row['em_fanta']))),
            'cf_matriz' => $row['cf_matriz'],
            'cf_nome' => ucwords(strtolower(utf8_decode($row['cf_nome']))),
            'cf_ativo' => $row['cf_ativo'],
            'cf_historico' => $row['cf_historico'],
        ));
    }
    
    return $retorno;
 
}

function clearStoredResults($mysqli_link){

    do while($mysqli_link->next_result()){
        if($l_result = $mysqli_link->store_result()){
                $l_result->free();
        }
    }
}

    function historicoBancario($conexao, $token, $grp_id){
        $retorno = array();
        $sql = "SELECT ht_id, ht_empresa, (SELECT em_fanta FROM empresas where em_cod = ht_empresa) as pd_empresa, ht_matriz
        ht_cod, ht_descricao, ht_grupo, ht_tipogrup, ht_dc, ht_ordem, ht_centro_custo, ht_desc_centrocusto
        FROM historico where ht_matriz = (SELECT em_cod FROM empresas where em_token = '$token') AND ht_id = $grp_id ORDER BY ht_descricao LIMIT 0, 100;";

        $query = mysqli_query($conexao, $sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($retorno, array(
                'ht_id' =>$row['ht_id'],
                'ht_empresa' =>$row['ht_empresa'],
                'pd_empresa' => utf8_encode($row['pd_empresa']),
                'ht_cod' =>$row['ht_cod'],
                'ht_descricao' =>utf8_encode($row['ht_descricao']),
                'ht_grupo' =>$row['ht_grupo'],
                'ht_tipogrup' =>$row['ht_tipogrup'],
                'ht_dc' =>utf8_encode($row['ht_dc']),
                'ht_ordem' =>$row['ht_ordem'],
                'ht_centro_custo' =>$row['ht_centro_custo'],
                'ht_desc_centrocusto' =>utf8_encode($row['ht_desc_centrocusto']),

            ));

        }
        return $retorno;
    }

    function salvarHistoricoBancario($conexao, $token, $ht_descricao, $ht_dc, $data, $hora, $ip, $us_id){
        
        $sql = "INSERT INTO historico (ht_cod, ht_empresa, ht_matriz,  ht_descricao, ht_grupo, ht_tipogrup, ht_dc, ht_ordem, ht_centro_custo, 
        ht_desc_centrocusto) select (max(ht_cod)+1), $empresaMatriz, $empresaMatriz, '$ht_descricao', 0, 0,'$ht_dc', 0, 0, 'NENHUM' FROM historico where (SELECT em_cod FROM empresas where em_token = '$token');";

        $query = mysqli_query($conexao,$sql);
        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
            logSistema_forID($conexao, $data, $hora, $ip, $us_id, utf8_decode('Histórico Criado Nome - ' . $ht_descricao . ''), $empresaAcesso, $empresaMatriz);
        }
    }

    function editarHistoricoBancario($conexao, $token, $ht_descricao, $ht_dc, $ht_id, $data, $hora, $ip, $us_id){
        $sql = "UPDATE historico SET ht_descricao = '$ht_descricao', ht_dc = '$ht_dc' where ht_matriz = (SELECT em_cod FROM empresas where em_token = '$token') 
        AND ht_id=$ht_id";
        $query = mysqli_query($conexao, $sql);
        
        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
            logSistema_forID($conexao, $data, $hora, $ip, $us_id, utf8_decode('Histórico Modificado  Nome - ' . $ht_descricao . ''), $empresaAcesso, $empresaMatriz);
        }
    }

    function excluirHistoricoBancario($conexao, $token, $ht_descricao, $ht_id, $data, $hora, $ip, $us_id){
        
        $sql = "DELETE FROM historico WHERE ht_matriz = (SELECT em_cod FROM empresas where em_token = '$token') 
        AND ht_id=$ht_id;";
        $query = mysqli_query($conexao,$sql);

        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
            logSistema_forID($conexao, $data, $hora, $ip, $us_id, utf8_decode('Histórico Deletado  Nome - ' . $ht_descricao . ''), $empresaAcesso, $empresaMatriz);
        }

    }

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }*/
?>