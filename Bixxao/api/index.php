<?php

include_once("conn.php");
//include_once("../confg/conf.php");

$array = json_decode(file_get_contents("php://input"), true);

$url= str_replace('pediucerto/api/','', $_SERVER['REQUEST_URI']);

$route = explode('/',$url);


//print_r($route);
if ($route[1] == 'valida') {
    
    if ($route[2]== 'social') {
        include_once 'valida.php';
    }
}
else if($route[1] == 'sendsms'){
    include_once 'sendsms.php';
}
else if($route[1] == 'sendsmsw'){
    include_once 'sendsmsw.php';
}
else if($route[1] == 'validaCodigo'){
    
    include_once 'validaCodigo.php';
}
else if(substr($route[1], 0, strpos($route[1], '?')) == 'buscaPerfil'){
    include_once 'buscaPerfil.php';
}
else if($route[1] == 'addLocal'){
    include_once 'addLocal.php';
}
else if($route[1] == 'salvarEnd'){
    include_once 'salvarEnd.php';
}
else if($route[1] == 'endereco'){
    include_once 'endereco.php';
}
else if($route[1] =='finalizar_pedido'){
    include_once 'finalizar_pedido.php';
}
else if(substr($route[1], 0, strpos($route[1], '?')) == 'meus_pedidos'){
    include_once 'meus_pedidos.php';
}
else if($route[1] =='valida-user'){
    include_once 'valida-user.php';
}
else if($route[1] == 'cria-conta'){
    include_once 'cria-conta.php';
}
else if($route[1] == 'valida-email'){
    include_once 'valida-email.php';
}
else if($route[1] == 'login'){
    include_once 'login.php';
}
else if($route[1] == 'itens'){
    include_once 'itens.php';
}
else if($route[1] == 'taxa'){
    include_once 'taxa.php';
}