<?php
    //criado 15/05/2020 - Diogo Cesar
    //modificado
    date_default_timezone_set('America/Bahia');
    require_once 'conecta.php';
    include 'conectaPDO.php';

    include 'log.php';
    include 'atualizaCache.php';
    include 'getIp.php';

    $ip = get_client_ip();
    $data = date('Y-m-d');
    $hora = date('H:i:s');

    $array = json_decode(file_get_contents("php://input"), true);

    //var_dump($array);

    if($array['tabela'] == 'taxa'){
        $retorno = json_encode(taxa($conexao, $pdo, $array['taxa'], $array['token'], $array['us'], $array['us_id'], $array['matriz'], $array['filial'],  $data, $hora, $ip));
        echo $retorno;

    }
    if($array['tabela'] == 'tempo'){
       $retorno = json_encode(tempo($conexao, $pdo, $array['token'], $array['hora1'], $array['hora2'], $array['retira'], $array['us'], $array['us_id'], $array['matriz'], $array['filial'],  $data, $hora, $ip));
       echo $retorno;

    }

    function taxa($conexao, $pdo, $taxa, $token, $us, $us_id, $matriz, $filial, $data, $hora, $ip){
        
        $retorno = array();
        $valor = str_replace('R','',$taxa);
        $valor = str_replace('$','',$taxa); 
        $valor = str_replace('.','',$taxa); 
        $valor = str_replace(',','.',$taxa); 

       
        
        
        $sql = "update empresas set em_taxa_entrega = ? where em_token= ?;";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$valor, $token]);
        $row = $stmt->rowCount();

        if ($row == 1) {
            array_push($retorno, array(
                'return'=>'SUCCESS'
            ));
        
            $obs = "Taxa alterada para R$ $valor";
            logTaxa($pdo, $token, $obs, $data, $hora, $ip, base64_decode($us), base64_decode($us_id));
            atualizaCache($conexao, base64_decode($matriz), base64_decode($filial), 'empresa');
        }else{
            array_push($retorno, array(
                'return'=>'ERROR'
            ));
        }
        
        return $retorno;
    }

    function tempo($conexao, $pdo, $token, $hora1, $hora2, $retira, $us, $us_id, $matriz, $filial,  $data, $hora, $ip){
         
        $retorno = array();
        
        $sql = "update empresas set em_entrega1 = ?, em_entrega2 = ?, em_retira = ? where em_token= ?;";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$hora1, $hora2, $retira, $token]);
        $row = $stmt->rowCount();

        if ($row == 1) {
            array_push($retorno, array(
                'return'=>'SUCCESS'
            ));
        
            $obs = "Modificado tempo para entrega para $hora1 à $hora2 e retirada para $retira  ";
            logTaxa($pdo, $token, $obs, $data, $hora, $ip, base64_decode($us), base64_decode($us_id));
            atualizaCache($conexao, base64_decode($matriz), base64_decode($filial), 'empresa');
        }else{
            array_push($retorno, array(
                'return'=>'ERROR'
            ));
        }
        
        return $retorno;
    }