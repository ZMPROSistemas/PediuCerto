
<?php

include 'conecta.php';
$empresa = base64_decode($_GET['e']);
$editarCadastrar = $_GET['editarCadastrar'];
$array = json_decode(file_get_contents("php://input"), true);

//print_r($array) . '<p>';

$empresas = $array['empresa'][0];
//print_r($empresas) . '<p>';
$id = $empresas['em_cod'];
$cnpj = $empresas['cnpj'];
$em_razao = ucwords(utf8_encode($empresas['em_razao']));
$em_fanta = ucwords(utf8_encode($empresas['em_fanta']));
$em_end = ucwords(utf8_encode($empresas['em_end']));
$em_end_num = $empresas['em_end_num'];
$em_bairro = ucwords(utf8_encode($empresas['em_bairro']));
$em_cid = ucwords(utf8_encode($empresas['em_cid']));
$em_uf = mb_strtoupper(utf8_encode($empresas['em_uf']));
$em_cep = $empresas['em_cep'];
$em_insc = $empresas['em_insc'];
$em_fone = $empresas['em_fone'];
$em_email = utf8_encode($empresas['em_email']);
$em_responsavel = ucwords(utf8_encode($empresas['em_responsavel']));
$em_cont_nome = ucwords(utf8_encode($empresas['em_cont_nome']));
$em_cont_fone = utf8_encode($empresas['em_cont_fone']);
$em_cont_email = utf8_encode($empresas['em_cont_email']);

/*
echo 'CNPJ CPF: ' . $cnpj . '<br>';
echo 'Razão Social: ' . $em_razao . '<br>';
echo 'Nome Fantasia: ' . $em_fanta . '<br>';
echo 'Edereço: ' . $em_end . '<br>';
echo 'Numero: ' . $em_end_num . '<br>';
echo 'Bairro: ' . $em_bairro . '<br>';
echo 'Cidade: ' . $em_cid . '<br>';
echo 'UF' . $em_uf . '<br>';
echo 'CEP: ' . $em_cep . '<br>';
echo 'InscriçãoEstadual: ' . $em_insc . '<br>';
echo 'Fone: ' . $em_fone . '<br>';
echo 'Email: ' . $em_email . '<br>';
echo 'Responsavel: ' . $em_responsavel . '<br>';
echo 'Contato Nome: ' . $em_cont_nome . '<br>';
echo 'Contato Fone: ' . $em_cont_fone . '<br>';
echo 'Contato email: ' . $em_cont_email . '<br>';

 */
if ($editarCadastrar == 'C') {
	insereEmpresa($conexao, $em_razao, $em_fanta, $em_end, $em_end_num, $em_bairro, $em_cid, $em_uf, $em_cep, $cnpj, $em_insc, $em_fone, $em_email, $em_responsavel, $em_cont_nome, $em_cont_fone, $em_cont_email, $empresa);
	//echo "C";
}
if ($editarCadastrar == 'E') {
	editarEmpresa($conexao, $em_razao, $em_fanta, $em_end, $em_end_num, $em_bairro, $em_cid, $em_uf, $em_cep, $cnpj, $em_insc, $em_fone, $em_email, $em_responsavel, $em_cont_nome, $em_cont_fone, $em_cont_email, $id);
	//echo "E";
}

function insereEmpresa($conexao, $em_razao, $em_fanta, $em_end, $em_end_num, $em_bairro, $em_cid, $em_uf, $em_cep, $em_cnpj, $em_insc, $em_fone, $em_email, $em_responsavel, $em_cont_nome, $em_cont_fone, $em_cont_email, $empresa) {

	$query = "insert into empresas (
em_razao,
em_fanta,
em_end,
em_end_num,
em_bairro,
em_cid,
em_uf,
em_cep,
em_cnpj,
em_insc,
em_fone,
em_email,
em_responsavel,
em_cont_nome,
em_cont_fone,
em_cont_email,
em_ativo,
em_cod_matriz
)

values (
'$em_razao',
'{$em_fanta}',
'{$em_end}',
'{$em_end_num}',
'{$em_bairro}',
'{$em_cid}',
'{$em_uf}',
'{$em_cep}',
'{$em_cnpj}',
'{$em_insc}',
'{$em_fone}',
'{$em_email}',
'{$em_responsavel}',
'{$em_cont_nome}',
'{$em_cont_fone}',
'{$em_cont_email}',
'S',
$empresa
)";

	$inserir = mysqli_query($conexao, $query);

	if (mysqli_insert_id($conexao) <= 0) {
		echo 0;
	} else {
		echo 1;
	}
	//echo $query;
	return $inserir;
}

function editarEmpresa($conexao, $em_razao, $em_fanta, $em_end, $em_end_num, $em_bairro, $em_cid, $em_uf, $em_cep, $cnpj, $em_insc, $em_fone, $em_email, $em_responsavel, $em_cont_nome, $em_cont_fone, $em_cont_email, $id) {

	$sql = "update empresas set em_razao='$em_razao', em_fanta='$em_fanta', em_end_num='$em_end_num',em_bairro='$em_bairro',em_cid='$em_cid', em_uf='$em_uf', em_cep='$em_cep', em_cnpj='$cnpj', em_insc='$em_insc', em_fone='$em_fone', em_email='$em_email', em_responsavel='$em_responsavel', em_cont_nome='$em_cont_nome', em_cont_fone='$em_cont_fone', em_cont_email='$em_cont_email' where em_cod= $id";

	$query = mysqli_query($conexao, $sql);

	if (mysqli_affected_rows($conexao) <= 0) {
		echo 0;
	} else {
		echo 1;
	}
	//echo $sql;
}