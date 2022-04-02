<?php

if (array_key_exists("u", $_GET)){
  $usuario = base64_decode($_GET["u"]);
}else{
  $usuario = $_POST["usuario"]; 
}  
if (array_key_exists("s", $_GET)){
  $senha = base64_decode($_GET["s"]);
}else{
  $senha = $_POST["senha"]; 
}  

?>