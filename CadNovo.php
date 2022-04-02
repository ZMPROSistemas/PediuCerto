<?php
date_default_timezone_set('America/Sao_Paulo');
require_once 'services/conectaPDO.php';
$date = date('H:i');

$app=$_POST['app'];
$cpf_cnpj=$_POST['cpf_cnpj'];
$inscricaoEstadual=$_POST['inscricaoEstadual'];
$razaoSocial=$_POST['razaoSocial'];
$nomeFantasia=$_POST['nomeFantasia'];
$nomeResponsavel=$_POST['nomeResponsavel'];
$celular=$_POST['celular'];
$cep=$_POST['cep'];
$endereco=$_POST['endereco'];
$numero=$_POST['numero'];
$bairro=$_POST['bairro'];
$complemento=$_POST['complemento'];
$cidade=$_POST['cidade'];
$estado=$_POST['estado'];
// $site=$_POST['site'];
$email=$_POST['email'];

$token = str_replace('-','',getGUID());
$token = str_replace('{','',$token);
$token = str_replace('}','',$token);

$imagemPadrao = 'imagens_empresas/11/grid/Banner_Inicio_Pediu_Certo.png';
$imagemSacola = 'imagens_empresas/11/app/ImagemEstabelecimento.png';

if($app=='zmpro'){

} else{


    $sqlEmp="INSERT INTO empresas (em_cod_local, em_razao, em_fanta, em_nome_resumido, em_end, em_end_num, em_bairro, em_cid, em_uf, 
    em_cep, em_cnpj, em_fone, em_email, em_responsavel, em_ramo, em_ativo, em_prazo_condicional, em_prazo_trava_condicional,
    em_aberto, em_token, em_comunica_sistema, em_foto_url, em_foto_app_sacola, em_franquiado)
    value(1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 'S', 5, 15, 'N', ?, 'S', ?, ?,  'N')";

    $stmtEmpresa=$pdo->prepare($sqlEmp);

    $stmtEmpresa->execute([$razaoSocial, $nomeFantasia, $nomeResponsavel, $endereco, $numero, $bairro, $cidade, $estado, $cep, $cpf_cnpj,
    $celular, $email, $nomeResponsavel, $token, $imagemPadrao, $imagemSacola]);

    $error=$stmtEmpresa->errorInfo();

    $row=$stmtEmpresa->rowCount();
    

    if($row>0){
        $sqlEmp="SELECT * FROM zmpro.empresas where em_cnpj = :cnpj";
        $stmtEmpresa=$pdo->prepare($sqlEmp);
        $stmtEmpresa->bindParam(':cnpj', $cpf_cnpj);
        $stmtEmpresa->execute();
        $rowEmpresa = $stmtEmpresa->fetchAll(PDO::FETCH_ASSOC);

        if($rowEmpresa != null){

            $sqlEmp="UPDATE empresas SET em_cnpj_matriz = :cnpj_matriz, em_cod_matriz = :cod_matriz WHERE (em_cod = :id);";
            $stmtEmpresa=$pdo->prepare($sqlEmp);
            $stmtEmpresa->bindParam(':cnpj_matriz', $cpf_cnpj);
            $stmtEmpresa->bindParam(':cod_matriz', $rowEmpresa[0]['em_cod']);
            $stmtEmpresa->bindParam(':id', $rowEmpresa[0]['em_cod']);
            $stmtEmpresa->execute();
            $error=$stmtEmpresa->errorInfo();
                      
        }
        
    }

}


function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }
    else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}




