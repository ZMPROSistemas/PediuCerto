<?php
session_name('http://localhost/pediucerto');
session_start();

require_once 'conn.php';

unset($_SESSION['cod']);

$randon = rand(10000,99999);

$_SESSION['cod'] = $randon;

//comentar linha 14 e 16 ante de subir
$url= str_replace('zmpro/pediucerto/api/','', $_SERVER['REQUEST_URI']);

$route = explode('/',$url);

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

      //wesangered
      /*  
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.wassenger.com/v1/messages",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"phone\":\"+55".$numero."\",\"message\":\"".$msg ."\",\"enqueue\":\"never\"}",
        //CURLOPT_POSTFIELDS => "{\"phone\":\"+554384261751\",\"message\":\"Hello world!.\",\"enqueue\":\"opportunistic\"}",

        CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
            "token: 13792050c67f5ec40e4bcf0e11d77fbcfa57df9ba91bda940908d8784e6652204c3507a7e65519cf"
        )
      ));
    
      $response= curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo '<pre>';
            print_r($response);
        echo '</pre>';

        $rest = array(
            'codigo' => $response['id'],
            'descricao' => "MENSAGEM NA FILA",
            'id' => $response['id'],
            'situacao' => "OK",
        );
      }*/

      //chatpro

      //$numero ='4398659941';
    //  $curl = curl_init();

      /*curl_setopt_array($curl, array(
        CURLOPT_URL => "https://v4.chatpro.com.br/chatpro-8ywu31l2y5/api/v1/send_message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n  \"menssage\": \"{$msg}\",\r\n  \"number\": \"{$numero}\"\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Authorization: n1r38759nbq7pnr7bl7miqeoapef7h",
            "cache-control: no-cache"
        ),
      ));*/

        /*$response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        //echo "cURL Error #:" . $err;
        } else {
            /*echo '<pre>';
            print_r($response);
            echo '</pre>';

        }
            */
        $rest = array(
            'codigo' => 1,
            'descricao' => "MENSAGEM NA FILA",
            'id' => 5876987,
            'situacao' => "OK",
        );
    }else{

        $rest = array(
            'codigo' => "2",
            'descricao' => "MENSAGEM NA FILA",
            'id' => "835904799",
            'situacao' => "conta_existe",
        );
       
    }
    $res = json_encode($rest);
    
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
    

}



