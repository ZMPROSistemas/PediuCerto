<?php
function buscaDadosLogin($conexao,$usuario,$senha){
	$dados = array();
	$resultado = mysqli_query($conexao,"select * from usuarios where us_email='{$usuario}' and us_senha='{$senha}'");
	$dados = mysqli_fetch_assoc($resultado);
	return $dados;
}

function buscaDadosEmpresa($conexao,$id){
	$dados = array();
	$resultado = mysqli_query($conexao,"select * from empresas where em_cod={$id}");
	$dados = mysqli_fetch_assoc($resultado);
	return $dados;
}

function buscaDadosPerfil($conexao,$idEmpresa,$idPerfil){
	$dados = array();
	$resultado = mysqli_query($conexao,"select * from perfil where empresa={$idEmpresa} and id={$idPerfil}");
	$dados = mysqli_fetch_assoc($resultado);
	return $dados;
}

function avisos($conexao,$matriz){
	$dados = array();
	$resultado = mysqli_query($conexao,"SELECT * FROM zmpro.aviso where av_matriz = $matriz;");
	$dados = mysqli_fetch_assoc($resultado);
	return $dados;
}

/*
function converteData($vdata){
	$retorno='';

	$cDdataI1 = new Date($vdata);
	$cDdataI1.setDate($cDdataI1.getDate());
	$cDdiaI = $cDdataI1.getDate();
	$cDmesI = $cDdataI1.getMonth()+1;
	$cDanoI = $cDdataI1.getFullYear();

	if ($cDdiaI<=9){
	  $cDdiaI='0'+$cDdiaI;
	}
	  
	if ($cDmesI<=9){
	  $cDmesI='0'+$cDmesI;
	}
	     
	$retorno = [$cDanoI, $cDmesI, $cDdiaI].join('-');

	return $retorno;
}
*/