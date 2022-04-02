<?php
//include 'conecta.php';

function logNavegacao($conexao, $data, $hora, $ip, $us_id, $msg, $empresa, $matriz) {
    if($empresa == 0){
        $empresa = $matriz;
    }

	$sql = "INSERT INTO log_navegacao (lg_data, lg_hora, lg_ip, lg_hist, lg_empresa, lg_matriz, lg_func_cod, lg_func_nome)
    VALUE('$data','$hora','$ip', '$msg', $empresa, $matriz,(SELECT us_cod FROM usuarios where us_id = $us_id),(SELECT us_nome FROM usuarios where us_id = $us_id))";

	$inserir = mysqli_query($conexao, $sql);

	//echo $sql;
	return $inserir;
}


?>