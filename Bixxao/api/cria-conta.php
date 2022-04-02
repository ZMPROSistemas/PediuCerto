<?php

    session_name('http://localhost/pediucerto');
    session_start();
    require_once 'conn.php';

    $array = json_decode(file_get_contents("php://input"), true);

    $retorno = array();

    $perfil = $array['dados'];
    $empresa = $array['empresa'][0];

/*
    if(isset($perfil['cep'])){
        $cep = $perfil['cep'];
    }else{
        $cep = null;
    }

    if($perfil['local'] == 'casa'){
        $local ="pe_endereco, pe_end_num, pe_end_comp, pe_bairro, pe_cidade, pe_uf, pe_cep";
    }else if($perfil['local'] ==  'trabalho'){
        $local = "pe_endtrab, pe_end_num_trab, pe_end_comp_trab, pe_bairro_trab, pe_end_cid_trab, pe_uf_trab, pe_cep_trab";
    }
    if(!isset($perfil['comp'])){
        $perfil['comp']=null;
    }
*/
    $sql = "INSERT INTO pessoas(pe_cod, pe_empresa, pe_matriz, pe_nome, pe_situacao, pe_fanta,  
    pe_site, pe_celular, pe_cadastro, pe_foto_perfil, pe_ativo, pe_fornecedor, pe_cliente, pe_colaborador, pe_vendedor, 
    pe_id_rede_social, pe_app_origem, pe_emp_origem, pe_senhaApp)
    select max(pe_cod)+1, 11, 11,'".ucwords(utf8_decode($perfil['nome']))."',1,'".ucwords(utf8_decode($perfil['nome']))."','perfil/".ucwords(utf8_decode($perfil['nome']))."', '".$array['telefone']."',
    curdate(),null, 'S', 'N', 'S','N','N', null, 'Pediu Certo', (SELECT em_cod FROM zmpro.empresas where em_token = '".$empresa['em_token']."'), '".$perfil['pass']."'
    
    from pessoas where pe_empresa = 1";

    $query = mysqli_query($conexao, $sql);

    $id = mysqli_insert_id($conexao);

    $row = mysqli_affected_rows($conexao);

  // $id = 22444;

   //$row = 1;
    if ($row > 0) {

        array_push($retorno, array(
            'retorno' => 'SUCCESS',
            'conta' => $id
        ));

        unset($_SESSION['criarConta']);

    }else{
        array_push($retorno, array(
            'retorno' => 'ERROR',
            
        ));
    }

    echo json_encode($retorno);