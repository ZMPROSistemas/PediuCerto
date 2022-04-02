<?php
session_name('http://localhost/pediucerto');
session_start();

require_once 'conn.php';

unset($_SESSION['cod']);

$randon = rand(10000,99999);

$_SESSION['cod'] = $randon;

//comentar linha 14 e 16 ante de subir
//$url= str_replace('zmpro/pediucerto/api/','', $_SERVER['REQUEST_URI']);

//$route = explode('/',$url);

/*
echo '<pre>';
print_r($route);
echo '</pre>';
*/
$numero = $route[2];

if(isset($route[3])){

    
    $sqlConta = "SELECT * FROM  pessoas where pe_celular = '$numero'";
    $queryConta = mysqli_query($conexao, $sqlConta);
    $row = mysqli_num_rows($queryConta);

    

    $msg = 'Seu código de verificação é '.$randon . '';


    if($row == 0){
        
/*
        $rest = array(
            'codigo' => "1",
            'descricao' => "MENSAGEM NA FILA",
            'id' => "835904799",
            'situacao' => "OK",
        );

            $res = json_encode($rest);
      */  
            
            $ch = curl_init();

            $data = array('key'         => 'QUGS3R69JXA4F23CLTK0HJ1IET6Z1IYLI1YPK4FHU5HBZ2VMSEH088L4NMR494U1Z9UZ6JTFY1CGLX477N09QJQ6NQUT9AIUEBA6LP2RFTHT5QCV9RE0OL7M0PSGUCAD', 
                        'type'        => '9',     //(9-Sms 
                        'number'      => ''.$numero.'',
                        'msg'         => ''.$msg.'',
                        'out'         => 'json' //Se desejar retorno em json ou xml
                    );    

            curl_setopt($ch, CURLOPT_URL, 'https://api.smsempresa.com.br/v1/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $res    = curl_exec ($ch);
            $err    = curl_errno($ch);
            $errmsg = curl_error($ch);
            $header = curl_getinfo($ch);
            
            curl_close($ch);
            
    }else{

        $rest = array(
            'codigo' => "2",
            'descricao' => "MENSAGEM NA FILA",
            'id' => "835904799",
            'situacao' => "conta_existe",
        );
        $res = json_encode($rest);
    }

    
    print_r($res);


}else{

    $msg = 'Seu código de verificação é '.$randon . '';


/*
    //echo $numero . $msg;

    $rest = array(
        'codigo' => "1",
        'descricao' => "MENSAGEM NA FILA",
        'id' => "835904799",
        'situacao' => "OK",
    );

    $res = json_encode($rest);
    */

    
    $ch = curl_init();

    $data = array('key'         => 'QUGS3R69JXA4F23CLTK0HJ1IET6Z1IYLI1YPK4FHU5HBZ2VMSEH088L4NMR494U1Z9UZ6JTFY1CGLX477N09QJQ6NQUT9AIUEBA6LP2RFTHT5QCV9RE0OL7M0PSGUCAD', 
                'type'        => '9',     //(9-Sms 
                'number'      => ''.$numero.'',
                'msg'         => ''.$msg.'',
                'out'         => 'json' //Se desejar retorno em json ou xml
            );    

    curl_setopt($ch, CURLOPT_URL, 'https://api.smsempresa.com.br/v1/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $res    = curl_exec ($ch);
    $err    = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);

    curl_close($ch);
    

    print_r($res); 
}



