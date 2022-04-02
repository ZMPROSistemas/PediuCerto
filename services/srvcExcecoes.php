<?php

require_once 'conectaPDO.php';



if (isset($_GET['listaExcecoesProd'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
    $CodProd = $_GET['pd_cod'];
    $param = '';

    if ($CodProd != '') {
        $pd_cod = " and pde_produto = " . $CodProd;
    } else {
        $pd_cod = '';
    }
	
		$lista = '{"result":[' . json_encode(listaExcecoes($pdo, $empresaAcesso, $pd_cod, $param)) . ']}';
		echo $lista;

}

if (isset($_GET['buscaExcecoes'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
 	
		$lista = '{"result":[' . json_encode(buscaExcecoes($pdo, $empresaAcesso)) . ']}';
		echo $lista;

}

if (isset($_GET['listaExcecoesEmpresa'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
    
    $CodProd = $_GET['pd_cod'];
    $param = ' not ';

    if ($CodProd != '') {

        $pd_cod = " and pde_produto = " . $CodProd;
    }
		
		$lista = '{"result":[' . json_encode(listaExcecoes($pdo, $empresaAcesso, $pd_cod, $param)) . ']}';
		echo $lista;

}

if (isset($_GET['salvarExcecao'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
    $pd_cod = $_GET['pd_cod'];
    $ex_desc = $_GET['ex_desc'];
    $ex_valor = $_GET['ex_valor'];
    $ex_tipo = $_GET['ex_tipo'];
	
		$lista = '{"result":[' . json_encode(salvarExcecao($pdo, $empresaMatriz, $empresaAcesso, $pd_cod, $ex_desc, $ex_valor, $ex_tipo)) . ']}';
		echo $lista;

}

if (isset($_GET['adicionarExcecaoProd'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
    $pd_cod = $_GET['pd_cod'];
    $ex_id = $_GET['ex_id'];
	
		$lista = '{"result":[' . json_encode(adicionarExcecao($pdo, $empresaMatriz, $empresaAcesso, $pd_cod, $ex_id)) . ']}';
		echo $lista;

}

if (isset($_GET['removerExcecaoProd'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
    $pde_produto = $_GET['pde_produto'];
    $pde_excecao = $_GET['pde_excecao'];
	
		$lista = '{"result":[' . json_encode(removerExcecaoProd($pdo, $empresaAcesso, $pde_produto, $pde_excecao)) . ']}';
		echo $lista;

}

if (isset($_GET['removerExcecao'])) {

	$empresaMatriz = base64_decode($_GET['e']);
    $empresaAcesso = base64_decode($_GET['eA']);
    if ($empresaAcesso == 0) {
        $empresaAcesso = $empresaMatriz;
    }
    $ex_id = $_GET['ex_id'];
	
		$lista = '{"result":[' . json_encode(removerExcecao($pdo, $empresaAcesso, $ex_id)) . ']}';
		echo $lista;

}

function listaExcecoes($pdo, $empresaAcesso, $pd_cod, $param) {
	$retorno = array();
    
    $sql="SELECT * from excecoes where ex_empresa = :empresa and ex_cod $param in (select pde_excecao from produtos_excecoes where pde_empresa = :empresa $pd_cod) order by ex_desc;";
    
    $excecao =$pdo->prepare($sql);
        //echo $sql;
        $excecao->bindValue(":empresa", $empresaAcesso);
        //$excecao->bindValue(":pd_cod", $pd_cod);
        $excecao->execute();
        $retorno = $excecao->fetchAll(PDO::FETCH_ASSOC);
   
	return $retorno;
}

function buscaExcecoes($pdo, $empresaAcesso) {
	$retorno = array();
    
    $sql="SELECT * from excecoes where ex_empresa = :empresa order by ex_desc;";
    
    $excecao =$pdo->prepare($sql);
        //echo $sql;
        $excecao->bindValue(":empresa", $empresaAcesso);
        //$excecao->bindValue(":pd_cod", $pd_cod);
        $excecao->execute();
        $retorno = $excecao->fetchAll(PDO::FETCH_ASSOC);
   
	return $retorno;
}

function salvarExcecao($pdo, $empresaMatriz, $empresaAcesso, $pd_cod, $ex_desc, $ex_valor, $ex_tipo) {

    $valor = str_replace('R$','',$ex_valor);
    $valor = number_format(str_replace(",",".",str_replace(".","","$valor")), 2, '.', '');
        
        $sql = "call cadastrarProdutoExcecao(:empresa, :matriz, :produto, :descricao, :valor, :tipo);";
        $resposta = $pdo->prepare($sql);
            $resposta->bindValue(":empresa", $empresaAcesso);
            $resposta->bindValue(":matriz", $empresaMatriz);
            $resposta->bindValue(":produto", $pd_cod);
            $resposta->bindValue(":descricao", addslashes(ucwords($ex_desc)));
            $resposta->bindValue(":valor", $valor);
            $resposta->bindValue(":tipo", $ex_tipo);
        $resposta->execute();
    
    return $resposta;
    
}

function adicionarExcecao($pdo, $empresaMatriz, $empresaAcesso, $pd_cod, $ex_id) {

    $sql = "INSERT INTO produtos_excecoes (pde_empresa, pde_matriz, pde_produto, pde_excecao, pde_tipo)
    (select '$empresaAcesso', '$empresaMatriz', '$pd_cod', ex_cod, ex_tipo from excecoes where ex_id = $ex_id);";
    //echo $sql;
    $resposta = $pdo->prepare($sql);
    $resposta->execute();
    //$retorno = $pdo->lastInsertId();
    
    return $resposta;
    
}

function removerExcecaoProd($pdo, $empresaAcesso, $pde_produto, $pde_excecao) {

    $sql = "DELETE from produtos_excecoes WHERE pde_empresa = :empresa and pde_produto = $pde_produto and pde_excecao = $pde_excecao;";
    //echo $sql;
    $resposta = $pdo->prepare($sql);
    $resposta->bindValue(":empresa", $empresaAcesso);
    $resposta->execute();
    //$retorno = $pdo->lastInsertId();
    
    return $resposta;
    
}

function removerExcecao($pdo, $empresaAcesso, $ex_id) {

    $sql = "DELETE from excecoes WHERE ex_id = :id;";
    //echo $sql;
    $resposta = $pdo->prepare($sql);
    $resposta->bindValue(":id", $ex_id);
    $resposta->execute();
    //$retorno = $pdo->lastInsertId();
    
    return $resposta;
    
}

?>
