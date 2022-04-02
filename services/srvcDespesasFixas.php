<?php

/*
	CRIADO POR KLEYTHON EM 13/08/2020

*/

  require_once 'conecta.php';

    
if (isset($_GET['historico'])) {

    $token = $_GET['token'];
 
    $lista = '{"result":[' . json_encode(dadosHistorico($conexao, $token)) . ']}';
 
    echo $lista;

}

if (isset($_GET['custos'])) {

    $token = $_GET['token'];
    
    $lista = '{"result":[' . json_encode(dadosCustosFixos($conexao, $token)) . ']}';

    echo $lista;

}

if (isset($_GET['salvar'])) {

    $empresa = $_GET['empresa'];
    $ht_id = $_GET['ht_id'];
        
    $lista = '{"result":[' . json_encode(adicionaDespesaFixa($conexao, $empresa, $ht_id)) . ']}';

    echo $lista;

}

if (isset($_GET['excluir'])) {

    $cf_id = $_GET['item'];
        
    $lista = '{"result":[' . json_encode(excluirTipoCusto($conexao, $cf_id)) . ']}';

    echo $lista;

}

function dadosHistorico($conexao, $token){

    //$retorno[0] = array();
    //$retorno[1] = array();
    /*echo $sql;
    $retorno = array();

    $query = $conexao -> query("call buscaHistorico('$token');", MYSQLI_STORE_RESULT);

    while ($row = $query -> fetch_array(MYSQLI_ASSOC)) {*/

    $retorno = array();

    $sql = "call buscaHistorico('$token');";

    $query = mysqli_query($conexao, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        array_push($retorno, array(
            'ht_id' =>$row['ht_id'],
            'ht_empresa' =>$row['ht_empresa'],
            'pd_empresa' => utf8_encode($row['pd_empresa']),
            'ht_cod' =>$row['ht_cod'],
            'ht_descricao' => ucwords(strtolower(utf8_decode($row['ht_descricao']))),
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

function dadosCustosFixos($conexao, $token){

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

function adicionaDespesaFixa($conexao, $empresa, $ht_id) {

		
		$sql = "call adicionaCustoFixo($empresa, $ht_id);";
		
		//echo $sql;
		
		$query = mysqli_query($conexao, $sql);
	
		return $query;
}

function excluirTipoCusto($conexao, $cf_id) {

		
    $sql = "delete from custos_fixos where cf_id = $cf_id;";
    
    echo $sql;
    
    $query = mysqli_query($conexao, $sql);

    return $query;
}


/*function clearStoredResults($mysqli_link){

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