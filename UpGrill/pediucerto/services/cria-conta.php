<?php

    session_name('http://localhost/pediucerto');
    session_start();
    require_once 'conn.php';

    $array = json_decode(file_get_contents("php://input"), true);

    $retorno = array();

    $perfil = $array['dados'];
    $empresa = $array['empresa'][0];

    if($perfil['local'] == 'casa'){
        $local ="pe_endereco, pe_end_num, pe_end_comp, pe_bairro, pe_cidade, pe_uf";
    }else if($perfil['local'] ==  'trabalho'){
        $local = "pe_endtrab, pe_end_num_trab, pe_end_comp_trab, pe_bairro_trab, pe_end_cid_trab, pe_uf_trab";
    }
    if(!isset($perfil['comp'])){
        $perfil['comp']=null;
    }

    $sql = "INSERT INTO pessoas(pe_cod, pe_empresa, pe_matriz, pe_nome, pe_situacao, pe_fanta, pe_email, 
    pe_site, pe_celular, pe_cadastro, pe_foto_perfil, pe_ativo, pe_fornecedor, pe_cliente, pe_colaborador, pe_vendedor, 
    pe_id_rede_social, pe_app_origem, pe_emp_origem, pe_senhaApp, $local)
    select max(pe_cod)+1, 1, 1,'".ucwords($perfil['nome'])."',1,'".ucwords($perfil['nome'])."','".$perfil['email']."','perfil/".$perfil['user']."', '".$array['telefone']."',
    curdate(),null, 'S', 'N', 'S','N','N', null, 'Pediu Certo', (SELECT em_cod FROM zmpro.empresas where em_token = '".$empresa['em_token']."'), '".$perfil['pass']."',
    '".ucwords($perfil['adress'])."', '".$perfil['numero']."', '".ucwords($perfil['comp'])."', '".ucwords($perfil['bairro'])."', '".ucwords($perfil['cidade'])."', '".strtoupper($perfil['uf'])."'
    
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