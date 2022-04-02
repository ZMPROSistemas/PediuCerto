<?php
session_name('http://localhost/pediucerto');
session_start();

require_once 'conn.php';

//$url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
//$route = explode('/',$url);

$array = json_decode(file_get_contents("php://input"), true);


$perfil = $array['perfil'];
$endereco = $array['endereco'];
$token = $array['token'];
//$cidade = $end.cidade;
//$uf = strtoupper($endereco[0]['pe_uf']);
//print_r($endereco) ;

if (!in_array('comp', $endereco)) {
    $comp = null;
}else{
    $comp = $endereco['comp'];
}

if(!isset($endereco['cep'])){
    $cep = null;
    
}else{
    $cep = $endereco['cep'];
    
}

 

 if($endereco['local'] == 'Casa'){

    $sqlTaxa = "SELECT * FROM bairro_atendido where ba_empresa = (SELECT em_cod from empresas where em_token='".$token."')
    and ba_codcidade = (SELECT cid_cod from cidades where cid_nome='".strtoupper($endereco['cidade'])."' and cid_uf='".strtoupper($endereco['uf'])."') and ba_nomebairro = '".ucwords(strtolower($endereco['bairro']))."';";
    
    //echo $sqlTaxa;
    $query_taxa = mysqli_query($conexao, $sqlTaxa);
    $row = mysqli_affected_rows($conexao);

    //if($row >= 1 ){ 
        $sqlEndereco = "UPDATE pessoas set pe_cep= '$cep', pe_endereco = '".  ucwords(strtolower(utf8_decode($endereco['adress']))). "', pe_end_num = '". $endereco['numero']. "', 
        pe_end_comp = '".  ucwords(strtolower(utf8_decode($comp))). "', pe_bairro = '".  ucwords(strtolower(utf8_decode($endereco['bairro']))). "', pe_cidade = '".  ucwords(strtolower(utf8_decode($endereco['cidade']))). "', 
        pe_uf= '". strtoupper(($endereco['uf'])) . "' where pe_id =". $perfil .";";

        $queryEndereco = mysqli_query($conexao, $sqlEndereco);
        
        $row = mysqli_affected_rows($conexao);

        if($row >= 1 ){
            //echo 1;
            $retorno = json_encode(retorno(1));
            echo $retorno;
        }else{
            //echo 2;
            $retorno = json_encode(retorno(0));
            echo $retorno;
        }
    // }else{
    //     echo 3;
    //     $retorno = json_encode(retorno(0));
    //     echo $retorno;
    // }
 }

 else if($endereco['local'] == 'Trabalho'){
    $sqlTaxa = "SELECT * FROM bairro_atendido where ba_empresa = (SELECT em_cod from empresas where em_token='".$token."')
    and ba_codcidade = (SELECT cid_cod from cidades where cid_nome='".strtoupper($endereco['cidade'])."' and cid_uf='".strtoupper($endereco['uf'])."') and ba_nomebairro = '".ucwords(strtolower($endereco['bairro']))."';";
    
    $query_taxa = mysqli_query($conexao, $sqlTaxa);
    $row = mysqli_affected_rows($conexao);

    //if($row >= 1 ){ 
        $sqlEndereco = "UPDATE pessoas set pe_cep_trab ='$cep', pe_endtrab = '".  ucwords(strtolower(utf8_decode($endereco['adress']))). "', pe_end_num_trab = '".  $endereco['numero']. "', 
        pe_end_comp_trab = '".  ucwords(strtolower(utf8_decode($comp))). "', pe_bairro_trab = '".  ucwords(strtolower(utf8_decode($endereco['bairro']))). "', pe_end_cid_trab = '".  ucwords(strtolower(utf8_decode($endereco['cidade']))). "', 
        pe_uf_trab= '". strtoupper(($endereco['uf'])) . "' where pe_id =". $perfil .";";

        $sqlEndereco = mysqli_query($conexao, $sqlEndereco);
        
        $row = mysqli_affected_rows($conexao);

        if($row >= 1 ){
            $retorno = json_encode(retorno(1));
            echo $retorno;
        }else{
            $retorno = json_encode(retorno(0));
            echo $retorno;
        }
    // }else{
    //     $retorno = json_encode(retorno(0));
    //     echo $retorno;
    // }
}


 function retorno($e){
    $retorno = array();
   
    if($e == 1){
        array_push($retorno,array(
            'return'=> 'SUCCESS'
        ));
    }else{
        array_push($retorno,array(
            'return'=> 'ERROR'
        ));
    }
    
    return $retorno;
 }