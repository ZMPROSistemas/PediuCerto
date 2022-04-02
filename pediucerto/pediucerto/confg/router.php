<?php

if(($route1[1] != 'verifica') 
    && ($route1[1] != 'codigo') 
    && ($route1[1] != 'endereco') 
    && ($route1[1] != 'fPagamento') 
    && ($route1[1] != 'perfil') 
    && ($route1[1] != 'meus_pedidos') 
    && ($route1[1] != 'login_celular')
    && ($route1[1] != 'codigo-verifica')
    && ($route1[1] != 'criar-conta')
    && ($route1[1] != 'item')
    && ($route1[1] != '')
    &&($route1[1] != 'produto')){
    
    $route = array(
        'page' => $route1[1],
        'id' => $route1[2],
        'token' => $route1[3],
    );
    $_SESSION['codEmpresa'] = $route['id'];
    $empresa = buscaDadosEmpresa($conexao,$route['id']);

 }
 else if($route1[1] == ''){
    $route = array(
        'page' => $route1[1]
    );
 }
 else if($route1[1] == 'verifica'){
     $route = array(
        'page' => $route1[1],
        'subPage'  => $route1[2],
        'perfil' => $route1[3],
     );
 }

 else if($route1[1] == 'codigo'){
    $route = array(
       'page' => $route1[1],
       'numero'  => substr($route1[2],0 , strpos($route1[2], '=')),
       
    );
}

else if($route1[1] == 'codigo-verifica'){
    $route = array(
       'page' => $route1[1],
       'numero'  => $route1[2],
       
    );
}

else if($route1[1] == 'endereco'){

    if(in_array('cadastrar', $route1)){
        $route = array(
            'page' => $route1[1],
            'subPage'  => $route1[2],
            'perfil' => $route1[3],
        );
    }
    else if(in_array('local_entrega', $route1)){
        $route = array(
            'page' => $route1[1],
            'subPage'  => $route1[2],
            'perfil' => $route1[3],
        );
    }
    else{
        $route = array(
            'page' => $route1[1],
            'subPage'  => $route1[2],
            'perfil' => $route1[3],
        );
    }
    
}
else if($route1[1] == 'fPagamento'){
    $route = array(
        'page' => $route1[1],
    );
}
else if($route1[1] == 'perfil'){
    $route = array(
        'page' => $route1[1],
        'perfil'  => $route1[2],
       
    );
}
else if($route1[1] == 'meus_pedidos'){
    $route = array(
        'page' => $route1[1],
        'subPage'  => $route1[2],
        'perfil' => $route1[3],
       
    );
}
else if($route1[1] == 'login_celular'){
    $route = array(
        'page' => $route1[1],
              
    );
}

else if($route1[1] == 'criar-conta'){
    
    $route = array(
        'page' => $route1[1],
              
    );
}
else if($route1[1] == 'item'){
    
    $route = array(
        'page' => $route1[1],
        'item' => $route1[2],
        'id' => $route1[3],
        'token' => $route1[4],
        
    );

    $empresa = buscaDadosEmpresa($conexao,$route['id']);
}

else if($route1[1] == 'produto'){
   
    $route = array(
        'page' => $route1[1],
        'id' => $route1[2],
        'token' => $route1[3],
        
    );

    $empresa = buscaDadosEmpresa($conexao,$route['id']);
}


else{
    $route = array(
        'page' => 'ERRO 404',
        
     );
}

 //var_dump($route);