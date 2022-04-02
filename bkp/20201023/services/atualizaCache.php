<?php 
 //include 'conecta.php';
if(isset($_GET['verifica'])){
    include 'conecta.php';
    
    $array = json_decode(file_get_contents("php://input"), true);

    $token = $array['token'];
    $id = $array['id'];
    $input = $array['input'];

    
    $verificaCache = verificaCache($conexao, $token, $id, $input);

    echo json_encode($verificaCache);
}

function atualizaCache($conexao, $matriz, $empresa, $tabela){

    $cod = rand(1000,9999);

    if ($empresa == 0) {
        $empresa = $matriz;
    }

    $select = "SELECT * FROM cache WHERE ca_empresa = $empresa;";

    $querySelect = mysqli_query($conexao, $select);
    
    $row = mysqli_num_rows($querySelect);

    if ($row <= 0) {

        $insert = "INSERT INTO cache (ca_matriz, ca_empresa ,ca_produto, ca_grupo, ca_subgrupo, ca_info)value($matriz,$empresa, $cod, $cod, $cod, $cod);";
        
        $queryInsert = mysqli_query($conexao, $insert);
    }else{

        if ($tabela == 'produto') {
            $update = "update cache set ca_produto = $cod where ca_empresa = $empresa and ca_id > 0;";
            $queryUpdate = mysqli_query($conexao, $update);
        }

        if ($tabela == 'grupo') {
            $update = "update cache set ca_grupo = $cod where ca_empresa = $empresa and ca_id > 0;";
            $queryUpdate = mysqli_query($conexao, $update);
        }

        if ($tabela == 'subgrupo') {
            $update = "update cache set ca_subgrupo = $cod where ca_empresa = $empresa and ca_id > 0;";
            $queryUpdate = mysqli_query($conexao, $update);
        }

        if ($tabela == 'empresa') {
            $update = "update cache set ca_info = $cod where ca_empresa = $empresa and ca_id > 0;";
            $queryUpdate = mysqli_query($conexao, $update);
        }
        
    }
    
}

function verificaCache($conexao, $token, $id, $input){

    $retorno = array();

    $sql = "SELECT * FROM cache WHERE ca_empresa = (SELECT  em_cod FROM empresas where em_token = '$token');";

    $query = mysqli_query($conexao, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        array_push($retorno, array(
            'ca_id' => $row['ca_id'],
            'ca_matriz' => $row['ca_matriz'],
            'ca_empresa' => $row['ca_empresa'],
            'ca_info' => $row['ca_info'],
            'ca_produto' => $row['ca_produto'],
            'ca_grupo' => $row['ca_grupo'],
            'ca_subgrupo' => $row['ca_subgrupo']

        ));
    }

    

    return $retorno;
}