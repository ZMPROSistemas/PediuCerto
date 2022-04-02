<?php
session_name('http://localhost/pediucerto');
session_start();

require_once 'conn.php';

unset($_SESSION['cod']);

$randon = rand(10000,99999);

$_SESSION['cod'] = $randon;

$url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
$route = explode('/',$url);

//var_dump($route);

$numero = $route[2];

if(isset($route[3])){

    $sqlConta = "SELECT * FROM  pessoas where pe_celular = '$numero'";
    $queryConta = mysqli_query($conexao, $sqlConta);
    $row = mysqli_num_rows($queryConta);

    //echo $row;

    $msg = 'Seu código de verificação é '.$randon . '';

    if($row == 0){

        $rest = array(
            'codigo' => "1",
            'descricao' => "MENSAGEM NA FILA",
            'id' => "835904799",
            'situacao' => "OK",
        );

            $res = json_encode($rest);
            /*
            $ch = curl_init();

            $data = array('key'         => 'R0PP44WVSHE8MC9E73GIVRXRLZ8L2JPJS801U1LHFIPL0WTEOF78384C0YB7NMFLPF9HEVWNM54WOR59FFT6SUWS6B8IO135XZ3FSP1ALB4RZAMFE4DGHBEWQI02WZTK', 
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
            */
    }else{

        $rest = array(
            'codigo' => "2",
            'descricao' => "MENSAGEM NA FILA",
            'id' => "835904799",
            'situacao' => "conta_existe",
        );
        $res = json_encode($rest);
    }

    //echo $numero . $msg;

    

    print_r($res);


}else{

    $msg = 'Seu código de verificação é '.$randon . '';



    //echo $numero . $msg;

    $rest = array(
        'codigo' => "1",
        'descricao' => "MENSAGEM NA FILA",
        'id' => "835904799",
        'situacao' => "OK",
    );

    $res = json_encode($rest);
    /*
    $ch = curl_init();

    $data = array('key'         => 'R0PP44WVSHE8MC9E73GIVRXRLZ8L2JPJS801U1LHFIPL0WTEOF78384C0YB7NMFLPF9HEVWNM54WOR59FFT6SUWS6B8IO135XZ3FSP1ALB4RZAMFE4DGHBEWQI02WZTK', 
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
    */

    print_r($res); 
}



