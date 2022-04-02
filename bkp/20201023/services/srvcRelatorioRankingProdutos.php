<?php
require_once 'conecta.php';

$empresaMatriz = base64_decode($_GET['e']);

$empresaAcesso = base64_decode($_GET['eA']);

if (isset($_GET['dataI'])) {
    $dataI = $_GET['dataI'];
}

if (isset($_GET['dataF'])) {
    $dataF = $_GET['dataF'];
}

if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$vdi_empr = '';

	} else {
		$vdi_empr = ' and vdi_empr=' . $empresa;
	}

} else {
	$vdi_empr = '';
}

if (isset($_GET['subgrupo'])) {
	$subgrupo = $_GET['subgrupo'];

	if ($subgrupo == null) {
		$pd_subgrupo = '';
	} else {
		$pd_subgrupo = ' AND vdi_subgrupo = ' . $subgrupo;
	}
} else {
	$pd_subgrupo = '';
}

if (isset($_GET['grupo'])) {
	$grupo = $_GET['grupo'];

	if ($grupo == null) {
		$pd_grupo = '';
	} else {
		$pd_grupo = '';
	}
} else {
	$pd_grupo = '';
}

if (isset($_GET['produto'])) {
	$produto = $_GET['produto'];

	if ($produto == null) {
		$pd_produto = '';
	} else {
		$pd_produto = ' AND vdi_descricao like "%' . $produto . '%"';
	}
} else {
	$pd_produto = '';
}

if (isset($_GET['dadosRelatorio'])) {

	if (isset($_GET['pagination'])) {

		$lista = '{"result":[' . json_encode(relatorioPaginate($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto)) . ']}';
		echo $lista;

	}

	if (isset($_GET['relatorio'])) {
		
		if (isset($_GET['js'])) {
			$lista = json_encode(relatorio($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto));
		}else{
			$lista = '{"result":[' . json_encode(relatorio($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto)) . ']}';
		}
		echo $lista;

	}

	if (isset($_GET['relatorioTotalRegistro'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalRegistro($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto)) . ']}';
		echo $lista;
	}
	if (isset($_GET['relatorioTotalQtsValor'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalQtsValor($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto)) . ']}';
		echo $lista;
	}
}

if (isset($_GET['listaSubgrupo'])) {

    if (isset($_GET['empresa'])) {
        $empresa = $_GET['empresa'];
    
        if ($empresa == null) {
            $sbp_empresa = '';
    
        } else {
            $sbp_empresa = ' and sbp_empresa=' . $empresa;
        }
    
    } else {
        $sbp_empresa = '';
    }
	
	$lista = '{"result":[' . json_encode(listaSubgrupo($conexao, $empresaMatriz, $sbp_empresa)) . ']}';
	echo $lista;
}

if (isset($_GET['listaGrupo'])) {

    if (isset($_GET['empresa'])) {
        $empresa = $_GET['empresa'];
    
        if ($empresa == null) {
            $grp_empresa = '';
    
        } else {
            $grp_empresa = ' and grp_empresa=' . $empresa;
        }
    
    } else {
        $grp_empresa = '';
    }
	
	$lista = '{"result":[' . json_encode(listaGrupo($conexao, $empresaMatriz, $grp_empresa)) . ']}';
	echo $lista;
}

function listaSubgrupo($conexao, $empresaMatriz, $sbp_empresa) {
	$resultado = array();

	$sql = "SELECT sbp_id, sbp_codigo, sbp_empresa, sbp_descricao, sbp_grupo FROM subgrupo_prod  
			where sbp_matriz = $empresaMatriz $sbp_empresa and sbp_deletado <> 'S' group by sbp_descricao;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'sbp_id' => $row['sbp_id'],
			'sbp_codigo' => $row['sbp_codigo'],
			'sbp_empresa' => $row['sbp_empresa'],
			'sbp_descricao' => utf8_decode($row['sbp_descricao']),
			'sbp_grupo' => $row['sbp_grupo'],
		));

	}

	//echo $sql;
	return $resultado;
}

function listaGrupo($conexao, $empresaMatriz, $grp_empresa) {
	$resultado = array();

	$sql = "SELECT grp_id, grp_codigo, grp_empresa, grp_descricao FROM grupo_prod  
			where grp_matriz = $empresaMatriz $grp_empresa and grp_deletado <> 'S' group by grp_descricao;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'grp_id' => $row['grp_id'],
			'grp_codigo' => $row['grp_codigo'],
			'grp_empresa' => $row['grp_empresa'],
			'grp_descricao' => utf8_decode($row['grp_descricao']),
		));

	}

	//echo $sql;
	return $resultado;
}

function relatorio($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto) {

	$resultado = array();

	$sql = "SELECT vdi_id, vdi_prod, vdi_empr, vdi_matriz, (select em_fanta from empresas where em_cod = vdi_empr) as em_fanta,
	vdi_descricao, vdi_subgrupo, sum(vdi_quant) as vdi_quant, vdi_preco
	from venda_item where vdi_emis between '$dataI' and '$dataF' and vdi_quant > 0
	AND vdi_canc<>'S' AND vdi_pgr<>'D' AND vdi_matriz = $empresaMatriz
	$vdi_empr $pd_subgrupo $pd_grupo $pd_produto group by vdi_prod order by vdi_quant DESC;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'vdi_id' => $row['vdi_id'],
			'vdi_prod' => $row['vdi_prod'],
			'vdi_descricao' => utf8_encode($row['vdi_descricao']),
			'vdi_empr' => $row['vdi_empr'],
			'em_fanta' => utf8_encode($row['em_fanta']),
			'vdi_matriz' => $row['vdi_matriz'],
			'vdi_subgrupo' => $row['vdi_subgrupo'],
			//'sbp_descricao' => utf8_encode($row['sbp_descricao']),
			'vdi_quant' => number_format($row['vdi_quant'], 2),
			'vdi_preco' => $row['vdi_preco'],
		));
	}

	//echo $sql;
	return $resultado;
}

function relatorioTotalRegistro($conexao, $empresaMatriz, $dataI, $dataF, $vdi_empr, $pd_subgrupo, $pd_grupo, $pd_produto) {

	$resultado = array();

	/*$sql = "SELECT SUM(vdi_quant) AS qnt, SUM(vdi_total) AS total from venda_item
		inner join produtos on (venda_item.vdi_prod=produtos.pd_cod and venda_item.vdi_matriz=produtos.pd_matriz)
		inner join subgrupo_prod on (produtos.pd_subgrupo=subgrupo_prod.sbp_codigo and venda_item.vdi_matriz=subgrupo_prod.sbp_matriz)
		WHERE vdi_emis>=CAST('$dataI'  AS DATE) AND vdi_emis<=CAST('$dataF' AS DATE)
		and venda_item.vdi_canc<>'S'
		AND venda_item.vdi_pgr<>'D'
		AND vdi_matriz = $empresaMatriz
		$vdi_empr
	*/

	$sql = "SELECT sum(vdi_quant) as quant_total, sum(vdi_total) as valor_total
	from venda_item where vdi_emis between '$dataI' and '$dataF'
	AND vdi_canc<>'S' AND vdi_pgr<>'D' AND vdi_matriz = $empresaMatriz
	$vdi_empr $pd_subgrupo $pd_grupo $pd_produto;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
			'quant_total' => (float) $row['quant_total'],
			'valor_total' => $row['valor_total'],
		));

		//echo $sql;
		return $resultado;
	}
}

?>