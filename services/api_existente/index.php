<?php
$urlbase =$_SERVER['REQUEST_URI'];
$url= str_replace('/zmpro/services/api_existente', '', $urlbase);

$route=explode('/', $url);

echo '<pre>';
print_r($route);
echo '</pre>';

if($route[1] == 'consultaEmp'){
    include_once ('consultaEmp.php');
}
if(substr($route[1], 0, strpos($route[1], '?')) == 'consultaEmp'){
    include_once ('consultaEmp');
}

