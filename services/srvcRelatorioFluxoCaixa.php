<?php
require_once 'conecta.php';

$empresaMatriz = base64_decode($_GET['e']);

$empresaAcesso = base64_decode($_GET['eA']);

$dataI = $_GET['dataI'];
$dataF = $_GET['dataF'];

if (isset($_GET['empresa'])) {
	$empresa = $_GET['empresa'];

	if ($empresa == null) {
		$ct_empresa = '';

	} else {
		$ct_empresa = ' and ct_empresa = ' . $empresa;
	}

} else {
	$ct_empresa = '';
}

if (isset($_GET['relatorio'])) {

	
	if (isset($_GET['dadosRegistro'])) {

		$lista = '{"result":[' . json_encode(relatorio($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	if (isset($_GET['somaReceber'])) {

		$lista = '{"result":[' . json_encode(somaValorReceberDia($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	if (isset($_GET['somaPagar'])) {

		$lista = '{"result":[' . json_encode(somaValorPagarDia($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	if (isset($_GET['relatorioTotalRegistro'])) {
		$lista = '{"result":[' . json_encode(relatorioTotalRegistro($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF)) . ']}';
		echo $lista;
	}
	if (isset($_GET['relatorioTotalGrupoBy'])) {

		$lista = '{"result":[' . json_encode(relatorioTotalGrupoBy($conexao, $empresaMatriz, $vd_empr, $dataI, $dataF)) . ']}';
		echo $lista;
	}
}

function relatorio($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF) {

	$resultado = array();

	$sql = "SELECT ct_matriz, ct_empresa, (select em_fanta from empresas where em_cod = ct_empresa) as em_fanta, 
	ct_cliente_forn, ct_nome, ct_docto, ct_parc, ct_vencto, ct_valor, ct_receber_pagar
    FROM contas WHERE ct_matriz = $empresaMatriz $ct_empresa and ct_vencto between '$dataI' and '$dataF' 
    AND ct_quitado <> 'S' AND ct_canc <> 'S' order by ct_vencto, ct_receber_pagar, ct_cliente_forn, ct_empresa;";

	$query = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(

            'ct_matriz' => $row['ct_matriz'],
            'ct_empresa' => $row['ct_empresa'],
			'em_fanta' => utf8_encode($row['em_fanta']),
			'ct_cliente_forn' => $row['ct_cliente_forn'],
			'ct_nome' => utf8_encode($row['ct_nome']),
			'ct_docto' => $row['ct_docto'],
			'ct_parc' => $row['ct_parc'],
            'ct_vencto' => utf8_encode($row['ct_vencto']),
            'ct_valor_pagar' => valorPagarDia($row['ct_receber_pagar'], $row['ct_valor']),
            'ct_valor_receber' => valorReceberDia($row['ct_receber_pagar'], $row['ct_valor']),
            'ct_receber_pagar' => $row['ct_receber_pagar'],
			//'soma_receber' => somaReceberDia($conexao, $empresaMatriz, $ct_empresa, $row['ct_vencto']),
			//'soma_pagar' => somaPagarDia($conexao, $empresaMatriz, $ct_empresa, $row['ct_vencto']),
			//'ct_quitado' => $row['ct_quitado'],
            //'saldoValor' => ($row['vd_total'] - $row['vd_custo']),
			//'saldoPorc' => round(calculo($row['total'], $row['descto'], $row['custo']), 2),
			//'saldoPerc' => ((($row['vd_total'] * 100) / $row['vd_custo']) - 100),
		));
	}
	//echo $sql;
	return $resultado;
}

function somaValorReceberDia($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF) {

	$resultado = array();

	$sql = "SELECT sum(ct_valor) as soma_receber, ct_vencto FROM contas  where ct_matriz = $empresaMatriz $ct_empresa and ct_vencto between '$dataI' and '$dataF' 
    AND ct_quitado <> 'S' AND ct_canc <> 'S' and ct_receber_pagar = 'R' group by ct_vencto;";

	$query = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
            'soma_receber' => $row['soma_receber'],
 		));
	}
	//echo $sql;
	return $resultado;
}

function somaValorPagarDia($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF) {

	$resultado = array();

	$sql = "SELECT sum(ct_valor) as soma_pagar, ct_vencto FROM contas  where ct_matriz = $empresaMatriz $ct_empresa and ct_vencto between '$dataI' and '$dataF' 
    AND ct_quitado <> 'S' AND ct_canc <> 'S' and ct_receber_pagar = 'P' group by ct_vencto;";

	$query = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(
            'soma_pagar' => $row['soma_pagar'],
 		));
	}
	//echo $sql;
	return $resultado;
}

function valorReceberDia($ct_receber_pagar, $ct_valor){

	if ($ct_receber_pagar == 'R') {
		$valor = $ct_valor;
	} else {
		$valor = 0;
	}
	
	return $valor;

}

function valorPagarDia($ct_receber_pagar, $ct_valor){

	if ($ct_receber_pagar == 'P') {
		$valor = $ct_valor;
	} else {
		$valor = 0;
	}
	
	return $valor;

}

function relatorioTotalRegistro($conexao, $empresaMatriz, $ct_empresa, $dataI, $dataF) {

	$resultado = array();

	$sql = "SELECT	SUM(ct_valor) as ct_valor_total, ct_vencto 
    FROM contas WHERE ct_matriz = $empresaMatriz $ct_empresa and ct_emissao between '$dataI' and '$dataF' 
    AND ct_quitado <> 'S' AND ct_canc <> 'S' 
    group by ct_vencto order by ct_vencto;";

	$query = mysqli_query($conexao, $sql);
	while ($row = mysqli_fetch_assoc($query)) {
		array_push($resultado, array(

            'ct_valor_total' => $row['ct_valor_total'],
        ));
    }

	return $resultado;
}

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