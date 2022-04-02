<?php
require_once 'conn.php';

$randon = rand(1000,9999);

//$url= str_replace('pediucerto/services/','', $_SERVER['REQUEST_URI']);
//$route = explode('/',$url);

//var_dump($route);


//$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

$array = json_decode(file_get_contents("php://input"), true);

//var_dump($array);

$id = $array['id'];
$token= $array['token'];
$IdConta= $array['IdConta'];
$nome= $array['nome'];
$image= $array['image'];
$email= $array['email'];
$id_token = $array['id_token'];

if(array_key_exists(2, $route)){
    if ($route[2] == 'social') {
       if ($route[3] == 'google') {

           $sqlConta = "SELECT * FROM  pessoas where pe_email = '".$array['email']."' and pe_id_rede_social = '".$array['IdConta']."';";
           $queryConta = mysqli_query($conexao, $sqlConta);
           $row = mysqli_num_rows($queryConta);
           

           if ($row == 0) {
               $criarConta = criarConta($conexao, $array['nome'], $array['email'], $array['image'], $array['IdConta'], $array['token']);
               $perfil =  json_encode(retornePerfil($conexao, $criarConta));
               echo $perfil;
               
           }else{
               $user = mysqli_fetch_assoc($queryConta);
               $perfil = json_encode(retornePerfil($conexao, $user['pe_id']));
                
               echo $perfil;
           }

       }
    }
}




function criarConta($conexao, $nome, $email, $image, $IdConta, $token){


   
    $e = substr($email, 0, strpos($email, '@'));

    $perfil = 'perfil/'. $e.'';
    
    $sql = "INSERT INTO pessoas(pe_cod, pe_empresa, pe_matriz, pe_nome, pe_situacao, pe_fanta, pe_email, 
    pe_site, pe_cadastro, pe_foto_perfil, pe_ativo, pe_fornecedor, pe_cliente, pe_colaborador, pe_vendedor, 
    pe_id_rede_social, pe_app_origem, pe_emp_origem)

    select max(pe_cod)+1, 1, 1, '$nome', 1, '$nome', '$email', '$perfil', curdate(), '$image', 'S','N', 'S', 'N', 'N', '$IdConta', 'Pediu Certo', 
    (SELECT em_cod FROM zmpro.empresas where em_token = '$token') from pessoas where pe_empresa = 1;";
    
    $query = mysqli_query($conexao, $sql);

    $row = mysqli_insert_id($conexao);

    if ($row > 0) {
        return $row;
    }else{
        return 0;
    }


}

function retornePerfil($conexao, $userID){

    $retorno = array();

    $sql = "SELECT 
    pe_id,
    pe_nome,
    pe_email,
    pe_celular,
    pe_site,
    pe_id_rede_social,
    pe_endereco,
    pe_end_num,
    pe_end_comp,
    pe_bairro,
    pe_cidade,
    pe_uf,
    pe_cep,
    pe_cep_trab,
    pe_endtrab,
    pe_end_num_trab,
    pe_end_comp_trab,
    pe_bairro_trab,
    pe_end_cid_trab,
    pe_uf_trab,
    pe_foto_perfil
FROM
    pessoas
WHERE
    pe_id =  $userID;";

    $query = mysqli_query($conexao, $sql);

    $row = mysqli_num_rows($query);

   while ($row = mysqli_fetch_assoc($query)){
		array_push($retorno, array(

            'pe_id' => $row['pe_id'],
            'pe_nome' => utf8_encode($row['pe_nome']),
            'pe_email' => utf8_encode($row['pe_email']),
            'pe_celular' => utf8_encode($row['pe_celular']),
            'pe_site'=> utf8_encode($row['pe_site']),
            'pe_id_rede_social' => utf8_encode($row['pe_id_rede_social']),
            'pe_endereco'=> utf8_encode($row['pe_endereco']),
            'pe_end_num'=> $row['pe_end_num'],
            'pe_end_comp' => utf8_encode($row['pe_end_comp']),
            'pe_bairro' => utf8_encode($row['pe_bairro']),
            'pe_cidade' => utf8_encode($row['pe_cidade']),
            'pe_uf' => $row['pe_uf'],
            'pe_cep' => $row['pe_cep'],
            
            'pe_cep_trab' => utf8_encode($row['pe_cep_trab']),
            'pe_endtrab' => utf8_encode($row['pe_endtrab']), 
            'pe_end_num_trab' => utf8_encode($row['pe_end_num_trab']),
            'pe_end_comp_trab' => utf8_encode($row['pe_end_comp_trab']),
            'pe_bairro_trab' => utf8_encode($row['pe_bairro_trab']),
            'pe_end_cid_trab' => utf8_encode($row['pe_end_cid_trab']),
            'pe_uf_trab' => utf8_encode($row['pe_uf_trab']),
            'pe_foto_perfil' => utf8_encode($row['pe_foto_perfil']),


        ));
    }

    return $retorno;

}