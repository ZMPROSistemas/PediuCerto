<?php
require_once 'conecta.php';

$empresaMatriz = base64_decode($_GET['e']);

$empresaAcesso = base64_decode($_GET['eA']);

$dataI = $_GET['dataI'];
$dataF = $_GET['dataF'];

if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$vd_empr = '';

	} else {
		$vd_empr = ' and vd_empr= ' . $empresa;
	}

} else {
	$vd_empr = '';
}

if (isset($_GET['relatorio'])) {

	if (isset($_GET['pagination'])) {

		$lista = '{"result":[' . json_encode(relatorioPaginate($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF)) . ']}';
		echo $lista;

	}
	if (isset($_GET['dadosRegistro'])) {

		$lista = '{"result":[' . json_encode(relatorio($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	if (isset($_GET['relatorioTotalRegistro'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalRegistro($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	if (isset($_GET['relatorioTotalGrupoBy'])) {

		$lista = '{"result":[' . json_encode(relatorioTotalGrupoBy($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF)) . ']}';
		echo $lista;
	}
}

function relatorio($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF) {

	$resultado = array();

	/*$sql = "SELECT vd_emis, vd_matriz, vd_empr, SUM(vd_valor) as total, sum(vd_desc) as descto,
		(select sum(vdi_custo) FROM venda_item where vdi_emis=vendas.vd_emis
		and vdi_matriz=vendas.vd_matriz
		and vdi_empr=vendas.vd_empr
		and venda_item.vdi_canc<>'S'
		AND venda_item.vdi_pgr<>'D') as custo FROM vendas
		WHERE vd_emis>=CAST('$dataI'  AS DATE) AND vd_emis<=CAST('$dataF' AS DATE)
		and vendas.vd_canc<>'S'
		AND vendas.vd_pgr<>'D'
		AND vd_matriz=$empresaMatriz
		$vd_empr
		group by vd_emis, vd_matriz, vd_empr
	*/

	$sql = "SELECT vd_emis, vd_matriz, vd_empr, (select em_fanta from empresas where em_cod = vd_empr) as em_fanta, 
	SUM(vd_valor) as vd_valor, sum(vd_desc) as vd_desc, sum(vd_total) as vd_total, 
	(select sum(vdi_custo) from venda_item where vdi_emis = vendas.vd_emis and vdi_matriz = vendas.vd_matriz 
	and vdi_empr = vendas.vd_empr and vdi_canc <> 'S' AND vdi_pgr <> 'D') as vd_custo
	from vendas where vd_emis between '$dataI' and '$dataF' and vd_canc <> 'S' AND vd_pgr <> 'D' 
	and vd_matriz = $empresaMatriz $vd_empr group by vd_emis, vd_empr order by vd_emis;";

	$query = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(

			'vd_emis' => utf8_encode($row['vd_emis']),
			'vd_matriz' => $row['vd_matriz'],
			'vd_empr' => $row['vd_empr'],
			'em_fanta' => utf8_encode($row['em_fanta']),
			'vd_total' => $row['vd_total'],
			'vd_desc' => $row['vd_desc'],
			'vd_valor' => $row['vd_valor'],
			'vd_custo' => $row['vd_custo'],
			//'saldoValor' => ($row['vd_total'] - $row['vd_custo']),
			//'saldoPorc' => round(calculo($row['total'], $row['descto'], $row['custo']), 2),
			//'saldoPerc' => ((($row['vd_total'] * 100) / $row['vd_custo']) - 100),

		));
	}
	//echo $sql;
	return $resultado;
}

function relatorioTotalRegistro($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF) {

	$resultado = array();

	$sql = "SELECT	SUM(vd_valor) as vd_valor, sum(vd_desc) as vd_desc, sum(vd_total) as vd_total, 
	(select sum(vdi_custo) from venda_item where vdi_emis = vendas.vd_emis and vdi_matriz = vendas.vd_matriz 
	and vdi_empr = vendas.vd_empr and vdi_canc <> 'S' AND vdi_pgr <> 'D') as vd_custo
	from vendas where vd_emis between '$dataI' and '$dataF' and vd_canc <> 'S' AND vd_pgr <> 'D' 
	and vd_matriz = $empresaMatriz $vd_empr group by vd_emis, vd_empr order by vd_emis;";

	$query = mysqli_query($conexao, $sql);
	array_push($resultado, array(
		'total' => mysqli_num_rows($query),
	));

	return $resultado;
}
/*

function relatorioTotalGrupoBy($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF) {

$resultado = array();

$sql = "SELECT SUM(vd_valor) as total, sum(vd_desc) as descto,
(select sum(vdi_custo) from venda_item where vdi_emis=vendas.vd_emis
and vdi_matriz=vendas.vd_matriz
and vdi_empr=vendas.vd_empr
and venda_item.vdi_canc<>'S'
AND venda_item.vdi_pgr<>'D') as custo from vendas
WHERE vd_emis>=CAST('$dataI'  AS DATE) AND vd_emis<=CAST('$dataF' AS DATE)
and vendas.vd_canc<>'S'
AND vendas.vd_pgr<>'D'
AND vd_matriz=$empresaMatriz
$vd_empr;";

$query = mysqli_query($conexao, $sql);

while ($row = mysqli_fetch_assoc($query)) {
array_push($resultado, array(

'total' => $row['total'],
'descto' => $row['descto'],
'custo' => $row['custo'],
'saldo' => (float) ($row['total'] - $row['custo'] - $row['descto']),
'saldoPorc' => round(calculo($row['total'], $row['descto'], $row['custo']), 2),
));

}

return $resultado;
}
 */

function relatorioTotalGrupoBy($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF) {

	$resultado = array();

	$sql = "SELECT SUM(vd_valor) as total, sum(vd_desc) as descto,
(select sum(vdi_custo) from venda_item where vdi_emis = vendas.vd_emis
and vdi_matriz=vendas.vd_matriz
and vdi_empr=vendas.vd_empr
and venda_item.vdi_canc<>'S'
AND venda_item.vdi_pgr<>'D'
) as custo,
(((SUM(vd_valor)-sum(vd_desc))*100)/(select sum(vdi_custo) from venda_item where vdi_emis = vendas.vd_emis
and vdi_matriz=vendas.vd_matriz
and vdi_empr=vendas.vd_empr
and venda_item.vdi_canc<>'S'
AND venda_item.vdi_pgr<>'D'
)-100) as saldoPorc
from vendas
WHERE vd_emis>=CAST('$dataI'  AS DATE) AND vd_emis<=CAST('$dataF' AS DATE)
and vendas.vd_canc<>'S'
AND vendas.vd_pgr<>'D'
AND vd_matriz=$empresaMatriz
$vd_empr;";

	$query = mysqli_query($conexao, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(

			'total' => $row['total'],
			'descto' => $row['descto'],
			'custo' => number_format($row['custo'], 2, '.', ''),
			'saldo' => number_format($row['total'] - $row['custo'] - $row['descto'], 2, '.', ''),
			//'saldoPorc' => round(calculo($row['total'], $row['descto'], $row['custo']), 2),
			'saldoPorc' => number_format($row['saldoPorc'], 2, '.', ''),
		));

	}

	return $resultado;
}

function calculo($venda, $desconto, $custo) {

	try {

		if ($custo == null) {
			$saldo = 0.00;
		} else if ($custo == '') {
			$saldo = 0.00;
		} else {
			$saldo = ((($venda - $desconto) * 100) / $custo) - 100;
		}

	} catch (Exception $e) {
		$saldo = 0.00;
	}
	//echo $saldo;
	return $saldo;
}

?>