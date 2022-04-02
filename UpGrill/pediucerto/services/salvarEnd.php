<?php
session_name('http://localhost/pediucerto');
session_start();

require_once 'conn.php';

//$url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
//$route = explode('/',$url);

$array = json_decode(file_get_contents("php://input"), true);


$perfil = $array['perfil'];
$endereco = $array['endereco'];

if (!in_array('comp', $endereco)) {
    $comp = null;
}else{
    $comp = $endereco['comp'];
}

 if($endereco['local'] == 'casa'){
     
     $sqlEndereco = "UPDATE pessoas set pe_endereco = '".  ($endereco['adress']). "', pe_end_num = '".  $endereco['numero']. "', 
     pe_end_comp = '".  ($comp). "', pe_bairro = '".  ($endereco['bairro']). "', pe_cidade = '".  ($endereco['cidade']). "', 
     pe_uf= '". strtoupper(($endereco['uf'])) . "' where pe_id =". $perfil .";";

    $sqlEndereco = mysqli_query($conexao, $sqlEndereco);
    
    $row = mysqli_affected_rows($conexao);

    if($row >= 1 ){
        $retorno = json_encode(retorno(1));
        echo $retorno;
    }else{
        $retorno = json_encode(retorno(0));
        echo $retorno;
    }
     
 }

 else if($endereco['local'] == 'trabalho'){

    $sqlEndereco = "UPDATE pessoas set pe_endtrab = '".  ($endereco['adress']). "', pe_end_num_trab = '".  $endereco['numero']. "', 
     pe_end_comp_trab = '".  ($comp). "', pe_bairro_trab = '".  ($endereco['bairro']). "', pe_end_cid_trab = '".  ($endereco['cidade']). "', 
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
 }


 function retorno($e){
    $retorno = array();
   
    if($e == 1){
        array_push($retorno,array(
            'return'=> 'SUCCESS'
        ));
    }else{
        array_push($retorno,array(
            'return'=> 'ERRROR'
        ));
    }
    
    return $retorno;
 }