<?php
include 'conecta.php';
//include 'alteraAlunoCodAtualiza.php';
//include 'editarExercicio.php';
//include 'alteraAlunoCodAtualiza.php';



if (isset($_GET['serieItemAluno'])) {
		$id = $_GET['id'];
		$lista = '{"result":[' . json_encode(serieItemAluno($conexao, $id)) . ']}';
		echo $lista;
}


if (isset($_GET['treinoAluno'])) {
		$id = $_GET['idaluno'];
		$lista = '{"result":[' . json_encode(treinoAluno($conexao, $id)) . ']}';
		echo $lista;
}


if (isset($_GET['exerciciosDoAluno'])) {
		$id = $_GET['idaluno'];
		$lista = '{"result":[' . json_encode(exerciciosDoAluno($conexao, $id)) . ']}';
		echo $lista;
}


function treinoAluno($conexao, $id){
	$categoria = array();
	
	$sql="SELECT * FROM treinoAluno where treinoPadraoAluno = (select idtreinoPadraoAluno from treinoPadraoAluno where aluno= {$id} and treinoAtual='S') order by ordem;";
	$resultado = mysqli_query($conexao,$sql);
	
	while ($row = mysqli_fetch_assoc($resultado)) {

		array_push($categoria, array(
			'idtreinoAluno' => $row['idtreinoAluno'],
			'nome' => utf8_encode($row['nome']),
			'ordem'=>$row['ordem'],
		));
	}		
	//echo $sql;
	return $categoria;
}


function exerciciosDoAluno($conexao, $id){
	$categoria = array();
	
	$resultado = mysqli_query($conexao, " select tr.idtreinoAluno, tr.nome, tr.ordem as ordemTreino, tr.treinoPadraoAluno, tr.aluno,  
 exTr.idexercicioTreinoAluno,exTr.treinoAluno, exTr.series, exTr.repeticoes, exTr.tipo_repeticoes, exTr.carga,
 exTr.descanso, exTr.dica, exTr.ordem as ordemExerc,
 ex.idexercicio, ex.nome as nomeEx,ex.academia, ex.caminhoVideo
 from treinoAluno as tr inner join exercicioTreinoAluno as exTr 
 on(tr.idtreinoAluno = exTr.treinoAluno) inner JOIN exercicio as ex
 on(exTr.exercicio = ex.idexercicio) where tr.treinoPadraoAluno = (select idtreinoPadraoAluno from treinoPadraoAluno where aluno= {$id} and treinoAtual='S') order by ordemTreino;");
	
	while ($row = mysqli_fetch_assoc($resultado)) {

		array_push($categoria, array(
			'idtreinoAluno'=>$row['idtreinoAluno'],
			'nome'=>utf8_encode($row['nome']), 
			'ordemTreino' => $row['ordemTreino'],
			'treinoPadraoAluno' =>$row['treinoPadraoAluno'],
			'idexercicioTreinoAluno' => $row['idexercicioTreinoAluno'],
			'treinoAluno' => $row['treinoAluno'],
			'series' => $row['series'],
			'repeticoes' => $row['repeticoes'],
			'tipo_repeticoes' => utf8_encode($row['tipo_repeticoes']),
			'carga' => $row['carga'],
			'descanso' => $row['descanso'],
			'dica'=>utf8_encode($row['dica']),
			'ordemExerc'=>$row['ordemExerc'],
			'idexercicio'=>$row['idexercicio'],
			'nomeEx'=>utf8_encode($row['nomeEx']),
			'academia'=>$row['academia'],
			'caminhoVideo'=>utf8_encode($row['caminhoVideo']),

		));
	}		
	//echo ("<br>ID inserido = " .$categoria."<br>");
	return $categoria;
}

function treinoPadraoAluno($conexao, $id){
	
	$sql ="select * from treinoPadraoAluno where aluno = {$id} and treinoAtual='S';";
	$resultado = mysqli_query($conexao, $sql);
	
	//$row = mysqli_fetch_assoc($resultado);
	 echo $sql;		
	
	return $resultado;
}

function serieItemAluno($conexao, $id){
	
	$categoria = array();

	$resultado = mysqli_query($conexao, " select series, carga FROM academia.serieItemAluno where exercicioTreinoAluno = {$id} order by ordem;");
	
	
	while ($row = mysqli_fetch_assoc($resultado)) {

		array_push($categoria, array(
			'series' => $row['series'],
			'carga' => $row['carga'],
		));
	}		

	return $categoria;
}
