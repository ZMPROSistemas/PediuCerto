<?php
     date_default_timezone_set('America/Bahia');
     require_once 'conecta.php';
     include 'log.php';
     include 'getIp.php';

     $ip = get_client_ip();
     $data = date('Y-m-d');
     $hora = date('H:i:s');
     $rand	= rand(0, 99999);

     if (isset($_GET['matriz'])){
         $matriz = base64_decode($_GET['matriz']);
     }
     if (isset($_GET['filial'])){
         $filial = base64_decode($_GET['filial']);
     }

     $array = json_decode(file_get_contents("php://input"), true);

     //var_dump($array);

     $imagem = $array['image'];
     $file = $array['fileImage'];

     $tipo = explode(',', $imagem); 

     //print_r($tipo);

     $Image64 = $tipo [1];

     $convertForImage = base64_decode($Image64);

     $pasta = "../imagens_empresas/$matriz/$file/";
     //echo $pasta;
    if(is_dir($pasta)){
        file_put_contents("../imagens_empresas/$matriz/$file/$file"."_"."$rand.jpg", $convertForImage);
    }else{
        mkdir($pasta, 0777, true);
         file_put_contents("../imagens_empresas/$matriz/$file/$file"."_"."$rand.jpg", $convertForImage);
    }

     $url = "http://sistema.zmpro.com.br/imagens_empresas/$matriz/$file/$file"."_"."$rand.jpg";

     echo $url;

?>