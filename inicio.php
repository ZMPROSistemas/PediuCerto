<?php

include 'varInicio.php';

include 'conecta.php';
include 'funcoes-inicio.php';
include 'cabecalho.php';

if (base64_decode($em_ramo) != 1) {
	include 'pagInicial.php';
}
if (base64_decode($em_ramo) == 1) {
	include 'pagInicial_R.php';
}
?>

</body>

</html>
