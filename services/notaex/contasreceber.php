<?php

include 'conecta.php';

$idcli = $_GET['idcli'];
$idempresa = $_GET['idempresa'];

$lista = '{"result":' . json_encode(getContas($conexao,$idcli,$idempresa)) . '}';
echo $lista;


function getContas($conexao,$idcli,$idempresa) {
	$retorno = array();

	$sql = "select * from contas where ct_cliente_forn=$idcli and ct_empresa=$idempresa and ct_receber_pagar='R' and ct_quitado='N' order by ct_vencto";

	$resultado = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($resultado)) {
		array_push($retorno, array(
			'ct_id' => $row['ct_id'],
			'ct_empresa' => $row['ct_empresa'],
			'ct_matriz' => $row['ct_matriz'],
			'ct_docto' => $row['ct_docto'],
			'ct_parc' => utf8_decode($row['ct_parc']),
			'ct_cliente_forn' => $row['ct_cliente_forn'],
			'ct_vendedor' => $row['ct_vendedor'],
			'ct_emissao' => $row['ct_emissao'],
			'ct_vencto' => $row['ct_vencto'],
			'ct_valor' => $row['ct_valor'],
			'ct_nome' => utf8_decode($row['ct_nome']),
		));
	}

	return $retorno;
}

/*
idaluno int(11) AI PK
nome varchar(70)
genero varchar(10)
matricula bigint(20)
email varchar(60)
celular varchar(18)
data_nascimento date
ativo varchar(1)
academia int(11)
professor int(11)
senha varchar(45)
pacote varchar(60)
cod_atualiza bigint(20)
ncatraca int(11)
imagem varchar(255)
rg varchar(25)
cpf varchar(25)
endereco varchar(255)
bairro varchar(80)
cep varchar(10)
cidade varchar(80)
profissao varchar(60)
uf varchar(60)
estado_civil varchar(20)
nomepai varchar(80)
nomemae varchar(80)
observacao longtext
aluno_principal int(11)
status varchar(45)
aluno_colaborador tinyint(1)
 */
